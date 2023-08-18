<?php


namespace App\Helper;

use App\Models\UserPurchaseSubscription;
use App\Models\Connection;
use App\Models\{CommonIcon, User, UserFamily, Message, UserFamilyProfileImage, UserProfileImage, UserLikesHideBlocked, Subscription};
use App\Models\MasterEducational;
use App\Models\{TechnicianAssignSlot,Order,Ticket,MasterChildren, MasterWork, SkinColor, UserRedConnections, UserYellowConnections};
use DB;
use Storage;
use Carbon\Carbon;
use Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use App\Traits\UserTrait;
use Codedge\Fpdf\Fpdf\Fpdf;
use PDF;
use QrCode;
use Config;
use Log;

class Helper
{
    public static function background_colors(){
        return [
            '.bg-color-1',
            '.bg-color-2',
            '.bg-color-3',
            '.bg-color-4',
            '.bg-color-5',
        ];
    }

    public static function get_new_tickets()
    {
        return Ticket::where('status',1)->count();
    }

    public static function get_new_orders()
    {
        return Order::where('order_status','pending')->count();
    }

    public static function is_slot_booked($id, $user_id)
    {
        return TechnicianAssignSlot::where('user_id', $user_id)
                            ->where('slot_id', $id)
                            ->whereDate('date', date('Y-m-d'))
                            ->count();
    }

    public static function get_statuses()
    {
        return [
            'created','assigned','inprogress','completed'
        ];
    }
    public static function custom_user_filter($list, $account_type, $search_keyword, $filter_option = [])
    {
        //dd($account_type);
        if (!empty($account_type)) {
            $list = $list->whereHas('account_type', function ($list) use ($account_type) {
                $list->where('name', $account_type);
            });
        }
        //dd($search_keyword);
        if (!empty($search_keyword)) {
            if (strpos($search_keyword, "@") === 0) {
                $search_keyword = $search_keyword;

                //$search_keyword = str_replace("@","",$search_keyword);
                //dd($request->search_keyword);
                $list = $list->where('users.username', 'like', '%' . $search_keyword . '%');
            } else {
                //dd($search_keyword);
                if (empty($account_type)) {
                    $list = $list->where('users.name', 'like', '%' . $search_keyword . '%');
                    $list = $list->where('users.is_completed', 1)
                        ->where('users.mobile', '!=', Auth::user()->mobile)
                        ->where('users.account_blocked', '!=', 1)
                        ->where('users.id', '!=', 1);

                    // $list = $list->orWhereHas('members', function ($list) use ($search_keyword) {
                    //     $list->where('name', 'like', '%'.$search_keyword.'%');
                    //     $list->has('user.members.user_has_active_subscription');
                    // });
                }
                if ($account_type == 'Family') {
                    $list = $list->where('users.name', 'like', '%' . $search_keyword . '%');
                }
                if ($account_type == 'Individual') {
                    // $list = $list->whereHas('members', function ($list) use ($search_keyword) {
                    //     $list->where('name', 'like', '%'.$search_keyword.'%');
                    // });
                    $list = $list->where('users.name', 'like', '%' . $search_keyword . '%');
                }
            }
        }

        /*  Filter Options */
        //dd($filter_option);
        if (isset($filter_option) && count($filter_option) > 0) {
            foreach ($filter_option[0] as $key => $value) {
                //dd($key);
                if (!empty($value)) {
                    if ($key == 'dob') {

                        $list = $list->whereHas('members', function ($list) use ($key, $value) {
                            $value[0] = $value[0];
                            $value[1] = $value[1] + 1;
                            $list->whereBetween('dob', [now()->subYears($value[1]), now()->subYears($value[0])]);
                        });
                    } else if ($key == 'height') {
                        if ($key == 'height') {
                            $list = $list->whereHas('members', function ($list) use ($key, $value) {
                                $list->whereBetween('height_max', $value);
                            });
                        }
                    } else if ($key == 'children_id') {
                        if ($key == 'children_id') {
                            $ids = self::get_children_ids($value);
                            if ($value == 'yes') {
                                $list = $list->whereHas('members', function ($list) use ($key, $value, $ids) {
                                    $list->whereIn('children_id', $ids);
                                    $list->where('is_hide', 0);
                                });
                            }
                            if ($value == 'no') {
                                $list = $list->whereHas('members', function ($list) use ($key, $value, $ids) {
                                    $list->whereIn('children_id', $ids);
                                    $list->where('is_hide', 0);
                                    //$list->orWhereNull('children_id');
                                });
                            }
                        }
                    } else if (
                        $key == 'gender' ||
                        $key == 'married_previously' ||
                        $key == 'currently_married' ||

                        $key == 'does_she_or_he_has_flexibility_to_marry_a_married_man' ||
                        $key == 'accept_polygamy'
                    ) {
                        //$list = $list->where('users.account_type_id',2);
                        $list = $list->whereHas('members', function ($list) use ($key, $value) {
                            $list->where($key, $value);
                        });
                    } else if (
                        $key == 'do_you_allow_talking_before_marriage'
                    ) {
                        $list = $list->whereIn('users.do_you_allow_talking_before_marriage', $value);
                    } else if (
                        $key == 'do_you_care_about_tribalism'
                    ) {
                        //$list = $list->where('users.do_you_care_about_tribalism',$value);
                        $list = $list->whereHas('members', function ($list) use ($key, $value) {
                            $list->where($key, $value);
                        });
                    } else if (
                        $key == 'is_your_family_tribal'
                    ) {
                        $list = $list->where('users.is_your_family_tribal', $value);
                    } else if (
                        $key == 'nationality_id' ||
                        $key == 'resident_country_id' ||
                        $key == 'live_in_city_id' ||
                        $key == 'live_in_region_id' ||
                        $key == 'family_origin_id' ||
                        $key == 'saudi_family_origin_region_id' ||
                        $key == 'saudi_family_origin_city_id' ||
                        $key == 'tribe_id'
                    ) {
                        $list = $list->whereIn($key, $value);
                    } else if (
                        $key == 'skin_color_id' ||
                        $key == 'education_id' ||
                        $key == 'work_id' ||
                        $key == 'smoking' ||
                        $key == 'sect_id'
                    ) {
                        //$list = $list->where('users.account_type_id',2);
                        $list = $list->whereHas('members', function ($list) use ($key, $value) {
                            $list->whereIn($key, $value);
                        });
                    }
                }
            }
        }



        // $query = str_replace(array('?'), array('\'%s\''), $list->toSql());
        // $query = vsprintf($query, $list->getBindings());
        // dump($query);
        // die;


        return $list;
    }

    public static function get_children_ids($yes_or_no)
    {
        if ($yes_or_no == 'yes') {
            $ids = MasterChildren::select('id')->where('children_count', '!=', 0)->pluck('id')->toArray();
        } else {
            $ids = MasterChildren::select('id')->where('children_count', '=', 0)->pluck('id')->toArray();
        }
        return isset($ids) ? $ids : [];
    }


    public static function check_user_has_access_to_send_request($user_id, $case)
    {
        //dd(date('Y-m-d H:i:s'));
        $connections_sent_count = Connection::where(function ($q) use ($user_id) {
            $q->where('request_id', $user_id)
                ->orWhere('receiver_id', $user_id);
        })
            ->where('connection_status', 'approved')
            ->count();

        $connections_sent_per_day_count = Connection::where(function ($q) use ($user_id) {
            $q->where('request_id', $user_id)
                ->orWhere('receiver_id', $user_id);
        })
            //->where('connection_status','approved')
            ->whereDate('created_at', date('Y-m-d'));
        $connections_sent_per_day_count = $connections_sent_per_day_count->count();

        $total_send_connection = 0;
        $total_day_limit = 0;
        if (Auth::check()) {
            $account_type_id = Auth::user()->account_type_id;
            $account_status = Auth::user()->status;
            if ($account_type_id == 1) { // family
                $list_data = DB::table('master_account_settings')->select('*')
                    ->where('account_type_id', $account_type_id)
                    ->first();
                $total_member = DB::table('user_purchase_subscriptions')
                    ->where('payment_type', 'member_addon')
                    ->where('user_id', $user_id)
                    ->sum('member_included');
                if (!$total_member) {
                    $total_member = 1;
                } else {
                    $total_member = $total_member + 1;
                }
                $total_send_connection = $list_data->connection ? $list_data->connection : 0;
                $total_send_connection = $total_send_connection *  $total_member;
                $total_day_limit =  $list_data->day_limit ? $list_data->day_limit : 0;
            }
            if ($account_type_id == 2) { // Individual
                $list_data = DB::table('master_account_settings')->select('*')
                    ->where('account_type_id', $account_type_id)
                    ->where('status', $account_status)
                    ->first();
                $total_send_connection = $list_data->connection ? $list_data->connection : 0;
                $total_day_limit =  $list_data->day_limit ? $list_data->day_limit : 0;
            }
        }


        if ($case == 'All_CONNECTIONS_USED') {
            if ($total_send_connection <= $connections_sent_count) {
                return 'All_CONNECTIONS_USED';
            }
        }
        if ($case == 'All_CONNECTIONS_USED_PER_DAY') {
            if ($total_day_limit <= $connections_sent_per_day_count) {
                return 'All_CONNECTIONS_USED_PER_DAY';
            }
        }
    }


    public static function check_is_recipitant_has_limit_to_accept_request($recipitant_id)
    {
        $connections_sent_count = Connection::where(function ($q) use ($recipitant_id) {
            $q->where('request_id', $recipitant_id)
                ->orWhere('receiver_id', $recipitant_id);
        })
            ->where('connection_status', 'approved')
            ->count();

        $total_send_connection = 0;
        $total_day_limit = 0;
        $recipitant_data = User::find($recipitant_id);
        $account_type_id = $recipitant_data->account_type_id;
        $account_status = $recipitant_data->status;
        $list_data = DB::table('statuses')->select('*')
            ->where('account_type', $account_type_id)
            ->where('type', $account_status)
            ->first();
        $total_send_connection = $list_data->connection_limit ? $list_data->connection_limit : 0;
        $total_day_limit =  $list_data->per_day_limit ? $list_data->per_day_limit : 0;
        $last_active_connection_limit = $total_send_connection - 1;
        if ($last_active_connection_limit == $connections_sent_count) {
            return 'LAST_ACTIVE_CONNECTION_REACHED';
        }

        if ($total_send_connection >= $connections_sent_count) {
            return 'NOT_USED_ALL_CONNECTION';
        } else {
            return 'All_CONNECTIONS_USED';
        }
    }



    public static function check_user_has_access_to_send_request_bk($user_id, $case)
    {
        $connections_sent_count = Connection::where(function ($q) use ($user_id) {
            $q->where('request_id', $user_id)
                ->orWhere('receiver_id', $user_id);
        })->where('connection_status', 'approved')->count();
        $connections_sent_per_day_count = Connection::where(function ($q) use ($user_id) {
            $q->where('request_id', $user_id)
                ->orWhere('receiver_id', $user_id);
        })
            ->where('connection_status', 'approved')
            ->whereDate('created_at', date('Y-m-d'));
        $connections_sent_per_day_count = $connections_sent_per_day_count->count();
        //dd($connections_sent_per_day_count);
        $user_subscription_list = UserPurchaseSubscription::with('subscription_detail')->where('user_id', $user_id)->where('status', 'active')->first();
        $total_send_connection = 0;
        $total_day_limit = 0;
        if ($user_subscription_list) {
            /*
            foreach($user_subscription_list as $subscription) {
                //dd($subscription->subscrition_detail->member_no);
                $total_send_connection += $total_send_connection + $subscription->subscrition_detail->member_no;
            }
            */
            $total_send_connection = $user_subscription_list->subscription_detail->active_connections;
            $total_day_limit =  $user_subscription_list->subscription_detail->day_limit;
        }

        if ($case == 'All_CONNECTIONS_USED') {
            if ($connections_sent_count >= $total_send_connection) {
                return 'All_CONNECTIONS_USED';
            }
        }
        if ($case == 'All_CONNECTIONS_USED_PER_DAY') {
            if ($connections_sent_per_day_count >= $total_day_limit) {
                return 'All_CONNECTIONS_USED_PER_DAY';
            }
        }
    }

    public static function get_all_other_users($user_id, $by_status)
    {
        $users = Connection::where(function ($q) use ($user_id) {
            $q->where('request_id', $user_id)
                ->orWhere('receiver_id', $user_id);
        });
        /*
        if($by_status) {
            $users = $users->where('connection_status','approved');
        } elseif() {
            $users = $users->where('connection_status','approved');
        } else {
            $users = $users->where('connection_status','approved');
        }
        */
        $users = $users->where('connection_status', $by_status);

        $users = $users->paginate(10);
        $connected_users = [];
        if ($users) {
            foreach ($users as $user) {

                $connected_users[] = $user->receiver_id != $user_id ? $user->receiver_id : $user->request_id;
            }
        }
        //dd($connected_users);
        $connected_users_list = User::whereIn('id', $connected_users)->get();
        if ($connected_users_list) {
            foreach ($connected_users_list as $user) {
                //dd($user);
                //dd(self::ck_connection($user_id,$user->id));
                $user->connection_status = self::ck_connection($user_id, $user->id);
            }
        }
        if ($connected_users_list)
            return $connected_users_list;
        else
            return [];
    }


    public static function get_all_connected_users_array($user_id, $by_status = null)
    {
        $users = Connection::select('request_id', 'receiver_id')->where(function ($q) use ($user_id) {
            $q->where('request_id', $user_id)
                ->orWhere('receiver_id', $user_id);
        });

        $users = $users->where('connection_status', $by_status);


        $users_list_recivers = $users->pluck('receiver_id')->toArray(); // array of ads ids
        $users_list_request_ids = $users->pluck('request_id')->toArray();
        $merge_all_ids = array_merge($users_list_recivers, $users_list_request_ids);
        foreach (array_keys($merge_all_ids, $user_id) as $key) {
            unset($merge_all_ids[$key]);
        }
        return $merge_all_ids;
    }

    public static function get_all_favroite_users($user_id, $by_status)
    {
        $fav_user_list = DB::table('user_favourites')->select('users.*')->leftJoin('users', 'users.id', 'user_favourites.favourite_user_id')->where('user_id', $user_id)->paginate(10);
        if ($fav_user_list) {
            foreach ($fav_user_list as $user) {
                //dd($user);
                //dd(self::ck_connection($user_id,$user->id));
                $user->connection_status = self::ck_connection($user_id, $user->id);
            }
        }
        if ($fav_user_list)
            return $fav_user_list;
        else
            return [];
    }

    public static function get_all_favroite_users_array($user_id)
    {
        //$user_id = 196;
        $users = DB::table('user_likes_hide_blocked')->select('user_id')
            ->where('is_liked', 1)
            ->where('request_id', $user_id);

        $users_list = $users->pluck('user_id')->toArray(); // array of ads ids
        //dd($users_list);
        return count($users_list) > 0 ? $users_list : [];
    }

    public static function ck_connection($logged_user_id, $user_id)
    {
        $connections_status = Connection::select('connection_status')->where(function ($q) use ($logged_user_id, $user_id) {
            $q->where('request_id', $logged_user_id)
                ->where('receiver_id', $user_id);
        })->orWhere(function ($q) use ($logged_user_id, $user_id) {
            $q->where('receiver_id', $logged_user_id)
                ->where('request_id', $user_id);
        });
        /*
        $query = str_replace(array('?'), array('\'%s\''), $connections_status->toSql());
        $query = vsprintf($query, $connections_status->getBindings());
        dump($query);
        die;
        */

        $connections_status = $connections_status->first();
        if ($connections_status)
            return $connections_status->connection_status;
        else
            return false;
    }

    public static function connection_detail($logged_user_id, $user_id)
    {
        $connections_status = Connection::select('*')->where(function ($q) use ($logged_user_id, $user_id) {
            $q->where('request_id', $logged_user_id)
                ->where('receiver_id', $user_id);
        })->orWhere(function ($q) use ($logged_user_id, $user_id) {
            $q->where('receiver_id', $logged_user_id)
                ->where('request_id', $user_id);
        });
        /*
        $query = str_replace(array('?'), array('\'%s\''), $connections_status->toSql());
        $query = vsprintf($query, $connections_status->getBindings());
        dump($query);
        die;
        */

        $connections_status = $connections_status->first();
        if ($connections_status)
            return $connections_status;
        else
            return false;
    }


    public static function is_picture_liked($pic_id, $user_id, $user_type)
    {

        if (Auth::check()) {
            $data =  DB::table('user_likes_gallery_images')->select('is_liked')
                ->where('profile_image_id', $pic_id)
                ->where('request_id', Auth::user()->id)
                ->where('user_id', $user_id);
            // $query = str_replace(array('?'), array('\'%s\''), $data->toSql());
            // $query = vsprintf($query, $data->getBindings());
            // return $query;
            //dump($query);
            //die;

            $data = $data->first();
            //dd($data);
            if (isset($data) && $data->is_liked) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }


    public static function get_profile_images($user)
    {
        $profile_images = $user->profile_images_list()->select('id', 'user_id', 'profile_img', 'is_default')->get();
        if ($profile_images) {
            foreach ($profile_images as $key => $profile_image) {
                //$profile_images[$key]->profile_img = $profile_image->profile_img;
                $profile_images[$key]->is_liked = self::is_picture_liked($profile_image->id, $profile_image->user_id, 'individual');
            }
        }
        return $profile_images;
    }


    public static function get_profile_individual_or_family_images($member)
    {

        $profile_images = $member->profile_images_list()->select('id', 'user_family_id', 'profile_img', 'is_default')->get();
        if ($profile_images) {
            foreach ($profile_images as $key => $profile_image) {
                //$profile_images[$key]->profile_img = $profile_image->profile_img;
                $profile_images[$key]->is_liked = self::is_picture_liked($profile_image->id, $profile_image->user_family_id, 'individual');
            }
        }
        return $profile_images;
    }



    public static function all_connected_users($logged_user_id)
    {
        //dd($logged_user_id);
        $members_list = Connection::select('request_id', 'receiver_id')
            ->where('connection_status', 'approved')
            ->where(function ($q) use ($logged_user_id) {
                $q->where('receiver_id', $logged_user_id)
                    ->orWhere('request_id', $logged_user_id);
            });


        // $query = str_replace(array('?'), array('\'%s\''), $members_list->toSql());
        // $query = vsprintf($query, $members_list->getBindings());
        // dump($query);
        // die;


        $members_list = $members_list->paginate(10);
        $all_other_users_arr1 = $members_list->pluck('receiver_id')->toArray(); // array of ads ids
        $all_other_users_arr2 = $members_list->pluck('request_id')->toArray();
        $user_list = array_merge($all_other_users_arr1, $all_other_users_arr2);

        $user_list = array_diff($user_list, [$logged_user_id]);
        $user_list = array_values($user_list);

        // sorting custom
        $user_has_message_list = [];
        $user_has_no_message_list = [];
        if (count($user_list) > 0) {
            foreach ($user_list as $user_id) {
                $has_message = self::get_user_has_message($user_id, $logged_user_id);
                if ($has_message) {
                    $user_has_message_list[] = $user_id;
                } else {
                    $user_has_no_message_list[] = $user_id;
                }
            }
            $sorted_user_list = array_merge($user_has_message_list, $user_has_no_message_list);
        }
        //dd($sorted_user_list);
        return (count($user_list) > 0) ? $sorted_user_list : [];
    }

    public static function all_connected_users_new($logged_user_id)
    {
        //dd($logged_user_id);
        $members_list = Connection::select('request_id', 'receiver_id')
            ->where('connection_status', 'approved')
            ->where(function ($q) use ($logged_user_id) {
                $q->where('receiver_id', $logged_user_id)
                    ->orWhere('request_id', $logged_user_id);
            });


        // $query = str_replace(array('?'), array('\'%s\''), $members_list->toSql());
        // $query = vsprintf($query, $members_list->getBindings());
        // dump($query);
        // die;


        $members_list = $members_list->paginate(10);

        $all_other_users_arr1 = $members_list->pluck('receiver_id')->toArray(); // array of ads ids
        $all_other_users_arr2 = $members_list->pluck('request_id')->toArray();

        $user_list = array_merge($all_other_users_arr1, $all_other_users_arr2);

        $user_list = array_diff($user_list, [$logged_user_id]);
        $user_list = array_values($user_list);

        // sorting custom
        $user_has_message_list = [];
        $user_has_no_message_list = [];
        if (count($user_list) > 0) {
            foreach ($user_list as $user_id) {
                $has_message = self::get_user_has_message($user_id, $logged_user_id);
                if ($has_message) {
                    $user_has_message_list[] = $user_id;
                } else {
                    $user_has_no_message_list[] = $user_id;
                }
            }
            $sorted_user_list = array_merge($user_has_message_list, $user_has_no_message_list);
        }
        //dd($sorted_user_list);
        return [
            'members_list' => $members_list,
            'user_has_message_list' => $user_has_message_list,
            'user_has_no_message_list' => $user_has_no_message_list,
        ];
    }


    public static function get_user_latest_message($user_id, $logged_user_id)
    {
        //return $user_id;
        $messages = Message::select('*')->where(function ($q) use ($logged_user_id, $user_id) {
            $q->where('request_id', $logged_user_id)
                ->where('receiver_id', $user_id);
        })->orWhere(function ($q) use ($logged_user_id, $user_id) {
            $q->where('receiver_id', $logged_user_id)
                ->where('request_id', $user_id);
        })
            ->orderBy('id', 'DESC');
        // $query = str_replace(array('?'), array('\'%s\''), $message->toSql());
        // $query = vsprintf($query, $message->getBindings());
        // dump($query);
        // die;
        $messages = $messages->get();


        //
        //dd($message);
        $mess_data = [];
        if ($messages) {
            foreach ($messages as $key => $message) {
                $message[$key]->is_deleted = self::check_for_delete_message($logged_user_id, $message->message_id);
                if ($message->is_deleted == false) {
                    $is_read = false;
                    if (!empty($message->is_read) && $message->receiver_id == $logged_user_id) {
                        $is_read_arr = explode(',', $message->is_read);
                        if (in_array($logged_user_id, $is_read_arr)) {
                            $is_read = true;
                        }
                    }
                    $message[$key]->is_read = $is_read;
                    $message[$key]->is_my_message = $message->request_id == $logged_user_id ? true : false;

                    // $message[$key]->message_text = !empty($message->message_text) ? Crypt::decryptString($message->message_text) : '';
                    // $message[$key]->message_image = !empty($message->message_image) ? Crypt::decryptString($message->message_image) : '';
                    // $message[$key]->message_audio_video = !empty($message->message_audio_video) ? Crypt::decryptString($message->message_audio_video) : '';

                    $message[$key]->message_text = !empty($message->message_text) ? Helper::encryption($message->message_text, 'decrypt') : '';
                    $message[$key]->message_image = !empty($message->message_image) ? Helper::encryption($message->message_image, 'decrypt') : '';
                    $message[$key]->message_audio_video = !empty($message->message_audio_video) ? Helper::encryption($message->message_audio_video, 'decrypt') : '';

                    $message[$key]->time_12_format = $message->updated_at ? date('h:i A', strtotime($message->updated_at)) : ($message->created_at ? date('h:i A', strtotime($message->created_at)) : '--');

                    return  $message;
                }
            }
        } else {
            return false;
        }
    }


    public static function get_user_has_message($user_id, $logged_user_id)
    {
        //return $user_id;
        $message = Message::select('*')->where(function ($q) use ($logged_user_id, $user_id) {
            $q->where('request_id', $logged_user_id)
                ->where('receiver_id', $user_id);
        })->orWhere(function ($q) use ($logged_user_id, $user_id) {
            $q->where('receiver_id', $logged_user_id)
                ->where('request_id', $user_id);
        })
            ->orderBy('id', 'DESC')
            ->first();
        if ($message) {
            return  true;
        } else {
            return false;
        }
    }


    public static function get_subscription_expired_date($package_id, $user_id)
    {
        $sub = DB::table('subscriptions')->where('id', $package_id)
            ->first();
        $user_subs = UserPurchaseSubscription::where('user_id', $user_id)->where('status', 'active')->first();
        $expiry_date = isset($user_subs->expired_date) ? $user_subs->expired_date : '';

        $days_left = 0;
        if (strtotime($expiry_date) > strtotime(date('Y-m-d')) && !empty($expiry_date)) {
            $date = Carbon::parse($expiry_date);
            $now = Carbon::now();
            $days_left = $date->diffInDays($now);
        }

        if ($sub) {
            $new_expiry_date = Carbon::now()->addMonths($sub->duration);
            if ($days_left > 0) {
                $new_expiry_date->addDays($days_left);
            }
            return $new_expiry_date;
        }
    }

    public static function has_active_subscription($user_id)
    {
        //$user_id = Auth::user()->id;
        $user_subs = UserPurchaseSubscription::where('user_id', $user_id)->where('status', 'active')->first();
        if ($user_subs) {
            return true;
        } else {
            false;
        }
    }

    // public static function has_active_subscription($user_id){
    //     //$user_id = Auth::user()->id;
    //     $user_subs = UserPurchaseSubscription::where('user_id',$user_id)->where('status','active')->first();
    //     if($user_subs) {
    //         return true;
    //     } else {
    //         false;
    //     }
    // }


    public static function get_user_profile_images($id, $user_id, $user_default_id)
    {
        if (!empty($user_default_id)) {
            $user_profile_pic = UserProfileImage::where('user_id', $id)->get();
            if ($user_profile_pic) {
                return $user_profile_pic;
            } else {
                return [];
            }
        } else {
            $user_profile_pic = UserFamilyProfileImage::where('user_family_id', $user_id)->get();
            if ($user_profile_pic) {
                return $user_profile_pic;
            } else {
                return [];
            }
        }
    }

    public static function get_user_profile_image($user_id)
    {
        if (!empty($user_id)) {
            $user_profile_pic = UserProfileImage::where('user_id', $user_id)->where('is_default', '1')->first();
            if ($user_profile_pic) {
                return $user_profile_pic->profile_img;
            } else {
                return false;
            }
        }
    }

    public static function user_likes_hide_blocked($id, $user_type)
    {

        $logged_in_id = Auth::user()->id;

        $user_likes_hide_blocked = UserLikesHideBlocked::select('*')
            ->where('user_type', $user_type)
            ->where('user_id', $id)
            ->where('request_id', $logged_in_id)
            ->first();
        if ($user_likes_hide_blocked) {
            return $user_likes_hide_blocked;
        } else {
            return false;
        }
    }


    public static function user_likes_hide_blocked_detail($id)
    {

        $logged_in_id = Auth::user()->id;

        $user_likes_hide_blocked = UserLikesHideBlocked::select('*')
            ->where('user_id', $id)
            ->where('request_id', $logged_in_id)
            ->first();
        if ($user_likes_hide_blocked) {
            return $user_likes_hide_blocked;
        } else {
            return false;
        }
    }





    public static function sendSms($message, $to, $type = 1)
    {
        // if(env('SANDBOX_MODE') == true) {
        //     return true;
        // }
        $url="https://bms-api.bab.sa/websmpp/websms?";

        $text_message=urlencode($message);
        $sbn_val= "user=".urlencode('Awaser')."&pass=".urlencode('Awa5570')."&type=".$type."&text=".$text_message."&sid=".urlencode('awaser app')."&mno=966".urlencode($to);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        //curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
        curl_setopt($ch, CURLOPT_POSTFIELDS,$sbn_val);
        curl_setopt($ch, CURLOPT_ENCODING,"");

        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-type: application/x-www-form-urlencoded;charset=utf-8'
        ));
        //curl_setopt($ch, CURLOPT_ENCODING ,"");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        $server_output = curl_exec($ch);
        Log::info('SMS Server LOG: '.$server_output);
        //dd($server_output);
        curl_close($ch);
    }

    public static function get_account_type($user_id)
    {
        $user = User::find($user_id);
        if ($user) {
            return isset($user->account_type_id) ? $user->account_type_id : false;
        } else {
            return false;
        }
    }

    public static function connection_removed( $user_id, $recepint_user_id)
    {
        if(1) {
            $data = [
                'requestd_at'=>date('Y-m-d H:i:s'),
                'connection_status'=>'removed'
            ];
            $logged_user_id = $user_id;
            $recepint_user_id = $recepint_user_id; //$request->recepintUser;
            $inserted = Connection::where(function($q) use ($logged_user_id,$recepint_user_id) {
                $q->where('request_id', $logged_user_id)
                  ->where('receiver_id', $recepint_user_id);
            })->orWhere(function($q) use ($logged_user_id,$recepint_user_id) {
                $q->where('receiver_id', $logged_user_id)
                  ->where('request_id', $recepint_user_id);
            })->update($data);
            if($inserted)
            {
                return true;
            }
        }

    }


    public static function getUserName($user_id)
    {
        $user = User::find($user_id);
        if ($user) {
            return isset($user->username) ? $user->username : '--';
        } else {
            return '--';
        }
    }


    public static function getName($user_id)
    {
        $user = User::find($user_id);
        if ($user) {
            if ($user->account_type_id == 1) {
                return isset($user->name) ? $user->name : $user->username;
            } else {
                $user_family = UserFamily::where('user_id', $user_id)->first();
                return isset($user_family->name) ? $user_family->name : $user->username;
            }
        } else {
            return '--';
        }
    }


    public static function send_notification_FCM($device_tokens, $message, $message_data, $sender_id, $receiver_ids, $key1, $key2 = null, $notification_type = null)
    {

        // $accesstoken = 'fxz4GwHIRtqf6nk_UYoUFx:APA91bH6UDvEcerWGxGt9HxgeLSjoZIwj7hGdtVr55d7VCzy2bA3XQ1OOkEKbrcEFpZ0mw8VADoQLmrOitItFM3VyX8_Ut6wYFTsgM6uOypr-Pc-kPTrlBSBHPMlJQADmuPqQvnB64RL';//env('FCM_KEY');

        $SERVER_API_KEY = 'AAAATdz_qKs:APA91bEiPTZyM0Bg_lYGjzsNL7YP986BLmj2JDOEkbyxWjkvq5XNsKZYXzQvHvAAkpK-D6RrTDMxnLXI_pd32fs3EnKR1ercM1zzjwdE9HBJW59c9F3jJN0EC0q6lVEJMVuBLmh-WHrv';

        // payload data, it will vary according to requirement
        $data = [
            "registration_ids" => $device_tokens, // for multiple device ids
            "notification" => $message,
            "data" => $message
        ];
        $dataString = json_encode($data);

        $headers = [
            'Authorization: key=' . $SERVER_API_KEY,
            'Content-Type: application/json',
        ];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);

        $response = curl_exec($ch);
        curl_close($ch);

        if ($notification_type != 'message') {
            $insert_data = [
                'message_en' => $message_data->message_value_en,
                'message_ar' => $message_data->message_value_ar,
                'sender_id' => $sender_id,
                'receiver_ids' => $receiver_ids,
                'key1' => $key1,
                'key2' => $key2,
                'notification_type' => $notification_type,
                'created_at' => date('Y-m-d H:i:s')
            ];
            $notification_insert_data[]  =  $insert_data;

            DB::table('user_notifications')->insert($notification_insert_data);
        }



        //return $response;

    }

    public static function send_notification_test_FCM($device_tokens, $message, $message_data, $sender_id, $receiver_ids, $key1, $key2 = null, $notification_type = null)
    {

        // $accesstoken = 'fxz4GwHIRtqf6nk_UYoUFx:APA91bH6UDvEcerWGxGt9HxgeLSjoZIwj7hGdtVr55d7VCzy2bA3XQ1OOkEKbrcEFpZ0mw8VADoQLmrOitItFM3VyX8_Ut6wYFTsgM6uOypr-Pc-kPTrlBSBHPMlJQADmuPqQvnB64RL';//env('FCM_KEY');

        $SERVER_API_KEY = 'AAAATdz_qKs:APA91bEiPTZyM0Bg_lYGjzsNL7YP986BLmj2JDOEkbyxWjkvq5XNsKZYXzQvHvAAkpK-D6RrTDMxnLXI_pd32fs3EnKR1ercM1zzjwdE9HBJW59c9F3jJN0EC0q6lVEJMVuBLmh-WHrv';

        // payload data, it will vary according to requirement
        $data = [
            "registration_ids" => $device_tokens, // for multiple device ids
            "notification" => $message,
            "data" => $message
        ];
        $dataString = json_encode($data);

        $headers = [
            'Authorization: key=' . $SERVER_API_KEY,
            'Content-Type: application/json',
        ];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);

        $response = curl_exec($ch);
        curl_close($ch);

        dd($response);
        return $response;

    }


    public static function getRecipantDeviceTokens($user_id = null, $type)
    {
        if (!empty($user_id)) {


            $devices_tokens = DB::table('users')->select('device_token')
                ->where('id', $user_id);
            if ($type != 'education') {
                $devices_tokens =  $devices_tokens->where('allow_notification_messages', 'yes');
            }
            if ($type == 'education') {
                $devices_tokens =  $devices_tokens->where('allow_notification_education_content', 'yes');
            }
            $devices_tokens =  $devices_tokens->where('device_token', '!=', '')
                ->pluck('device_token')->toArray();
        } else {
            $devices_tokens = DB::table('users')->select('device_token')
                ->where('id', '!=', 1);
            if ($type == 'education') {
                $devices_tokens =  $devices_tokens->where('allow_notification_education_content', 'yes');
            }
            $devices_tokens =  $devices_tokens->where('device_token', '!=', '')
                ->pluck('device_token')->toArray();
        }

        if ($devices_tokens)
            return $devices_tokens;
        else
            return [];
    }

    public static function getRecipantFamilyDeviceTokens($user_id = null, $type)
    {
        if (!empty($user_id)) {

            $user_family = DB::table('user_families')->where('id',$user_id)->first();
            if(isset($user_family)) {
                $user_id = $user_family->user_id;
                $devices_tokens = DB::table('users')->select('device_token')
                ->where('id', $user_id);
                if ($type != 'education') {
                    $devices_tokens =  $devices_tokens->where('allow_notification_messages', 'yes');
                }
                if ($type == 'education') {
                    $devices_tokens =  $devices_tokens->where('allow_notification_education_content', 'yes');
                }
                $devices_tokens =  $devices_tokens->where('device_token', '!=', '')
                    ->pluck('device_token')->toArray();
            }
            
        } else {
            $devices_tokens = DB::table('users')->select('device_token')
                ->where('id', '!=', 1);
            if ($type == 'education') {
                $devices_tokens =  $devices_tokens->where('allow_notification_education_content', 'yes');
            }
            $devices_tokens =  $devices_tokens->where('device_token', '!=', '')
                ->pluck('device_token')->toArray();
        }

        if ($devices_tokens)
            return $devices_tokens;
        else
            return [];
    }

    public static function getMessageByCode($code)
    {
        $message_data = DB::table('master_popup_messages')->select('*')
            ->where('group_name', $code)
            ->first();
        if ($message_data)
            return $message_data;
        else
            return false;
    }


    public static function getUserIDs()
    {
        $ids = DB::table('users')->select('id')
            ->where('id', '!=', 1)
            ->where('device_token', '!=', '')
            ->pluck('id')->toArray();


        if ($ids)
            return implode(',', $ids);
        else
            return null;
    }

    public static function get_latest_subscription($user_id,$status="")
    {
        $data = DB::table('user_purchase_subscriptions')
            ->select('user_purchase_subscriptions.*', 'subscriptions.name')
            ->leftJoin('subscriptions', 'subscriptions.id', 'user_purchase_subscriptions.subscription_id')
            ->where('user_purchase_subscriptions.user_id', $user_id)
            ->where('user_purchase_subscriptions.status',$status)
            ->orderBy('user_purchase_subscriptions.id', 'desc')
            ->first();

        return $data;
    }

    public static function check_for_delete_message($logged_in_id, $message_id)
    {

        $message = Message::where('message_id', $message_id)->first();
        $is_deleted = false;
        if (isset($message)) {
            $logged_in_id = $logged_in_id;
            $message_id = $message->id;
            $request_id = $message->request_id;
            $receiver_id = $message->receiver_id;
            $receiver_deleted = $message->receiver_deleted; // string
            $request_deleted = $message->request_deleted; /// only id


            //dd($logged_in_id);
            if ($logged_in_id == $request_id) { // self send message
                if (!empty($request_deleted) && ($request_deleted ==  $request_id)) {
                    $is_deleted = true;
                    return $is_deleted;
                } else {
                    return false;
                }
            } else { //reciving message

                if (!empty($receiver_deleted)) {
                    if (in_array($receiver_id, explode(',', $receiver_deleted))) {
                        $is_deleted = true;
                    }
                }

                if (!empty($request_deleted)) {
                    if ($request_deleted ==  $request_id) {
                        $is_deleted = true;
                    }
                }
            }
        }

        //dd($is_deleted);

        return $is_deleted;
    }

    public static function get_time_line_minutes($post_date)
    {

        $ptime = strtotime($post_date);
        $etime = time() - $ptime;

        $one_mnth_time = strtotime('-1 month');
        if ($ptime > strtotime('-1 month')) {
            if ($etime < 1) {
                return trans('api.timeline.seconds', ['attribute' => 0]);
            }

            $a = array(
                365 * 24 * 60 * 60  =>  'year',
                30 * 24 * 60 * 60  =>  'month',
                24 * 60 * 60  =>  'day',
                60 * 60  =>  'hour',
                60  =>  'minute',
                1  =>  'second'
            );



            foreach ($a as $secs => $str) {
                $d = $etime / $secs;
                if ($d >= 1) {
                    $r = round($d);
                    if ($r > 1) {
                        return trans('api.timeline_plural.' . $str, ['attribute' => $r]);
                    } else {
                        return trans('api.timeline_singular.' . $str, ['attribute' => $r]);
                    }
                }
            }
        } else {
            return date('d-m-Y', strtotime($post_date));
        }
    }

    public static function get_connection_limits($user_id, $account_type_id)
    {
        if (!empty($account_type_id)) {
            if ($account_type_id == 1) {
                $data = DB::table('master_account_settings')
                    ->where('account_type_id', $account_type_id)
                    ->first();
                if (isset($data)) {
                    $data->connection_limit = $data->connection;
                    $data->pending_connection_limit = self::get_pending_connection($user_id, $account_type_id, '', $data->connection);
                    $data->pending_per_day_connection_limit = self::get_pending_per_day_connection($user_id, $account_type_id, '', $data->day_limit);
                }
            }
            if ($account_type_id == 2) {
                $data = DB::table('master_account_settings')
                    ->where('account_type_id', $account_type_id)
                    ->first();
                if (isset($data)) {

                    $data->connection_limit = $data->connection;
                    $data->pending_connection_limit = self::get_pending_connection($user_id, $account_type_id, $data->status, $data->connection);
                    $data->pending_per_day_connection_limit = self::get_pending_per_day_connection($user_id, $account_type_id, $data->status, $data->day_limit);
                }
            }

            return $data;
        } else {
            return false;
        }
    }

    public static function get_connection_limits_all($user_id, $account_type_id)
    {
        if (!empty($account_type_id)) {
            if ($account_type_id == 1) {
                $data = DB::table('master_account_settings')
                    ->where('account_type_id', $account_type_id)
                    ->first();
                if (isset($data)) {
                    $data->connection_limit = $data->connection;
                    $data->pending_connection_limit = self::get_pending_connection($user_id, $account_type_id, '', $data->connection);
                    $data->pending_per_day_connection_limit = self::get_pending_per_day_connection($user_id, $account_type_id, '', $data->day_limit);
                }
            }
            if ($account_type_id == 2) {
                $data = DB::table('master_account_settings')
                    ->where('account_type_id', $account_type_id)
                    ->get();
                if (isset($data)) {

                    foreach ($data as $row) {
                        $row->connection_limit = $row->connection;
                        $row->pending_connection_limit = self::get_pending_connection($user_id, $account_type_id, $row->status, $row->connection);
                        $row->pending_per_day_connection_limit = self::get_pending_per_day_connection($user_id, $account_type_id, $row->status, $row->day_limit);
                    }
                }
            }

            return $data;
        } else {
            return false;
        }
    }

    public static function get_pending_connection($user_id, $account_type_id, $type = null, $connection_limit)
    {
        $pending_conection = $connection_limit;
        //$user_id = Auth::user()->id;
        if ($account_type_id == 2) {
            switch ($type) {
                case 'green':
                    $pending_conection = Connection::where(function ($q) use ($user_id) {
                        $q->where('request_id', $user_id)
                            ->orWhere('receiver_id', $user_id);
                    })
                        ->where('connection_status', 'approved')
                        ->count();
                    break;
                case 'yellow':
                    $pending_conection = UserYellowConnections::where('user_id', $user_id)->count();
                    break;
                case 'red':
                    $pending_conection = UserRedConnections::where('user_id', $user_id)->count();
                    break;

                default:
                    $pending_conection;
                    break;
            }
            $pending_conection = $connection_limit - $pending_conection;
        }
        if ($account_type_id == 1) {
            $pending_conection = $connection_limit;
        }

        return $pending_conection;
    }
    // comment

    public static function get_pending_per_day_connection($user_id, $account_type_id, $type, $per_day_limit)
    {
        $connections_sent_per_day_count = $per_day_limit;
        //$user_id = Auth::user()->id;
        //dd(date('Y-m-d'));
        $connections_sent_per_day_count = Connection::where(function ($q) use ($user_id) {
            $q->where('request_id', $user_id)
                ->orWhere('receiver_id', $user_id);
        })
            //->where('connection_status','approved')
            //->where('connection_status','!=','removed')
            ->whereDate('created_at', date('Y-m-d'));

        $connections_sent_per_day_count = $connections_sent_per_day_count->count();


        return $per_day_limit - $connections_sent_per_day_count;
    }

    public static function can_add_member_maximum($user_id, $account_type_id)
    {

        if ($account_type_id == 1) {

            $already_added_member = UserFamily::where('user_id', $user_id)
                ->count();


            //$total_member_added = DB::table('user_member_addon')->where('user_id',$user_id)->sum('member_add_on');
            $total_member_added = DB::table('user_purchase_subscriptions')
                //->where('payment_type','member_addon')
                ->where('user_id', $user_id)
                ->where('status', 'active')
                ->sum('member_included');
            if (!$total_member_added) {
                $total_member_added = 1;
            } else {
                $total_member_added = $total_member_added;
            }
            if ($already_added_member  == 4) {
                return 0;
            } else {
                return $total_member_added - $already_added_member;
            }
        } else {
            return 0;
        }
    }

    public static function report_count($user_id)
    {
        $report_count = DB::table('user_likes_hide_blocked')->where('user_id', $user_id)->where('is_reported', 1)->count();
        return isset($report_count) ? $report_count : '--';
    }


    public static function get_reported_by_name($request_id, $type)
    {
        if ($type == 'family') {
            $user_detail = User::find($request_id);
            return $user_detail->family_name;
        } else {
            $user_detail = UserFamily::where('user_id', $request_id)->first();
            return $user_detail->name;
        }
    }

    public static function resizeAndCompressImagefunction($file, $base64_file, $w, $h, $crop = FALSE)
    {
        list($width, $height) = getimagesize($base64_file);
        $r = $width / $height;
        if ($crop) {
            if ($width > $height) {
                $width = ceil($width - ($width * ($r - $w / $h)));
            } else {
                $height = ceil($height - ($height * ($r - $w / $h)));
            }
            $newwidth = $w;
            $newheight = $h;
        } else {
            if ($w / $h > $r) {
                $newwidth = $h * $r;
                $newheight = $h;
            } else {
                $newheight = $w / $r;
                $newwidth = $w;
            }
        }
        $image_info = getimagesize($base64_file);
        $raw_image = explode(',', $base64_file)[1];
        //dd($raw_image);
        $data = base64_decode($raw_image);
        $src = imagecreatefromstring($data);
        $dst = imagecreatetruecolor($newwidth, $newheight);
        imagecopyresampled($dst, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
        return $dst;
    }

    public static function user_has_unread_notifications()
    {
        $logged_in_user = Auth::user()->id;
        $badge_count = DB::table('user_notifications')
            ->whereRaw("find_in_set($logged_in_user, receiver_ids)");

        $all_blocked_users_ids = self::get_blocked_users($logged_in_user);
        if (count($all_blocked_users_ids) > 0) {
            $badge_count = $badge_count->whereNotIn('user_notifications.sender_id', $all_blocked_users_ids);
        }


        $badge_count = $badge_count->whereRaw("
                            ( not find_in_set($logged_in_user, is_read) AND find_in_set($logged_in_user, receiver_ids))
                            or ( is_read is NULL AND find_in_set($logged_in_user, receiver_ids) )");

        // $query = str_replace(array('?'), array('\'%s\''), $badge_count->toSql());
        // $query = vsprintf($query, $badge_count->getBindings());
        // dump($query);
        // die;
        $badge_count = $badge_count->count();
        return isset($badge_count) ? $badge_count : 0;
    }

    public static function get_blocked_users($logged_in_user)
    {
        $blocked_user_ids = UserLikesHideBlocked::select('user_id')->where('is_blocked', 1)->where('request_id', $logged_in_user)->pluck('user_id')->toArray();
        return isset($blocked_user_ids) ? $blocked_user_ids : [];
    }

    public static function get_other_blocked_users($logged_in_user, $user_id)
    {
        $blocked_user = UserLikesHideBlocked::select('user_id')
        ->where('is_blocked', 1)
        ->where('request_id','=', $user_id) //8077
        ->where('user_id','=', $logged_in_user) //8077
        ->count();
        if(isset($blocked_user)) {
            if($blocked_user == 0)
            {
              return true;
            } else if ($blocked_user > 0) {
             return false;
            }
        } else {
            return true;
        }


    }


    public static function get_all_connected_users_list($type)
    {
        $logged_user_id = Auth::user()->id;
        // GENERAL DATA
        $commonIcon = CommonIcon::all();
        $list = User::select('users.*')->with('account_type');
        //->with('profile_images')
        $list = $list->with('members');

        $list = $list->with('members.skin_detail', 'members.work_detail', 'members.education_detail', 'members.children_detail', 'members.sect_detail', 'members.hijab_detail', 'user_has_active_subscription')
            ->with('family_origin_detail')
            ->with('nationality_detail')
            ->with('nationality_current_detail')
            ->with('live_in_city_detail')
            ->has('user_has_active_subscription')
            ->with('personality_dimension')
            ->with('tribe_detail');

        // if(Auth::user()->status == 'yellow') {
        //     $list->leftJoin('user_yellow_connections','user_yellow_connections.request_id','users.id')
        //           ->where('user_yellow_connections.user_id',Auth::user()->id);
        // }
        if (Auth::user()->status == 'red') {
            $list->leftJoin('user_red_connections', 'user_red_connections.request_id', 'users.id')
                ->where('user_red_connections.user_id', Auth::user()->id);
        }

        if (1) {
            if ($type == 'connection') {
                $status = 'approved';
            }
            if ($type == 'request') {
                $status = 'pending';
            }
            $user_id = Auth::user()->id;
            $connected_users_ids = Helper::get_all_connected_users_array($user_id, $status);
            //dd($connected_users_ids);
            $list = $list->whereIn('users.id', $connected_users_ids);
        }

        $list = $list->whereHas('members', function ($list) {
            $list->where('is_hide', 0);
        });

        $list = $list->where('is_completed', true)
            ->where('users.mobile', '!=', Auth::user()->mobile)
            ->where('users.account_blocked', '!=', 1)
            ->whereNull('users.deleted_at')
            ->where('users.id', '!=', 1);



        $list = $list->paginate(10);
        //$list = $list->get();

        // return $list;

        if (count($list) > 0) {
            foreach ($list as $user) {

                $member_detaail = self::user_all_detail($user);
                $user->members = $member_detaail;
            }


            $user_id = Auth::user()->id;
            $user = User::find($user_id);

            $verfied_data = self::user_all_detail($user);

            $message = '';
            $response = [
                'status' => true,
                'message' => $message,
                'data' => $list,
                'user_detail' => $verfied_data
            ];
        } else {
            $response = [
                'status' => true,
                'message' => __('api.common.user_search'),
                'data' => ['data' => []]
            ];
        }

        return $response;
    }

    public static function get_all_connected_users_list_optimized($type)
    {
        $logged_user_id = Auth::user()->id;
        // GENERAL DATA
        $commonIcon = CommonIcon::all();
        $list = User::select('users.*')->with('account_type');
        //->with('profile_images')
        $list = $list->with('members')
                    ->with('profile_images_list')
                    ->with('members.profile_images_list');
        $list = $list->with('members.skin_detail', 'members.work_detail', 'members.education_detail', 'members.children_detail', 'members.sect_detail', 'members.hijab_detail', 'user_has_active_subscription')
            ->with('family_origin_detail')
            ->with('nationality_detail')
            ->with('nationality_current_detail')
            ->with('live_in_city_detail')
            ->has('user_has_active_subscription')
            ->with('personality_dimension')
            ->with('tribe_detail');

        // if(Auth::user()->status == 'yellow') {
        //     $list->leftJoin('user_yellow_connections','user_yellow_connections.request_id','users.id')
        //           ->where('user_yellow_connections.user_id',Auth::user()->id);
        // }
        if (Auth::user()->status == 'red') {
            $list->leftJoin('user_red_connections', 'user_red_connections.request_id', 'users.id')
                ->where('user_red_connections.user_id', Auth::user()->id);
        }

        if (1) {
            if ($type == 'connection') {
                $status = 'approved';
            }
            if ($type == 'request') {
                $status = 'pending';
            }
            $user_id = Auth::user()->id;
            $connected_users_ids = Helper::get_all_connected_users_array($user_id, $status);
            //dd($connected_users_ids);
            $list = $list->whereIn('users.id', $connected_users_ids);
        }

        $list = $list->whereHas('members', function ($list) {
            $list->where('is_hide', 0);
        });

        $list = $list->where('is_completed', true)
            ->where('users.mobile', '!=', Auth::user()->mobile)
            ->where('users.account_blocked', '!=', 1)
            ->whereNull('users.deleted_at')
            ->where('users.id', '!=', 1);



        $list = $list->paginate(10);
        //$list = $list->get();

        // return $list;

        if (count($list) > 0) {
            foreach ($list as $user) {

                //$member_detaail = self::user_all_detail($user);
                //$user->members = $member_detaail;
                $user->family_members_male_count = $user->members()->where('is_hide', 0)->where('gender', 'male')->count();
                $user->family_members_female_count = $user->members()->where('is_hide', 0)->where('gender', 'female')->count();

                $user->connection_detail = UserTrait::_check_connection_status($user->id, Auth::user()->id);
                $user->is_requested = UserTrait::_check_is_requested($user->id, Auth::user()->id);
                if ($user->account_type_id == 1) {
                    $user_type = 'family';
                    $user->user_likes_hide_blocked = Helper::user_likes_hide_blocked($user->id, $user_type);
                }
                if (1) {
                    $user->user_likes_hide_blocked = Helper::user_likes_hide_blocked_detail($user->id);
                }
            }


            //$user_id = Auth::user()->id;
            //$user = User::find($user_id);

            //$verfied_data = self::user_all_detail($user);
            $verfied_data = '';
            $message = '';
            $response = [
                'status' => true,
                'message' => $message,
                'data' => $list,
                'user_detail' => $verfied_data
            ];
        } else {
            $response = [
                'status' => true,
                'message' => __('api.common.user_search'),
                'data' => ['data' => []]
            ];
        }

        return $response;
    }


    public static function get_all_favroite_users_list()
    {
        $logged_user_id = Auth::user()->id;
        // GENERAL DATA
        $commonIcon = CommonIcon::all();
        $list = User::select('users.*')->with('account_type');
        //->with('profile_images')
        $list = $list->with('members');

        $list = $list->with('members.skin_detail', 'members.work_detail', 'members.education_detail', 'members.children_detail', 'members.sect_detail', 'members.hijab_detail', 'user_has_active_subscription')
            ->with('family_origin_detail')
            ->with('nationality_detail')
            ->with('nationality_current_detail')
            ->with('live_in_city_detail')
            ->has('user_has_active_subscription')
            ->with('personality_dimension')
            ->with('tribe_detail');

        // if(Auth::user()->status == 'yellow') {
        //     $list->leftJoin('user_yellow_connections','user_yellow_connections.request_id','users.id')
        //           ->where('user_yellow_connections.user_id',Auth::user()->id);
        // }
        if (Auth::user()->status == 'red') {
            $list->leftJoin('user_red_connections', 'user_red_connections.request_id', 'users.id')
                ->where('user_red_connections.user_id', Auth::user()->id);
        }

        if (1) {
            $user_id = Auth::user()->id;
            $connected_users_ids = Helper::get_all_favroite_users_array($user_id);
            //dd($connected_users_ids);
            $list = $list->whereIn('users.id', $connected_users_ids);
        }

        $list = $list->whereHas('members', function ($list) {
            $list->where('is_hide', 0);
        });

        $list = $list->where('is_completed', true)
            ->where('users.mobile', '!=', Auth::user()->mobile)
            ->where('users.account_blocked', '!=', 1)
            ->where('users.id', '!=', 1);



        $list = $list->paginate(10);
        //$list = $list->get();

        // return $list;

        if (count($list) > 0) {
            foreach ($list as $user) {

                $member_detaail = Helper::user_all_detail($user);
                $user->members = $member_detaail;
            }


            $user_id = Auth::user()->id;
            $user = User::find($user_id);

            $verfied_data = Helper::user_all_detail($user);

            $message = '';
            $response = [
                'status' => true,
                'message' => $message,
                'data' => $list,
                'user_detail' => $verfied_data
            ];
        } else {
            $response = [
                'status' => true,
                'message' => __('api.common.user_search'),
                'data' => []
            ];
        }

        return $response;
    }

    public static function user_all_detail($user,$type = null)
    {
        $commonIcon = CommonIcon::all();
        //dd($type);

        if(isset($user->account_type_id)) {

            if ($user->account_type_id == 1) {
                // for family
                $load_arr = ['account_type', 'tribe_detail', 'user_default_info', 'members', 'live_in_region_detail', 'live_in_city_detail', 'family_origin_region_detail', 'family_origin_city_detail', 'members.profile_images_list', 'family_origin_detail', 'saudi_family_origin_detail', 'members.skin_detail', 'members.children_detail', 'members.work_detail', 'members.education_detail', 'members.hijab_detail', 'talk_before_marriage_detail'];
            } else {
                // for individual
                $load_arr = ['account_type', 'tribe_detail', 'live_in_region_detail', 'live_in_city_detail', 'family_origin_region_detail', 'family_origin_city_detail', 'profile_images_list', 'user_default_info', 'members', 'family_origin_detail', 'saudi_family_origin_detail', 'user_default_info.skin_detail', 'user_default_info.children_detail', 'user_default_info.work_detail', 'user_default_info.education_detail', 'user_default_info.hijab_detail', 'talk_before_marriage_detail'];
            }


            $user->load($load_arr);

            if (isset($user)) {
                $user->is_all_required_fields = self::check_all_required_fields($user->id); //false => mendatory field not filled
                if (isset($user->account_type_id)) {
                    $user->connection_setting = Helper::get_connection_limits_all($user->id, $user->account_type_id);
                    if ($user->account_type_id == 1) {
                        $user->can_add_member_maximum = Helper::can_add_member_maximum($user->id, $user->account_type_id);
                        $user->family_members_male_count = $user->members()->where('gender', 'male')->count();
                        $user->family_members_female_count = $user->members()->where('gender', 'female')->count();
                    }

                }
                //$user->profile_images_list = UserFamilyProfileImage::where('user_family_id', $user->user_default_info->id)->where('is_default', 0)->get();
            }

            if (isset($user)) {
                if (isset($user->account_type_id)) {
                    $user->connection_setting = Helper::get_connection_limits_all($user->id, $user->account_type_id);
                    $user->can_add_member_maximum = Helper::can_add_member_maximum($user->id, $user->account_type_id);
                    if ($user->account_type_id == 1) {
                        if($type==1) {
                            $user->family_members_male_count = $user->members()->where('gender', 'male')->count();
                            $user->family_members_female_count = $user->members()->where('gender', 'female')->count();
                        } else {
                            $user->family_members_male_count = $user->members()->where('is_hide', 0)->where('gender', 'male')->count();
                            $user->family_members_female_count = $user->members()->where('is_hide', 0)->where('gender', 'female')->count();
                        }
                    }
                    $user->profile_images = Helper::get_profile_images($user);




                    if($type==1) {
                        $user->added_member_count = $user->members()->count();
                        $user->family_members_male_count = $user->members()->where('gender', 'male')->count();
                        $user->family_members_female_count = $user->members()->where('gender', 'female')->count();
                    } else {
                        $user->added_member_count = $user->members()->where('is_hide', 0)->count();
                        $user->family_members_male_count = $user->members()->where('is_hide', 0)->where('gender', 'male')->count();
                        $user->family_members_female_count = $user->members()->where('is_hide', 0)->where('gender', 'female')->count();
                    }

                    //$user->profile_images = Helper::get_profile_images($user); //$user->profile_images()->get();
                    $user->connection_detail = UserTrait::_check_connection_status($user->id, Auth::user()->id);
                    $user->is_requested = UserTrait::_check_is_requested($user->id, Auth::user()->id);
                    if ($user->account_type_id == 1) {
                        $user_type = 'family';
                        $user->user_likes_hide_blocked = Helper::user_likes_hide_blocked($user->id, $user_type);
                    }
                    if (1) {
                        $user->user_likes_hide_blocked = Helper::user_likes_hide_blocked_detail($user->id);
                    }

                    //$user->connection_setting = Helper::get_connection_limits($user->id,$user->account_type_id);
                    $country = isset($user->nationality_detail) ? $user->nationality_detail : '';
                    $current_country = isset($user->nationality_current_detail) ? $user->nationality_current_detail : '';

                    /* Livein region & city */
                    $region = isset($user->live_in_region_detail) ? $user->live_in_region_detail : '';
                    $city = isset($user->live_in_city_detail) ? $user->live_in_city_detail : '';

                    $family_origin_region = isset($user->family_origin_region_detail) ? $user->family_origin_region_detail : '';
                    $family_origin_city = isset($user->family_origin_city_detail) ? $user->family_origin_city_detail : '';

                    $family_origin = isset($user->family_origin_detail) ? $user->family_origin_detail : '';

                    //dd($family_origin);

                    /* custom tags */
                    if (!empty($country)) {
                        $country->tag_name_en =  isset($user->nationality_detail) ? '🌎 ' . trans('api.common.nationality', ['attribute' => $user->nationality_detail->name], 'en')  : '';
                        $country->tag_name_ar =  isset($user->nationality_detail) ? '🌎 ' . trans('api.common.nationality', ['attribute' => $user->nationality_detail->name_ar], 'ar') : '';
                        //$country->icon_emoji = '⚓';
                    }

                    if (!empty($current_country)) {
                        $current_country->tag_name_en =  isset($user->nationality_current_detail) ? '📍 ' . trans('api.common.lives_in', ['attribute' => $user->nationality_current_detail->name], 'en')  : '';
                        $current_country->tag_name_ar =  isset($user->nationality_current_detail) ? '📍 ' . trans('api.common.lives_in', ['attribute' => $user->nationality_current_detail->name_ar], 'ar') : '';
                        //$country->icon_emoji = '⚓';
                    }

                    if (!empty($region)) {
                        $region->tag_name_en =  isset($user->live_in_region_detail) ? '📍 ' . trans('api.common.region', ['attribute' => $user->live_in_region_detail->name], 'en') : '';
                        $region->tag_name_ar =  isset($user->live_in_region_detail) ? '📍 ' . trans('api.common.region', ['attribute' => $user->live_in_region_detail->name_ar], 'ar') : '';
                    }


                    if (!empty($city)) {
                        $city->tag_name_en =  isset($user->live_in_city_detail) ? '📍 ' . trans('api.common.city', ['attribute' => $user->live_in_city_detail->name], 'en') : '';
                        $city->tag_name_ar =  isset($user->live_in_city_detail) ? '📍 ' . trans('api.common.city', ['attribute' => $user->live_in_city_detail->name_ar], 'ar') : '';
                    }

                    if (!empty($family_origin_region)) {
                        $family_origin_region->tag_name_en =  isset($user->family_origin_region_detail) ? '🗺 ' . trans('api.common.region', ['attribute' => $user->family_origin_region_detail->name], 'en') : '';
                        $family_origin_region->tag_name_ar =  isset($user->family_origin_region_detail) ? '🗺 ' . trans('api.common.region', ['attribute' => $user->family_origin_region_detail->name_ar], 'ar') : '';
                    }


                    if (!empty($family_origin_city)) {
                        $family_origin_city->tag_name_en =  isset($user->family_origin_city_detail) ? '🗺 ' . trans('api.common.region', ['attribute' => $user->family_origin_city_detail->name], 'en') : '';
                        $family_origin_city->tag_name_ar =  isset($user->family_origin_city_detail) ? '🗺 ' . trans('api.common.region', ['attribute' => $user->family_origin_city_detail->name_ar], 'ar') : '';
                    }



                    if (!empty($user->family_origin_detail)) {
                        //dd($user->family_origin_detail);
                        $family_origin->name_en = $user->family_origin_detail->name;
                        $family_origin->name_ar = $user->family_origin_detail->name_ar;
                        $family_origin->tag_name_en =  isset($user->family_origin_detail) ? '🗺 ' . trans('api.common.family_origin', ['attribute' => $user->family_origin_detail->name], 'en')  : '';
                        $family_origin->tag_name_ar =  isset($user->family_origin_detail) ? '🗺 ' . trans('api.common.family_origin', ['attribute' => $user->family_origin_detail->name_ar], 'ar')  : '';
                    }


                    $talk_before_marriage_obj = isset($user->talk_before_marriage_detail) ? $user->talk_before_marriage_detail : '';
                    if (!empty($talk_before_marriage_obj)) {
                        $talk_before_marriage_obj->tag_name_en =  isset($user->talk_before_marriage_detail) ? '🗣️ ' . trans('api.common.talk_before_marriage', ['attribute' => $user->talk_before_marriage_detail->name_en], 'en')  : '';
                        $talk_before_marriage_obj->tag_name_ar =  isset($user->talk_before_marriage_detail->name_ar) ? '🗣️ ' . trans('api.common.talk_before_marriage', ['attribute' => $user->talk_before_marriage_detail->name_ar], 'ar')  : '';
                    }



                    $about_me_arr = [
                        'country' => $country,
                        'current_country' => $current_country,
                        'region' => $region,
                        'city' => $city,
                        'family_origin_region' => $family_origin_region,
                        'family_origin_city' => $family_origin_city,
                        'family_origin' => $family_origin,
                        'talk_before_marriage' => $talk_before_marriage_obj
                        // 'skin_color'=>$skin_color,
                        // 'currently_married'=>'',
                        // 'child'=>'',
                    ];

                    $user->family_profile_detail = $about_me_arr;
                    $user->family_origin = $family_origin;
                    $user->about_me_arr = $about_me_arr;

                    // $user->about_me_arr = $about_me_arr;
                    if ($user->members) {

                        $temp_about_me = [];
                        $temp_education_and_carrer = [];
                        $temp_social = [];
                        foreach ($user->members as $key => $member) {

                            $user_type = $user->account_type_id == 1 ? 'member' : 'individual';
                            // $is_active_user = self::is_member_active($member->id,$user_type);
                            // //$is_active_user = 1;
                            // $member->user_type = $user_type;
                            // $member->is_active_user = $is_active_user;
                            if (1) {
                                $height_obj = [
                                    'icon' => $commonIcon->where('name', 'height')->first()->icon ?? '',
                                    'tag_name_en' => isset($member->height) ? '📏 ' . $member->height : '',
                                    'tag_name_ar' => isset($member->height) ? '📏 ' . $member->height : ''
                                ];

                                $member->personality_dimension;




                                $skin_color = isset($member->skin_detail) ? $member->skin_detail : '';
                                if (!empty($skin_color)) {
                                    $skin_color->tag_name_en =  isset($member->skin_detail) ? '🤝🏼 ' . trans('api.common.skin', ['attribute' => $member->skin_detail->name_en], 'en')  : '';
                                    $skin_color->tag_name_ar =  isset($member->skin_detail->name_ar) ? '🤝🏼 ' . trans('api.common.skin', ['attribute' => $member->skin_detail->name_ar], 'ar')  : '';
                                }




                                // @ education and career Undergraduate studies
                                $education = isset($member->education_detail) ? $member->education_detail : '';
                                if (!empty($education)) {
                                    $education->tag_name_en =  isset($member->education_detail) ? '🎓 ' . $member->education_detail->name_en  : '';
                                    $education->tag_name_ar =  isset($member->education_detail) ? '🎓 ' . $member->education_detail->name_ar  : '';
                                }
                                // Freelancer
                                $career = isset($member->work_detail) ? $member->work_detail : '';
                                if (!empty($career)) {
                                    $career->tag_name_en =  isset($member->work_detail) ? '💼 ' . $member->work_detail->name_en  : '';
                                    $career->tag_name_ar =  isset($member->work_detail) ? '💼 ' . $member->work_detail->name_ar  : '';
                                }
                                // @ social
                                $sect = isset($member->sect_detail) ? $member->sect_detail : '';

                                if (!empty($sect)) {
                                    if ($member->sect_detail->name_en == 'Other') {
                                        $sect->tag_name_en =  isset($member->sect_detail) ? '🌑 Religion:' . $member->sect_detail->name_en  : '';
                                    } else {
                                        $sect->tag_name_en =  isset($member->sect_detail) ? '🌑 ' . $member->sect_detail->name_en  : '';
                                    }
                                    if ($member->sect_detail->name_ar == 'غير ذلك') {
                                        $sect->tag_name_ar =  isset($member->sect_detail) ? '🌑 الديانة:' . $member->sect_detail->name_ar  : '';
                                    } else {
                                        $sect->tag_name_ar =  isset($member->sect_detail) ? '🌑 ' . $member->sect_detail->name_ar  : '';
                                    }
                                }

                                $tribal = isset($user->tribe_detail) ? $user->tribe_detail : '';

                                if (!empty($tribal)) {
                                    $tribal->tag_name_en = isset($user->tribe_detail->name_en) ? '👥 ' . trans('api.common.tribe', ['attribute' => $user->tribe_detail->name_en], 'en') : '';
                                    $tribal->tag_name_ar = isset($user->tribe_detail->name_ar) ? '👥 ' . trans('api.common.tribe', ['attribute' => $user->tribe_detail->name_ar], 'ar') : '';
                                }


                                $hijab = isset($member->hijab_detail) ? $member->hijab_detail : '';
                                if (!empty($hijab)) {

                                    $hijab->tag_name_en =  isset($member->hijab_detail) ? '🧕 ' . $member->hijab_detail->name_en  : '';
                                    $hijab->tag_name_ar =  isset($member->hijab_detail) ? '🧕 ' . $member->hijab_detail->name_ar  : '';
                                }

                                $yes_no_obj = [
                                    "yes" => ['name_en' => 'YES', 'name_ar' => 'نعم'],
                                    "no" => ['name_en' => 'NO', 'name_ar' => 'رقم'],
                                    "sometimes" => ['name_en' => 'Sometimes', 'name_ar' => 'رقم']
                                ];
                                // current marriedCurrently married


                                if ($member->gender == 'male') {
                                    $previously_married_obj = [
                                        "married" => true,
                                        "value" => ($member->married_previously == 'yes') ? 'currently married' : 'not married',
                                        "tag_name_en" => ($member->married_previously == 'yes') ? '💍 ' . trans('api.common.previously_married', ['attribute' => ''], 'en') : '💍 ' . trans('api.common.not_married', ['attribute' => ''], 'en'),
                                        "tag_name_ar" => ($member->married_previously == 'yes') ? '💍 ' . trans('api.common.previously_married', ['attribute' => ''], 'ar') : '💍 ' . trans('api.common.not_married', ['attribute' => ''], 'ar'),
                                        "icon" => $commonIcon->where('name', 'currently_married')->first()->icon ?? ''
                                    ];

                                    $currently_married_obj = [
                                        "married" => true,
                                        "value" => ($member->currently_married == 'yes') ? 'currently married' : 'not married',
                                        "tag_name_en" => ($member->currently_married == 'yes') ? '💍 ' . trans('api.common.currently_married', ['attribute' => ''], 'en') : '💍 ' . trans('api.common.not_married', ['attribute' => ''], 'en'),
                                        "tag_name_ar" => ($member->currently_married == 'yes') ? '💍 ' . trans('api.common.currently_married', ['attribute' => ''], 'ar') : '💍 ' . trans('api.common.not_married', ['attribute' => ''], 'ar'),
                                        "icon" => $commonIcon->where('name', 'currently_married')->first()->icon ?? ''
                                    ];
                                } else { // female
                                    $previously_married_obj = [
                                        "married" => true,
                                        "value" => ($member->married_previously == 'yes') ? 'currently married' : 'not married',
                                        "tag_name_en" => ($member->married_previously == 'yes') ? '💍 ' . trans('api.common.previously_married_F', ['attribute' => ''], 'en') : '💍 ' . trans('api.common.not_married', ['attribute' => ''], 'en'),
                                        "tag_name_ar" => ($member->married_previously == 'yes') ? '💍 ' . trans('api.common.previously_married_F', ['attribute' => ''], 'ar') : '💍 ' . trans('api.common.not_married', ['attribute' => ''], 'ar'),
                                        "icon" => $commonIcon->where('name', 'currently_married')->first()->icon ?? ''
                                    ];

                                    $currently_married_obj = [
                                        "married" => true,
                                        "value" => ($member->currently_married == 'yes') ? 'currently married' : 'not married',
                                        "tag_name_en" => ($member->currently_married == 'yes') ? '💍 ' . trans('api.common.currently_married', ['attribute' => ''], 'en') : '💍 ' . trans('api.common.not_married', ['attribute' => ''], 'en'),
                                        "tag_name_ar" => ($member->currently_married == 'yes') ? '💍 ' . trans('api.common.currently_married', ['attribute' => ''], 'ar') : '💍 ' . trans('api.common.not_married_F', ['attribute' => ''], 'ar'),
                                        "icon" => $commonIcon->where('name', 'currently_married')->first()->icon ?? ''
                                    ];
                                }


                                $married_status_obj = [
                                    "value" => ($member->currently_married == 'yes') ? 'yes' : ($member->married_previously == 'yes' ? 'yes' :  'no'),
                                    "icon" => $commonIcon->where('name', 'currently_married')->first()->icon ?? ''
                                ];

                                $children = ( isset($member->children_detail) && ($member->currently_married == 'yes' or $member->married_previously == 'yes') ) ? $member->children_detail : '';
                                //Has 1 child
                                if (!empty($children)) {
                                    $children->tag_name_en =  isset($member->children_detail) ? '👶 ' . $member->children_detail->children_number_en  : '';
                                    $children->tag_name_ar =  isset($member->children_detail) ? '👶 ' . $member->children_detail->children_number_ar  : '';
                                }

                                // $currently_married_obj=(isset($member->currently_married) && $member->currently_married)?$yes_no_obj[$member->currently_married]:[];
                                // $currently_married_obj['icon']=$commonIcon->where('name','currently_married')->first()->icon??'';
                                // @ smoking obj
                                $smoking_obj = (isset($member->smoking) && $member->smoking) ? $yes_no_obj[$member->smoking] : [];
                                //Non-smoker
                                $smoking_tag_en = '';
                                $smoking_tag_ar = '';
                                if ($member->smoking == 'yes') {
                                    $smoking_tag_en = '🚬 ' . trans('api.common.smoke', ['attribute' => ''], 'en');
                                    $smoking_tag_ar = '🚬 ' . trans('api.common.smoke', ['attribute' => ''], 'ar');
                                } else if ($member->smoking == 'sometimes') {
                                    $smoking_tag_en = '🚬 ' . trans('api.common.sometimes_smoke', ['attribute' => ''], 'en');
                                    $smoking_tag_ar = '🚬 ' . trans('api.common.sometimes_smoke', ['attribute' => ''], 'ar');
                                } else {
                                    $smoking_tag_en = '🚭 ' . trans('api.common.no_smoke', ['attribute' => ''], 'en');
                                    $smoking_tag_ar = '🚭 ' . trans('api.common.no_smoke', ['attribute' => ''], 'ar');
                                }
                                $smoking_obj['tag_name_en'] =  $smoking_tag_en;
                                $smoking_obj['tag_name_ar'] =  $smoking_tag_ar;
                                $smoking_obj['icon'] = $commonIcon->where('name', 'smoking')->first()->icon;


                                $care_tribalism_obj = (isset($member->do_you_care_about_tribalism) &&
                                    $member->do_you_care_about_tribalism) ? $yes_no_obj[$member->do_you_care_about_tribalism] : [];


                                $care_tribalism_obj_en = '';
                                $care_tribalism_obj_ar = '';
                                if ($member->do_you_care_about_tribalism == 'yes') {
                                    $care_tribalism_obj_en = '👤 ' . trans('api.common.care_about_tribalism', ['attribute' => ''], 'en');
                                    $care_tribalism_obj_ar = '👤 ' . trans('api.common.care_about_tribalism', ['attribute' => ''], 'ar');
                                } else {
                                    $care_tribalism_obj_en = '👤 ' . trans('api.common.not_care_about_tribalism', ['attribute' => ''], 'en');
                                    $care_tribalism_obj_ar = '👤 ' . trans('api.common.not_care_about_tribalism', ['attribute' => ''], 'ar');
                                }

                                $care_tribalism_obj['tag_name_en'] =  $care_tribalism_obj_en;
                                $care_tribalism_obj['tag_name_ar'] =   $care_tribalism_obj_ar;

                                $care_tribalism_obj['icon'] = $commonIcon->where('name', 'is_tribal')->first()->icon ?? '';
                                // @is tribal
                                $is_tribal_obj = (isset($user->is_your_family_tribal) && $user->is_your_family_tribal)
                                    ? $yes_no_obj[$user->is_your_family_tribal] : [];


                                $is_tribal_obj_en = '';
                                $is_tribal_obj_ar = '';
                                if ($user->is_your_family_tribal == 'yes') {
                                    $is_tribal_obj_en = '👤 ' . trans('api.common.tribal_person', ['attribute' => ''], 'en');
                                    $is_tribal_obj_ar = '👤 ' . trans('api.common.tribal_person', ['attribute' => ''], 'ar');
                                } else {
                                    $is_tribal_obj_en = '👤 ' . trans('api.common.not_tribal_person', ['attribute' => ''], 'en');
                                    $is_tribal_obj_ar = '👤 ' . trans('api.common.not_tribal_person', ['attribute' => ''], 'ar');
                                }


                                $is_tribal_obj['tag_name_en'] = $is_tribal_obj_en;
                                $is_tribal_obj['tag_name_ar'] = $is_tribal_obj_ar;
                                $is_tribal_obj['icon'] = $commonIcon->where('name', 'is_tribal')->first()->icon ?? '';

                                $accept_polygamy_obj = [];
                                if (!empty($member->does_she_or_he_has_flexibility_to_marry_a_married_man)) {
                                    $accept_polygamy_obj = [
                                        "tag_name_en" => ($member->does_she_or_he_has_flexibility_to_marry_a_married_man == 'yes')
                                            ? '👤👤 ' . trans('api.common.accept_polygamy', ['attribute' => ''], 'en') : '👤👤 ' . trans('api.common.not_accept_polygamy', ['attribute' => ''], 'en'),
                                        "tag_name_ar" => ($member->does_she_or_he_has_flexibility_to_marry_a_married_man == 'yes')
                                            ? '👤👤 ' . trans('api.common.accept_polygamy', ['attribute' => ''], 'ar') : '👤👤 ' . trans('api.common.not_accept_polygamy', ['attribute' => ''], 'ar'),
                                    ];
                                }

                                $temp_about_me = [
                                    'height' => $height_obj,
                                    'skin_color' => $skin_color,
                                    'married_previously' => $previously_married_obj,
                                    'currently_married' => $currently_married_obj,
                                    'married_status' => $married_status_obj,
                                    'children' => $children,
                                    'accept_polygamy' => $accept_polygamy_obj
                                ];


                                $temp_education_and_career = [
                                    'education' => $education,
                                    'career' => $career
                                ];

                                if (isset($user->nationality_detail->id) && $user->nationality_detail->id == 195) {
                                    $temp_social = [
                                        'sect' => $sect,
                                        'smoking' => $smoking_obj,
                                        // 'smoking'=>["value"=>($smoking=='yes')?__('admin_dashboard.common.yes'):__('admin_dashboard.common.no')],
                                        'Tribal_Person' => $is_tribal_obj,
                                        'tribal' => $tribal,
                                        'Cares_About_Tribalism' => $care_tribalism_obj,
                                        'Flexible_About_Hijab' => $hijab,
                                    ];
                                } else {
                                    $temp_social = [
                                        'sect' => $sect,
                                        'smoking' => $smoking_obj,
                                        // 'smoking'=>["value"=>($smoking=='yes')?__('admin_dashboard.common.yes'):__('admin_dashboard.common.no')],
                                        //'Tribal_Person'=>$is_tribal_obj,
                                        'tribal' => $tribal,
                                        'Cares_About_Tribalism' => $care_tribalism_obj,
                                        'Flexible_About_Hijab' => $hijab,
                                    ];
                                }



                                $member->about_me_arr = array_merge($about_me_arr, $temp_about_me);
                                $member->education_and_career_arr = $temp_education_and_career;
                                $member->social_arr = $temp_social;
                                $member->profile_images = Helper::get_profile_individual_or_family_images($member);

                                if ($user->account_type_id == 1) {
                                    $user_type = 'member';
                                    $member->user_likes_hide_blocked = Helper::user_likes_hide_blocked($member->id, $user_type);
                                }
                                if ($user->account_type_id == 2) {
                                    $user_type = 'individual';
                                    $member->user_likes_hide_blocked = Helper::user_likes_hide_blocked($user->id, $user_type);
                                }
                            }
                        }

                        //array_values((array)$user->members);

                    }
                }
            }


            $format_data = [
                "name" => $user->user_default_info->name ?? '',
                "family_name" => $user->family_name,
                "username" => $user->username ?? '',
                "gender" => $user->user_default_info->gender_obj ?? '',
                "age" => $user->user_default_info->age_obj ?? '',
                "status" => $user->user_default_info->status ?? '',
                "about_me" => $user->user_default_info->bio ?? '',
                "nationality" => $user->user_default_info->nationality_detail ?? '',
                "current_count_of_residence" => $user->user_default_info->nationality_current_detail ?? '',
                "region" => $user->live_in_region_detail ?? '',
                "city" => $user->user_default_info->live_in_city_detail ?? '',
                "family_origin_region" => $user->family_origin_region_detail ?? '',
                "family_origin_city" => $user->family_origin_city_detail ?? '',
                "family_origin" => $user->family_origin_detail,
                "married_previously" => $user->user_default_info->married_previously ?? '',
                "currently_married" => $user->user_default_info->currently_married ?? '',
                "marital_status" => $user->user_default_info->currently_married ?? '',
                "height" => $user->user_default_info->height_obj ?? '',
                "skin_color" => $user->user_default_info->skin_detail ?? '',
                "education" => $user->user_default_info->education_detail ?? '',
                "work" => $user->user_default_info->work_detail ?? '',
                "headwear_preference" => $user->user_default_info->hijab_detail ?? '',
                "tribal" => $user->is_tribal_obj ?? '',
                "tribe" => $user->tribe_detail ?? '',
                "care_about_tribalism" => "",
                "marriage_flexibility" => $user->user_default_info->does_she_or_he_has_flexibility_to_marry_a_married_man ?? '',
            ];

            $user->format_data = $format_data;
            $user->personality_dimension;
            return $user;
        }
    }


    public static function generate_invoice($checkout_id = null, $download = 0, $default_lang = 'en')
    {

        //ini_set('display_errors', '0');
        //$user_id = Auth::user()->id;
        $language_arr = ['en', 'ar'];
        //dd($checkout_id);
        foreach ($language_arr as $localization) {
            $vat_detail = DB::table('master_settings')->first();
            $logo = asset('assets_front/img/logo.png');

            $path = storage_path('app/public/invoice/');
            $file_name =  'invoice-' . $checkout_id . $localization . '.pdf';
            $html = '';
            if (is_file($path . $file_name)) {
                //dd(' exits');
            } else if ($download == 0) {
                //dd('not exits');
                if (!empty($checkout_id)) {
                    $trans_detail = DB::table('transactions')->where('checkout_id', $checkout_id)->first();
                    $trackable_data = json_decode($trans_detail->trackable_data);

                    if (property_exists($trackable_data, 'invoice_no')) {
                        $invoice_no = $trackable_data->invoice_no;
                    } else {
                        $invoice_no = 0;
                    }

                    if (property_exists($trackable_data, 'payment_type')) {
                        $payment_type = $trackable_data->payment_type;
                    } else {
                        $payment_type = '';
                    }

                    $file = '';
                    $file = storage_path('app/public/invoice/qr.svg');
                    if (!is_file($file)) {
                        QrCode::size(80)
                            ->format('svg')
                            ->generate('awaser.sa', $file);
                    }
                    $qr_file = asset('/storage/invoice/qr.svg');


                    if ($localization == 'ar' || $localization == 'en') {
                        $html .= '
                        <style>
                        .logo {
                            text-align:left;
                        }
                            .invoice-logo {
                               width:40px;
                               height:40px;
                            }
                        </style>
                        ';
                    }

                    $html .= '<div class="logo"><img class="invoice-logo" src="' . $logo . '" /></div>';

                    $html .= '<html><meta charset="utf-8" />
                     <body>
                        <table border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td align="center" colspan="4"><h2>' . trans('api.invoice.invoice_title', [], $localization) . '</h2></td>
                            </tr>
                            <tr>
                                <td align="center" colspan="4"><h3>' . trans('api.invoice.invoice_no', ['attribute' => $invoice_no], $localization) . '</h3></td>
                            </tr>
                            <tr>
                                <td align="center" colspan="4"><h4>Awaser App</h4></td>
                            </tr>
                        </table>

                            <h2 align="center">' . trans('api.invoice.invoice_date', ['attribute' => date('d-m-Y', strtotime($trans_detail->created_at))], $localization) . '<br>
                            <span style="font-size:10px;">' . trans('api.invoice.vat_no', ['attribute' => $vat_detail->vat_no], $localization) . '</span></h2>
                            <br><br>';

                    //dd($trackable_data->payment_type);
                    if ($payment_type == 'subscription') {
                        if (property_exists($trackable_data, 'sub_total')) {
                            $sub_total = $trackable_data->sub_total;
                        } else {
                            $sub_total = 0;
                        }
                        if (property_exists($trackable_data->vat_detail, 'total_vat_amt')) {
                            $total_vat_amt = $trackable_data->vat_detail->total_vat_amt;
                        } else {
                            $total_vat_amt = 0;
                        }

                        $subscription_detail = Subscription::find($trackable_data->product_id);

                        if ($localization == 'en') {

                            $package_name = $subscription_detail->name;
                            $currency = trans('hyper_pay.checkout.saudi_currency', [], $localization);
                        } else {
                            $package_name = $subscription_detail->name_ar;
                            $currency = trans('hyper_pay.checkout.saudi_currency', [], $localization);
                        }

                        if ($subscription_detail->account_type_id == 1) {
                            $member_included = '<br>' . trans('api.invoice.table.member_included', ['attribute' => $trackable_data->member_add_on], $localization);
                        } else {
                            $member_included = '';
                        }



                        $html .= '<table class="invoice-table" border="1" cellpadding="4">
                                    <tr >
                                        <th>#</th>
                                        <th align="left">' . trans('api.invoice.table.description', [], $localization) . '</th>
                                        <th align="left">' . trans('api.invoice.table.duration', [], $localization) . '</th>
                                        <th align="left">' . trans('api.invoice.table.amount', [], $localization) . '</th>
                                        <th>' . trans('api.invoice.table.total_amt', [], $localization) . '</th>
                                    </tr>
                                    <tr >
                                        <td>1</td>
                                        <td>' . $package_name . $member_included . '</td>
                                        <td>' . trans('hyper_pay.checkout.subscription_months', ['attribute' => $subscription_detail->duration], $localization) . '</td>
                                        <td>' . trans('hyper_pay.checkout.price_tag', ['attribute' => $sub_total], $localization) . '</td>
                                        <td>' . trans('hyper_pay.checkout.price_tag', ['attribute' => $sub_total], $localization) . '</td>
                                    </tr>
                                    <tr>
                                        <td colspan="4">' . trans('api.invoice.table.vat', [], $localization) . '</td>
                                        <td>' . trans('hyper_pay.checkout.price_tag', ['attribute' => $total_vat_amt], $localization) . '</td>
                                    </tr>
                                    <tr >
                                        <td colspan="4">' . trans('api.invoice.table.total_amt', [], $localization) . '</td>
                                        <td>' . trans('hyper_pay.checkout.price_tag', ['attribute' => $trans_detail->amount], $localization) . '</td>
                                    </tr>

                                </table>
                                <table border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                        <td align="center" colspan="4"><img src="' . $qr_file . '"></td>
                                    </tr>
                                </table>
                                </body></html>';
                    }
                    if ($payment_type == 'member_addon') {
                        if (property_exists($trackable_data, 'sub_total')) {
                            $sub_total = $trackable_data->sub_total;
                        } else {
                            $sub_total = 0;
                        }
                        if (property_exists($trackable_data->vat_detail, 'total_vat_amt')) {
                            $total_vat_amt = $trackable_data->vat_detail->total_vat_amt;
                        } else {
                            $total_vat_amt = 0;
                        }
                        $html .= '<table border="1" cellpadding="4">
                                        <tr>
                                            <th>#</th>
                                            <th align="left">' . trans('api.invoice.table.member_included_header', [], $localization) . '</th>
                                            <th align="left">' . trans('api.invoice.table.amount', [], $localization) . '</th>
                                            <th>' . trans('api.invoice.table.total_amt', [], $localization) . '</th>
                                        </tr>
                                        <tr>
                                            <td>1</td>
                                            <td>' . $trackable_data->member_add_on . '</td>
                                            <td> ' . trans('hyper_pay.checkout.price_tag', ['attribute' => $sub_total], $localization) . ' </td>
                                            <td>' . trans('hyper_pay.checkout.price_tag', ['attribute' => $sub_total], $localization) . '</td>
                                        </tr>
                                        <tr>
                                            <td colspan="3">' . trans('api.invoice.table.vat', [], $localization) . '</td>
                                            <td>' . trans('hyper_pay.checkout.price_tag', ['attribute' => $total_vat_amt], $localization) . '</td>
                                        </tr>
                                        <tr>
                                            <td colspan="3">' . trans('api.invoice.table.total_amt', [], $localization) . '</td>
                                            <td>' . trans('hyper_pay.checkout.price_tag', ['attribute' => $trans_detail->amount], $localization) . '</td>
                                        </tr>

                                    </table>
                                    <table border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                            <td align="center" colspan="4" ><img src="' . $qr_file . '"></td>
                                        </tr>
                                    </table>
                                    </body></html>';
                    }

                    PDF::SetTitle('اسمي');
                    PDF::SetFont('aealarabiya', '', 18, '');
                    PDF::AddPage();

                    if ($localization == 'ar') {
                        PDF::SetRTL(true);
                    } else {
                        PDF::SetRTL(false);
                    }

                    PDF::writeHTML($html, true, false, true, false, '');
                    PDF::Output($path . $file_name, 'F');

                    $logdata = [
                        'request_data' => $request->all(),
                        'response_data' => array("message"=>"Downloaded")
                    ];
                    Helper::save_api_logs($logdata);
                }
            } else {
                $logdata = [
                    'request_data' => $request->all(),
                    'response_data' => array('status' => true,
                    'message' => 'Invoice not yet generated...try some time later',
                    'download_url' => '')
                ];
                Helper::save_api_logs($logdata);
                return $response = [
                    'status' => true,
                    'message' => 'Invoice not yet generated...try some time later',
                    'download_url' => ''
                ];
            }
        }


        $pdf_url = asset('storage/invoice/' . 'invoice-' . $checkout_id . $default_lang . '.pdf');



        return $response = [
            'status' => true,
            'message' => '',
            'download_url' => $pdf_url
        ];
    }

    public static function is_member_active($id, $user_type)
    {
        $user_likes_hide_blocked = UserLikesHideBlocked::select('is_liked', 'is_reported', 'is_hide', 'is_blocked')
            ->where('user_type', $user_type)
            ->where('user_id', $id);


        $user_likes_hide_blocked = $user_likes_hide_blocked->first();

        if ($user_likes_hide_blocked) {
            return $user_likes_hide_blocked->is_hide == 1 ? 0 : 1;
        } else {
            return 1;
        }
    }

    public static function encryption($value, $mode)
    {
        //dd(Config::get( 'app.cipher' ));
        $key = "Hl4Z5XkE/orROpSmWbAeP1GBcNSoBBadO0Lo/HjtxvA=";
        $encrypter = new \Illuminate\Encryption\Encrypter(base64_decode($key), config('app.cipher'));
        if ($mode == 'encrypt') {
            $value = $encrypter->encrypt($value);
        }
        if ($mode == 'decrypt') {
            $value = $encrypter->decrypt($value);
        }
        return $value;
    }

    // HYPER PAY

    public static function hyper_pay_prepare_checkout($merchant_transactionId, $brand, $amount, $user)
    {
        //dd($merchant_transactionId);
        //echo $merchant_transactionId;
        $user_name = $user->name ? $user->name : 'customer';
        $user_id = $user->id ? $user->id : '--';
        $mobile = $user->mobile ? $user->mobile : '--';
        $surname = $user_id;
        $user_email = $user->email ? $user->email : 'customer@test.com';
        switch ($brand) {
            case 'MADA':
                $payment_type = 'PA';
                $entity_id = env('ENTITY_ID_MADA');
                break;
            case 'APPLEAPY':
                $payment_type = 'PA';
                $entity_id = env('ENTITY_ID_APPLE_PAY');
                break;
            default:
                $payment_type = 'DB';
                $entity_id = env('ENTITY_ID');
                break;
        }

        // "&customParameters['testpackage']" .

        if(env('SANDBOX_MODE') == true) {
            $url = "https://eu-prod.oppwa.com/v1/checkouts";
            $data = "entityId=$entity_id" .
            "&merchantTransactionId=$merchant_transactionId" .
            "&amount=$amount" .
            "&customer.givenName=$user_name" .
            "&customer.surname=$surname" .
            "&customer.email=$user_email" .
            "&customer.phone=$mobile" .
            "&customer.mobile=$mobile" .
            "&currency=SAR" .
            "&billing.street1=street 1" .
            "&billing.city=riyadh" .
            "&billing.state=riyadh" .
            "&billing.country=SA" .
            "&billing.postcode=00000" .
            "&paymentType=DB";
        } else {
            $url = "https://test.oppwa.com/v1/checkouts";
            $data = "entityId=$entity_id" .
            "&merchantTransactionId=$merchant_transactionId" .
            "&amount=$amount" .
            "&customer.givenName=$user_name" .
            "&customer.surname=$surname" .
            "&customer.email=$user_email" .
            "&customer.mobile=$mobile" .
            "&customer.phone=$mobile" .
            "&testMode=EXTERNAL" .
            "&currency=SAR" .
            "&billing.street1=street 1" .
            "&billing.city=riyadh" .
            "&billing.state=riyadh" .
            "&billing.country=SA" .
            "&billing.postcode=00000" .
            "&paymentType=DB";
        }



        //dd($url);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization:Bearer '.env('ACCESS_TOKEN')
        ));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // this should be set to true in production
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $responseData = curl_exec($ch);
        if (curl_errno($ch)) {
            return curl_error($ch);
        }
        curl_close($ch);
        return $responseData;
    }

    public static function hyper_pay_payment_status($checkout_id,$entity_id)
    {

        if(env('SANDBOX_MODE') == true) {
            $url = "https://eu-prod.oppwa.com/v1/checkouts";
        } else {
            $url = "https://test.oppwa.com/v1/checkouts";
        }

        $url .= "/".$checkout_id."/payment";
        $url .= "?entityId=$entity_id";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization:Bearer '.env('ACCESS_TOKEN')
        ));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // this should be set to true in production
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $responseData = curl_exec($ch);
        if (curl_errno($ch)) {
            return curl_error($ch);
        }
        curl_close($ch);
        return $responseData;
    }

    public static function hyper_pay_request__($brand, $amount, $card_details)
    {
        $url = "https://eu-test.oppwa.com/v1/payments"; //https://eu-test.oppwa.com

        $card_no = $card_details['card_number'];
        $expiry_month = $card_details['expiry_month'];
        $expiry_year = $card_details['expiry_year'];
        $card_cvv = $card_details['card_cvv'];
        $holder_name = $card_details['holder_name'];

        $brand == 'MADA' ? $payment_type = 'PA' : $payment_type = 'DB';

        switch ($brand) {
            case 'MADA':
                $payment_type = 'PA';
                $entity_id = '8ac7a4c782e78c940182ea74b17b051d';
                break;
            case 'APPLEAPY':
                $payment_type = 'PA';
                $entity_id = '8ac7a4c984793c3d01847a47b3a60085';
                break;
            default:
                $payment_type = 'DB';
                $entity_id = '8ac7a4c782e78c940182ea73d8f70518';
                break;
        }

        $data = "entityId=$entity_id" .
            "&amount=$amount" .
            "&currency=SAR" .
            "&paymentBrand=$brand" .
            "&card.number=$card_no" .
            "&card.expiryMonth=$expiry_month" .
            "&card.expiryYear=$expiry_year" .
            "&card.holder=$holder_name" .
            "&card.cvv=$card_cvv" .
            "&threeDSecure.verificationId=ABiKYvXjhcB7AAc+K04XAoABFA==" .
            "&threeDSecure.eci=07" .
            "&billing.street1=street 1" .
            "&billing.city=riyadh" .
            "&billing.state=riyadh" .
            "&billing.country=SA" .
            "&billing.postcode=00000" .
            "&shopperResultUrl=/hyperpay/finalize" .
            "&paymentType=$payment_type" .
            "&applePay.source=web";
        //dd($data);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization:Bearer OGFjN2E0Yzc4MmU3OGM5NDAxODJlYTcxZDQ0MjA1MDV8S0hha2JnOGFyQg=='
        ));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // this should be set to true in production
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $responseData = curl_exec($ch);
        if (curl_errno($ch)) {
            return curl_error($ch);
        }
        curl_close($ch);
        return $responseData;
    }



    public static function save_api_logs($logdata)
    {
        if (Auth::check()) {
            $user_id = Auth::user()->id;
        }
        else
        {
            $user_id = 0;
        }
        $insert_data = [
            //'api_url' => url()->current(),
            //'api_url' => $_SERVER["REQUEST_URI"],
            'api_url' => url()->full(),
            'request_data' => json_encode($logdata['request_data'],JSON_UNESCAPED_UNICODE),
            'response_data' => json_encode($logdata['response_data'],JSON_UNESCAPED_UNICODE),
            'request_ip' => \Request::ip(),
            'user_id' => $user_id,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];
        //$savelogs = DB::table('api_logs')->insert($insert_data);

    }

    public static function check_all_required_fields($user_id)
    {
       $user = User::find($user_id);
       //dd($user);
       if($user) {
        if(
            empty($user->username) or
            empty($user->account_type_id) or
            empty($user->name) or
            empty($user->email) or
            empty($user->mobile) or
            empty($user->nationality_id) or
            empty($user->resident_country_id)
        ) {
            return false;
        } else {
            if($user->account_type_id == 2) {
                $user_family = UserFamily::where('user_default_id', $user->id)->first();
                if(empty($user_family->height) or empty($user_family->gender) or empty($user_family->dob)) {
                    return false;
                }
            }
            return true;
        }
       } else {
        return false;
       }
    }
}
