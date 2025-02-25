<?php
use app\assets\AppAsset;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
AppAsset::register($this);
?>
<body style="background-color: #cccccc">
    <div class="container-fluid logins">
        <div class="row w-100">
            <div class="col-md-6 info-log text-center">
                <h2 style="font-size: 20px">ระบบจัดการงาน <i class="fa-solid fa-briefcase"></i></h2>
                <?= Html::img('@web/images/planning.jpg', ['alt' => 'logo', 'class' => 'img-responsive', 'style'=>'width:500px; border-radius:15px']) ?>
                <p>แพลตฟอร์มที่มีความแข็งแกร่งและใช้งานง่าย ออกแบบมาเพื่อทำให้การมอบหมายงาน การติดตาม
                    และการรายงานเป็นไปอย่างมีประสิทธิภาพสำหรับองค์กร ระบบนี้ถูกปรับให้เหมาะสมกับการทำงานร่วมกันอย่างมีประสิทธิภาพระหว่างทีมภายในและผู้ใช้ภายนอก
                    เพื่อให้มั่นใจในความโปร่งใสและความรับผิดชอบในทุกระดับของการดำเนินงาน</p>
                <h5 style="color: #cc5555; font-size: 16px;">สนใจจ้างงาน? <?= Html::a('คลิกที่นี่',['job/assignment'], ['class'=>'btn btn-guest']) ?></h5>
                <?= Html::a('<i class="fa-solid fa-book"></i> คู่มือการใช้งานสำหรับบุคลภายนอก',['/uploads/Manual_work-management_os.pdf'], ['class'=>'btn manual','style'=>'font-size:10px;', 'target'=>'_blank', 'rel' => 'noopener noreferrer']) ?>
            </div>
            <div class="col-md-1 divider"></div>
            <div class="col-md-5 login">
                <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
                <form class="login-form">
                    <h2 class="logo">
<!--                        <i class="fa-solid fa-briefcase"></i>-->
                        <?= Html::img('@web/images/work2.png', ['alt' => 'logo', 'style'=>'width:130px']) ?>
                    </h2>
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
                    <div class="form-group w-100 forgot-pass text-right">
                        <?= Html::a('ลืมรหัสผ่าน', ['./users'],['class'=>'forgot-pass']) ?>
                    </div>
                    <?= Html::submitButton('ล็อกอิน', ['class' => 'btn btn-custom', 'name'=>'login-button']) ?>
                </form>
                <?php ActiveForm::end(); ?>
                <?= Html::a('<i class="fa-solid fa-book"></i> คู่มือการใช้งาน',['/uploads/Manual_work-management.pdf'], ['class'=>'btn manual manual-login','style'=>'font-size:10px;', 'target'=>'_blank', 'rel' => 'noopener noreferrer']) ?>
                <div class="mobile-os">
                    <?= Html::a('สนใจจ้างงาน',['job/assignment'], ['class'=>'btn btn-guest']) ?>
                    <?= Html::a('<i class="fa-solid fa-book"></i> คู่มือภายนอก',['/uploads/Manual_work-management_os.pdf'], ['class'=>'btn manual','style'=>'font-size:10px;', 'target'=>'_blank', 'rel' => 'noopener noreferrer']) ?>
                </div>
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

