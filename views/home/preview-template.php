<?php

use yii\helpers\Html;
?>
<style>
    .previews{
        height: 80vh;
        width: 95%;
        margin: 20px;
        border: 1px solid #cccccc;
        border-radius: 20px;
        padding: 20px;
        overflow-y: auto;
    }
    .back-btn{
        margin-top: 20px;
        font-size: 20px;
        border: none;
        background: none;
    }
    .btn-edit{
        background-color: #cc5555;
        color: white;
    }
    .btn-d-preview{
        font-size: 20px;
        font-weight: bold;
        padding: 10px;
        width: 120px;
        border-radius: 30px;
        border: 1px solid #ffffff;
        margin-top: -20px;
    }
    .btn-d-preview:hover{
        opacity: 0.7;
    }
</style>

<?= Html::button('<i class="fa-solid fa-arrow-left back-btn"></i>', [
    'class' => 'back-btn',
    'onclick' => 'window.history.back();',
    'encode' => false,
]) ?>
<div class="previews text-center">

</div>
<div class="group-btn-preview text-center">
    <button type="submit" class="btn-d-preview btn-edit">แก้ไข</button>
    <button type="submit" class="btn-d-preview btn-add">เพิ่ม</button>
</div>

