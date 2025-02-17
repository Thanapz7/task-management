<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use himiklab\yii2\recaptcha\ReCaptcha2;

$this->title = 'Assignment Form';
?>
<?php if(Yii::$app->session->hasFlash('authKey')): ?>
<div id="authkeyModal" class="modal outs-modal">
    <div class="outs-modal-content">
        <h3>บันทึกข้อมูลสำเร็จ</h3>
        <hr style="margin: 0;">
        <p style="margin-top: 10px;">คีย์ของคุณคือ : </p>
        <p id="authkey" class="authkey"><?=Yii::$app->session->getFlash('authKey')?></p>
        <p class="warning-text">***กรุณาคัดลอกคีย์นี้เพื่อดูงานที่สั่ง***</p>
        <button id="copyAuthkey" class="btn-copy-auth">คัดลอก</button>
        <button onclick="redirectToNextPage()" class="btn-copy-next">ถัดไป</button>
    </div>
</div>
<script>
    document.getElementById('copyAuthkey').addEventListener('click', function(){
        const authKey = document.getElementById('authkey').innerText;

        navigator.clipboard.writeText(authKey).then(function(){
            alert('คัดลอกคีย์สำเร็จ')
        }, function (){
            alert('เกิดข้อผิดพลาดในการคัดลอก');
        });
    });
    function redirectToNextPage(){
        window.location.href = "<?= Url::to(['job/assigned'])?>"
    }
</script>
<?php endif; ?>

<div class="assignment-form">
    <div class="info text-center">
        <h4>กรอกข้อมูล : <?= $form['form_name'] ?></h4>
        <h4>แผนก : <?= mb_strtoupper($form['department_name']) ?></h4>
    </div>
    <hr style="margin: 0; margin-bottom: 10px;">
    <?php $form = ActiveForm::begin([
        'action' => ['assignment-form', 'id' => $id],
        'id' => 'assignment-form',
        'method' => 'post',
        'options' => [
            'enctype' => 'multipart/form-data'
        ],
    ]); ?>
    <?php foreach ($fields as $field): ?>
        <div class="form-group">
            <div class="input-g">
                <label for="<?= $field['field_name'] ?>"><?= Html::encode($field['field_name']) ?></label>

                <?php switch ($field['field_type']):
                    case 'short-text': ?>
                        <input type="text" name="DynamicForm[<?= $field['id'] ?>]" class="form-control input-type" placeholder="กรอก<?= Html::encode($field['field_name']) ?>" required>
                        <?php break;

                    case 'long-text': ?>
                        <textarea name="DynamicForm[<?= $field['id'] ?>]" class="form-control input-type" rows="5" placeholder="กรอก<?= Html::encode($field['field_name']) ?>" required></textarea>
                        <?php break;

                    case 'dropdown': ?>
                    <select name="DynamicForm[<?= $field['id'] ?>]" class="form-control input-type" id="dropdown_<?= $field['id'] ?>" onchange="updateDropdownValue(this)" required>
                        <option value="">เลือก<?= Html::encode($field['field_name']) ?></option>
                        <?php
                        $options = json_decode($field['options'], true);
                        if (is_array($options)) {
                            foreach ($options as $option): ?>
                                <option value="<?= Html::encode($option) ?>"><?= Html::encode($option) ?></option>
                            <?php endforeach;
                        } else {
                            echo '<option value="">ไม่มีตัวเลือก</option>';
                        }
                        ?>
                    </select>
                    <p class="ml-3 mt-1 warning-text" style="color: #454d55; font-size: 14px">ตัวเลือกที่เลือก: <span style="color: #000;" id="selectedValue_<?= $field['id'] ?>"></span></p>
                    <script>
                        function updateDropdownValue(selectElement) {
                            var selectedValue = selectElement.value;
                            document.getElementById("selectedValue_<?= $field['id'] ?>").textContent = selectedValue ? selectedValue : "ไม่ได้เลือก";
                        }
                    </script>
                        <?php break;

                    case 'number': ?>
                        <input type="number" id="<?= $field['field_name']?>" name="DynamicForm[<?= $field['id'] ?>]" class="form-control input-type" placeholder="กรอก<?= $field['field_name']?>" required>
                        <?php break;

                    case 'phone': ?>
                        <input type="tel" id="<?= $field['field_name']?>" name="DynamicForm[<?= $field['id'] ?>]" class="form-control input-type" placeholder="กรอก<?= $field['field_name']?>" required>
                        <?php break;

                    case 'radio': ?>
                        <?php
                        $options = json_decode($field['options'], true);
                        if (is_array($options)) {
                            foreach ($options as $option): ?>
                                <label>
                                    <input type="radio" name="DynamicForm[<?= $field['id'] ?>]" value="<?= Html::encode($option) ?>" required> <?= Html::encode($option) ?>
                                </label>
                            <?php endforeach;
                        } else {
                            echo "ไม่มีตัวเลือก";
                        }
                        ?>
                        <?php break;

                    case 'checkbox': ?>
                        <?php
                        $options = json_decode($field['options'], true, 512, JSON_UNESCAPED_UNICODE);
                        if (is_array($options)) {
                            foreach ($options as $option): ?>
                                <label>
                                    <input type="checkbox" name="DynamicForm[<?= $field['id'] ?>][]" value="<?= Html::encode($option) ?>"> <?= Html::encode($option) ?>
                                </label>
                            <?php endforeach;
                        } else {
                            echo "<span style='margin-left: 10px;'>ไม่มีตัวเลือก</span>";
                        }
                        ?>
                        <?php break;

                    case 'date': ?>
                        <input type="date" name="DynamicForm[<?= $field['id'] ?>]" class="form-control input-type" required>
                        <?php break;

                    case 'time': ?>
                        <input type="time" name="DynamicForm[<?= $field['id'] ?>]" class="form-control input-type" required>
                        <?php break;

                    case 'file': ?>
                        <input type="file" name="DynamicForm[<?= $field['id'] ?>]" class="form-control input-type" required>
                        <?php break;

                    case 'text'; ?>
                        <span style="margin: -10px"></span>
                        <?php break;

                endswitch; ?>
            </div>
        </div>
    <?php endforeach; ?>
    <input type="hidden" id="recaptchaResponse" name="recaptchaResponse">
</div>
<div class="group-btn-preview text-center" style="margin-top: 5px;">
    <?= Html::a('ยกเลิก', ['job/assignment'],
        [
            'class' => 'btn-d-preview btn btn-cancel',
            'data-confirm'=>'ยกเลิกการกรอกข้อมูล'
        ])
    ?>
    <?= Html::submitButton('ตกลง', ['class' => 'btn-d-preview btn btn-confirm']) ?>
    <?php ActiveForm::end(); ?>
</div>

<script src="https://www.google.com/recaptcha/api.js?render=6LeQg9kqAAAAAE_yOyxhIqzBtPeYoFr65F4NcnXO"></script>
<script>
    grecaptcha.ready(function() {
        grecaptcha.execute('6LeQg9kqAAAAAE_yOyxhIqzBtPeYoFr65F4NcnXO', { action: 'submit' }).then(function(token) {
            console.log("reCAPTCHA Token: ", token); // ตรวจสอบ token ใน Console
            document.getElementById('recaptchaResponse').value = token;
        });
    });
</script>
<script>
    document.querySelectorAll('input[type="file"]').forEach(function (input){
        input.addEventListener('change', function(e){
            let file = e.target.files[0];
            if (file){
                let render = new FileReader();
                render.onload = function (event){
                    let img = document.createElement('img');
                    img.src = event.target.result;
                    img.width = 200;
                    e.target.parentElement.appendChild(img)
                };
                render.readAsDataURL(file);
            }
        })
    })
</script>
