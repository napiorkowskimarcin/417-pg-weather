console.log("selectize.js");
const $ = require("jquery");

$(document).ready(function () {
  console.log("ready!");
  let findAllStations = $("#findAll").attr("data-findall");
  findAllStations = JSON.parse(findAllStations);
  //   let selectedValue = $("#station").val();
  let selectedValue = $("#station").val();
  console.log(selectedValue);
});
