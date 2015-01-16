<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var dektrium\user\models\UserSearch $searchModel
 */

$this->title = Yii::t('user', 'Upravljanje korisnicima');
$this->params['breadcrumbs'][] = $this->title;
?>
<h1><?= Html::encode($this->title) ?> </h1>

<?= $this->render('/_alert', [
    'module' => Yii::$app->getModule('user'),
]) ?>

<?php Pjax::begin() ?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel'  => $searchModel,
    'layout'  => "{items}\n{pager}",
    'columns' => [
        'username',
        'email:email',
        [
            'header' => 'Status', // Yii::t('user', 'Block status'),
            'value' => function ($model) {
                if ($model->isBlocked) {
                    return Html::a(Yii::t('user', 'Odblokiraj'), ['block', 'id' => $model->id], [
                        'class' => 'btn btn-xs btn-success btn-block',
                        'data-method' => 'post',
                        'data-confirm' => Yii::t('user', 'Are you sure to unblock this user?')
                    ]);
                } else {
                    return Html::a(Yii::t('user', 'Blokiraj'), ['block', 'id' => $model->id], [
                        'class' => 'btn btn-xs btn-danger btn-block',
                        'data-method' => 'post',
                        'data-confirm' => Yii::t('user', 'Are you sure to block this user?')
                    ]);
                }
            },
            'format' => 'raw',
        ],
        [
            'header' => Yii::t('user', 'Admin'),
            'value' => function ($model) {
                if ($model->isAdmin) {
                    return Html::a('<span class="glyphicon glyphicon-plus"></span>', ['admin', 'id' => $model->id], [
                        'class' => 'btn btn-xs btn-success btn-block',
                        'data-method' => 'post',
                        'data-confirm' => Yii::t('user', 'Da li sigurno želite smanjiti ovlasti korisniku?')
                    ]);
                } else {
                    return Html::a('<span class="glyphicon glyphicon-minus"></span>', ['admin', 'id' => $model->id], [
                        'class' => 'btn btn-xs btn-primary btn-block',
                        'data-method' => 'post',
                        'data-confirm' => Yii::t('user', 'Da li sigurno želite proglasiti korisnika administratorom?')
                    ]);
                }
            },
            'format' => 'raw',
        ],
    ],
]); ?>

<?php Pjax::end() ?>
