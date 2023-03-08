<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\{User,UserFamily,UserLikesHideBlocked};
use App\Models\{Message,Connection};
use App\Models\UserPurchaseSubscription;
use App\Traits\Base64FileTrait;
use Auth;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;
use App\Helper\Helper;
use Illuminate\Support\Facades\Storage;


class MessageController extends Controller
{
    use Base64FileTrait;
    
    public function get_all_user_messages_live(Request $request) {
        $logged_user_id = Auth::user()->id;
        //dd($logged_user_id);
       
        $all_connected_users = Helper::all_connected_users($logged_user_id);
        //dd($all_connected_users);
        $data = [];
        $user_data = true;
        if(isset($all_connected_users) && count($all_connected_users) > 0) {
            foreach($all_connected_users as $user_id) {
                $user_data =  User::with('account_type')
                            ->with('profile_images_list')
                            ->with('members', 'members.profile_images_list', 'members.skin_detail', 'members.work_detail', 'members.education_detail','members.children_detail','members.sect_detail','members.hijab_detail','user_has_active_subscription')
                            ->with('family_origin_detail')
                            ->with('nationality_detail')
                            ->with('nationality_current_detail')
                            ->with('city_detail')
                            //->has('user_has_active_subscription')
                            ->with('personality_dimension')
                            ->with('tribe_detail')
                            ->where('users.id',$user_id)
                            ->first();
                
                // 3 => 2,5,8
                //dd($all_connected_users);
    
                if($user_data) {
                    
                    $user_data->message = Helper::get_user_latest_message($user_data->id,$logged_user_id);
                    $user_data->prifile_images = $user_data->profile_images_list();
                    $data[] = $user_data;
                }

            }
        }
        
        
                               
        if($user_data) {
            $logdata = [
                'request_data' => $request->all(),
                'response_data' => array('status'=>200,
                'loggedInUser' => $logged_user_id,
                'data'=>$data)
            ];
            Helper::save_api_logs($logdata);

            return response()->json([
                'status'=>200,
                'loggedInUser' => $logged_user_id,
                'data'=>$data,
            ]);
        } else {

            $logdata = [
                'request_data' => $request->all(),
                'response_data' => array('status'=>200,
                'loggedInUser' => $logged_user_id,
                'data'=>[],
                'message'=>__('api.common.server_error'))
            ];
            Helper::save_api_logs($logdata);

            return response()->json([
                'status'=>200,
                'loggedInUser' => $logged_user_id,
                'data'=>[],
                'message'=>__('api.common.server_error')
            ]);
        }
        
        
        
    }

    public function get_all_user_messages(Request $request) {
        $perPageCount = 10;
        $logged_user_id = Auth::user()->id;
        //dd($logged_user_id);
        $members_list = Connection::select('request_id','receiver_id')
            ->where('connection_status','approved')
            ->whereNull('deleted_at')
            ->where(function($q) use ($logged_user_id) {
                            $q->where('receiver_id', $logged_user_id)
                            ->orWhere('request_id', $logged_user_id);
                        });

          
        
                
        $members_list = $members_list->get();
        //dd($members_list);

        $all_other_users_arr1 = $members_list->pluck('receiver_id')->toArray(); // array of ads ids
        $all_other_users_arr2 = $members_list->pluck('request_id')->toArray(); 

        $user_list = array_merge($all_other_users_arr1,$all_other_users_arr2); 
        
        $user_list = array_diff($user_list,[$logged_user_id]);
        $user_list = array_values($user_list);



        // sorting custom
        // $yellow_connection_user_list_array = []; $red_connection_user_list_array = [];
        // if(Auth::user()->status == 'yellow') {
        //     $yellow_connection_user_list_array = DB::table('user_yellow_connections')->select('request_id')->where('user_id',$logged_user_id)->pluck('request_id')->toArray();
        // } 
        // if(Auth::user()->status == 'red') {
        //     $red_connection_user_list_array = DB::table('user_red_connections')->select('request_id')->where('user_id',$logged_user_id)->pluck('request_id')->toArray();
        // } 

        $user_has_message_list = [];
        $user_has_no_message_list = [];
        if(count($user_list) > 0) {
            foreach($user_list as $user_id) {

                $has_active_subscription = Helper::has_active_subscription($user_id);
                $user_detail = User::find($user_id);

                $user_blocked_detail = UserLikesHideBlocked::select('is_blocked')
                                                    ->where('request_id',$logged_user_id)
                                                    ->where('user_id',$user_id)
                                                    ->first();
                if(isset($user_blocked_detail) && !empty($user_blocked_detail->is_blocked)) {
                    $is_user_blocked_by_loggedin_user =  $user_blocked_detail->is_blocked == 1 ? 1 : 0; 
                } else {
                    $is_user_blocked_by_loggedin_user = 0;
                }

                if($has_active_subscription && $user_detail->account_blocked == 0 && $is_user_blocked_by_loggedin_user == 0)  {
                //if(0)  {
                    $has_message = Helper::get_user_has_message($user_id,$logged_user_id);
                    if($has_message) {
                        $user_has_message_list[] = $user_id;
                    } else {
                        $user_has_no_message_list[] = $user_id;
                    }
                }
                
                
                // if(Auth::user()->status == 'yellow') {
                //     if(in_array($user_id,$yellow_connection_user_list_array)) {
                //         $has_message = Helper::get_user_has_message($user_id,$logged_user_id);
                //         if($has_message) {
                //             $user_has_message_list[] = $user_id;
                //         } else {
                //             $user_has_no_message_list[] = $user_id;
                //         }
                //     }
                // } else if(Auth::user()->status == 'red') {
                //     if(in_array($user_id,$red_connection_user_list_array)) {
                //         $has_message = Helper::get_user_has_message($user_id,$logged_user_id);
                //         if($has_message) {
                //             $user_has_message_list[] = $user_id;
                //         } else {
                //             $user_has_no_message_list[] = $user_id;
                //         }
                //     }
                // } else {
                //     $has_message = Helper::get_user_has_message($user_id,$logged_user_id);
                //     if($has_message) {
                //         $user_has_message_list[] = $user_id;
                //     } else {
                //         $user_has_no_message_list[] = $user_id;
                //     }
                // }

                
            }
            



            $sorted_user_list = array_merge($user_has_message_list,$user_has_no_message_list);
        }
        $all_connected_users['user_has_message_list'] = $user_has_message_list;
        $all_connected_users['user_has_no_message_list'] = $user_has_no_message_list;
        //dd($all_connected_users['user_has_message_list']);
        //dd($all_connected_users['user_has_no_message_list']);
        // new concept

        //$all_connected_users = Helper::all_connected_users_new($logged_user_id);
        //$all_connected_users = $all_connected_users['user_has_message_list'];
        //dd($all_connected_users['members_list']);
        $result = [];
        $user_data = true;
        if(isset($all_connected_users) && count($all_connected_users['user_has_message_list']) > 0) {
            foreach($all_connected_users['user_has_message_list'] as $key=>$user) {
                $user_id = $user;
                

                $message = Message::select('*')
                //->with('user_detail','member_detail','profile_images')
                ->where(function($q) use ($user_id,$logged_user_id)
                {
                    $q->where('request_id', $user_id)
                    ->where('receiver_id', $logged_user_id);
                })->orWhere(function($q) use ($user_id,$logged_user_id) {
                    $q->where('receiver_id', $user_id)
                    ->where('request_id', $logged_user_id);
                })
                ->orderBy('created_at','DESC');
                // $query = str_replace(array('?'), array('\'%s\''), $messages->toSql());
                // $query = vsprintf($query, $messages->getBindings());
                // dump($query);
                // die;
                $message = $message->first();
                if(isset($message)) {
                    //$message->user_detail->individual_name = ;

                    $message->is_deleted = Helper::check_for_delete_message($logged_user_id,$message->message_id);
                    
                    $is_read = false;
                    if(!empty($message->is_read) && $message->receiver_id == $logged_user_id ) {
                        $is_read_arr = explode(',',$message->is_read);
                        if(in_array($logged_user_id,$is_read_arr)) {
                            $is_read = true; 
                        }
                    }
                    $message->is_read = $is_read;
                    $message->is_my_message = $message->request_id == $logged_user_id ? true : false;
                    
                    //$message->message_text = !empty($message->message_text) ? Crypt::decryptString($message->message_text) : '';
                    //$message->message_image = !empty($message->message_image) ? Crypt::decryptString($message->message_image) : '';
                    //$message->message_audio_video = !empty($message->message_audio_video) ? Crypt::decryptString($message->message_audio_video) : '';

                    $message->message_text = !empty($message->message_text) ? Helper::encryption($message->message_text,'decrypt') : '';
                    $message->message_image = !empty($message->message_image) ? Helper::encryption($message->message_image,'decrypt') : '';
                    $message->message_audio_video = !empty($message->message_audio_video) ? Helper::encryption($message->message_audio_video,'decrypt') : '';
                    
                    $message->time_12_format = $message->updated_at ? date('h:i A', strtotime($message->updated_at)) : $message->created_at ? date('h:i A', strtotime($message->created_at)) : '--';
                        
                       
                    
                }
                //dd($message);
                $result[$key]['message_detail'] = isset($message) ? $message : false;

                $result[$key]['connection_detail'] = Helper::connection_detail($logged_user_id,$user_id);
                $user = User::find($user_id);
                // user detail
                $user_data = Helper::user_all_detail($user,1);
                $result[$key]['user_detail'] = $user_data;
            }
            
        }

        //dd($data);
        // sorting
        usort($result, function ($item1, $item2) {
            return $item2['message_detail']->created_at <=> $item1['message_detail']->created_at;
        });


        //dd($all_connected_users['user_has_no_message_list']);
        if(isset($all_connected_users) && count($all_connected_users['user_has_no_message_list']) > 0) {
            $new_key = isset($result) ? count($result) : 0;
            foreach($all_connected_users['user_has_no_message_list'] as $key=>$user_id) {
                
                $user_data =  User::with('account_type')
                            ->with('profile_images_list')
                            ->with('members', 'members.profile_images_list', 'members.skin_detail', 'members.work_detail', 'members.education_detail','members.children_detail','members.sect_detail','members.hijab_detail','user_has_active_subscription')
                            ->with('family_origin_detail')
                            ->with('nationality_detail')
                            ->with('nationality_current_detail')
                            ->with('live_in_city_detail')
                            ->has('user_has_active_subscription')
                            ->with('personality_dimension')
                            ->with('tribe_detail')
                            ->where('users.id',$user_id)
                            ->first();
                
                // 3 => 2,5,8
                //dd($all_connected_users);
    
                if($user_data) {
                    
                    //$user_data->message = Helper::get_user_latest_message($user_data->id,$logged_user_id);
                    $user_data->profile_images = Helper::get_profile_images($user_data);
                    $result[$new_key]['user_detail'] = $user_data;
                    
                    $result[$new_key]['message_detail'] = Helper::get_user_latest_message($user_data->id,$logged_user_id);
                    $result[$new_key]['connection_detail'] = Helper::connection_detail($logged_user_id,$user_id);
                    $new_key++;
                }

            }
        }
        
        //dd($members_list);
                               
        if($user_data) {
            $logdata = [
                'request_data' => $request->all(),
                'response_data' => array('status'=>200,
                'loggedInUser' => $logged_user_id,
                'perPage' => $perPageCount,
                'data'=>$result)
            ];
            Helper::save_api_logs($logdata);

            return response()->json([
                'status'=>200,
                'loggedInUser' => $logged_user_id,
                'perPage' => $perPageCount,
                'data'=>$result,
            ]);
        } else {
            $logdata = [
                'request_data' => $request->all(),
                'response_data' => array('status'=>200,
                'loggedInUser' => $logged_user_id,
                'data'=>[],
                'message'=>__('api.common.server_error'))
            ];
            Helper::save_api_logs($logdata);

            return response()->json([
                'status'=>200,
                'loggedInUser' => $logged_user_id,
                'data'=>[],
                'message'=>__('api.common.server_error')
            ]);
        }
        
        
        
    }

    public function get_user_messages(Request $request) {
        $logged_user_id = Auth::user()->id;
        //dd($logged_user_id);
        $user_id = $request->recepintUser;
        
        
        $message_data = Message::where(function($q) use ($logged_user_id,$user_id) {
                                        $q->where('request_id', $logged_user_id)
                                        ->where('receiver_id', $user_id);
                                    })->orWhere(function($q) use ($logged_user_id,$user_id) {
                                        $q->where('receiver_id', $logged_user_id)
                                        ->where('request_id', $user_id);
          
                                  })
                                  ->orderBy('created_at','desc')
                                  ->paginate(35)
                                  ->groupBy(function($item)
                                  {
                                   
                                    return $item->created_at->format('d-M-y');
                                      
                                   
                                  });

        //dd($message_data);
        $new_message_data = [];
        if($message_data) {
            $i = 0;
            foreach($message_data as $key=>$message_arr) {
                    $new_message_data[$i]['title'] = $key;
                    foreach($message_arr as $key=>$message) {
                        $is_read = false;
                        $message = (object) $message;
                        //dd($message['is_read']);
                        if(!empty($message->is_read)) {
                            $is_read_arr = explode(',',$message->is_read);
                            if(in_array($logged_user_id,$is_read_arr)) {
                                $is_read = true; 
                            }
                        }
                        //dd($is_read);
                        $message->is_read = $is_read;
        
                        // // For checking delete
                        $message->is_deleted = Helper::check_for_delete_message($logged_user_id,$message->message_id);
                        // //$message_data[$key]->is_deleted = false;
        
                        $message_type = '';
                        if(!empty($message->message_text)) {
                            //$message->message_text =  $message->message_text ? Crypt::decryptString($message->message_text) : '';
                            $message->message_text =  $message->message_text ? Helper::encryption($message->message_text,'decrypt') : '';
                            $message_type = 'text';
                        }
                        if(!empty($message->message_image)) {
                           //$message->message_image = $message->message_image ? Crypt::decryptString($message->message_image) : '';
                           $message->message_image = $message->message_image ?  Helper::encryption($message->message_image,'decrypt') : '';
                            $message->image_path =  $message->message_image;
                            $message_type = 'image';
                        }
                        if(!empty($message->message_audio_video)) {
                            // $message->message_audio_video = $message->message_audio_video ? Crypt::decryptString($message->message_audio_video) : '';

                            $message->message_audio_video = $message->message_audio_video ? Helper::encryption($message->message_audio_video,'decrypt') : '';
                            $message->message_audio_video_path = $message->message_audio_video;
                            
                            $message_type = 'audio';
                        }
                        $message->type = $message_type;
                        //$message->message_type = $message_type;
                        $message->time_12_format = $message->updated_at ? date('h:i A', strtotime($message->updated_at)) : $message->created_at ? date('h:i A', strtotime($message->created_at)) : '--';
                        $new_message_data[$i]['data'][] = $message;
                    }
                    
                    $i++;
            }

        }  

        //@ for update is read
        $message_data_update = Message::where(function($q) use ($logged_user_id,$user_id) {
                                                $q->where('request_id', $logged_user_id)
                                                ->where('receiver_id', $user_id);
                                            })->orWhere(function($q) use ($logged_user_id,$user_id) {
                                                $q->where('receiver_id', $logged_user_id)
                                                ->where('request_id', $user_id);

                                        })->get();
        if($message_data_update) {
            foreach($message_data_update as $key=>$message) {
                $old_users_is_read = !empty($message->is_read) ? explode(',',$message->is_read) : [];
                if(!in_array($logged_user_id,$old_users_is_read)) {
                    $old_users_is_read[] = $logged_user_id;
                }
                Message::where('id',$message->id)
                        ->update(['is_read'=>implode(',',$old_users_is_read)]);
            }
        }
        // End update is read
        if($message_data) {

            $logdata = [
                'request_data' => $request->all(),
                'response_data' => array('status'=>200,
                'recepintUser' => $user_id,
                'data'=>$new_message_data)
            ];
            Helper::save_api_logs($logdata);

            return response()->json([
                'status'=>200,
                'recepintUser' => $user_id,
                'data'=>$new_message_data,
            ]);
        } else {
            $logdata = [
                'request_data' => $request->all(),
                'response_data' => array('status'=>200,
                'recepintUser' => $user_id,
                'data'=>[],
                'message'=>__('api.common.server_error'))
            ];
            Helper::save_api_logs($logdata);

            return response()->json([
                'status'=>200,
                'recepintUser' => $user_id,
                'data'=>[],
                'message'=>__('api.common.server_error')
            ]);
        }
        
        
        
    }

    public function send_message(Request $request)
    {
        if(empty($request->message_text) &&  empty($request->message_image) && empty($request->message_audio_video)) {
            $logdata = [
                'request_data' => $request->all(),
                'response_data' => array('status'=>false,
                'message'=>__('api.common.required'))
            ];
            Helper::save_api_logs($logdata);

            return response()->json([
                'status'=>false,
                'message'=>__('api.common.required'),
            ],422);
        }

        $logged_user_id = Auth::user()->id;

        $request_member_id = $request->requestMember;
        // @ Recienpt user ids
        $user_id = $request->recepintUser;
        $receiver_member_id = $request->recepintMember;
        // @ Message details
        //$message_text =  !empty($request->message_text) ? Crypt::encryptString($request->message_text) : '';
        
        $message_text =  !empty($request->message_text) ? Helper::encryption($request->message_text,'encrypt') : '';
        $message_image =  !empty($request->message_image) ? $request->message_image : '';
        $message_audio_video =  !empty($request->message_audio_video) ? $request->message_audio_video : '';
        $location = '';
        $filename = '';
        $message_audio_video_path = '';
        $message_image_path = '';
        $audio_video_location = '';
        // Save Image in base64 && audio file && video file
        if (!empty($request->message_image)) {
            //$file = base64_decode($request->message_image);
            // $safeName = uniqid().'.'.'png';
            // Storage::put('public/messages/images/'.$safeName,$file);
            // $message_image_path = Crypt::encryptString(asset('storage/messages/images/'.$safeName));
            //$path = $this->_base64fileUpload($request->message_image, '/messages/images');
            $path = $this->_normalFileUpload($request->message_image,'messages/images');
            //$message_image_path = Crypt::encryptString(asset('storage/'.$path));
            $message_image_path = Helper::encryption(env('S3_URL').$path,'encrypt');
            
        }

        if ( !empty($request->hasFile('message_audio_video')) ) {
            // The file
            $music_file = $request->file('message_audio_video');
            $storage = Storage::put('public/messages/audio_video',$music_file);
            $file = pathinfo($storage);
            $audo_file_name = $file['basename'];
            // $message_audio_video_path = Crypt::encryptString(asset( 'storage/messages/audio_video/'.$audo_file_name ));

            $message_audio_video_path = Helper::encryption(asset( 'storage/messages/audio_video/'.$audo_file_name ),'encrypt');

            $audio_video_location = asset( 'storage/messages/audio_video/'.$audo_file_name );
        }

        $message_data = [
            'request_id'=>$logged_user_id,
            'request_member_id' => $request_member_id,
            'receiver_id'=>$user_id,
            'receiver_member_id'=>$receiver_member_id,
            'message_text'=>$message_text,
            'message_image'=>$message_image_path,
            'message_type' => $request->message_type,
            'message_audio_video'=>$message_audio_video_path,
            'created_at'=>date('Y-m-d H:i:s'),
            'updated_at'=>date('Y-m-d H:i:s'),
            'message_id' => $request->message_id,
        ];

        $inserted = Message::insert($message_data);
        if($inserted) {
            // Notification 
            //@ send notifications
            $device_tokens = Helper::getRecipantDeviceTokens($request->recepintUser,'message');
            $message_data = Helper::getMessageByCode('NOT07');
            // $messgae = array(
            //     "title" => isset($message_data->message_value_en) ? $message_data->message_value_en : '', 
            //     "body" => isset($message_data->message_value_en) ? $message_data->message_value_en : ''
            // );
            $sender_id = Auth::user()->id;
            $notification_type = 'message';
            $key1 = Helper::getUserName($sender_id);
            $key2 = '';
            $recipant_data = User::find($user_id);
            $prefered_lag = $recipant_data->default_language ? $recipant_data->default_language : 'en';
            if($prefered_lag == 'en') {
                $noti_title = $message_data->title_en;
                $noti_mesage = $key1. ' '. $message_data->message_value_en;
            } else {
                $noti_title = $message_data->title_ar;
                $noti_mesage = $key1. ' '. $message_data->message_value_ar;
            }
            $badge_count = Helper::user_has_unread_notifications();
            //dd($badge_count);
            $messgae = array(
                "title" => $noti_title, 
                "body" => $noti_mesage,
                "badge" => $badge_count,
                "key_name" => $message_data->key_name,
                "sound" => "default"
            );
            Helper::send_notification_FCM($device_tokens, $messgae, $message_data, $sender_id,$request->recepintUser,$key1,$key2,$notification_type);
            // End send notifications

            $logdata = [
                'request_data' => $request->all(),
                'response_data' => array('status'=>200,
                'message'=>'',
                'logged_user_id' =>$logged_user_id,
                'audio_video_location' => $audio_video_location,
                'time_12_format' => date('h:i A', strtotime( date('Y-m-d H:i:s') )))
            ];
            Helper::save_api_logs($logdata);

            return response()->json([
                'status'=>200,
                'message'=>'',
                'logged_user_id' =>$logged_user_id,
                'audio_video_location' => $audio_video_location,
                'time_12_format' => date('h:i A', strtotime( date('Y-m-d H:i:s') ))
            ]);
        } else {
            $logdata = [
                'request_data' => $request->all(),
                'response_data' => array('status'=>200,
                'message'=>__('api.common.server_error'))
            ];
            Helper::save_api_logs($logdata);

            return response()->json([
                'status'=>200,
                'message'=>__('api.common.server_error')
            ]);
        }
    }

    public function read_message_(Request $request,$message_id,$reciver_id) {
        $message_data = [
            'is_read'=>$reciver_id,
        ];

        $inserted = Message::where('id',$message_id)->update($message_data);

        $message = Message::where('id',$message_id)->first();
        if($message) {
            
            // $message->message_text = $message->message_text ? Crypt::decryptString($message->message_text) : '';
            // $message->message_image = $message->message_image ? Crypt::decryptString($message->message_image) : '';
            // $message->message_audio_video = $message->message_audio_video ? Crypt::decryptString($message->message_audio_video) : '';

            $message->message_text = $message->message_text ? Helper::encryption($message->message_text,'decrypt') : '';
            $message->message_image = $message->message_image ? Helper::encryption($message->message_image,'decrypt') : '';
            $message->message_audio_video = $message->message_audio_video ? Helper::encryption($message->message_audio_video,'decrypt') : '';
            
        }
        if($inserted) {
            $logdata = [
                'request_data' => $request->all(),
                'response_data' => array('status'=>200,
                'message'=>$message)
            ];
            Helper::save_api_logs($logdata);

            return response()->json([
                'status'=>200,
                'message'=>$message,
            ]);
        } else {
            $logdata = [
                'request_data' => $request->all(),
                'response_data' => array('status'=>200,
                'message'=>__('api.common.server_error'))
            ];
            Helper::save_api_logs($logdata);

            return response()->json([
                'status'=>200,
                'message'=>__('api.common.server_error')
            ]);
        }
    }


    public function delete_message($message_id) {

        $logged_user_id = Auth::user()->id;


        $message_request = Message::where('message_id',$message_id)
            ->where('request_id',$logged_user_id)
            ->first();  


        $message_reciver = Message::where('message_id',$message_id)
            ->where('receiver_id',$logged_user_id)
            ->first();

        if(isset($message_request) or isset($message_reciver)) {

            if($message_request) {

            
                $message_data = Message::where('message_id',$message_id)
                ->where('request_id',$logged_user_id)
                ->update(['request_deleted'=>$logged_user_id]);

                if($message_data) {
                    $logdata = [
                        'request_data' => array('message_id'=>$message_id),
                        'response_data' => array('status'=>200,
                        'recepintUser' => $logged_user_id,
                        'data'=>$message_data)
                    ];
                    Helper::save_api_logs($logdata);

                    return response()->json([
                        'status'=>200,
                        'recepintUser' => $logged_user_id,
                        'data'=>$message_data,
                    ]);
                } else {
                    $logdata = [
                        'request_data' => array('message_id'=>$message_id),
                        'response_data' => array('status'=>200,
                        'recepintUser' => $logged_user_id,
                        'data'=>$message_data)
                    ];
                    Helper::save_api_logs($logdata);

                    return response()->json([
                        'status'=>200,
                        'recepintUser' => $logged_user_id,
                        'data'=>$message_data,
                    ]);
                }

            }

            if($message_reciver) {
                $old_users_is_deleted = !empty($message->receiver_deleted) ? explode(',',$message->receiver_deleted) : [];
                if(!in_array($logged_user_id,$old_users_is_deleted)) {
                    $old_users_is_deleted[] = $logged_user_id;
                }
                $message_data = Message::where('message_id',$message_id)
                        ->where('receiver_id',$logged_user_id)
                        ->update(['receiver_deleted'=>implode(',',$old_users_is_deleted)]);
    
                if($message_data) {
                    $logdata = [
                        'request_data' => array('message_id'=>$message_id),
                        'response_data' => array('status'=>200,
                        'recepintUser' => $logged_user_id,
                        'data'=>$message_data)
                    ];
                    Helper::save_api_logs($logdata);

                    return response()->json([
                        'status'=>200,
                        'recepintUser' => $logged_user_id,
                        'data'=>$message_data,
                    ]);
                } else {
                    $logdata = [
                        'request_data' => array('message_id'=>$message_id),
                        'response_data' => array('status'=>200,
                        'recepintUser' => $logged_user_id,
                        'data'=>$message_data)
                    ];
                    Helper::save_api_logs($logdata);

                    return response()->json([
                        'status'=>200,
                        'recepintUser' => $logged_user_id,
                        'data'=>$message_data,
                    ]);
                    
                }
            }

        } else {
            $logdata = [
                'request_data' => array('message_id'=>$message_id),
                'response_data' => array('status'=>500,
                'message'=>__('api.common.server_error'))
            ];
            Helper::save_api_logs($logdata);

            return response()->json([
                'status'=>500,
                'message'=>__('api.common.server_error')
            ]);
        }


       
        
      
    }

    //Message read statys
    
    public function user_has_unread_message(Request $request,$user_id) {

        if(!empty($user_id) && $user_id != "undefined") {
            $user_id = $user_id;
            $all_blocked_users_ids = Helper::get_blocked_users($user_id);

            if(count($all_blocked_users_ids)>0) {
                $has_unread = Message::whereRaw(" ( is_read is NULL and receiver_id = '".$user_id."' and request_id NOT IN ( '" . implode( "', '" , $all_blocked_users_ids ) . "' ) ) or (  not find_in_set($user_id, is_read) AND receiver_id = '".$user_id."' ) and request_id NOT IN ( '" . implode( "', '" , $all_blocked_users_ids ) . "' )  ");
            } else {
                $has_unread = Message::whereRaw(" ( is_read is NULL and receiver_id = '".$user_id."' ) or (  not find_in_set($user_id, is_read) AND receiver_id = '".$user_id."' )  ");
            }
    
            // $query = str_replace(array('?'), array('\'%s\''), $has_unread->toSql());
            // $query = vsprintf($query, $has_unread->getBindings());
            // dump($query);
            // die;
    
            $has_unread = $has_unread->count();
            //dd($has_unread);
            if(isset($has_unread) && $has_unread >0) {
                $logdata = [
                    'request_data' => $request->all(),
                    'response_data' => array('status'=>200,
                    'unread_count' => $has_unread,
                    'unread_message' => true)
                ];
                Helper::save_api_logs($logdata);

                return response()->json([
                    'status'=>200,
                    'unread_count' => $has_unread,
                    'unread_message' => true,
                ]); 
            } else {
                $logdata = [
                    'request_data' => $request->all(),
                    'response_data' => array('status'=>200,
                    'unread_count' => 0,
                    'unread_message' => false)
                ];
                Helper::save_api_logs($logdata);

                return response()->json([
                    'status'=>200,
                    'unread_count' => 0,
                    'unread_message' => false,
                ]);
            }
        }        
    }
}
