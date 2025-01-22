<?php

use yii\helpers\Html;

$this->title = 'Assigned Preview';
?>

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
    .assignment-preview{
        margin-left: 20px;
        margin-top: 20px;
        height: 85vh;
        width: 95%;
        overflow-y: auto;
        border: 1px solid #cccccc;
        border-radius: 20px;
        padding: 15px;
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
    .for-print{
        display: none;
    }
    .applyer{
        margin-right: 5px;
        font-size: 16px;
    }
    .applyer span{
        background-color: rgba(85, 173, 155, 0.46);
        border-radius: 15px;
        padding: 5px;
    }
    @media print {
        .back-btn{
            display: none;
        }
        .sidenav{
            display: none;
        }
        .assignment-preview{
            height: auto;
            width: 100%;
            margin: 0px;
        }
        .for-print{
            display: block;
        }
    }
</style>

<?= Html::button('<i class="fa-solid fa-arrow-left back-btn"></i>', [
    'class' => 'back-btn',
    'onclick' => 'window.history.back();',
    'encode' => false,
]) ?>
<div class="assignment-preview">
    <div class="info text-center">
        <?php foreach ($results_info as $info):?>
            <h4>ชื่อแฟ้ม <?= htmlspecialchars($info['form_name']) ?></h4>
            <h4>ลงเมื่อวันที่ <?= htmlspecialchars((new DateTime($info['created_at']))->format('d/m/Y H:i')) ?></h4>
            <h4>แผนกที่ติดต่อ <?= htmlspecialchars(mb_strtoupper($info['department_name'])) ?></h4>
        <?php endforeach; ?>
    </div>
    <hr>
    <div class="apply">
        <?php foreach ($results as $result): ?>
            <div class="field-name">
                <?= $result['field_name'] ?>
            </div>
            <div class="value" style="margin-bottom: 20px">
                <?= $result['value'] ?>
            </div>
        <?php endforeach; ?>
    </div>
    <hr style="margin-top: 20px;">
    <div class="contact text-right">
        <h5 class="applyer">ผู้กรอก : <span><?= $user->name?> <?= $user->lastname?></span></h5>
        <br class="for-print">
        <div class="for-print">
            <p>......................................</p>
            <p style="margin-right: 25px;">( <?= htmlspecialchars((new DateTime($info['created_at']))->format('d/m/Y')) ?> ) </p>
        </div>

    </div>
</div>

<script>
    function printPage(){
        window.print();
    }
</script>

