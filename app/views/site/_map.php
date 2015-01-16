<?php
/**
 * User: Ivan Grgurina
 */
/** @var $parkings Parking[]  */
/** @var $currentLocation LatLng */
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
    'center' => $currentLocation == null ? $Zagreb : $currentLocation,
    'zoom' => 12,
    'width' => '100%',
    'height' => '300',
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

    $linkToReservation = Html::a('Rezerviraj mjesto', ['reservation/type', 'parking_id' => $parking->id]);

    $marker->attachInfoWindow(
        new InfoWindow([
            'content' => '<div style="height: 100px;width:200px;"><span class="glyphicon glyphicon-globe pull-left" style="margin-top:2px;"></span><h4 class="text-center">Parking Zagreb</h4>
            <p>' . $parking->location->address . '</p>
            <p>Trenutno je slobodno ' . $parking->freeParkingSpotsCount . ' od ' . $parking->number_of_parking_spots . ' parkirališnih mjesta.</p>
            <p class="pull-right">' . $linkToReservation . '</p>
            </div>'
        ])
    );

    $map->addOverlay($marker);

}

echo $map->display();
?>