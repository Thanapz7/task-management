<?php
use app\assets\AppAsset;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
AppAsset::register($this);
?>
<style>
    body {
        background-color: #cccccc;
        color: #000000;
        font-family: "Noto Sans Thai", serif;
    }
    .forgot-pass{
        text-decoration: underline;
        font-size: 16px;
        color: #656565cc;
        cursor: pointer;
    }
    .forgot-pass:hover{
        color: #cc5555;
    }
</style>
<div class="container-fluid">
    <div class="row w-100">
        <div class="col-md-6 info">
            <h2>Welcome to Our Service</h2>
            <p>Here you can find some information about our service. We provide the best solutions for your needs. Join us and enjoy the benefits.</p>
        </div>
        <div class="col-md-1 divider"></div>
        <div class="col-md-5 login">
            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
            <form class="login-form">
                <h2 class="logo"><i class="fa-solid fa-briefcase"></i></h2>
                <div class="form-group w-100">
                    <?= $form->field($model, 'username', [
                        'inputOptions' => ['placeholder' => 'ชื่อผู้ใช้ หรือ อีเมล', 'class' => 'form-control']
                    ])
                        ->textInput(['autofocus' => true])
                    ?>
                </div>
                <br>
                <div class="form-group w-100 password-input">
                    <?= $form->field($model, 'password')->passwordInput() ?>
                    <i class="fa-solid fa-eye-slash login-eye"></i>
                </div>
                <div class="form-group w-100 forgot-pass">
                    <?= Html::a('ลืมรหัสผ่าน', ['./user'],['class'=>'forgot-pass']) ?>
                </div>
                <?= Html::submitButton('Login', ['class' => 'btn btn-custom', 'name'=>'login-button']) ?>
            </form>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>

