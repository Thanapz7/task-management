<?php

use yii\helpers\Html; ?>

<style>
    .back-btn{
        margin-left: 20px;
        margin-top: 20px;
        font-size: 20px;
        border: none;
        background: none;
        transition: 0.3s;
    }
    .back-btn:hover{
        transform: scale(1.2);
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
    .info h4{
        font-size: 18px;
        font-weight: bold;
    }
    .field-name{
        font-size: 16px;
        font-weight: bold;
    }
    .value{
        font-size: 14px;
        border: 1px solid rgba(204, 204, 204, 0.74);
        border-radius: 10px;
        padding: 10px;
    }
    .pad-lr20{
        padding-left: 100px;
        padding-right: 100px;
    }
    @media print {
        .back-btn{
            display: none;
        }
        .btn-d-preview{
            display: none;
        }
        .detail-preview{
            width: 100%;
            height: auto;
            margin: 0;
            padding: 10px;
        }
    }
</style>


<?= Html::button('<i class="fa-solid fa-arrow-left back-btn"></i>', [
    'class' => 'back-btn',
    'onclick' => 'window.history.back();',
    'encode' => false,
]) ?>
<!--<p>แสดงข้อมูลสำหรับ Record ID: --><?php //= Html::encode(Yii::$app->request->get('id')) ?><!--</p>-->

<div style="margin-left: 20px;">
    <div class="detail-preview pad-lr20">
        <div class="info text-center">
            <?php if (!empty($data)): ?>
                <h4>รายละเอียดข้อมูล - <?= Html::encode($data[0]['form_name'])?></h4>
            <?php endif; ?>
            <?php foreach ($resultsinfo as $info): ?>
                <h4>ผู้กรอก : <?= htmlspecialchars($info['username'])?> | แผนก : <?= htmlspecialchars(mb_strtoupper($info['department_name']))?></h4>
                <h4>วันที่กรอก : <?= htmlspecialchars((new DateTime($info['create_at']))->format('d/m/y H:i'))?></h4>
            <?php endforeach; ?>
        </div>
        <div class="apply">
            <?php foreach ($data as $item): ?>
                <div class="field-name">
                    <?= Html::encode($item['field_name']) ?>
                </div>
                <div class="value" style="margin-bottom: 20px;">
                    <?= Html::encode($item['value']) ?>
                </div>
            <?php endforeach; ?>
        </div>

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



