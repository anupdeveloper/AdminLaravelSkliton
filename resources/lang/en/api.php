<?php

use App\Models\MasterPopupMessage;

$login=MasterPopupMessage::where('group_name','login')->first();

// dd(json_decode($login->message_value_en,true));

return [

    'invoice' => [
        'invoice_title' => 'Simplified VAT invoice',
        'invoice_no' => 'Invoice No. :attribute',
        'invoice_date' => 'Date ::attribute',
        'vat_no' => 'Vat No. ::attribute',
        'table' => [
            'description' => 'Description',
            'duration' => 'Duration',
            'amount' => 'Amount',
            'vat' => 'Vat',
            'total_amt' => 'Total Amount',
            'member_included' => 'Member Included ::attribute',
            'member_included_header' => 'Member Included',
        ],
        
    ],
    'login' => [
        'mobile_no_is_not_registered_with_us' => 'Mobile number not registered in the system',
        'invalid_otp' => 'Please check the entered OTP number',
        'enter_your_phone_number' => 'Mobile no is required.',
        'mobile_number_must_start_with_05' => 'Mobile no must be starts with 5',
        'mobile_number_consists_of_10_digits' => 'Mobile no must be 9 digits only',
        'this_phone_number_is_used_as_admin' => 'This number is used as admin, Please try other number.',
        'your_account_is_blocked' => 'Your account is blocked by admin.',
    ],
    // 'login' => json_decode($login->message_value_en,true),

    'register' => [
        'mobile' => [
            'required' => 'The mobile no is required.',
            'starts_with' => 'Mobile no must be starts with 5',
            'size' => 'Mobile no must be 9 digits only',
        ],

    ],
    'verify_otp' => [
        'mobile' => [
            'required' => 'The mobile field is required.',
            'exists' => 'The selected mobile is invalid.',
            'size' => 'The mobile must be 9 characters.',
        ],
        'otp' => [
            'required' => 'The otp field is required.',
        ],

    ],
    'resend_otp' => [
        'mobile' => [
            'required' => 'The mobile field is required.',
            'exists' => 'The selected mobile is invalid.',
            'size' => 'The mobile must be 9 characters.',
        ],


    ],
    'logout' => [
        'success' => 'Successfully Logout'
    ],

    'set_profile_info' => [
        'form_fields' => [
            'account_type_id' => [
                'required' => 'The account_type_id field is required.',
                'exists' => 'The selected account_type_id is invalid.',
            ],
            'name' => [
                'required' => 'The name field is required.',
                'max' => 'The name must not be greater than 20 characters.',
                'min' => 'The name must be at least 4 characters.',
            ],
            'username' => [
                'required' => 'The username field is required.',
                'unique' => 'Username already exits.',
                'alpha_numeric' => 'Username can have max 4 numbers.',
                'avaliable' => 'Username is available.'
            ],
            'email' => [
                'required' => 'The email field is required.',
                'email' => 'The email must be a valid email address.',
                'unique' => 'Email already exist.',
                'avaliable' => 'Email is available.'
            ],
            'dob' => [
                'required' => 'The dob field is required.',
                'date' => 'The dob field is invalid.',
                'before' => 'The selected dob should be before 18 year of current date.',
            ],
            'gender' => [
                'required' => 'The gender field is required.',
                'in' => 'The selected gender should be male|female.',
            ],
        ]
    ],
    'user_profile_update' => [
        'profile_image' => [
            'required' => 'The profile_image is required.',
        ],
        'status' => [
            'required' => 'The status is required.',
        ],
        'region_id' => [
            'required' => 'The region_id is required.',
        ],
        'bio' => [
            'required' => 'The bio is required.',
        ],
        'nationality_id' => [
            'required' => 'The nationality_id is required.',
        ],
        'resident_country_id' => [
            'required' => 'The resident_country_id is required.',
        ],
        'family_origin_id' => [
            'required' => 'The family_origin_id is required.',
        ],
        'married_previously' => [
            'required' => 'The married_previously is required.',
        ],
        'currently_married' => [
            'required' => 'The currently_married is required.',
        ],
        'children_id' => [
            'required' => 'The children_id is required.',
        ],
        'height' => [
            'required' => 'The height is required.',
        ],
        'skin_color_id' => [
            'required' => 'The skin_color_id is required.',
        ],
        'body_appearence' => [
            'required' => 'The body_appearence is required.',
        ],
        'education_id' => [
            'required' => 'The education_id is required.',
        ],
        'work_id' => [
            'required' => 'The work_id is required.',
        ],
        'religion_id' => [
            'required' => 'The religion_id is required.',
        ],
        'smoking' => [
            'required' => 'The smoking is required.',
        ],
        'is_your_family_tribal' => [
            'required' => 'The is_your_family_tribal is required.',
        ],
        'tribe_id' => [
            'required' => 'The tribe_id is required.',
        ],
        'other' => [
            'required' => 'The other is required.',
        ],
        'do_you_care_about_tribalism' => [
            'required' => 'The do_you_care_about_tribalism is required.',
        ],
        'hijab_type_id' => [
            'required' => 'The hijab_type_id is required.',
        ],
        'accept_poligamy' => [
            'required' => 'The accept_poligamy is required.',
        ],
        // message
        'success_message' => 'Profile Update Successfully',
        'success_message_profile_image_default' => 'Default Updated Successfully',
        'failed_message_profile_image_default' => 'Oops problem occured!',

    ],

    'profile_img' => [
        'edit' => [
            'validation' => [
                'message' => [
                    'invalid_image_id' => 'Invalid image id'
                ]
            ]
        ]
    ],

    'timeline_singular' => [
        'year' => ':attribute year ago',
        'month' => ':attribute month ago',
        'day' => ':attribute day ago',
        'hour' => ':attribute hour ago',
        'minute' => ':attribute minute ago',
        'second' => ':attribute second ago',
    ],

    
    'timeline_plural' => [
        'year' => ':attribute years ago',
        'month' => ':attribute months ago',
        'day' => ':attribute days ago',
        'hour' => ':attribute hours ago',
        'minute' => ':attribute minutes ago',
        'second' => ':attribute seconds ago',
    ],

    'common' => [
        'please_register_on_our_site' => 'Please visit website www.awaser.sa first to register then you can use the App',
        'click_here' => 'Click here',
        'message_payment' => 'Please complete subscription and payment via this link, then return to the App :attribute',
        'blocked_reported' => 'You have been blocked or reported by :attribute',
        'error' => 'The given data was invalid.',
        'user_search' => 'There are no results matching the entered key word',
        'Hi' => 'Hi,',
        "server_error" => "Error while make connection",
        "nothing_to_update" => "No data to update",
        "required" => "This is required",
        'no_active_subscription' => 'No active Subscription',
        "lives_in" => "Lives in :attribute",
        'nationality' => "Nationality: :attribute",
        "region" => ":attribute",
        "city" => ":attribute",
        "family_origin" => "Originally From :attribute",
        "skin" => ":attribute Skin",
        "tribe" => ":attribute",
        "care_about_tribalism" => "Cares about tribalism",
        "not_care_about_tribalism"=>"Not cares about tribalism",
        "tribal_person" => "Tribal Person",
        "not_tribal_person" => "Not Tribal Person",
        "currently_married" => "Currently married",
        "previously_married" => "Previously married",
        "previously_married_F" => "Previously married",
        "not_married" => "Single",
        "not_married_F" => "Single",
        "smoke"=>"Smoker",
        "talk_before_marriage"=>":attribute",
        "accept_polygamy"=>"Accept Polygamy",
        "not_accept_polygamy"=>"Not Accept Polygamy",
        "sometimes_smoke"=>"Smoke sometime",
        "no_smoke"=>"Non Smoker",
        "connection_request_sent_successfully" => "You have successfully sent connection request to :attribute",
        "your_account_is_deleted_successfully" => "Your account is deleted successfully.",
        "successfully_liked" => "You have successfully liked this picture.",
        "successfully_disliked" => "You have disliked this picture.",
        "otp_message" => "Your Awaser App OTP :otp_no",
    ],
    'pre_member_screen' => [
        'heading' => 'Unlock your Membership',
        'sub_heading' => 'You’re one step away from accessing your profile! Purchase a plan to continute'
    ],

    "admin" => [
        "common" => [
            'action' => "Action"
        ],



        //Master Education
        "MasterEducational" => [
            "labels" => [
                "name_ar" => "Name ar",
                "name_en" => "Name en",
                "code" => "Code",
                "description" => "Description",

            ],
            "validation_msg" => [
                "name_ar" => [
                    "required" => "The name_ar field is required.",

                    "max" => "The name_ar must not be greater than 20.",
                ],
                "name_en" => [
                    "required" => "The name_en field is required.",
                ],
                "code" => [
                    "required" => "The code field is required.",
                ],
                "Description" => [
                    "required" => "The description field is required.",
                ],

            ],
            "message" => [
                "add" => [
                    "success" => "Data added successfully",
                    "error" => "Problem Occured!"
                ],
                "edit" => [
                    "success" => "Data updated successfully",
                    "error" => "Problem Occured!",
                ],
                "delete" => [
                    "success" => "Data deleted successfully",
                    "error" => "Problem Occured!",
                ],
            ],
            "pages" => [
                "list" => [
                    "labels" => [
                        "all_the_mastereducational" => "All the MasterEducational",
                    ],
                    "button" => [
                        "add" => "Add MasterEducational",
                        "view" => "View",
                        "edit" => "Edit",
                        "delete" => "Delete",
                    ]
                ],
                "add" => [
                    "labels" => [
                        "create_a_mastereducational" => "Create a MasterEducational",
                    ],
                    "button" => [
                        "add" => "Add MasterEducational",
                        "view" => "View",
                        "edit" => "Edit",
                        "delete" => "Delete",
                    ]
                ],
                "view" => [
                    "labels" => [
                        "view_mastereducational" => "MasterEducational View",
                    ]
                ],
                "edit" => [
                    "labels" => [
                        "edit_a_mastereducational" => "Edit a MasterEducational"
                    ],
                    "button" => [
                        "update" => "Update",

                    ]
                ]

            ]
        ],

        // SKIN COLOR
        "SkinColor" => [
            "labels" => [
                "name_ar" => "Name ar",
                "name_en" => "Name en",

            ],
            "validation_msg" => [
                "name_ar" => [
                    "required" => "The name_ar field is required.",
                ],
                "name_en" => [
                    "required" => "The name_en field is required.",
                ],

            ],
            "message" => [
                "add" => [
                    "success" => "Data added successfully",
                    "error" => "Problem Occured!"
                ],
                "edit" => [
                    "success" => "Data updated successfully",
                    "error" => "Problem Occured!",
                ],
                "delete" => [
                    "success" => "Data deleted successfully",
                    "error" => "Problem Occured!",
                ],
            ],
            "pages" => [
                "list" => [
                    "labels" => [
                        "all_the_skincolor" => "All the SkinColor",
                    ],
                    "button" => [
                        "add" => "Add SkinColor",
                        "view" => "View",
                        "edit" => "Edit",
                        "delete" => "Delete",
                    ]
                ],
                "add" => [
                    "labels" => [
                        "create_a_skincolor" => "Create a SkinColor",
                    ],
                    "button" => [
                        "add" => "Add SkinColor",
                        "view" => "View",
                        "edit" => "Edit",
                        "delete" => "Delete",
                    ]
                ],
                "view" => [
                    "labels" => [
                        "view_skincolor" => "SkinColor View",
                    ]
                ],
                "edit" => [
                    "labels" => [
                        "edit_a_skincolor" => "Edit a SkinColor"
                    ],
                    "button" => [
                        "update" => "Update",

                    ]
                ]

            ]
        ],

        // personality dimension
        "PersonalityDimension" => [
            "labels" => [
                "left_title_en" => "Left Title en",
                "left_title_ar" => "Left Title ar",
                "right_title_en" => "Right Title en",
                "right_title_ar" => "Right Title ar",
                "points" => "Points",

            ],
            "validation_msg" => [
                "title_en" => [
                    "required" => "The title_en field is required.",
                ],
                "title_ar" => [
                    "required" => "The title_ar field is required.",
                ],
                "desc_en" => [
                    "required" => "The desc_en field is required.",
                ],
                "desc_ar" => [
                    "required" => "The desc_ar field is required.",
                ],
                "points" => [
                    "required" => "The points field is required.",
                ],

            ],
            "message" => [
                "add" => [
                    "success" => "Data added successfully",
                    "error" => "Problem Occured!"
                ],
                "edit" => [
                    "success" => "Data updated successfully",
                    "error" => "Problem Occured!",
                ],
                "delete" => [
                    "success" => "Data deleted successfully",
                    "error" => "Problem Occured!",
                ],
            ],
            "pages" => [
                "list" => [
                    "labels" => [
                        "all_the_personalitydimension" => "All the PersonalityDimension",
                    ],
                    "button" => [
                        "add" => "Add PersonalityDimension",
                        "view" => "View",
                        "edit" => "Edit",
                        "delete" => "Delete",
                    ]
                ],
                "add" => [
                    "labels" => [
                        "create_a_personalitydimension" => "Create a PersonalityDimension",
                    ],
                    "button" => [
                        "add" => "Add PersonalityDimension",
                        "view" => "View",
                        "edit" => "Edit",
                        "delete" => "Delete",
                    ]
                ],
                "view" => [
                    "labels" => [
                        "view_personalitydimension" => "PersonalityDimension View",
                    ]
                ],
                "edit" => [
                    "labels" => [
                        "edit_a_personalitydimension" => "Edit a PersonalityDimension"
                    ],
                    "button" => [
                        "update" => "Update",

                    ]
                ]

            ]
        ],

        // ONBOARDING

        "OnBoarding" => [
            "labels" => [
                "title_ar" => "Title ar",
                "title_en" => "Title en",
                "description_en" => "Description en",
                "description_ar" => "Description ar",
                "image" => "Image",
                "expired_at" => "Expired at",
                "validated_at" => "Validated at",

            ],
            "validation_msg" => [
                "title_ar" => [
                    "required" => "The title_ar field is required.",
                ],
                "title_en" => [
                    "required" => "The title_en field is required.",
                ],
                "description_en" => [
                    "required" => "The description_en field is required.",
                ],
                "description_ar" => [
                    "required" => "The description_ar field is required.",
                ],
                "image" => [
                    "required" => "The image field is required.",
                ],
                "expired_at" => [
                    "required" => "The expired_at field is required.",
                ],
                "validated_at" => [
                    "required" => "The validated_at field is required.",
                ],

            ],
            "message" => [
                "add" => [
                    "success" => "Data added successfully",
                    "error" => "Problem Occured!"
                ],
                "edit" => [
                    "success" => "Data updated successfully",
                    "error" => "Problem Occured!",
                ],
                "delete" => [
                    "success" => "Data deleted successfully",
                    "error" => "Problem Occured!",
                ],
            ],
            "pages" => [
                "list" => [
                    "labels" => [
                        "all_the_onboarding" => "All the OnBoarding",
                    ],
                    "button" => [
                        "add" => "Add OnBoarding",
                        "view" => "View",
                        "edit" => "Edit",
                        "delete" => "Delete",
                    ]
                ],
                "add" => [
                    "labels" => [
                        "create_a_onboarding" => "Create a OnBoarding",
                    ],
                    "button" => [
                        "add" => "Add OnBoarding",
                        "view" => "View",
                        "edit" => "Edit",
                        "delete" => "Delete",
                    ]
                ],
                "view" => [
                    "labels" => [
                        "view_onboarding" => "OnBoarding View",
                    ]
                ],
                "edit" => [
                    "labels" => [
                        "edit_a_onboarding" => "Edit a OnBoarding"
                    ],
                    "button" => [
                        "update" => "Update",

                    ]
                ]

            ]
        ],

        // --------- Subscription CRUD ----------
        "Subscription" => [
            "labels" => [
                "account_type_id" => "Account Type",
                "name" => "Name",
                "name_ar" => "Name Ar",
                "price" => "Price",
                "member_no" => "Member no",
                "member_cost" => "Each Member Cost",
                "duration" => "Duration",
                "description" => "Description",
                "description_ar" => "Description Ar",
                "status" => "Status",

            ],
            "validation_msg" => [
                "account_type_id" => [
                    "required" => "The account_type_id field is required.",
                ],
                "name" => [
                    "required" => "The name field is required.",
                ],
                "name_ar" => [
                    "required" => "The name field is required.",
                ],
                "price" => [
                    "required" => "The price field is required.",
                ],
                "member_no" => [
                    "required" => "The member_no field is required.",
                ],
                "duration" => [
                    "required" => "The duration field is required.",
                ],
                "description" => [
                    "required" => "The description field is required.",
                ],
                "description_ar" => [
                    "required" => "The description field is required.",
                ],

            ],
            "message" => [
                "add" => [
                    "success" => "Data added successfully",
                    "error" => "Problem Occured!"
                ],
                "edit" => [
                    "success" => "Data updated successfully",
                    "error" => "Problem Occured!",
                ],
                "delete" => [
                    "success" => "Data deleted successfully",
                    "error" => "Problem Occured!",
                ],
            ],
            "pages" => [
                "list" => [
                    "labels" => [
                        "all_the_subscription" => "All the Subscription",
                    ],
                    "button" => [
                        "add" => "Add Subscription",
                        "view" => "View",
                        "edit" => "Edit",
                        "delete" => "Delete",
                    ]
                ],
                "add" => [
                    "labels" => [
                        "create_a_subscription" => "Create a Subscription",
                    ],
                    "button" => [
                        "add" => "Add Subscription",
                        "view" => "View",
                        "edit" => "Edit",
                        "delete" => "Delete",
                    ]
                ],
                "view" => [
                    "labels" => [
                        "view_subscription" => "Subscription View",
                    ]
                ],
                "edit" => [
                    "labels" => [
                        "edit_a_subscription" => "Edit a Subscription"
                    ],
                    "button" => [
                        "update" => "Update",

                    ]
                ]

            ]
        ],

        // Master Status

        "Status" => [
            "labels" => [
                "type" => "Type",
                "connection_limit" => "Connection limit",

            ],
            "validation_msg" => [
                "type" => [
                    "required" => "The type field is required.",
                ],
                "connection_limit" => [
                    "required" => "The connection_limit field is required.",
                ],

            ],
            "message" => [
                "add" => [
                    "success" => "Data added successfully",
                    "error" => "Problem Occured!"
                ],
                "edit" => [
                    "success" => "Data updated successfully",
                    "error" => "Problem Occured!",
                ],
                "delete" => [
                    "success" => "Data deleted successfully",
                    "error" => "Problem Occured!",
                ],
            ],
            "pages" => [
                "list" => [
                    "labels" => [
                        "all_the_status" => "All the Status",
                    ],
                    "button" => [
                        "add" => "Add Status",
                        "view" => "View",
                        "edit" => "Edit",
                        "delete" => "Delete",
                    ]
                ],
                "add" => [
                    "labels" => [
                        "create_a_status" => "Create a Status",
                    ],
                    "button" => [
                        "add" => "Add Status",
                        "view" => "View",
                        "edit" => "Edit",
                        "delete" => "Delete",
                    ]
                ],
                "view" => [
                    "labels" => [
                        "view_status" => "Status View",
                    ]
                ],
                "edit" => [
                    "labels" => [
                        "edit_a_status" => "Edit a Status"
                    ],
                    "button" => [
                        "update" => "Update",

                    ]
                ]

            ]
        ],


        // ADMIN USER MANAGEMENT

        "User" => [
            "title" => "User Management",
            "labels" => [
                "reset_password" => "Reset Password",
                "password" => "Password",
                "account_type_id" => "Account Type",
                "name" => "Name",
                "email" => "Email",
                "mobile" => "Mobile",
                "nationality_id" => "Nationality",
                "region_id" => "Region",
                "city_id" => "City",
                "profile_completed" => "Profile Completed",
                "subscription_status" => "Subscription Status",
                "currently_married" => "Currently Married",
                "report_count" => "Report Count",
                "members_count" => 'Members Count',
                "send_noti" => "Send Notification",
                "gender"=>"Gender",
                "height"=>"Height",
                "residence_nationality" => "Residence Nationality",
                "family_origin" => "Family Origin",
                "previsously_married" => "Previously Married",
                "currently_married" => "Currently Married",
                "no_of_children" => "No of children",
                "skin_color" => "Skin Color",
                "education" => "Education",
                "occupation" => "Occupation",
                "smoking" => "Smoking",
                "city" => "City",
                "tribal" => "Tribal",
                "sect" => "Sect",
                "search" => "Search",
                "view_reports" => "View Reports",
                "username" => "Username",
                "dob" => "DOB"

            ],
            "validation_msg" => [
                "account_type_id" => [
                    "required" => "The account_type_id field is required.",
                ],
                "username" => [
                    "required" => "The username field is required.",
                ],
                "dob" => [
                    "required" => "The dob field is required.",
                ],
                "gender" => [
                    "required" => "The gender field is required.",
                ],
                "email" => [
                    "required" => "The email field is required.",
                ],
                "mobile" => [
                    "required" => "The mobile field is required.",
                ],
                "nationality_id" => [
                    "required" => "The nationality_id field is required.",
                ],
                "resident_country_id" => [
                    "required" => "The resident_country_id field is required.",
                ],
                "region_id" => [
                    "required" => "The region_id field is required.",
                ],
                "city_id" => [
                    "required" => "The city_id field is required.",
                ],
                "family_origin_id" => [
                    "required" => "The family_origin_id field is required.",
                ],
                "married_previously" => [
                    "required" => "The married_previously field is required.",
                ],
                "currently_married" => [
                    "required" => "The currently_married field is required.",
                ],
                "children_id" => [
                    "required" => "The children_id field is required.",
                ],
                "height" => [
                    "required" => "The height field is required.",
                ],
                "skin_color_id" => [
                    "required" => "The skin_color_id field is required.",
                ],
                "education_id" => [
                    "required" => "The education_id field is required.",
                ],
                "work_id" => [
                    "required" => "The work_id field is required.",
                ],
                "smoking" => [
                    "required" => "The smoking field is required.",
                ],
                "is_your_family_tribal" => [
                    "required" => "The is_your_family_tribal field is required.",
                ],
                "tribe_id" => [
                    "required" => "The tribe_id field is required.",
                ],
                "do_you_care_about_tribalism" => [
                    "required" => "The do_you_care_about_tribalism field is required.",
                ],
                "do_you_have_flexibility_to_marry_a_married_man" => [
                    "required" => "The do_you_have_flexibility_to_marry_a_married_man field is required.",
                ],
                "hijab_type_id" => [
                    "required" => "The hijab_type_id field is required.",
                ],

            ],
            "message" => [
                "add" => [
                    "success" => "Data added successfully",
                    "error" => "Problem Occured!"
                ],
                "edit" => [
                    "success" => "Data updated successfully",
                    "error" => "Problem Occured!",
                ],
                "delete" => [
                    "success" => "Data deleted successfully",
                    "error" => "Problem Occured!",
                ],
            ],
            "pages" => [
                "list" => [
                    "labels" => [
                        "all_the_user" => "All the User",
                    ],
                    "button" => [
                        "add" => "Add User",
                        "view" => "View",
                        "edit" => "Edit",
                        "delete" => "Delete",
                    ]
                ],
                "add" => [
                    "labels" => [
                        "create_a_user" => "Create a User",
                    ],
                    "button" => [
                        "add" => "Add User",
                        "view" => "View",
                        "edit" => "Edit",
                        "delete" => "Delete",
                    ]
                ],
                "view" => [
                    "labels" => [
                        "view_user" => "User View",
                    ]
                ],
                "edit" => [
                    "labels" => [
                        "edit_a_user" => "Edit a User"
                    ],
                    "button" => [
                        "update" => "Update",

                    ]
                ]

            ]
        ],









    ],

    'connection' => [
        "send_add_request" => "Request sent successfully",
        "reached_max_send_request_per_day" => "You have reached the daily maximum allowed to send add requests!",
        "reached_max_send_request" => "You reached to the maximum allowed connections number!",
        "accept_max_active_connection" => "You have reached the maximum allowed limit of active connections! In order to accept new connections, please delete some of your active connections.",
        "cancel_add_request" => '',
        'recipant_has_no_active_connection' => 'Recipient has no active connection',
        "message_delete" => "Connection is deleted successfully!!"
    ],

    "user-status" => [
        'message' => [
            'green' => 'Successfully Changed to Green',
            'yellow' => 'Successfully Changed to Yellow',
            'red' => 'Successfully Changed to Red',
        ]
    ],

];
