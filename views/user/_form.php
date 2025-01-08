<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\User $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>

<!--    --><?php //= $form->field($model, 'password_hash')->passwordInput(['maxlength' => true]) ?>

    <!-- เพิ่ม Dropdown สำหรับ Role -->
    <?= $form->field($model, 'role')->dropDownList([
        'admin' => 'Admin',
        'user' => 'User',
    ], ['prompt' => 'Select Role']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create User' : 'Save Changes', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
