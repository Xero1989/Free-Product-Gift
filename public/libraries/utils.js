var $ = jQuery;

$(document).ready(async function () {

    console.log("Loading Master JS script");

    // show_loader(true);



    // show_loader(false);

});

var server_response_temp;
function proccess_remote_response(server_response, action) {
    server_response_temp = server_response;

    //Response FAIL
    if (server_response["response_code"] == "") {
        show_alert('error', "Error", "An error happens " + action);

        console.log("An error happen trying to make a request " + action);

        return false;

    } else if (server_response["response_code"] != 200) {
        show_alert('error', "Error", "An error happens " + action);

        let status = server_response["data"]["status"];
        let code = server_response["code"];
        let message = server_response["message"];

        console.log("A request was fail " + action);
        console.log("Code: " + status);
        console.log("Type: " + code);
        console.log("Message: " + message);

        return false;
    }
    //Response 200 OK
    else if (server_response["success"] == false) {
        show_alert('error', server_response["title"], server_response["message"]);
        return false;
    } else if (server_response["success"] == true) {
        // show_alert('success', server_response["title"], server_response["message"]);
        return true;
    }
}

//------------------------Sweet Alert Custom---------------------------------------------------------------
function show_alert(type, title, message) {

    if (type == 'error') {
        Swal.fire({
            icon: 'error',
            title: title,
            text: message,
            confirmButtonColor: 'red',
        });
    } else if (type == 'info') {
        Swal.fire({
            icon: 'info',
            title: title,
            text: message,
            confirmButtonColor: 'blue',
        });
    }
    else if (type == 'success') {
        Swal.fire({
            icon: 'success',
            title: title,
            text: message,
            confirmButtonColor: 'blue',
        });
    }
}
//---------------------------------------------------------------------------------------

//------------------------Loader Custom---------------------------------------------------------------
var is_loading = false;
function show_loader(show) {
    if (is_loading) {
        if (show == false) {
            jQuery("#loader-background").hide();
            is_loading = false;
        }
    } else {
        if (show == true) {
            jQuery("#loader-background").show();
            is_loading = true;
        }
    }
}
//---------------------------------------------------------------------------------------