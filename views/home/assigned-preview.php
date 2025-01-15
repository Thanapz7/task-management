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
    @media print {
        .back-btn{
            display: none;
        }
        .sidenav{
            display: none;
        }
        .assignment-preview{
            height: auto;
        }
    }
</style>

<?= Html::button('<i class="fa-solid fa-arrow-left back-btn"></i>', [
    'class' => 'back-btn',
    'onclick' => 'window.history.back();',
    'encode' => false,
]) ?>
<div class="assignment-preview">

</div>

<script>
    function printPage(){
        window.print();
    }
</script>

