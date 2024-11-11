"use strict";

$(document).ready(function () {
  const $dataUrl = $("#data_url");
  const $mapElement = document.getElementById("map");
  let map;

  function initMap(mapData) {
    const initialLocation = {
      lat: parseFloat(mapData[0]?.location_log?.latitude) || 23.7947653,
      lng: parseFloat(mapData[0]?.location_log?.longitude) || 90.4013282,
    };

    map = new google.maps.Map($mapElement, {
      zoom: 12,
      center: initialLocation,
    });

    const infoWindow = new google.maps.InfoWindow();

    mapData.forEach((element, index) => {
      const { latitude, longitude } = element.location_log;

      const marker = new google.maps.Marker({
        position: {
          lat: parseFloat(latitude),
          lng: parseFloat(longitude),
        },
        map,
        title: element.location_log.address,
        optimized: false,
      });
      const label = {
        text: element.name,
        color: "#FFA500",
        fontWeight: "bold",
        background: {
          color: "#000000",
        },
        fontSize: "12px",
        padding: "8px",
        labelOrigin: new google.maps.Point(0, -20), // Adjust the label position
      };

      marker.setLabel(label);

      const infoWindow = new google.maps.InfoWindow();

      marker.addListener("click", () => {
        infoWindow.close();
        infoWindow.setContent(marker.getTitle());
        infoWindow.open(marker.getMap(), marker);
      });
    });
  }

  if ($dataUrl.val()) {
    $.getJSON($dataUrl.val(), function (mapData) {
      if (mapData[0]) {
        initMap(mapData);
      } else {
        map = new google.maps.Map($mapElement, {
          center: { lat: -34.397, lng: 150.644 },
          zoom: 8,
        });
      }
    });
  } else {
    map = new google.maps.Map($mapElement, {
      center: { lat: -34.397, lng: 150.644 },
      zoom: 8,
    });
  }
});
