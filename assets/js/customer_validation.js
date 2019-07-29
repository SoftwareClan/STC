$(document).ready(function () {

    // Only letter
    $.validator.addMethod("only_letter", function (value, element) {
        var alph = new RegExp(/^[a-zA-Z]*$/);
        return alph.test(value);
    });

    // Only number
    $.validator.addMethod("only_number", function (value, element) {
        var alph = new RegExp(/\d/);
        return alph.test(value);
    });
    // Mobile number
    $.validator.addMethod("mobile_number", function (value, element) {
        var alph = new RegExp(/^[0-9]{10}$/);
        return alph.test(value);
    });

    // Pincode
    $.validator.addMethod("pincode", function (value, element) {
        var alph = new RegExp(/^[0-9]{4}$/);
        return alph.test(value);
    });

    // letter with whitespace
    $.validator.addMethod("letter_with_whitespace", function (value, element) {
        var alph = new RegExp(/^[a-zA-Z ]*$/);
        return alph.test(value);
    });

    // letter with underscrol
    $.validator.addMethod("letter_with_underscore", function (value, element) {
        var alph = new RegExp(/^[a-zA-Z_]*$/);
        return alph.test(value);
    });

    $.validator.addMethod("mpin_password", function (value, element) {
        var alph = new RegExp(/^[0-9]{4}$/);
        return alph.test(value);
    });



});

function showNotification(from, align, icon, message, type) {

    $.notify({
        icon: icon,
        message: message

    }, {
        type: type,
        timer: 2000,
        placement: {
            from: from,
            align: align
        }
    });
}

function getFormData(form) {

    var client_service = encypt("frontend-client");
    var auth_key = encypt("stchexaclan");
    var json = '{"client_service": "' + client_service + '","auth_key": "' + auth_key + '"}';
    var object = JSON.parse(json);
    
    for (var i = 0; i < form.length - 1; i++) {
        if (form[i].value !== "") {
            object[form[i].name] = encypt(form[i].value);
        }
    }
    return object;
}

function getFormData(form,token,user_key,user_type) {

    var client_service = encypt("frontend-client");
    var auth_key = encypt("stchexaclan");
    var json = '{"client_service": "' + client_service + '","auth_key": "' + auth_key + '","token": "' 
            + encypt(token) + '","auth_client": "' + encypt(user_key) 
            + '","user_type": "' + encypt(user_type) + '"}';
    var object = JSON.parse(json);
    
    for (var i = 0; i < form.length - 1; i++) {
        if (form[i].value !== "") {
            object[form[i].name] = encypt(form[i].value);
        }
    }
    console.log(object);
    return object;
}

function getRequestData() {
    var client_service = encypt("frontend-client");
    var auth_key = encypt("stchexaclan-client");
    var json = '{"client_service": "' + client_service + '","auth_key": "' + auth_key + '"}';
    var object = JSON.parse(json);
    return object;
}


function encypt(value) {
    return window.btoa(value);
}

function dencypt(value) {
    return window.atob(value);
}

function getAjax(u_url, u_data) {
    var request = $.ajax({
        url: u_url,
        data: u_data,
        method: "post"
    });

    return request;
}

function load_table(url,data) {
    var request = getAjax(url, data);
    request.done(function (success) {
        $('#firm_list_tbody').empty();
        $('#firm_list_tbody').append(success['data_table']);
        $('#firm_list_table').DataTable();
    });

    request.fail(function (error) {
        console.log(error);
        showNotification('top', 'right', 'add_alert', 'Error While loading..', 'danger');
    });

}