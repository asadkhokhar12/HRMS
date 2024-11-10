"use strict";

const toggleAllPermission = () => {
    $('.permission-group').prop('checked', $('#checkAll').is(':checked'));
    $('.single-permission').prop('checked', $('#checkAll').is(':checked'));
}

const toggleSinglePermissions = (obj) => {
    let isChecked = $(obj).closest('.accordion-item').find('.permission-group').is(':checked');
    $(obj).closest('.accordion-item').find('.single-permission').prop('checked', isChecked);
}

const togglePermissionGroup = (obj) => {

    let count = 0;

    $(obj).closest('.accordion-item').find('.single-permission').each(function () {
        if ($(this).is(':checked')) {
            count++;
        }
    })

    if (count > 0) {
        $(obj).closest('.accordion-item').find('.permission-group').prop('checked', true);
    } else {
        $(obj).closest('.accordion-item').find('.permission-group').prop('checked', false);
    }
}
