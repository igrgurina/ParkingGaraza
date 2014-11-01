<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\i18n\Formatter;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ParkingSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Parkings';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="parking-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Parking', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            /// "attribute:format:label"
            'company.name:text:Company',
            'location.address:text:Location',
            'type',
            'number_of_parking_spots:integer:Size',
            [
                'label' => 'Cost/h',
                'attribute' => 'cost' ,
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
