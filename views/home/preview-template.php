<?php

use yii\helpers\Html;
?>

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

