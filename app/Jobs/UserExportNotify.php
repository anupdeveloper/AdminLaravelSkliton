<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\Events\JobProcessed;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Queue;
use Rap2hpoutre\FastExcel\FastExcel;
use DB;

class UserExportNotify implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $searchParams;
    public $fileName;

    public function __construct($searchParams = '', $fileName = '')
    {
        $this->searchParams = $searchParams;
        $this->fileName = $fileName;
    }

    public function handle()
    {

        $searchParams = $this->searchParams;
        $user = User::with(['user_default_info'])
            ->withCount(['userFamily'])
            ->select('id', 'name', 'email', 'mobile', 'account_type_id',
                DB::raw("(select count(*) from user_families where user_id = users.id) as family_count"))
            ->where('email', '!=', 'admin@admin.com')
            ->where('is_admin', '0')
            ->when(!empty($searchParams['account_type']), function ($user) use ($searchParams) {
                $user->where('account_type_id', $searchParams['account_type']);
            })
            ->when(!empty($searchParams['country']) && (count($searchParams['country']) > 0), function ($user) use ($searchParams) {
                $user->whereIn('nationality_id', $this->searchParams['country']);
            })
            ->when(!empty($searchParams['residence_country']) && (count($searchParams['residence_country']) > 0), function ($user) use ($searchParams) {
                $user->whereIn('resident_country_id', $this->searchParams['residence_country']);
            })
            ->when(!empty($searchParams['region']), function ($user) use ($searchParams) {
                $user->where('live_in_region_id', $searchParams['region']);
            })
            ->when(!empty($searchParams['city']), function ($user) use ($searchParams) {
                $user->where('live_in_city_id', $searchParams['city']);
            })
            ->when(!empty($searchParams['family_origin']), function ($user) use ($searchParams) {
                $user->where('family_origin_id', $searchParams['family_origin']);
            })
            ->when(!empty($searchParams['previsously_married']), function ($user) use ($searchParams) {
                $user->whereHas('user_default_info', function ($q) use ($searchParams) {
                    $q->where('married_previously', $searchParams['previsously_married']);
                });
            })
            ->when(!empty($searchParams['currently_married']), function ($user) use ($searchParams) {
                $user->whereHas('user_default_info', function ($q) use ($searchParams) {
                    $q->where('currently_married', $searchParams['currently_married']);
                });
            })
            ->when(!empty($searchParams['height']), function ($user) use ($searchParams) {
                $user->whereHas('user_default_info', function ($q) use ($searchParams) {
                    $q->where('height', $searchParams['height']);
                });
            })
            ->when(!empty($searchParams['age']), function ($user) use ($searchParams) {
                $user->whereHas('user_default_info', function ($q) use ($searchParams) {
                    $q->whereDate('dob', '>=', $searchParams['age']);
                });
            })
            ->when(!empty($searchParams['gender']), function ($user) use ($searchParams) {
                $user->whereHas('user_default_info', function ($q) use ($searchParams) {
                    $q->where('gender', $searchParams['gender']);
                });
            })
            ->when(!empty($searchParams['no_of_children']), function ($user) use ($searchParams) {
                $user->whereHas('user_default_info', function ($q) use ($searchParams) {
                    $q->where('children_id', $searchParams['no_of_children']);
                });
            })
            ->when(!empty($searchParams['skin_color']), function ($user) use ($searchParams) {
                $user->whereHas('user_default_info', function ($q) use ($searchParams) {
                    $q->where('skin_color_id', $searchParams['skin_color']);
                });
            })
            ->when(!empty($searchParams['occupation']), function ($user) use ($searchParams) {
                $user->whereHas('user_default_info', function ($q) use ($searchParams) {
                    $q->where('work_id', $searchParams['occupation']);
                });
            })
            ->when(!empty($searchParams['smoking']), function ($user) use ($searchParams) {
                $user->whereHas('user_default_info', function ($q) use ($searchParams) {
                    $q->where('smoking', $searchParams['smoking']);
                });
            })
            ->when(!empty($searchParams['profile_completed']), function ($user) use ($searchParams) {
                $user->where('is_completed', $searchParams['profile_completed']);
            })
            ->when(!empty($searchParams['subscription_status']), function ($user) use ($searchParams) {
                $user = $user->whereHas('user_subscriptions', function ($q) use ($searchParams) {
                    $q->where('status', $searchParams['subscription_status']);
                });
            })
            ->when(!empty($searchParams['education']), function ($user) use ($searchParams) {
                $user->whereHas('user_default_info', function ($q) use ($searchParams) {
                    $q->where('education_id', $searchParams['education']);
                });
            });
        $fileName = $this->fileName;
        $file_path = public_path('users/' . str_replace([':', ' '], '', $fileName));
        (new FastExcel($user->get()))->export($file_path, function ($user) {
            return [
                'Email' => $user->email,
                'First Name' => $user->name,
                'Mobile No' => $user->mobile,
                'Family Count' => $user->family_count ?? 0,
                'Account Type' => $user->user_default_info ? $user->user_default_info->account_type->name : '--',
                'Nationality' => $user->user_default_info ? $user->user_default_info->nationality_detail ? $user->user_default_info->nationality_detail->name : '--' : '--',
                'Region' => $user->user_default_info ? $user->user_default_info->region_detail ? $user->user_default_info->region_detail->name : '--' : '--',
                'City' => $user->user_default_info ? $user->user_default_info->city_detail ? $user->user_default_info->city_detail->name : '--' : '--',
                'Currently Married' => $user->account_type_id == 2 ? isset($row->user_default_info->currently_married) ? $row->user_default_info->currently_married : '' : '',
            ];
        });

    }

}
