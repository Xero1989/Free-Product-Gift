

$(document).ready(async function () {

  console.log("Loading BACKEND JS script");

});


async function save_session_data(session_data) {
  let result = false;

  await jQuery.ajax({
    url: url_admin_ajax,
    type: "post",
    data: {
      action: "save_session_data",
      session_data
    },
    success: function (server_response) {
      server_response = JSON.parse(server_response);

      if (!proccess_remote_response(server_response)) {
        result = false;
        return;
      }

      result = true;

    },
    error: () => {
      console.log("Something went wrong save_session_data");

    }

  });

  return result;
}





