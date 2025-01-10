<?php
use app\assets\AppAsset;
use yii\helpers\Html;
AppAsset::register($this);

$this->title='work';

?>
<h4 class="text-header">แฟ้มของฉัน</h4>
<div class="row folders">
    <div class="col-sm-3 folder" style="cursor: pointer">
        <div style="margin: 10px">
            <div class="folder-head">
                <i class="fa-regular fa-folder"></i>
                <h5>HR folder1</h5>
            </div>
            <p class="department">แผนก: HR</p>
        </div>
    </div>
    <div class="col-sm-3 folder" style="cursor: pointer">
        <div style="margin: 10px">
            <div class="folder-head">
                <i class="fa-regular fa-folder"></i>
                <h5>HR folder1</h5>
            </div>
            <p class="department">แผนก: HR</p>
        </div>
    </div>
    <div class="col-sm-3 folder" style="cursor: pointer">
        <div style="margin: 10px">
            <div class="folder-head">
                <i class="fa-regular fa-folder"></i>
                <h5>HR folder1</h5>
            </div>
            <p class="department">แผนก: HR</p>
        </div>
    </div>
    <div class="col-sm-3 folder" style="cursor: pointer">
        <div style="margin: 10px">
            <div class="folder-head">
                <i class="fa-regular fa-folder"></i>
                <h5>HR folder1</h5>
            </div>
            <p class="department">แผนก: HR</p>
        </div>
    </div>
    <div class="col-sm-3 folder" style="cursor: pointer">
        <div style="margin: 10px">
            <div class="folder-head">
                <i class="fa-regular fa-folder"></i>
                <h5>HR folder1</h5>
            </div>
            <p class="department">แผนก: HR</p>
        </div>
    </div>
    <div class="col-sm-3 folder" style="cursor: pointer">
        <div style="margin: 10px">
            <div class="folder-head">
                <i class="fa-regular fa-folder"></i>
                <h5>HR folder1</h5>
            </div>
            <p class="department">แผนก: HR</p>
        </div>
    </div>
</div>
<?= Html::a(
    '<button type="submit" style="background: none; border: none"><i class="fa-solid fa-power-off" style="color: #cc5555"></i></button>',
    ['each-work']
) ?>

