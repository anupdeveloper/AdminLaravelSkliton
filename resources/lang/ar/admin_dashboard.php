<?php


return [

    "dashboard" => [
        "total_accounts" => "Total Accounts",
        "total_active_accounts" => "Total Active Accounts",
        "total_family_accounts" => "Total Family Accounts",
        "total_individual_accounts" => "Total Individual Accounts",
        "total_active_connections" => "Total Active Connections",
        "total_pending_connections" => "Total Pending Connections",

        "total_cancel_connections" => "Total Cancel Connections",
        "total_subscriptions" => "Total Subscriptions",
        "total_active_subscriptions" => "Total Active Subscriptions",
        "total_education_contents" => "Total Education Contents",
        "more_info" => "More Info",
    ],

    "sidebar_menu" => [
        "user_management" => "إدارة المستخدم",
        "user_transaction" => "معاملة المستخدم",
        "user_subscription" => "اشتراك المستخدم",
        "users" => "المستخدمون",
        "roles" => "الأدوار",
        "permission" => "أذونات",
        "send_notifications" => "إرسال الإخطار",
        "user_connection" => "اتصال",
        "active_connections" => "اتصال نشط",
        "request_connections" => "الاتصال المطلوب",
        "cancel_connections" => "إلغاء الاتصال",
        "requested_suggestion" => "الاقتراح المطلوب",
        "settings" => "إعدادات",
        "master_education" => "تعليم",
        "master_skin_color" => "لون البشرة",
        "master_personality_dimension" => "أبعاد الشخصية",
        "master_onboarding" => "على متن الطائرة",
        "master_subscription" => "الاشتراك",
        "master_status" => "حالة",
        "master_education_content" => "محتوى تعليمي",
        "master_hijab_type" => "نوع الحجاب",
        "master_work" => "تحفة",
        "master_family_origin" => "الأصل العائلي",
        "master_children" => "سيد الأطفال",
        "master_popup_message" => "رسالة POPUp الرئيسية",
        "master_sect" => "الطائفة الرئيسية",
        "master_height" => "الارتفاع الرئيسي",
        "terms_n_condition" => "الشروط والأحكام",
        "vat_setting" => "إعدادات",
        "user_report" =>"تقرير المستخدم",
        "master_country" => "Master Country",
        "master_city" => "Master City",
        'master_region' => "Master Region",
        "master_tribe" => "Master Tribe",
        "user_payment"=> "User Payments",
        "logout" => "تسجيل خروج"
    ],

    "common" => [
        "yes" => "YES",
        "no" => "NO",
    ],

    "admin" => [

        // COUNTRY
        "MasterCountry" => [
            "labels" => [
                "name_en" => "Name en",
                "name_ar" => "Name ar",
            ],
            "success_message" => "Country has been added successfully.",
            "success_update_message"=>"Country has been updated successfully.",
            "success_delete_message" =>"Country has been deleted successfully.",
            "required" => "This field is required!",
            "page_title" => "Country Lists",
            "create_page_title" => "Create Country",
            "edit_page_title" => "Edit Country",
            "add" => "Add New",
            "edit" => "Edit",
            "delete" => "Delete"
        ],
        // Region
        "MasterRegion" => [
            "labels" => [
                "name_en" => "Name en",
                "name_ar" => "Name ar",
            ],
            "success_message" => "Region has been added successfully.",
            "success_update_message"=>"Region has been updated successfully.",
            "success_delete_message" =>"Region has been deleted successfully.",
            "required" => "This field is required!",
            "page_title" => "Region Lists",
            "create_page_title" => "Create Region",
            "edit_page_title" => "Edit Region",
            "add" => "Add New",
            "edit" => "Edit",
            "delete" => "Delete"
        ],
        // CITY
        "MasterCity" => [
            "labels" => [
                "name_en" => "Name en",
                "name_ar" => "Name ar",
            ],
            "success_message" => "City has been added successfully.",
            "success_update_message"=>"City has been updated successfully.",
            "success_delete_message" =>"City has been deleted successfully.",
            "required" => "This field is required!",
            "page_title" => "City Lists",
            "create_page_title" => "Create City",
            "edit_page_title" => "Edit City",
            "add" => "Add New",
            "edit" => "Edit",
            "delete" => "Delete"
        ],

        // Tribe
        "MasterTribe" => [
            "labels" => [
                "name_en" => "Name en",
                "name_ar" => "Name ar",
            ],
            "success_message" => "Tribe has been added successfully.",
            "success_update_message"=>"Tribe has been updated successfully.",
            "success_delete_message" =>"Tribe has been deleted successfully.",
            "required" => "This field is required!",
            "page_title" => "Tribe Lists",
            "create_page_title" => "Create Tribe",
            "edit_page_title" => "Edit Tribe",
            "add" => "Add New",
            "edit" => "Edit",
            "delete" => "Delete"
        ],

        // HIJAB TYPE
        "HijabType" => [
            "labels" => [
                "name_en" => "Name en",
                "name_ar" => "Name ar",

            ],
            "validation_msg" => [
                "name_en" => [
                    "required" => "The name_en field is required.",
                ],
                "name_ar" => [],

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
                        "all_the_hijabtype" => "All the HijabType",
                    ],
                    "button" => [
                        "add" => "Add HijabType",
                        "view" => "View",
                        "edit" => "Edit",
                        "delete" => "Delete",
                    ]
                ],
                "add" => [
                    "labels" => [
                        "create_a_hijabtype" => "Create a HijabType",
                    ],
                    "button" => [
                        "add" => "Add HijabType",
                        "view" => "View",
                        "edit" => "Edit",
                        "delete" => "Delete",
                    ]
                ],
                "view" => [
                    "labels" => [
                        "view_hijabtype" => "HijabType View",
                    ]
                ],
                "edit" => [
                    "labels" => [
                        "edit_a_hijabtype" => "Edit a HijabType"
                    ],
                    "button" => [
                        "update" => "Update",

                    ]
                ]

            ]
        ],

        // Send Notification
        "SendNotification" => [
            "labels" => [
                "name_en" => "Name en",
                "name_ar" => "Name ar",
                "description_en" => "Description en",
                "description_ar" => "Description ar",

            ],
            "pages" => [
                "list" => [
                    "labels" => [
                        "send_notification" => "Send Notification",
                    ],
                    "button" => [
                        "add" => "Add EducationalContent",
                        "view" => "View",
                        "edit" => "Edit",
                        "delete" => "Delete",
                        "send_notification" => "Send Notification"
                    ]
                ],
                "add" => [
                    "labels" => [
                        "create_a_educationalcontent" => "Create a EducationalContent",
                    ],
                    "button" => [
                        "add" => "Add EducationalContent",
                        "view" => "View",
                        "edit" => "Edit",
                        "delete" => "Delete",
                    ]
                ],
                "view" => [
                    "labels" => [
                        "view_educationalcontent" => "EducationalContent View",
                    ]
                ],
                "edit" => [
                    "labels" => [
                        "edit_a_educationalcontent" => "Edit a EducationalContent"
                    ],
                    "button" => [
                        "update" => "Update",

                    ]
                ]

            ]
        ],

        // EDUCATIONAL CONTENT 
        "EducationalContent" => [
            "labels" => [
                "name_en" => "Name en",
                "name_ar" => "Name ar",
                "description_en" => "Description en",
                "description_ar" => "Description ar",
                "video_link" => "Video Link",
            ],
            "validation_msg" => [
                "name_en" => [
                    "required" => "The name_en field is required.",
                ],
                "name_ar" => [],
                "description_en" => [
                    "required" => "The description_en field is required.",
                ],
                "description_ar" => [],

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
                        "all_the_educationalcontent" => "All the EducationalContent",
                    ],
                    "button" => [
                        "add" => "Add EducationalContent",
                        "view" => "View",
                        "edit" => "Edit",
                        "delete" => "Delete",
                    ]
                ],
                "add" => [
                    "labels" => [
                        "create_a_educationalcontent" => "Create a EducationalContent",
                    ],
                    "button" => [
                        "add" => "Add EducationalContent",
                        "view" => "View",
                        "edit" => "Edit",
                        "delete" => "Delete",
                    ]
                ],
                "view" => [
                    "labels" => [
                        "view_educationalcontent" => "EducationalContent View",
                    ]
                ],
                "edit" => [
                    "labels" => [
                        "edit_a_educationalcontent" => "Edit a EducationalContent"
                    ],
                    "button" => [
                        "update" => "Update",

                    ]
                ]

            ]
        ],

        // MASTER WORK
        "MasterWork" => [
            "labels" => [
                "name_en" => "Name en",
                "name_ar" => "Name ar",

            ],
            "validation_msg" => [
                "name_en" => [
                    "required" => "The name_en field is required.",
                ],
                "name_ar" => [],

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
                        "all_the_masterwork" => "All the MasterWork",
                    ],
                    "button" => [
                        "add" => "Add MasterWork",
                        "view" => "View",
                        "edit" => "Edit",
                        "delete" => "Delete",
                    ]
                ],
                "add" => [
                    "labels" => [
                        "create_a_masterwork" => "Create a MasterWork",
                    ],
                    "button" => [
                        "add" => "Add MasterWork",
                        "view" => "View",
                        "edit" => "Edit",
                        "delete" => "Delete",
                    ]
                ],
                "view" => [
                    "labels" => [
                        "view_masterwork" => "MasterWork View",
                    ]
                ],
                "edit" => [
                    "labels" => [
                        "edit_a_masterwork" => "Edit a MasterWork"
                    ],
                    "button" => [
                        "update" => "Update",

                    ]
                ]

            ]
        ],
        // MASTER FAMILY ORIGIN
        "FamilyOrigin" => [
            "labels" => [
                "name_en" => "Name en",
                "name_ar" => "Name ar",

            ],
            "validation_msg" => [
                "name_en" => [
                    "required" => "The name_en field is required.",
                ],
                "name_ar" => [],

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
                        "all_the_familyorigin" => "All the FamilyOrigin",
                    ],
                    "button" => [
                        "add" => "Add FamilyOrigin",
                        "view" => "View",
                        "edit" => "Edit",
                        "delete" => "Delete",
                    ]
                ],
                "add" => [
                    "labels" => [
                        "create_a_familyorigin" => "Create a FamilyOrigin",
                    ],
                    "button" => [
                        "add" => "Add FamilyOrigin",
                        "view" => "View",
                        "edit" => "Edit",
                        "delete" => "Delete",
                    ]
                ],
                "view" => [
                    "labels" => [
                        "view_familyorigin" => "FamilyOrigin View",
                    ]
                ],
                "edit" => [
                    "labels" => [
                        "edit_a_familyorigin" => "Edit a FamilyOrigin"
                    ],
                    "button" => [
                        "update" => "Update",

                    ]
                ]

            ]
        ],


        // MASTER CHILDREN
        "MasterChildren" => [
            "labels" => [
                "children_number_en" => "Children number en",
                "children_number_ar" => "Children number ar",
                "children_count" => "Children Count",

            ],
            "validation_msg" => [
                "children_number_en" => [
                    "required" => "The children_number_en field is required.",
                ],
                "children_number_ar" => [
                    "required" => "The children_number_ar field is required.",
                ],
                "children_count" => [
                    "required" => "The children count is required.",
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
                        "all_the_masterchildren" => "All the MasterChildren",
                    ],
                    "button" => [
                        "add" => "Add MasterChildren",
                        "view" => "View",
                        "edit" => "Edit",
                        "delete" => "Delete",
                    ]
                ],
                "add" => [
                    "labels" => [
                        "create_a_masterchildren" => "Create a MasterChildren",
                    ],
                    "button" => [
                        "add" => "Add MasterChildren",
                        "view" => "View",
                        "edit" => "Edit",
                        "delete" => "Delete",
                    ]
                ],
                "view" => [
                    "labels" => [
                        "view_masterchildren" => "MasterChildren View",
                    ]
                ],
                "edit" => [
                    "labels" => [
                        "edit_a_masterchildren" => "Edit a MasterChildren"
                    ],
                    "button" => [
                        "update" => "Update",

                    ]
                ]

            ]
        ],

        // MASTER HEIGHT
        "MasterHeight" => [
            "labels" => [
                "height"=>"Height",

            ],
            "validation_msg"=>[
                "height"=>[
                    "required"=>"The height field is required.",
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
                        "all_the_masterheight" => "All the MasterHeight",
                    ],
                    "button" => [
                        "add" => "Add MasterHeight",
                        "view" => "View",
                        "edit" => "Edit",
                        "delete" => "Delete",
                    ]
                ],
                    "add" => [
                    "labels" => [
                        "create_a_masterheight" => "Create a MasterHeight",
                    ],
                    "button" => [
                        "add" => "Add MasterHeight",
                        "view" => "View",
                        "edit" => "Edit",
                        "delete" => "Delete",
                    ]
                ],
                "view"=>[
                    "labels"=>[
                        "view_masterheight"=>"MasterHeight View",
                    ]
                ],
                "edit"=>[
                    "labels"=>[
                        "edit_a_masterheight"=>"Edit a MasterHeight"
                    ],
                    "button" => [
                        "update" => "Update",

                    ]
                ]

            ]
        ],

        


        // USER 
        "User" => [
            "labels" => [
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
                "send_noti" => "Send Notification",
                "members_count" => "Members Count",
             ],
        ],

        // USER FAMILY
        "UserFamily" => [
            "labels" => [
                "status" => "Status",
                "name" => "Name",
                "dob" => "Dob",
                "gender" => "Gender",
                "married_previously" => "Married previously",
                "currently_married" => "Currently married",
                "children_id" => "Children",
                "height" => "Height",
                "skin_color_id" => "Skin color",
                "education_id" => "Education",
                "work_id" => "Work",
                "sect_id" => "Sect",
                "smoking" => "Smoking",
                "hijab_type_id" => "Hijab type id",
                "does_she_has_flexibility_to_marry_a_married_man" => "Does she has flexibility to marry a married man",

            ],
            "validation_msg" => [
                "status" => [
                    "required" => "The status field is required.",
                ],
                "name" => [
                    "required" => "The name field is required.",
                ],
                "dob" => [
                    "required" => "The dob field is required.",
                ],
                "gender" => [
                    "required" => "The gender field is required.",
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
                "sect_id" => [
                    "required" => "The sect_id field is required.",
                ],
                "smoking" => [
                    "required" => "The smoking field is required.",
                ],
                "hijab_type_id" => [
                    "required" => "The hijab_type_id field is required.",
                ],
                "does_she_has_flexibility_to_marry_a_married_man" => [
                    "required" => "The does_she_has_flexibility_to_marry_a_married_man field is required.",
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
                        "all_the_userfamily" => "All the UserFamily",
                    ],
                    "button" => [
                        "add" => "Add UserFamily",
                        "view" => "View",
                        "edit" => "Edit",
                        "delete" => "Delete",
                    ]
                ],
                "add" => [
                    "labels" => [
                        "create_a_userfamily" => "Create a UserFamily",
                    ],
                    "button" => [
                        "add" => "Add UserFamily",
                        "view" => "View",
                        "edit" => "Edit",
                        "delete" => "Delete",
                    ]
                ],
                "view" => [
                    "labels" => [
                        "view_userfamily" => "UserFamily View",
                    ]
                ],
                "edit" => [
                    "labels" => [
                        "edit_a_userfamily" => "Edit a UserFamily"
                    ],
                    "button" => [
                        "update" => "Update",

                    ]
                ]

            ]
        ],


        // MASTER POPUP MESSAGE

        "MasterPopupMessage" => [
            "labels" => [
                "group_name" => "Group name/Notification No.",
                "message_value_en" => "Message value en",
                "message_value_ar" => "Message value ar",

            ],
            "validation_msg" => [
                "group_name" => [
                    "required" => "The group_name field is required.",
                ],
                "message_value_en" => [
                    "required" => "The message_value_en field is required.",
                ],
                "message_value_ar" => [
                    "required" => "The message_value_ar field is required.",
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
                        "all_the_masterpopupmessage" => "All the MasterPopupMessage",
                    ],
                    "button" => [
                        "add" => "Add MasterPopupMessage",
                        "view" => "View",
                        "edit" => "Edit",
                        "delete" => "Delete",
                    ]
                ],
                "add" => [
                    "labels" => [
                        "create_a_masterpopupmessage" => "Create a MasterPopupMessage",
                    ],
                    "button" => [
                        "add" => "Add MasterPopupMessage",
                        "view" => "View",
                        "edit" => "Edit",
                        "delete" => "Delete",
                    ]
                ],
                "view" => [
                    "labels" => [
                        "view_masterpopupmessage" => "MasterPopupMessage View",
                    ]
                ],
                "edit" => [
                    "labels" => [
                        "edit_a_masterpopupmessage" => "Edit a MasterPopupMessage"
                    ],
                    "button" => [
                        "update" => "Update",

                    ]
                ]

            ]
        ],

        // MASTER SECT
        "MasterSect" => [
            "labels" => [
                "name_en" => "Name en",
                "name_ar" => "Name ar",

            ],
            "validation_msg" => [
                "name_en" => [
                    "required" => "The name_en field is required.",
                ],
                "name_ar" => [
                    "required" => "The name_ar field is required.",
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
                        "all_the_mastersect" => "All the MasterSect",
                    ],
                    "button" => [
                        "add" => "Add MasterSect",
                        "view" => "View",
                        "edit" => "Edit",
                        "delete" => "Delete",
                    ]
                ],
                "add" => [
                    "labels" => [
                        "create_a_mastersect" => "Create a MasterSect",
                    ],
                    "button" => [
                        "add" => "Add MasterSect",
                        "view" => "View",
                        "edit" => "Edit",
                        "delete" => "Delete",
                    ]
                ],
                "view" => [
                    "labels" => [
                        "view_mastersect" => "MasterSect View",
                    ]
                ],
                "edit" => [
                    "labels" => [
                        "edit_a_mastersect" => "Edit a MasterSect"
                    ],
                    "button" => [
                        "update" => "Update",

                    ]
                ]

            ]
        ],

        // USER SUGGESTION
        "UserSuggestion" => [
            "title" => "اقتراح",
            "labels" => [
                "user_id" => "المستخدم المحمول",
                "category_id" => "فئة",
                "suggestion" => "اقتراح",
                "action" => "عمل",

            ],
            "validation_msg" => [
                "user_id" => [
                    "required" => "The user_id field is required.",
                ],
                "category_id" => [
                    "required" => "The category_id field is required.",
                ],
                "suggestion" => [
                    "required" => "The suggestion field is required.",
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
                        "all_the_usersuggestion" => "All the UserSuggestion",
                    ],
                    "button" => [
                        "add" => "Add UserSuggestion",
                        "view" => "View",
                        "edit" => "Edit",
                        "delete" => "Delete",
                    ]
                ],
                "add" => [
                    "labels" => [
                        "create_a_usersuggestion" => "Create a UserSuggestion",
                    ],
                    "button" => [
                        "add" => "Add UserSuggestion",
                        "view" => "View",
                        "edit" => "Edit",
                        "delete" => "Delete",
                    ]
                ],
                "view" => [
                    "labels" => [
                        "view_usersuggestion" => "UserSuggestion View",
                    ]
                ],
                "edit" => [
                    "labels" => [
                        "edit_a_usersuggestion" => "Edit a UserSuggestion"
                    ],
                    "button" => [
                        "update" => "Update",

                    ]
                ]

            ]
        ],

        // USER TRANSACTION
        "Transaction" => [
            "labels" => [
                "transaction_no" => "Transaction no",
                "user_id" => "user-mobile",

            ],
            "validation_msg" => [
                "transaction_no" => [
                    "required" => "The transaction_no field is required.",
                ],
                "user_id" => [
                    "required" => "The user_id field is required.",
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
                        "all_the_transaction" => "All the Transaction",
                    ],
                    "button" => [
                        "add" => "Add Transaction",
                        "view" => "View",
                        "edit" => "Edit",
                        "delete" => "Delete",
                    ]
                ],
                "add" => [
                    "labels" => [
                        "create_a_transaction" => "Create a Transaction",
                    ],
                    "button" => [
                        "add" => "Add Transaction",
                        "view" => "View",
                        "edit" => "Edit",
                        "delete" => "Delete",
                    ]
                ],
                "view" => [
                    "labels" => [
                        "view_transaction" => "Transaction View",
                    ]
                ],
                "edit" => [
                    "labels" => [
                        "edit_a_transaction" => "Edit a Transaction"
                    ],
                    "button" => [
                        "update" => "Update",

                    ]
                ]

            ]
        ],

        // USER SUBSCRIPTION
        "UserSubscription" => [
            "title" => "الاشتراك",
            "labels" => [
                "email"=>"البريد الإلكتروني",
                "mobile"=>"التليفون المحمول",
                "status" => "حالة",
                "subscrption_id"=>"الاشتراك",
                "username" => "اسم المستخدم",
                "created_at"=>"أنشئت في",
                "expired_at"=>"انتهت في",
                "account_type_id" => "نوع الحساب",
                "transaction_id"=>"Transaction ID",
                "payment_type"=>"Payment Type",
                "name" => "اسم",
                "price" => "سعر",
                "member_no" => "رقم العضو",
                "member_cost" => "تكلفة كل عضو",
                "duration" => "مدة",
                "description" => "وصف",
	        ],
            "validation_msg"=>[
                "account_type_id"=>[
					"required"=>"The account_type_id field is required.",
					],
			"email"=>[
					"required"=>"The email field is required.",
					],
			"mobile"=>[
					"required"=>"The mobile field is required.",
					],
			"subscrption_id"=>[
					"required"=>"The subscrption_id field is required.",
					],
			"created_at"=>[
					"required"=>"The created_at field is required.",
					],
			"expired_at"=>[
					"required"=>"The expired_at field is required.",
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
                        "all_the_usersubscription" => "All the UserSubscription",
                    ],
                    "button" => [
                        "add" => "Add UserSubscription",
                        "view" => "View",
                        "view_history" => "View History",
                        "edit" => "Edit",
                        "delete" => "Delete",
                    ]
                ],
                 "add" => [
                    "labels" => [
                        "create_a_usersubscription" => "Create a UserSubscription",
                    ],
                    "button" => [
                        "add" => "Add UserSubscription",
                        "view" => "View",
                        "view_history" => "View History",
                        "edit" => "Edit",
                        "delete" => "Delete",
                    ]
                ],
                "view"=>[
                    "labels"=>[
                        "view_usersubscription"=>"UserSubscription View",
                    ]
                ],
                "edit"=>[
                    "labels"=>[
                        "edit_a_usersubscription"=>"Edit a UserSubscription"
                    ],
                    "button" => [
                        "update" => "Update",
                       
                    ]
                ]

            ]
        ],


        // User Connection
        "Connection" => [
            "title" => "اتصال",
            "labels" => [
                "connection_form"=>"اتصال من",
                "connection_to"=>"Connection To",
                "status" => "حالة",
                "action"=>"عمل",
                "created_at"=>"أنشئت في",
                
            ],
            "validation_msg"=>[
                "account_type_id"=>[
                    "required"=>"The account_type_id field is required.",
                    ],
            "email"=>[
                    "required"=>"The email field is required.",
                    ],
            "mobile"=>[
                    "required"=>"The mobile field is required.",
                    ],
            "subscrption_id"=>[
                    "required"=>"The subscrption_id field is required.",
                    ],
            "created_at"=>[
                    "required"=>"The created_at field is required.",
                    ],
            "expired_at"=>[
                    "required"=>"The expired_at field is required.",
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
                        "all_the_usersubscription" => "All the UserSubscription",
                    ],
                    "button" => [
                        "add" => "Add UserSubscription",
                        "view" => "View",
                        "edit" => "Edit",
                        "delete" => "Delete",
                    ]
                ],
                "add" => [
                    "labels" => [
                        "create_a_usersubscription" => "Create a UserSubscription",
                    ],
                    "button" => [
                        "add" => "Add UserSubscription",
                        "view" => "View",
                        "edit" => "Edit",
                        "delete" => "Delete",
                    ]
                ],
                "view"=>[
                    "labels"=>[
                        "view_usersubscription"=>"UserSubscription View",
                    ]
                ],
                "edit"=>[
                    "labels"=>[
                        "edit_a_usersubscription"=>"Edit a UserSubscription"
                    ],
                    "button" => [
                        "update" => "Update",
                    
                    ]
                ]

            ]
        ],





    ],

];
