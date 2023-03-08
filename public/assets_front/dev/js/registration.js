$(document).on('change', '#country', function () {
    var country = $(this).val();
    $.ajax({
        type: "POST",
        url: "/getRegionByCountry",
        data: ({ country_id: country }),
        success: function (response) {
            text = `<option>Select Region</option>`;
            for (let index = 0; index < response.data.length; index++) {
                text += `<option value="${response.data[index].id}">${response.data[index].name}</option>`
            }
            $("#region").html(text);
        }
    });
});

$(document).on('change', '#region', function () {
    var region = $(this).val();
    $.ajax({
        type: "POST",
        url: "/getCityByRegion",
        data: ({ region_id: region }),
        success: function (response) {
            text = `<option>Select City</option>`;
            for (let index = 0; index < response.data.length; index++) {
                text += `<option value="${response.data[index].id}">${response.data[index].name}</option>`
            }
            $("#city").html(text);
        }
    });
});

$(document).on('change', '#family_country', function () {
    var country = $(this).val();
    $.ajax({
        type: "POST",
        url: "/getRegionByCountry",
        data: ({ country_id: country }),
        success: function (response) {
            text = `<option>Select Family Region</option>`;
            for (let index = 0; index < response.data.length; index++) {
                text += `<option value="${response.data[index].id}">${response.data[index].name}</option>`
            }
            $("#family_region").html(text);
        }
    });
});

$(document).on('change', '#family_region', function () {
    var region = $(this).val();
    $.ajax({
        type: "POST",
        url: "/getCityByRegion",
        data: ({ region_id: region }),
        success: function (response) {
            text = `<option>Select Family City</option>`;
            for (let index = 0; index < response.data.length; index++) {
                text += `<option value="${response.data[index].id}">${response.data[index].name}</option>`
            }
            $("#family_city").html(text);
        }
    });
});

$(document).on('change', '#marital_status', function () {
    var marital_status = $(this).val();
    if (marital_status == 1) {
        $("#children_number").attr('required', 'required');
        $("#children_number").parent().show();
    } else {
        $("#children_number").removeAttr('required');
        $("#children_number").parent().hide();
    }
});

$(document).on('change', '#tribe_status', function () {
    var tribe_status = $(this).val();
    if (tribe_status == 1) {
        $("#tribe_id").attr('required', 'required');
        $("#tribe_id").parent().show();
    } else {
        $("#tribe_id").removeAttr('required');
        $("#tribe_id").parent().hide();
    }
});


// $(document).on('submit', "#complete_registration", function (e) {
//     e.preventDefault();
// });

// $("#complete_registration").validate({
//     ignore: "",
//     rules: {
//         'nationality_id': {
//             required: true,
//         },
//         'resident_country_id': {
//             required: true,
//         },
//         'region_id': {
//             required: true,
//         },
//         'city': {
//             required: true,
//         },
//         'family_origin_id': {
//             required: true,
//         },
//         'family_region': {
//             required: true,
//         },
//         'family_city': {
//             required: true,
//         },
//         'currently_married': {
//             required: true,
//         },
//         'married_previously': {
//             required: true,
//         },
//         'height': {
//             required: true,
//         },
//         'skin_color_id': {
//             required: true,
//         },
//         'education_id': {
//             required: true,
//         },
//         'work_id': {
//             required: true,
//         },
//         'do_you_allow_talking_before_marriage': {
//             required: true,
//         },
//         'smoking': {
//             required: true,
//         },
//         'is_your_family_tribal': {
//             required: true,
//         },
//         'care_tribal': {
//             required: true,
//         },
//         'hijab_type_id': {
//             required: true,
//         }
//     }
// });