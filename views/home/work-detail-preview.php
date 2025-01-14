<?php

use yii\helpers\Html; ?>

<style>
    .back-btn{
        margin-left: 20px;
        margin-top: 20px;
        font-size: 20px;
        border: none;
        background: none;
    }
    .detail-preview{
        overflow-y: auto;
        width: 90vw;
        height: 80vh;
        border: 1px solid #cccccc;
        border-radius: 20px;
        margin: 20px;
        padding: 20px;
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
    .btn-preview-detail{
        color: #ffffff;
        background-color: #F0B754;
    }

    @media print {
        .back-btn{
            display: none;
        }
        .btn-d-preview{
            display: none;
        }
        .detail-preview{
            width: auto;
            height: auto;
            margin: 0;
        }
    }
</style>


<?= Html::button('<i class="fa-solid fa-arrow-left back-btn"></i>', [
    'class' => 'back-btn',
    'onclick' => 'window.history.back();',
    'encode' => false,
]) ?>
<div style="margin-left: 20px;">
    <div class="detail-preview text-center">

    </div>
</div>
<div class="group-btn-preview text-center">
    <button type="submit" class="btn-d-preview btn-preview-detail" onclick="printPage()">ดาวน์โหลด</button>
</div>

<script>
    function printPage(){
        window.print();
    }
</script>



