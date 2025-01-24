<?php
use app\assets\AppAsset;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
AppAsset::register($this);
?>
<body style="background-color: #cccccc">
    <div class="container-fluid">
        <div class="row w-100">
            <div class="col-md-6 info-log text-center">
                <h2>Job Management <i class="fa-solid fa-briefcase"></i></h2>
                <p>A robust and user-friendly platform designed to streamline task assignments, tracking, and reporting for organizations.
                    This system is tailored to facilitate efficient collaboration between internal teams and external users,
                    ensuring transparency and accountability across all levels of operations.</p>
                <h5 style="color: #cc5555">สนใจจ้างงาน? <?= Html::a('คลิกที่นี่',['assignment'], ['class'=>'btn btn-guest']) ?></h5>
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
</body>

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

