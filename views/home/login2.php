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
    .btn-guest{
        font-size: 16px;
        font-weight: bold;
        margin-left: 5px;
        background-color: #95D2B3;
        color: #ffffff;
        border: 2px solid #ffffff;
        box-shadow: 0 3px 0 0 rgba(0,0,0,0.2);
        border-radius: 20px;
        padding: 8px 23px;
        transition: 0.3s;
    }
    .btn-guest:hover{
        transform: scale(1.15);
        color: #343a40;
        background-color: #73a68b;
    }
</style>
<div class="container-fluid">
    <div class="row w-100">
        <div class="col-md-6 info text-center">
            <h2>Job Management <i class="fa-solid fa-briefcase"></i></h2>
            <p>A robust and user-friendly platform designed to streamline task assignments, tracking, and reporting for organizations.
                This system is tailored to facilitate efficient collaboration between internal teams and external users,
                ensuring transparency and accountability across all levels of operations.</p>
            <h4 style="color: #cc5555">สนใจจ้างงาน? <?= Html::a('คลิกที่นี่',['assignment'], ['class'=>'btn btn-guest']) ?></h4>
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
                    <?= $form->field($model, 'password')->passwordInput(['placeholder' => 'รหัสผ่าน']) ?>
                    <i class="fa-solid fa-eye-slash login-eye"></i>
                </div>
                <div class="form-group w-100 forgot-pass">
                    <?= Html::a('ลืมรหัสผ่าน', ['./users'],['class'=>'forgot-pass']) ?>
                </div>
                <?= Html::submitButton('ล็อกอิน', ['class' => 'btn btn-custom', 'name'=>'login-button']) ?>
            </form>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
<script>
    document.querySelector('.login-eye').addEventListener('click', function (){
        const passwordInput = document.querySelector('input[name="LoginForm[password]"]');
        const icon = this;

        if(passwordInput.type === "password"){
            passwordInput.type = "text";
            icon.classList.remove("fa-eye-slash");
            icon.classList.add("fa-eye");
        }else {
            passwordInput.type = "password";
            icon.classList.remove("fa-eye");
            icon.classList.add("fa-eye-slash");
        }
    });
</script>

