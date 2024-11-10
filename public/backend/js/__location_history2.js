"use strict";

$(document).ready(function () {
  $("#location-pattern-select").change(function () {
    var selectedPattern = $(this).val();

    // Hide all maps
    $('[id^="map-pattern-"]').hide();

    // Show the selected map based on the value
    if (selectedPattern !== "") {
      $("#map-pattern-" + selectedPattern).show();
    }
  });

  const $dataUrl = $("#data_url");
  const $mapElement = $("#map");
  let map;
  let markers = [];
  let directionsService;
  let directionsRenderer;

  function initializeMap(mapData) {
    const initialLocation = {
      lat: mapData[0]?.latitude ?? 23.7947653,
      lng: mapData[0]?.longitude ?? 90.4013282,
    };

    map = new google.maps.Map($mapElement[0], {
      mapTypeId: google.maps.MapTypeId.ROADMAP,
      scrollwheel: true,
      center: initialLocation,
      zoom: 12,
    });

    const bounds = new google.maps.LatLngBounds();

    // Add the start marker
    const startMarker = new google.maps.Marker({
      position: {
        lat: parseFloat(mapData[0].latitude),
        lng: parseFloat(mapData[0].longitude),
      },
      map: map,
      title: mapData[0].start_location,
      optimized: false,
      label: {
        text: mapData[0].start_location,
        color: "black",
        fontWeight: "bold",
        className: "marker-label", // Add a CSS class name
        labelOrigin: new google.maps.Point(0, 100),
      },
      icon: {
        url: "https://maps.google.com/mapfiles/ms/icons/red-dot.png", // Use the default red pin point icon
        scaledSize: new google.maps.Size(32, 32), // Adjust the size of the icon as needed
      },
    });

    bounds.extend(startMarker.getPosition());
    markers.push(startMarker);

    // Add the end marker
    const endMarker = new google.maps.Marker({
      position: {
        lat: parseFloat(mapData[mapData.length - 1].latitude),
        lng: parseFloat(mapData[mapData.length - 1].longitude),
      },
      map: map,
      title: mapData[mapData.length - 1].start_location,
      optimized: false,
      label: {
        text: mapData[mapData.length - 1].start_location,
        color: "black",
        fontWeight: "bold",
        className: "marker-label", // Add a CSS class name
        labelOrigin: new google.maps.Point(0, 100),
      },
      icon: {
        url: "https://maps.google.com/mapfiles/ms/icons/green-dot.png", // Use a green pin point icon for the end marker
        scaledSize: new google.maps.Size(32, 32), // Adjust the size of the icon as needed
      },
    });

    bounds.extend(endMarker.getPosition());
    markers.push(endMarker);

    // Create a DirectionsService object
    directionsService = new google.maps.DirectionsService();
    // Create a DirectionsRenderer object
    directionsRenderer = new google.maps.DirectionsRenderer({
      map: map,
      suppressMarkers: true, // Suppress the default markers
      polylineOptions: {
        strokeColor: "#0000FF", // Set the color of the line
        strokeOpacity: 1.0,
        strokeWeight: 5,
      },
    });

    // Set the DirectionsRenderer to display the walking route
    calculateAndDisplayRoute(directionsService, directionsRenderer, startMarker.getPosition(), endMarker.getPosition());

    map.fitBounds(bounds);
  }

  function initMap() {
    const initialLocation = {
      lat: 23.7947653,
      lng: 90.4013282,
    };

    map = new google.maps.Map($mapElement[0], {
      zoom: 12,
      center: initialLocation,
    });
  }

  function calculateAndDisplayRoute(directionsService, directionsRenderer, startLocation, endLocation) {
    directionsService.route(
      {
        origin: startLocation,
        destination: endLocation,
        travelMode: google.maps.TravelMode.WALKING,
      },
      function (response, status) {
        if (status === "OK") {
          directionsRenderer.setDirections(response);
        } else {
          window.alert("Directions request failed due to " + status);
        }
      }
    );
  }

  if ($dataUrl.val()) {
    $.getJSON($dataUrl.val(), function (mapData) {
      if (mapData[0]) {
        initializeMap(mapData);
      } else {
        initMap();
      }
    });
  } else {
    initMap();
  }
});
