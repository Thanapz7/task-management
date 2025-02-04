<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Assignment Form';
?>

<div class="assignment-form">
    <div class="info text-center">
        <h4>กรอกข้อมูล : <?= $form['form_name'] ?></h4>
        <h4>แผนก : <?= mb_strtoupper($form['department_name']) ?></h4>
    </div>
    <hr style="margin: 0; margin-bottom: 10px;">
    <?php $form = ActiveForm::begin([
            'options' => [
                    'enctype' => 'multipart/form-data'
            ],
    ]); ?>
    <?php foreach ($fields as $field): ?>
        <div class="form-group">
            <div class="input-g">
                <label for="<?= $field['field_name'] ?>" class="<?= ($field['field_type'] == 'text') ? 'label-text' : '' ?>"><?= Html::encode($field['field_name']) ?></label>

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
                            echo "<span style='margin-left: 10px;'>ไม่มีตัวเลือก</span>";
                        }
                        ?>
                        <?php break;

                    case 'checkbox': ?>
                        <?php
                        $options = json_decode($field['options'], true, 512, JSON_UNESCAPED_UNICODE);
                        if (is_array($options)) {
                            foreach ($options as $option): ?>
                                <label>
                                    <input type="checkbox" name="DynamicForm[<?= $field['id'] ?>][]" value="<?= Html::encode($option) ?>" required> <?= Html::encode($option) ?>
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
                        <div class="form-group">
                            <?php if (!empty($fieldValue['value'])): ?>
                                <div class="uploaded-file">
                                    <a href="<?= Yii::getAlias('@web') . '/' . Html::encode($fieldValue['value']) ?>" target="_blank">
                                        ดาวน์โหลดไฟล์ที่แนบไว้
                                    </a>
                                </div>
                                <p>หากต้องการเปลี่ยนไฟล์ ให้แนบไฟล์ใหม่:</p>
                            <?php endif; ?>
                            <input type="file" name="DynamicForm[<?= $field['id'] ?>]" class="form-control input-type" required>
                        </div>
                        <?php break;

                    case 'text'; ?>
                        <span style="margin: -10px"></span>
                        <?php break;

                endswitch; ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>
<div class="group-btn-preview text-center" style="margin-top: 5px;">
    <?= Html::a('ยกเลิก', ['home/assignment'],
        [
            'class' => 'btn-d-preview btn btn-cancel',
            'data-confirm'=>'ยกเลิกการกรอกข้อมูล'
        ])
    ?>
    <?= Html::submitButton('ตกลง', ['class' => 'btn-d-preview btn btn-confirm']) ?>
    <?php ActiveForm::end(); ?>
</div>

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