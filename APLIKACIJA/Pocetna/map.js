var map;
var addressField;
var geocoder;

$(document).ready(function () {
    // Define map options
    var mapOptions = {
        center: new google.maps.LatLng(45.8130, 15.9819),
        zoom: 11,
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        panControl: true,
        zoomControl: true,
        mapTypeControl: true,
        scaleControl: true,
        streetViewControl: true,
        overviewMapControl: true
    };

    // Define map
    map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);

    // Define Gecoder
    geocoder = new google.maps.Geocoder();

    // Init searchbox
    initSearchBox();
});

function initSearchBox() {
    // Add searchbox
    var searchControlDiv = document.createElement('div');
    var searchControl = new SearchControl(searchControlDiv, map);

    searchControlDiv.index = 1;
    map.controls[google.maps.ControlPosition.TOP_CENTER].push(searchControlDiv);
}

function SearchControl(controlDiv, map) {
    // Set CSS styles for the DIV containing the control
    // Setting padding to 5 px will offset the control
    // from the edge of the map.
    controlDiv.style.padding = '5px';

    // Set CSS for the control border.
    var controlUI = document.createElement('div');
    controlUI.style.backgroundColor = '#fff';
    controlUI.style.borderStyle = 'solid';
    controlUI.style.borderWidth = '1px';
    controlUI.style.borderColor = '#ccc';
    controlUI.style.cursor = 'pointer';
    controlUI.style.textAlign = 'center';
    controlUI.style.opacity = '0.8';
    controlUI.style.height = '30px';
    controlUI.style.borderRadius = '4px';
    controlUI.title = 'Sök ex: gatunamn, stad';
    controlDiv.appendChild(controlUI);

    // Create the search box
    var controlSearchBox = document.createElement('input');
    controlSearchBox.id = 'search_address';
    controlSearchBox.size = '40';
    controlSearchBox.type = 'text';
    controlSearchBox.style.height = '30px';

    // Initiat autocomplete
    $(function () {
        $(controlSearchBox).autocomplete({
            source: function (request, response) {

                if (geocoder == null) {
                    geocoder = new google.maps.Geocoder();
                }

                geocoder.geocode({
                    'address': request.term
                }, function (results, status) {
                    if (status == google.maps.GeocoderStatus.OK) {
                        var searchLoc = results[0].geometry.location;
                        var lat = results[0].geometry.location.lat();
                        var lng = results[0].geometry.location.lng();
                        var latlng = new google.maps.LatLng(lat, lng);
                        var bounds = results[0].geometry.bounds;

                        geocoder.geocode({
                            'latLng': latlng
                        }, function (results1, status1) {
                            if (status1 == google.maps.GeocoderStatus.OK) {
                                if (results1[1]) {
                                    response($.map(results1, function (loc) {
                                        return {
                                            label: loc.formatted_address,
                                            value: loc.formatted_address,
                                            bounds: loc.geometry.bounds
                                        }
                                    }));
                                }
                            }
                        });
                    }
                });
            },
            select: function (event, ui) {
                var pos = ui.item.position;
                var lct = ui.item.locType;
                var bounds = ui.item.bounds;

                if (bounds) {
                    map.fitBounds(bounds);
                }
            }
        });
    });

    // Set CSS for the control interior.
    var controlText = document.createElement('div');
    controlText.style.fontFamily = 'Calibri,sans-serif';
    controlText.style.fontSize = '16px';
    controlText.appendChild(controlSearchBox);
    controlUI.appendChild(controlText);


    //Add div to Google Maps
    map.controls[google.maps.ControlPosition.RIGHT_BOTTOM].push(
        document.getElementById('desni'));
}

