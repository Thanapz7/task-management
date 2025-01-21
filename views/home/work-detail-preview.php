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
<p>แสดงข้อมูลสำหรับ Record ID: <?= Html::encode(Yii::$app->request->get('id')) ?></p>

<div style="margin-left: 20px;">
    <div class="detail-preview text-center">
        <?php if (!empty($data)): ?>
            <h2>รายละเอียดข้อมูล - <?= Html::encode($data[0]['form_name']) ?></h2>
            <p><strong>ผู้ใช้งาน:</strong> <?= Html::encode($data[0]['user_name']) ?></p>
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>Field Name</th>
                    <th>Value</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($data as $item): ?>
                    <tr>
                        <td><?= Html::encode($item['field_name']) ?></td>
                        <td><?= Html::encode($item['value']) ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>ไม่พบข้อมูล</p>
        <?php endif; ?>
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



