import "selectize/dist/js/standalone/selectize.min.js";
const $ = require("jquery");

$(document).ready(function () {
  let findAllStations = $("#findAll").attr("data-findall");
  findAllStations = JSON.parse(findAllStations);

  let sendAjax = {
    ajax: true,
    type: "get",
    dataType: "html",
    success: function (data) {
      let response = JSON.parse(data);
      $("#table").html(response.template);
    },
  };

  $("#station").selectize({
    options: findAllStations,
    valueField: "id",
    labelField: "stationName",
    placeholder: "choose station",
  });
  $("#station").change(function (event) {
    event.preventDefault();
    sendAjax.url = "/getone/" + $("#station").val();
    $.ajax(sendAjax);
  });
});
