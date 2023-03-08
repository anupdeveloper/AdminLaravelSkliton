<?php

use App\Models\MasterPopupMessage;

$login=MasterPopupMessage::where('group_name','login')->first();

return [

    'invoice' => [
        'invoice_title' => 'فاتورة ضريبية مبسطة',
        'invoice_no' => 'رقم الفاتورة::attribute',
        'invoice_date' => 'التاريخ ::attribute',
        'vat_no' => 'رقم تسجيل ضريبة القيمة المضافة::attribute',
        'table' => [
            'description' => 'وصف',
            'duration' => 'مدة',
            'amount' => 'مقدار',
            'vat' => 'ضريبة القيمة المضافة',
            'total_amt' => 'المبلغ الإجمالي',
            'member_included' => 'يشمل الأعضاء ::attribute',
            'member_included_header' => 'يشمل الأعضاء',
        ],
        
    ],
    'login' => [
        'mobile_no_is_not_registered_with_us' => 'رقم الجوال غري النظام',
        'invalid_otp' => 'يرجى التأكد من رمز التحقق المدخل',
        'enter_your_phone_number' => 'رقم الجوال مطلوب',
        'mobile_number_must_start_with_05' => 'يجب أن يبدأ رقم الجوال بـ 5',
        'mobile_number_consists_of_10_digits' => 'رقم الجوال يجب أن يتكون من 9 أرقام فقط',
        'this_phone_number_is_used_as_admin' => 'This number is used as admin, Please try other number.',
        'your_account_is_blocked' => 'Your account is blocked by admin.',
    ],

    'register' => [
        'mobile' => [
            'required' => 'رقم الجوال مطلوب',
            'starts_with' => 'يجب أن يبدأ رقم الجوال بـ 5',
            'size' => 'رقم الجوال يجب أن يتكون من 9 أرقام فقط',
        ],

    ],

    'verify_otp' => [
        'mobile' => [
            'required' => 'رقم الجوال مطلوب',
            'exists' => 'The selected mobile is invalid.',
            'size' => 'رقم الجوال يجب أن يتكون من 9 أرقام فقط',
        ],
        'otp' => [
            'required' => 'رمز التحقق مطلوب',
        ],

    ],
    'resend_otp' => [
        'mobile' => [
            'required' => 'رقم الجوال مطلوب',
            'exists' => 'The selected mobile is invalid.',
            'size' => 'رقم الجوال يجب أن يتكون من 9 أرقام فقط',
        ],


    ],
    'logout' => [
        'success' => 'Successfully Logout'
    ],

    'timeline_singular' => [
        'year' => ':attribute year ago',
        'month' => ':attribute month ago',
        'day' => ':attribute منذ يوم',
        'hour' => ':attribute منذ ساعة',
        'minute' => ':attribute منذ دقيقة',
        'second' => ':attribute قبل ثانية',
    ],

    
    'timeline_plural' => [
        'year' => ':attribute years ago',
        'month' => ':attribute months ago',
        'day' => ':attribute منذ يوم',
        'hour' => ':attribute hours ago',
        'minute' => ':attribute minutes ago',
        'second' => ':attribute seconds ago',
    ],

    'set_profile_info' => [
        'form_fields' => [
            'account_type_id' => [
                'required' => 'The account_type_id field is required.',
                'exists' => 'The selected account_type_id is invalid.',
            ],
            'name' => [
                'required' => 'حقل الاسم مطلوب.',
                'max' => 'The name must not be greater than 20 characters.',
                'min' => 'The name must be at least 4 characters.',
            ],
            'username' => [
                'required' => 'حقل اسم المستخدم مطلوب.',
                'unique' => 'اسم المستخدم موجود مسبقًا',
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
                'required' => 'حقل تاريخ الميلاد مطلوب.',
                'date' => 'The dob field is invalid.',
                'before' => 'The selected dob should be before 18 year of current date.',
            ],
            'gender' => [
                'required' => 'الرجاء تحديد جنسك',
                'in' => 'الجنس المحدد يجب أن يكون ذكر | أنثى',
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

    'common' => [
        'please_register_on_our_site' => 'الرجاء التسجيل عبر موقع أواصر أولاً ثم قم باستخدام التطبيق لتسجيل الدخول www.awaser.sa',
        'click_here' => 'انقر هنا',
        'message_payment' => 'رجاء أكمل خطوات الاشتراك والدفع عبر الرابط ومن ثم العودة للتطبيق:attribute',
        'blocked_reported' => 'تم حظرك أو الإبلاغ عنك بواسطة :attribute',
        'error' => 'البيانات المقدمة كانت غير صالحة.',
        'user_search' => 'ال يوجد نتائج تطابق الكلمة المدخلة',
        'Hi' => 'أهلاً,',
        "server_error" => "خطأ أثناء إجراء الاتصال",
        'required' => 'هذا مطلوب',
        'no_active_subscription' => 'لا يوجد اشتراك نشط',
        "lives_in" => "يعيش في :attribute",
        'nationality' => "الجنسية: :attribute",
        "region" => ":attribute",
        "city" => ":attribute",
        "family_origin" => "الأصل من :attribute",
        "skin" => "لون البشرة :attribute",
        "tribe" => ":attribute",
		"care_about_tribalism" => "يهتم بالقبلية",
        "not_care_about_tribalism"=>"لا يهتم بالقبلية",
        "tribal_person" => "قَبلي",
        "not_tribal_person" => "غير قَبلي",
        "currently_married" => "متزوج حاليا",
        "previously_married_F" => "متزوجه سابقا",
        "previously_married" => "متزوج سابقا",
        "talk_before_marriage"=>":attribute",
        "accept_polygamy"=>"لدي المرونة للزواج بمعدد",
        "not_accept_polygamy"=>"لا أقبل الزواج بمعدد",
        "not_married" => "أعزب",
        "not_married_F" => "عزباء",
        "smoke"=>"مدخن",
        "sometimes_smoke"=>"مدخن أحياناً",
        "no_smoke"=>"غير مدخن",
        "connection_request_sent_successfully" => "لقد نجحت في إرسال طلب الاتصال إلى :attribute",
        "your_account_is_deleted_successfully" => "تم حذف حسابك بنجاح.",
        "successfully_liked" => "You have successfully liked this picture.",
        "successfully_disliked" => "You have disliked this picture.",
        "otp_message" => "رمز التحقق الخاص بك هو :otp_no",
    ],
    'pre_member_screen' => [
        'heading' => 'افتح عضويتك',
        'sub_heading' => 'أنت على بعد خطوة واحدة من الوصول إلى ملفك الشخصي! شراء خطة للاستمرار'
    ],

    'connection' => [
        "send_add_request" => "تم إرسال الطلب بنجاح",
        "reached_max_send_request_per_day" => "لقد وصلت للحد الأعلى اليومي المسموح به لإرسال طلبات الإضافة!",
        "reached_max_send_request"=>"لقد وصلت للحد الأعلى المسموح به للإضافة!",
        "accept_max_active_connection"=>"لقد وصلت للحد الأعلى من عدد جهات الاتصال. لتتمكن من قبول جهات اتصال جديدة، لا بد من حذف بعض جهات الاتصال لديك.",
        "nothing_to_update" => "No data to update",
        'recipant_has_no_active_connection' => 'Recipient has no active connection',
        "message_delete" => "Connection is deleted successfully!!"
    ],


    "admin" => [
        "common" => [
            'action' => "عمل"
        ],


        "User" => [
            "title" => "إدارةالمستخدم",
            "labels" => [
                "reset_password" => "إعادة تعيين كلمة المرور",
                "password" => "كلمة المرور",
                "account_type_id" => "نوع الحساب",
                "name" => "اسم",
                "email" => "البريد الإلكتروني",
                "mobile" => "التليفون المحمول",
                "nationality_id" => "جنسية",
                "region_id" => "منطقة",
                "city_id" => "مدينة",
                "profile_completed" => "اكتمل الملف الشخصي",
                "subscription_status" => "حالة الاشتراك",
                "currently_married" => "متزوج حاليا",
                "report_count" => "تقرير العدد",
                "members_count" => 'عدد الأفراد',
                "send_noti" => "إرسال الإخطار",
                "gender"=>"جنس",
                "height"=>"ارتفاع",
                "residence_nationality" => "جنسية الاقامة",
                "family_origin" => "الأصل العائلي",
                "previsously_married" => "متزوج سابقا",
                "currently_married" => "متزوج حاليا",
                "no_of_children" => "لا من الاطفال",
                "skin_color" => "لون البشرة",
                "education" => "تعليم",
                "occupation" => "إشغال",
                "smoking" => "التدخين",
                "city" => "مدينة",
                "tribal" => "القبلية",
                "sect" => "الطائفة",
                "search" => "يبحث",
                "view_reports" => "عرض التقارير",
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


        "MasterEducational" => [
            "labels" => [
               "name_ar"=>"Name ar",
                "name_en"=>"Name en",
                "code"=>"Code",
	
            ],
            "validation_msg"=>[
                "name_ar"=>[
					"required"=>"حقل name_ar مطلوب.",
					
					"max"=>"يجب ألا يكون الاسم_ar أكبر من 20.",
					],
			"name_en"=>[
					"required"=>"حقل name_ar مطلوب.",
					],
			"code"=>[
					"required"=>"حقل الرمز مطلوب.",
					],
			
            ],
            "message" => [
                "add" => [
                    "success" => "تمت إضافة البيانات بنجاح",
                    "error" => "حدثت مشكلة!"
                ],
                "edit" => [
                    "success" => "تم تحديث البيانات بنجاح",
                    "error" => "حدثت مشكلة!",
                ],
                "delete" => [
                    "success" => "تم حذف البيانات بنجاح",
                    "error" => "حدثت مشكلة!",
                ],
            ],
            "pages" => [
                "list" => [
                    "labels" => [
                        "all_the_mastereducational" => "كل ال MasterEducational",
                    ],
                    "button" => [
                        "add" => "يضيف MasterEducational",
                        "view" => "رأي",
                        "edit" => "يحرر",
                        "delete" => "حذف",
                    ]
                ],
                 "add" => [
                    "labels" => [
                        "create_a_mastereducational" => "إنشاء MasterEducational",
                    ],
                    "button" => [
                        "add" => "يضيف MasterEducational",
                        "view" => "رأي",
                        "edit" => "يحرر",
                        "delete" => "حذف",
                    ]
                ],
                "view"=>[
                    "labels"=>[
                        "view_mastereducational"=>"MasterEducational رأي",
                    ]
                ],
                "edit"=>[
                    "labels"=>[
                        "edit_a_mastereducational"=>"تحرير أ MasterEducational"
                    ],
                    "button" => [
                        "update" => "تحديث",
                       
                    ]
                ]

            ]
        ],

        "Subscription" => [
            "labels" => [
                "account_type_id" => "نوع الحساب",
                "name" => "اسم",
                "name_ar" => "Ar اسم",
                "price" => "سعر",
                "member_no" => "رقم العضو",
                "member_cost" => "تكلفة كل عضو",
                "duration" => "مدة",
                "description" => "وصف",
                "description" => "Ar وصف",
                "status" => "Status",

            ],
            "validation_msg" => [
                "account_type_id" => [
                    "required" => "The account_type_id field is required.",
                ],
                "name" => [
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

    ],




    
];
