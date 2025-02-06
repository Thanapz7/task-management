<?php
?>
<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JqueryAsset;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Forms $model */
/** @var yii\widgets\ActiveForm $form */

$this->title = 'Create Form' . Html::encode($form_id);
?>

<div class="form-group">
    <?= Html::a('<i class="fa-solid fa-arrow-left back-icon"></i>', ['home/create-form', 'id' => $form_id], ['class' => 'btn-back', 'style'=>'color:#000000']) ?>
</div>
<div class="container-fluid">
    <div class="row g-3" style="margin-left: 30px;">
        <!-- ส่วนแสดงตัวอย่างฟอร์ม -->
        <div class="col-md-8 form-preview" id="form-preview">
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
        <div class="col-md-3 data-type form-setting">
            <?php $form = ActiveForm::begin(['options' => ['class' => 'form-group']]); ?>

            <div class="mb-3 form" style="display: flex; flex-direction: row">
                <label class="label-text-form">ชื่อแฟ้ม <span class="text-danger">*</span>:</label>
                <?= $form->field($model, 'form_name')->textInput(['maxlength' => true, 'class' => 'form-control', 'style'=> 'border-radius:20px;margin-top:-5px; margin-left:10px;max-width:190px; font-size:16px'])->label(false) ?>
            </div>

            <div class="text-center">
                <label class="label-text-form mb-2">จัดการการเข้าถึง</label>
            </div>

            <!-- เลือกแผนกที่สามารถกรอกข้อมูลได้ -->
            <div style="margin-bottom: 6px;">
                <label class="label-content-form">เลือกแผนกที่สามารถกรอกข้อมูลได้<span class="text-danger">*</span></label>
                <button class="btn btn-default btn-sort dropdown-toggle" data-bs-toggle="dropdown">
                    ตัวเลือก
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
            <div style="margin-bottom: 10px;">
                <label class="label-content-form">เลือกแผนกที่สามารถดูข้อมูลได้<span class="text-danger">*</span></label>
                <button class="btn btn-default btn-sort dropdown-toggle" data-bs-toggle="dropdown">
                    ตัวเลือก
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
                <label class="label-content-form">เลือกบุคคลที่สามารถดูข้อมูลได้</label>
                <input type="text" id="searchUser" class="form-control" style="margin-bottom: 5px; border-radius: 20px" placeholder="พิมพ์ชื่อเพื่อค้นหา...">
                <select class="form-control" name="view_users[]" id="view_users" multiple>
                    <?php foreach ($users as $user) : ?>
                        <option value="<?= $user->id ?>" <?= in_array($user->id, $selectedViewUsers) ? 'selected' : '' ?>>
                            <?= Html::encode($user->name) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <div class="mt-2 font-min">
                    <strong class="text-warning">บุคคลที่เลือก:</strong> <span id="selected-users">ยังไม่มีการเลือก</span>
                </div>
            </div>

            <div class="group-btn-setting">
                <?= Html::a('ยกเลิก', ['home/delete-form', 'id' => $model->id], [
                    'class' => 'btn-cancel-setting',
                    'data-confirm' => 'ยกเลิกการสร้างฟอร์มนี้?',
                ])?>
                <div class="text-end">
                    <?= Html::submitButton('บันทึก', ['class' => 'btn btn-primary btn-save']) ?>
                </div>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const selectBox = document.getElementById("view_users");
        const selectedUsersDisplay = document.getElementById("selected-users");

        function updateSelectedUsers() {
            // ดึงค่าทั้งหมดที่ถูกเลือก
            let selectedOptions = Array.from(selectBox.selectedOptions).map(option => option.text);

            // อัปเดตข้อความที่แสดง
            selectedUsersDisplay.textContent = selectedOptions.length > 0 ? selectedOptions.join(", ") : "ยังไม่มีการเลือก";
        }

        // เมื่อมีการเปลี่ยนแปลงใน select, อัปเดตรายชื่อที่เลือก
        selectBox.addEventListener("change", updateSelectedUsers);

        // อัปเดตค่าเริ่มต้น
        updateSelectedUsers();
    });
    // เลือกแผนกที่สามารถกรอกข้อมูลได้   // เลือกแผนกที่สามารถดูข้อมูลได้
    document.addEventListener("DOMContentLoaded", function () {
        function setupSelectAll(selectAllId, checkboxesName) {
            const selectAllCheckbox = document.getElementById(selectAllId);
            const checkboxes = document.querySelectorAll(`input[name="${checkboxesName}"]`);

            selectAllCheckbox.addEventListener("change", function () {
                checkboxes.forEach(checkbox => {
                    checkbox.checked = selectAllCheckbox.checked;
                });
            });

            checkboxes.forEach(checkbox => {
                checkbox.addEventListener("change", function () {
                    selectAllCheckbox.checked = [...checkboxes].every(cb => cb.checked);
                });
            });
        }
        setupSelectAll("select-all-departments-checkbox", "departments[]");
        setupSelectAll("select-all-view-departments-checkbox", "view_departments[]");
    });

    document.addEventListener("DOMContentLoaded", function (){
        const searchInput = document.getElementById("searchUser");
        const selectBox = document.getElementById("view_users");
        const selectedUserDisplay = document.getElementById("selected-users")

        searchInput.addEventListener("input", function (){
            let filter = searchInput.value.toLowerCase();
            let options = selectBox.options;

            for(let i = 0; i < options.length; i++){
                let optionText = options[i].text.toLowerCase();
                options[i].style.display = optionText.includes(filter) ? "" : "none";
            }
        });

        selectBox.addEventListener("change", function() {
            let selectedOptions = [...selectBox.selectOptions].map(optoin => option.text).join(",");
            selectedUserDisplay.textContent = selectedOptions || "ยังไม่ได้เลือก";
        });
    });



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
            return '<input type="tel" class="form-control" name="field_' . $id . '" placeholder="Phone Number">';
        case "number":
            return '<input type="number" class="form-control" name="field_' . $id . '" placeholder="Number">';
        case "date":
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
                    $html .= "<label><input type='radio' name='field_$id' value='$option'>$option</label>";
                }
            } else {
                $html .= "<label>ไม่มีตัวเลือก</label>";
            }
            return $html;

        case "checkbox":
            $html = "";
            if (is_array($options) && !empty($options)) {
                foreach ($options as $option) {
                    $html .= "<label><input type='checkbox' name='field_{$id}[]' value='$option'>$option</label>";
                }
            } else {
                $html .= "<label>ไม่มีตัวเลือก</label>";
            }
            return $html;

        default:
            return '';
    }
}
?>


