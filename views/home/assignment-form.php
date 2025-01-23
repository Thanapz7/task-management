<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Assignment Form';
?>

<style>
    .assignment-form{
        margin-top: 20px;
        padding: 20px;
        height: 89vh;
        width: 100%;
        overflow-y: auto;
        border: 1px solid #cccccc;
        border-radius: 20px;
    }
    .btn-d-preview{
        font-size: 20px;
        font-weight: bold;
        padding: 10px;
        width: 120px;
        border-radius: 30px;
        border: 1px solid #ffffff;
        /*margin-top: -20px;*/
    }
    .btn-d-preview:hover{
        opacity: 0.7;
    }
    .info h4{
        font-size: 18px;
        font-weight: bold;
    }
    .input-g{
        display: flex;
        flex-direction: column;
        margin-bottom: 20px;
        margin-left: 30px;
        margin-right: 30px;
    }
    .input-type{
        margin:  0 10px 0 10px;
    }
    .input-g label{
        font-size: 16px;
        font-weight: 600;
    }
    .choice{
        display: flex;
        flex-direction: column;
    }
    .choice label{
        font-weight: normal;
    }
    img{
        margin: 10px;
    }
    .btn-cancel{
        background-color: #cc5555;
        color: #ffffff;
    }
    .btn-confirm{
        background-color: #55AD9B;
        color: #ffffff;
    }
</style>

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
                <label for="<?= $field['field_name'] ?>"><?= Html::encode($field['field_name']) ?></label>

                <?php switch ($field['field_type']):
                    case 'short-text': ?>
                        <input type="text" name="DynamicForm[<?= $field['id'] ?>]" class="form-control input-type" placeholder="กรอก<?= Html::encode($field['field_name']) ?>">
                        <?php break;

                    case 'long-text': ?>
                        <textarea name="DynamicForm[<?= $field['id'] ?>]" class="form-control input-type" rows="5" placeholder="กรอก<?= Html::encode($field['field_name']) ?>"></textarea>
                        <?php break;

                    case 'dropdown': ?>
                        <select name="DynamicForm[<?= $field['id'] ?>]" class="form-control input-type">
                            <option value="">เลือก<?= Html::encode($field['field_name']) ?></option>
                            <?php
                                $options = json_decode($field['options'], true);
                                if (is_array($options)) {
                                    foreach ($options as $option): ?>
                                        <option value="<?= Html::encode($option)?>"><?= Html::encode($option) ?></option>
                                    <?php endforeach;
                                }else{
                                    echo '<option value="">ไม่มีตัวเลือก</option>';
                                }
                            ?>
                        </select>
                        <?php break;

                    case 'number': ?>
                        <input type="number" id="<?= $field['field_name']?>" name="DynamicForm[<?= $field['id'] ?>]" class="form-control input-type" placeholder="กรอก<?= $field['field_name']?>">
                        <?php break;

                    case 'phone': ?>
                        <input type="number" id="<?= $field['field_name']?>" name="DynamicForm[<?= $field['id'] ?>]" class="form-control input-type" placeholder="กรอก<?= $field['field_name']?>">
                        <?php break;

                    case 'radio': ?>
                        <?php
                        $options = json_decode($field['options'], true);
                        if (is_array($options)) {
                            foreach ($options as $option): ?>
                                <label>
                                    <input type="radio" name="DynamicForm[<?= $field['id'] ?>]" value="<?= Html::encode($option) ?>"> <?= Html::encode($option) ?>
                                </label>
                            <?php endforeach;
                        } else {
                            echo "ไม่มีตัวเลือก";
                        }
                        ?>
                        <?php break;

                    case 'checkbox': ?>
                        <?php
                        $options = json_decode($field['options'], true);
                        if (is_array($options)) {
                            foreach ($options as $option): ?>
                                <label>
                                    <input type="checkbox" name="DynamicForm[<?= $field['id'] ?>][]" value="<?= Html::encode($option) ?>"> <?= Html::encode($option) ?>
                                </label>
                            <?php endforeach;
                        } else {
                            echo "ไม่มีตัวเลือก";
                        }
                        ?>
                        <?php break;

                    case 'date': ?>
                        <input type="date" name="DynamicForm[<?= $field['id'] ?>]" class="form-control input-type">
                        <?php break;

                    case 'time': ?>
                        <input type="time" name="DynamicForm[<?= $field['id'] ?>]" class="form-control input-type">
                        <?php break;

                    case 'file': ?>
                        <input type="file" name="DynamicForm[<?= $field['id'] ?>]" class="form-control input-type">
                        <?php break;

                endswitch; ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>
    <div class="group-btn-preview text-center" style="margin-top: 5px;">
        <button type="submit" class="btn-d-preview btn-cancel" onclick="location.href='<?= Yii::$app->urlManager->createUrl(['home/assignment']) ?>'">ยกเลิก</button>
        <?= Html::submitButton('ตกลง', ['class' => 'btn-d-preview btn btn-confirm']) ?>
    </div>
<?php ActiveForm::end(); ?>

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