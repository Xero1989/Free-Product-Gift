

$(document).ready(async function () {
  console.log("Loading Shop JS script");

  show_loader(true);

  reset_init_variables();

  create_event_listener();

  // await load_autoship_frequencies();

  show_loader(false);

});


function reset_init_variables() {

}

function create_event_listener() {

  // Add button 1 Event
  // $('#addOnePlus01').on('click', async function () {
  //   console.log("button_action");  

  //   show_loader(true);   

  //   await load_autoship_frequencies();

  //   show_loader(false);
  // });  

}




async function load_autoship_frequencies() {
  console.log("Loading frecuencys");

  if (autoship_frequencies == null) {//Load values from the API
    await jQuery.ajax({
      url: url_admin_ajax,
      type: "post",
      data: {
        action: "load_autoship_frequencies",
      },
      success: function (server_response) {
        server_response = JSON.parse(server_response);
        console.log("Frequencies LOADED");
        console.log(server_response);

        if (!proccess_remote_response(server_response, "load_autoship_frequencies"))
          return;

        autoship_frequencies = server_response["data"];

        $("#frecuency").empty();

        autoship_frequencies.forEach(element => {
          let id_frequency = element["autoshipFrecuencyId"];
          let name_frequency = element["name"];

          $("#frecuency").append('<option value="' + id_frequency + '">' + name_frequency + '</option>');

        });

        $("#frecuency").val(selected_frequency["autoshipFrecuencyId"]);

      },
      error: () => {
        console.log("Something went wrong load_autoship_frequencies()");
      }

    });
  } else {//Load values from the JS
    console.log("Load frecuencys with JS");
    $("#frecuency").empty();

    autoship_frequencies.forEach(element => {
      let id_frequency = element["autoshipFrecuencyId"];
      let name_frequency = element["name"];

      $("#frecuency").append('<option value="' + id_frequency + '">' + name_frequency + '</option>');

    });

    $("#frecuency").val(selected_frequency["autoshipFrecuencyId"]);
  }

}

