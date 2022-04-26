let map;

function initMap() {
  map = new google.maps.Map(document.getElementById("map"), {
    center: { lat: -34.397, lng: 150.644 },
    zoom: 8,
  });
}

window.initMap = initMap;

$(document).on("click", ".trigggerModal", function () {
  $("#modal").modal("show").find("#modalContent").load($(this).attr("value"));
});
