<?php
?>
<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Forms $model */
/** @var yii\widgets\ActiveForm $form */

$this->title = 'Create Form' . Html::encode($form_id);
?>
<style>
    label{
        font-weight: normal;
    }
    .back-icon{
        margin-top: 10px;
        margin-bottom: 0px;
        margin-left: 20px;
        font-size: 20px;
        cursor: pointer;
    }
    .form-setting{
        overflow-y: auto;
        height: 85vh;
        padding: 20px;
        border: none;
        border-radius: 20px;
        margin: 10px;
        background-color: #e0e0e0;
    }
    .form-preview{
        margin-top: 10px;
        padding: 10px;
        height: 85vh;
        overflow-y: auto;
        border: 1px solid #cccccc;
        border-radius: 20px;
    }
    .form-item {
        font-size: 16px;
        margin-bottom: 5px;
        padding: 10px;
        position: relative;
    }
    .form-item .field-header {
        display: flex;
        align-items: center;
        margin-bottom: 5px;
    }
    .form-item .field-actions {
        display: flex;
        gap: 5px;
    }
    .form-item .field-actions i {
        cursor: pointer;
    }
    .form-item .field-actions .edit-icon {
        color: #5bc0de;
    }
    .form-item .field-actions .delete-icon {
        color: #d9534f;
    }
    .form-item .field-actions .access-icon {
        color: #f0ad4e;
    }
    .list-group-item{
        display: flex;
    }
    .input-group-add{
        display: flex;
        flex-direction: row;
    }
    .field-input{
        display: flex;
        flex-direction: column;
    }
    .btn-sort{
        border-radius: 20px;
        box-shadow: 0 2px 0 0 rgba(0,0,0,0.2);
        margin-top: 12px;
    }
    .label-text{
        font-size: 18px;
        font-weight: bold;
    }
    .label-content{
        font-size: 16px;
    }
    .radio{
        display: inline-flex;
        overflow: hidden;
        border-radius: 20px;
        box-shadow: 0 2px 0 0 rgba(0,0,0,0.2);
    }
    .form-horizontal .checkbox, .form-horizontal .checkbox-inline, .form-horizontal .radio, .form-horizontal .radio-inline {
        padding-top: 0;
        margin-top: 0;
        margin-bottom: 0;
    }
    .radio-input{
        display: none;
    }
    .radio-label{
        padding: 7px;
        font-size: 16px;
        font-weight: bold;
        color: #ffffff;
        background-color: #95D2B3;
        cursor: pointer;
        transition: 0.1s;
    }
    .radio-label:not(:last-of-type){
        border-right: 1px solid #a6a6a6;
    }
    .radio-input:checked + .radio-label{
        background-color: #55AD9B;
    }
    .btn-save {
        /*position: absolute; !* ใช้ absolute positioning สำหรับปุ่ม *!*/
        /*bottom: 10px;*/
        /*right: 10px;*/
        /*background-color: #6DB2E5;*/
        /*padding: 10px 20px;*/
        /*font-size: 16px;*/
        /*color: white;*/
        /*border-radius: 5px;*/
        border: 1px solid #ffffff;
        border-radius: 20px;
        background-color: #55AD9B;
        color: #ffffff;
        font-size: 20px;
        font-weight: bold;
        padding: 5px 25px ;
    }
    .btn-save:hover{
        background-color: #55AD9B;
        color: #ffffff;
        opacity: 0.8;
    }
    .add-people{
        width: 100px;
        padding: 5px;
        font-size: 14px;
        border: 1px solid #cccccc;
        border-radius: 20px;
        bottom: 10px;
    }

</style>

<div class="form-group">
    <?= Html::a('<i class="fa-solid fa-arrow-left back-icon"></i>', ['home/create-form', 'id' => $form_id], ['class' => 'btn btn-secondary mb-3']) ?>
</div>
<div class="container-fluid">
    <div class="row g-3">
        <!-- ส่วนแสดงตัวอย่างฟอร์ม -->
        <div class="col-md-8 form-preview" id="form-preview">
            <p>Content here!</p>
            <?php if (!empty($fields)) : ?>
                <?php foreach ($fields as $field) : ?>
                    <div class="field-header d-flex align-items-center justify-content-between mt-3">
                        <span class="field-label fw-bold fs-5"><?= Html::encode($field->field_name) ?></span>
                    </div>
                    <div class="field-input">
                        <?= getFieldHtml($field->field_type, $field->id, $field->options) ?>
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <p>ไม่มีข้อมูลฟอร์มให้แสดง</p>
            <?php endif; ?>
        </div>

        <!-- ส่วนจัดการฟอร์ม -->
        <div class="col-md-4">
            <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal p-3']]); ?>

            <div class="mb-3">
                <label class="label-text">ชื่อแฟ้ม <span class="text-danger">*</span>:</label>
                <?= $form->field($model, 'form_name')->textInput(['maxlength' => true, 'class' => 'form-control'])->label(false) ?>
            </div>

            <div class="text-center">
                <label class="label-text mb-2">จัดการการเข้าถึง</label>
            </div>

            <!-- เลือกแผนกที่สามารถกรอกข้อมูลได้ -->
            <div class="mb-3">
                <label class="label-content">เลือกแผนกที่สามารถกรอกข้อมูลได้</label>
                <button class="btn btn-default btn-sort dropdown-toggle" data-bs-toggle="dropdown">
                    ตัวเลือก <span class="caret"></span>
                </button>
                <ul class="dropdown-menu">
                    <li>
                        <label class="dropdown-item">
                            <input type="checkbox" id="select-all-departments-checkbox">
                            ทั้งหมด
                        </label>
                    </li>
                    <?php foreach ($departments as $department) : ?>
                        <li>
                            <label class="dropdown-item">
                                <input type="checkbox" name="departments[]" value="<?= $department->id ?>"
                                    <?= in_array($department->id, $selectedDepartments) ? 'checked' : '' ?>>
                                <?= Html::encode($department->department_name) ?>
                            </label>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <!-- เลือกแผนกที่สามารถดูข้อมูลได้ -->
            <div class="mb-3">
                <label class="label-content">เลือกแผนกที่สามารถดูข้อมูลได้</label>
                <button class="btn btn-default btn-sort dropdown-toggle" data-bs-toggle="dropdown">
                    ตัวเลือก <span class="caret"></span>
                </button>
                <ul class="dropdown-menu">
                    <li>
                        <label class="dropdown-item">
                            <input type="checkbox" id="select-all-view-departments-checkbox">
                            ทั้งหมด
                        </label>
                    </li>
                    <?php foreach ($departments as $department) : ?>
                        <li>
                            <label class="dropdown-item">
                                <input type="checkbox" name="view_departments[]" value="<?= $department->id ?>"
                                    <?= in_array($department->id, $selectedViewDepartments) ? 'checked' : '' ?>>
                                <?= Html::encode($department->department_name) ?>
                            </label>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <!-- เลือกบุคคลที่สามารถดูข้อมูลได้ -->
            <div class="mb-3">
                <label class="label-content">เลือกบุคคลที่สามารถดูข้อมูลได้</label>
                <select class="form-control" name="view_users[]" id="view_users" multiple>
                    <?php foreach ($users as $user) : ?>
                        <option value="<?= $user->id ?>" <?= in_array($user->id, $selectedViewUsers) ? 'selected' : '' ?>>
                            <?= Html::encode($user->name) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="text-end">
                <?= Html::submitButton('บันทึก', ['class' => 'btn btn-primary btn-save']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>

<script>
    // Toggle Select All functionality
    $(document).ready(function () {
        function handleSelectAll(selectAllId, checkboxesName) {
            $(selectAllId).change(function () {
                var isChecked = $(this).prop('checked');
                $('input[name="' + checkboxesName + '[]"]').prop('checked', isChecked);
            });

            $('input[name="' + checkboxesName + '[]"]').change(function () {
                var allChecked = $('input[name="' + checkboxesName + '[]"]').length ===
                    $('input[name="' + checkboxesName + '[]"]:checked').length;
                $(selectAllId).prop('checked', allChecked);
            });
        }

        handleSelectAll('#select-all-departments-checkbox', 'departments');
        handleSelectAll('#select-all-view-departments-checkbox', 'view_departments');
    });
</script>

<script>
    $('#view_users').autocomplete({
        source: function(request, response) {
            $.ajax({
                url: '" . \yii\helpers\Url::to(['user/search']) . "',
                data: { term: request.term },
            success: function(data) {
                response(data);
            }
        });
        },
        select: function(event, ui) {
            let selectedUsers = $('#view_users').val().split(',').map(function(item) {
                return item.trim();
            });

            if (selectedUsers.indexOf(ui.item.label) === -1) {
                selectedUsers.push(ui.item.label);
                $('#view_users').val(selectedUsers.join(', '));
                $('#view_users-hidden').val(selectedUsers.join(', '));  // อัปเดตค่าใน hidden input
            }
        }
    });
</script>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


<?php
function getFieldHtml($type, $id, $options) {
    switch ($type) {
        case "short-text":
            return '<input type="text" class="form-control" name="field_' . $id . '" placeholder="Short Text">';
        case "long-text":
            return '<textarea class="form-control" name="field_' . $id . '" placeholder="Long Text"></textarea>';
        case "phone":
            return '<input type="number" class="form-control" name="field_' . $id . '" placeholder="Phone Number">';
        case "date":
            return '<input type="date" class="form-control" name="field_' . $id . '">';
        case "time":
            return '<input type="time" class="form-control" name="field_' . $id . '">';
        case "file":
            return '<input type="file" class="form-control" name="field_' . $id . '">';

        case "dropdown":
            $html = '<select class="form-control" name="field_' . $id . '">';
            if (is_array($options) && !empty($options)) {
                foreach ($options as $option) {
                    $html .= "<option value='" . Html::encode($option) . "'>" . Html::encode($option) . "</option>";
                }
            } else {
                $html .= "<option value=''>ไม่มีตัวเลือก</option>";
            }
            $html .= '</select>';
            return $html;

        case "radio":
            $html = "";
            if (is_array($options) && !empty($options)) {
                foreach ($options as $option) {
                    $html .= "<label><input type='radio' name='field_$id' value='$option'>$option</label><br>";
                }
            } else {
                $html .= "<label>ไม่มีตัวเลือก</label><br>";
            }
            return $html;

        case "checkbox":
            $html = "";
            if (is_array($options) && !empty($options)) {
                foreach ($options as $option) {
                    $html .= "<label><input type='checkbox' name='field_{$id}[]' value='$option'>$option</label><br>";
                }
            } else {
                $html .= "<label>ไม่มีตัวเลือก</label><br>";
            }
            return $html;

        default:
            return '';
    }
}
?>


