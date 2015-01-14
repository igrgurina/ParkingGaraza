<?php
/**
 * User: Ivan Grgurina
 */
/** @var $parkings Parking[]  */
use dosamigos\google\maps\LatLng;
use dosamigos\google\maps\services\DirectionsWayPoint;
use dosamigos\google\maps\services\TravelMode;
use dosamigos\google\maps\overlays\PolylineOptions;
use dosamigos\google\maps\services\DirectionsRenderer;
use dosamigos\google\maps\services\DirectionsService;
use dosamigos\google\maps\overlays\InfoWindow;
use dosamigos\google\maps\overlays\Marker;
use dosamigos\google\maps\Map;
use dosamigos\google\maps\services\DirectionsRequest;
use dosamigos\google\maps\overlays\Polygon;
use dosamigos\google\maps\layers\BicyclingLayer;
use app\models\Parking;
use yii\helpers\Html;

$Zagreb = new LatLng(['lat' => 45.8167, 'lng' => 15.9833]);
$map = new Map([
    'center' => $Zagreb,
    'zoom' => 12,
]);

foreach ($parkings as $parking) {
    $coordinate = new LatLng([
        'lat' => $parking->location->lat,
        'lng' => $parking->location->lng,
    ]);

    $marker = new Marker([
        'position' => $coordinate,
        'title' => $parking->location->address,
    ]);

    $linkToReservation = Html::a('Rezerviraj mjesto', ['reservation/create', 'parking_id' => $parking->id]);

    $marker->attachInfoWindow(
        new InfoWindow([
            'content' => '<div style="height: 100px;width:200px;"><h4 class="text-center">Parking: ' . $parking->freeParkingSpotsCount . '/' . $parking->number_of_parking_spots . '</h4>
            <p>' . $parking->location->address . '</p><p>' . $linkToReservation . '</p></div>'
        ])
    );

    $map->addOverlay($marker);

}

echo $map->display();
?>
HAHA