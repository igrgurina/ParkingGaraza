<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
$this->title = 'About';
$this->params['breadcrumbs'][] = $this->title;
rmrevin\yii\fontawesome\AssetBundle::register($this);
?>
<style>
    .block-update-card {
        height: 100%;
        border: 1px #FFFFFF solid;
        width: 380px;
        float: left;
        margin-left: 10px;
        margin-top: 0;
        padding: 0;
        box-shadow: 1px 1px 8px #d8d8d8;
        background-color: #FFFFFF;
    }
    .block-update-card .update-card-MDimentions {
        width: 80px;
        height: 80px;
    }
    .block-update-card .update-card-body {
        position: relative;
        top: 15px;
        margin-left: 5px;
    }
    .block-update-card .update-card-body h4 {
        color: #737373;
        font-weight: bold;
        font-size: 15px;
    }
    .block-update-card .update-card-body p {
        color: #737373;
        font-size: 12px;
    }

    /*
    Creating a block for social media buttons
    */
    .card-body-social {
        font-size: 30px;
        margin-top: 10px;
    }
    .card-body-social .git {
        color: black;
        cursor: pointer;
        margin-left: 10px;
    }
    .card-body-social .twitter {
        color: #19C4FF;
        cursor: pointer;
        margin-left: 10px;
    }
    .card-body-social .google-plus {
        color: #DD4B39;
        cursor: pointer;
        margin-left: 10px;
    }
    .card-body-social .facebook {
        color: #49649F;
        cursor: pointer;
        margin-left: 10px;
    }
    .card-body-social .linkedin {
        color: #007BB6;
        cursor: pointer;
        margin-left: 10px;
    }
</style>

<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>
        <div class="media block-update-card">
            <a class="pull-left" href="#">
                <img class="media-object update-card-MDimentions" src="http://3.bp.blogspot.com/-IbEOTNtCMyU/TfCAdHaAxEI/AAAAAAAAA8U/EATib38SSAM/s320/joe-mcelderry.jpg" alt="...">
            </a>
            <div class="media-body update-card-body">
                <h4 class="media-heading">Ivan Grgurina</h4>
                <div class="btn-toolbar card-body-social" role="toolbar">
                    <div class="btn-group fa fa-github-alt git"></div>
                    <div class="btn-group linkedin fa fa-linkedin-square"></div>
                    <div class="btn-group twitter fa fa-twitter"></div>
                    <div class="btn-group facebook fa fa-facebook"></div>
                    <div class="btn-group google-plus fa fa-google-plus"></div>
                </div>
            </div>
        </div>

        <div class="media block-update-card">
            <a class="pull-left" href="#">
                <img class="media-object update-card-MDimentions" src="http://3.bp.blogspot.com/-IbEOTNtCMyU/TfCAdHaAxEI/AAAAAAAAA8U/EATib38SSAM/s320/joe-mcelderry.jpg" alt="...">
            </a>
            <div class="media-body update-card-body">
                <h4 class="media-heading">Ante Tomić</h4>
                <div class="btn-toolbar card-body-social" role="toolbar">
                    <div class="btn-group fa fa-github-alt git"></div>
                    <div class="btn-group linkedin fa fa-linkedin-square"></div>
                    <div class="btn-group twitter fa fa-twitter"></div>
                    <div class="btn-group facebook fa fa-facebook"></div>
                    <div class="btn-group google-plus fa fa-google-plus"></div>
                </div>
            </div>
        </div>

        <div class="media block-update-card">
            <a class="pull-left" href="#">
                <img class="media-object update-card-MDimentions" src="http://3.bp.blogspot.com/-IbEOTNtCMyU/TfCAdHaAxEI/AAAAAAAAA8U/EATib38SSAM/s320/joe-mcelderry.jpg" alt="...">
            </a>
            <div class="media-body update-card-body">
                <h4 class="media-heading">Antun Maldini</h4>
                <div class="btn-toolbar card-body-social" role="toolbar">
                    <div class="btn-group fa fa-github-alt git"></div>
                    <div class="btn-group linkedin fa fa-linkedin-square"></div>
                    <div class="btn-group twitter fa fa-twitter"></div>
                    <div class="btn-group facebook fa fa-facebook"></div>
                    <div class="btn-group google-plus fa fa-google-plus"></div>
                </div>
            </div>
        </div>

</div>
