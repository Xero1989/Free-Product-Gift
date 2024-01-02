$(document).ready(function () {
  console.log("Loading Admin JS script");

  show_loader(true);

  create_event_listener();

  show_loader(false);
});

function create_event_listener() {

  //Click save settings button
  $(".bt_save_settings").click(async () => {
    show_loader(true);

    await fpg_save_settings();

    show_loader(false);
  });

}


async function fpg_save_settings() {

  let options = new Array();
  for (let i = 0; i < $('input[id^="fpg_"]').length; i++) {
    let id = $('input[id^="fpg_"]').eq(i).prop("id");
    let value = $('input[id^="fpg_"]').eq(i).val();

    options.push(new Array(id, value));
  }

  await $.ajax({
    url: url_admin_ajax,
    type: "post",
    data: {
      action: "fpg_save_settings",
      options
    },
    success: function (server_response) {
      server_response = JSON.parse(server_response);

      show_alert('info', 'Info', 'Settings Saved');
    },
    error: () => {
      console.log("Something went wrong");

      show_alert('error', 'Error', 'Something went wrong, try again...');

    }
  });
}




