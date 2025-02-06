<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Fields */
/* @var $form yii\widgets\ActiveForm */

$this->title = 'สร้างฟอร์ม';
?>
<style>
    body{
        font-family: "Noto Sans Thai", serif;
    }
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
    .data-type{
        padding: 20px;
        border: none;
        border-radius: 20px;
        margin: 10px;
        background-color: #e0e0e0;
    }
    .data-item{
        margin-bottom: 10px;
        border-bottom: 1px solid #cccccc;
        cursor: grab;
        transition: 0.25s;
    }
    .data-item:hover{
        background-color: #cccccc;
        border-radius: 10px;
        padding: 8px;
    }
    .data-item i{
        margin-right: 8px;
    }
    .form-preview{
        margin-top: 10px;
        padding: 10px;
        height: 85vh;
        overflow-y: auto;
        border: 2px dashed #cccccc;
        border-radius: 20px;
    }
    .form-preview .form-control{
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
    .btn-next {
        position: absolute; /* ใช้ absolute positioning สำหรับปุ่ม */
        bottom: -22px;
        right: 97px;
        background-color: #6DB2E5;
        padding: 10px 20px;
        font-size: 16px;
        color: white;
        border-radius: 5px;
        border: 1px solid #ffffff;
        border-radius: 20px;
        background-color: #6DB2E5;
        color: #ffffff;
        font-size: 20px;
        font-weight: bold;
        padding: 5px 25px ;
    }
    .btn-next:hover{
        background-color: #6DB2E5;
        color: #000000;
        opacity: 0.8;
    }
    .modal-content{
        border-radius: 20px;
    }
    .modal-content .btn{
        border-radius: 20px;
        font-weight: bold;
    }

    @media screen and (max-width: 767px) {
        .btn-next {
            right: 10px;
        }
    }
</style>
<div>
    <form method="post" action="<?= \yii\helpers\Url::to(['home/delete-form', 'id'=>$form->id])?>">
        <?= \yii\helpers\Html::hiddenInput(Yii::$app->request->csrfParam, Yii::$app->request->getCsrfToken()) ?>
        <button type="submit" style="background: none; border: none">
            <i class="fa-solid fa-arrow-left back-icon"></i>
        </button>
    </form>
</div>


<div class="row" style="margin-left: 30px">
    <div id="drag-items" class="col-md-3 data-type">
        <h4 class="text-center" style="font-size:20px; font-weight: bold">ลากฟิลด์จากรายการ</h4>
        <div style="margin-left:20px; font-size: 18px;">
            <div class="data-item" draggable="true" data-type="text">
                <i class="fa-solid fa-font"></i> ข้อความตัวอักษร
            </div>
            <div class="data-item" draggable="true" data-type="short-text">
                <i class="fa-solid fa-align-left"></i> ข้อความตอบสั้น
            </div>
            <div class="data-item" draggable="true" data-type="long-text">
                <i class="fa-solid fa-align-justify"></i> ข้อความตอบยาว
            </div>
            <div class="data-item" draggable="true" data-type="dropdown">
                <i class="fa-regular fa-square-caret-down"></i> ตัวเลือก (Dropdown)
            </div>
            <div class="data-item" draggable="true" data-type="radio">
                <i class="fa-solid fa-circle-dot"></i> ตัวเลือกเดียว (Radio)
            </div>
            <div class="data-item" draggable="true" data-type="checkbox">
                <i class="fa-regular fa-square-check"></i> หลายตัวเลือก (Checkbox)
            </div>
            <div class="data-item" draggable="true" data-type="number">
                <i class="fa-solid fa-1"></i> ตัวเลข
            </div>
            <div class="data-item" draggable="true" data-type="phone">
                <i class="fa-solid fa-phone"></i> เบอร์มือถือ
            </div>
            <div class="data-item" draggable="true" data-type="date">
                <i class="fa-regular fa-calendar"></i> วันที่
            </div>
            <div class="data-item" draggable="true" data-type="time">
                <i class="fa-regular fa-clock"></i> เวลา
            </div>
            <div class="data-item" draggable="true" data-type="file">
                <i class="fa-solid fa-paperclip"></i> ไฟล์
            </div>
        </div>
    </div>

    <div class="col-md-8 form-preview" id="form-preview" style="margin-bottom: 20px;">
        <!-- ฟิลด์ที่สร้างแบบ Drag-and-Drop จะถูกเพิ่มที่นี่ -->
        <p style="color: #999;">ลากฟิลด์ไปยังพื้นที่นี้...</p>
        <?php if (!empty($existingFields)): ?>
            <?php foreach ($existingFields as $field): ?>
                <?php
                $options = isset($field['options']) ? json_decode($field['options'], true) : [];
                if (!is_array($options)) {
                    $options = []; // ป้องกัน error กรณี decode ไม่สำเร็จ
                }
                ?>
                <div class="form-item" draggable="true" data-id="<?= Html::encode($field['id']) ?>" data-type="<?= Html::encode($field['field_type']) ?>" data-options='<?= json_encode($options, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) ?>'>
                    <div class="field-header" style="display: flex; align-items: center; justify-content: space-between;">
                        <span class="field-label" style="font-weight: bold;"><?= Html::encode($field['field_name']) ?></span>
                        <div class="field-actions" style="margin-left: 10px;">
                            <i class="fa-solid fa-pen edit-icon" style="cursor: pointer; margin-right: 10px;" onclick="openEditModalForExistingField(this.closest('.form-item'))"></i>
                            <i class="fa-solid fa-trash delete-icon" style="cursor: pointer;" onclick="openDeleteModal(this.closest('.form-item'))"></i>
                        </div>
                    </div>
                    <div class="field-input">
                        <?php if ($field['field_type'] == 'short-text'): ?>
                            <input type="text" class="form-control" placeholder="Short Text">
                        <?php elseif ($field['field_type'] == 'long-text'): ?>
                            <textarea class="form-control" placeholder="Long Text"></textarea>
                        <?php elseif ($field['field_type'] == 'dropdown'): ?>
                            <select class="form-control">
                                <?php foreach ($options as $option): ?>
                                    <option><?= Html::encode($option) ?></option>
                                <?php endforeach; ?>
                            </select>
                        <?php elseif ($field['field_type'] == 'number'): ?>
                            <input type="number" class="form-control" placeholder="Number">
                        <?php elseif ($field['field_type'] == 'phone'): ?>
                            <input type="tel" class="form-control" placeholder="Phone Number">
                        <?php elseif ($field['field_type'] == 'radio'): ?>
                            <?php foreach ($options as $option): ?>
                                <label>
                                    <input type="radio" name="radio_<?= Html::encode($field['id']) ?>" value="<?= Html::encode($option) ?>">
                                    <?= Html::encode($option) ?>
                                </label>
                            <?php endforeach; ?>

                        <?php elseif ($field['field_type'] == 'checkbox'): ?>
                            <?php foreach ($options as $option): ?>
                                <label>
                                    <input type="checkbox" name="checkbox_<?= Html::encode($field['id']) ?>[]" value="<?= Html::encode($option) ?>">
                                    <?= Html::encode($option) ?>
                                </label>
                            <?php endforeach; ?>
                        <?php elseif ($field['field_type'] == 'date'): ?>
                            <input type="date" class="form-control" >
                        <?php elseif ($field['field_type'] == 'time'): ?>
                            <input type="time" class="form-control">
                        <?php elseif ($field['field_type'] == 'file'): ?>
                            <input type="file" class="form-control">
                        <?php elseif ($field['field_type'] == 'text'): ?>
                            <?php echo ''; ?>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>

    </div>

    <?php $form = ActiveForm::begin([
        'id' => 'save-form',
        'action' => ['home/field','id' => $formId],
        'method' => 'post',
        'options' =>['onsubmit' => 'return prepareFormData()'],
    ]); ?>

    <!-- ฟิลด์ซ่อนสำหรับจัดเก็บข้อมูลฟอร์ม -->
    <input type="hidden" name="fields" id="fields-input" value="<?= $formId?>">

    <div class="form-group col-md-12 text-right">
        <?= Html::submitButton('ถัดไป', ['class' => 'btn btn-default btn-next', 'onclick' => 'prepareFormData()']) ?>
    </div>
    <?php ActiveForm::end(); ?>

</div>

<div class="modal fade" id="editLabelModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">แก้ไขหัวข้อ</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="editLabelInput">หัวข้อ:</label>
                    <input type="text" class="form-control" id="editLabelInput">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">ยกเลิก</button>
                <button type="button" class="btn btn-success" onclick="saveLabel()">บันทึก</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal สำหรับแก้ไขตัวเลือก -->
<div class="modal fade" id="editOptionsModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">แก้ไขหัวข้อและตัวเลือก</h4>
            </div>
            <div class="modal-body">
                <!--                <div class="form-group">-->
                <!--                    <label for="editLabelInput">หัวข้อ:</label>-->
                <!--                    <input type="text" class="form-control" id="editLabelInput">-->
                <!--                </div>-->
                <div class="form-group">
                    <label>ตัวเลือก:</label>
                    <ul class="list-group" id="optionsList"></ul>
                    <div class="input-group input-group-add mt-2">
                        <input type="text" class="form-control" id="newOptionInput" placeholder="เพิ่มตัวเลือกใหม่">
                        <div class="input-group-append">
                            <button class="btn btn-success" onclick="addOption()">เพิ่ม</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">ยกเลิก</button>
                <button type="button" class="btn btn-success" onclick="saveOptions();">บันทึก</button>
            </div>
        </div>
    </div>
</div>
<!-- Delete Confirmation Modal -->
<div id="deleteFieldModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">ยืนยันการลบ</h4>
            </div>
            <div class="modal-body">
                <p>คุณแน่ใจหรือไม่ว่าต้องการลบฟิลด์นี้?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">ยกเลิก</button>
                <button type="button" id="confirmDeleteFieldBtn" class="btn btn-danger">ลบ</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="accessFieldModal" role="dialog">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 style="font-size: 20px; text-align: center">การกรอกฟิลด์</h4>
            </div>
            <div class="modal-body">
                <div style="display: flex; flex-direction: row; ">
                    <div style="margin-top: 10px;">
                        <h4>บุคคลที่สามารถกรอกฟิลด์นี้ได้</h4>
                    </div>
                    <div class="" style="margin-left: 20px;">
                        <button class="btn btn-default btn-sort dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            ตัวเลือก
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a href="">พนักงานทั้งหมด</a></li>
                            <li><a href="">บุคคลภายนอก</a></li>
                        </ul>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" data-dismiss="modal" >บันทึก</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        const formPreview = document.getElementById("form-preview");
        const fieldsInput = document.getElementById("fields-input");

        let allowDrop = true;
        let currentEditField = null;
        let currentEditType = null;
        let fieldToDelete = null;
        let options = [];

        document.querySelectorAll(".data-item").forEach(item => {
            item.addEventListener("dragstart", e => {
                e.dataTransfer.setData("type", e.target.getAttribute("data-type"));
            });
        });

        formPreview.addEventListener("dragover", (e) => {
            e.preventDefault();
            if (allowDrop) {
                e.dataTransfer.dropEffect = "move";  // กำหนดการแสดงตัวชี้ให้เหมาะสม
            } else {
                e.dataTransfer.dropEffect = "none";  // ป้องกันไม่ให้ลากไปวางในบางกรณี
            }
        });

        formPreview.addEventListener("drop", e => {
            e.preventDefault();
            const type = e.dataTransfer.getData("type");
            const field = createField(type);
            formPreview.appendChild(field);
        });

        function createField(type) {
            const field = document.createElement("div");
            field.classList.add("form-item");
            field.setAttribute("draggable", "true");
            field.setAttribute("data-type", type);
            field.innerHTML = `
            <div class="field-header" style="display: flex; align-items: center; justify-content: space-between;">
                <span class="field-label" style="font-weight: bold;">ชื่อหัวข้อ</span>
                <div class="field-actions" style="margin-left: 10px;">
                    <i class="fa-solid fa-pen edit-icon" style="cursor: pointer; margin-right: 10px;"></i>
                    <i class="fa-solid fa-trash delete-icon" style="cursor: pointer;"></i>
                </div>
            </div>
            <div class="field-input">${getFieldHtml(type)}</div>
        `;
            field.querySelector(".edit-icon").addEventListener("click", () => openEditModal(field, type));
            field.querySelector(".delete-icon").addEventListener("click", () => openDeleteModal(field));
            return field;
        }

        function getFieldHtml(type) {
            switch (type) {
                // case "text": return '<input type="text" class="form-control" placeholder="Text">';
                case "short-text": return '<input type="text" class="form-control" placeholder="Short Text">';
                case "long-text": return '<textarea class="form-control" placeholder="Long Text"></textarea>';
                case "dropdown": return `<select class="form-control"><option>Option 1</option><option>Option 2</option></select>`;
                case "phone" : return '<input type="number" class="form-control" placeholder="Phone Number">';
                case "date" : return '<input type="date" class="form-control" placeholder="Date">';
                case "time" : return '<input type="time" class="form-control" placeholder="Time">';
                case "file": return '<input type="file" class="form-control" placeholder="File">';
                case "radio":
                    return `<label><input type="radio" name="radio"> Option 1</label>
                        <label><input type="radio" name="radio"> Option 2</label>`;
                case "checkbox":
                    return `<label><input type="checkbox" value=""> Option 1</label>
                        <label><input type="checkbox" value=""> Option 2</label>`;
                case "number": return '<input type="number" class="form-control" placeholder="Number">';
                default: return '';
            }
        }

        function openEditModalForExistingField(field) {
            console.log("openEditModalForExistingField called");

            const type = field.getAttribute("data-type");
            currentEditField = field;
            currentEditType = type;

            $("#editLabelModal").modal("show");

            const label = field.querySelector(".field-label").textContent.trim();
            document.getElementById("editLabelInput").value = label;

            // โหลดตัวเลือกที่มีอยู่แล้วจาก data-options
            let options = [];
            try {
                options = JSON.parse(field.getAttribute("data-options")) || [];
            } catch (e) {
                options = [];
            }

            console.log("Options:", options);

            if (["dropdown", "radio", "checkbox", "status"].includes(type)) {
                const optionsList = document.getElementById("optionsList");
                optionsList.innerHTML = options
                    .map(
                        (option, index) =>
                            `<li class="list-group-item">
                        <input type="text" class="form-control option-input" value="${option}"
                            oninput="updateOption(${index}, this.value)">
                        <button class="btn btn-danger btn-sm pull-right" onclick="deleteOption(${index})">
                            <i class="fa-solid fa-minus"></i>
                        </button>
                    </li>`
                    )
                    .join("");

                document.getElementById("newOptionInput").value = ""; // ล้าง input ตัวเลือกใหม่
                $("#editOptionsModal").modal("show");
            } else {
                $("#editLabelModal").modal("show");
            }
        }



        function openEditModal(field, type) {
            currentEditField = field; // เก็บฟิลด์ปัจจุบัน
            currentEditType = type;  // เก็บประเภทของฟิลด์

            $("#editLabelModal").modal("show");
            // โหลดชื่อหัวข้อ
            const label = field.querySelector(".field-label").textContent.trim();
            //console.log("Current Label:", label);  // ตรวจสอบค่าที่ดึงมาจากฟิลด์
            document.getElementById("editLabelInput").value = label;

            // หากเป็นประเภท dropdown, radio, checkbox ให้แสดง modal ตัวเลือก
            if (["dropdown", "radio", "checkbox", "status"].includes(type)) {
                options = Array.from(field.querySelectorAll(".field-input label, .field-input option"))
                    .map(opt => opt.textContent.trim());

                const optionsList = document.getElementById("optionsList");
                optionsList.innerHTML = options
                    .map(
                        (option, index) =>
                            `<li class="list-group-item">
                        <input type="text" class="form-control option-input" value="${option}"
                            oninput="updateOption(${index}, this.value)">
                        <button class="btn btn-danger btn-sm pull-right" onclick="deleteOption(${index})">
                            <i class="fa-solid fa-minus"></i>
                        </button>
                    </li>`
                    )
                    .join("");

                document.getElementById("newOptionInput").value = ""; // ล้าง input ตัวเลือกใหม่
                $("#editOptionsModal").modal("show"); // เปิด Modal ตัวเลือก
            } else {
                // หากไม่ใช่ dropdown, radio, checkbox เปิด modal เฉพาะแก้ไขหัวข้อ
                $("#editLabelModal").modal("show");
            }
        }

        function prepareFormData() {
            const fields = [];
            document.querySelectorAll(".form-item").forEach(item => {
                const label = item.querySelector(".field-label").textContent.trim();
                const type = item.getAttribute("data-type");
                const id = item.getAttribute("data-id") || null; //ดึง id ถ้ามี
                const options = Array.from(item.querySelectorAll(".field-input option, .field-input label"))
                    .map(opt => opt.textContent.trim());
                fields.push({ id, label, type, options });
            });
            fieldsInput.value = JSON.stringify(fields);
        }


        function saveLabel() {
            const newLabel = document.getElementById("editLabelInput").value.trim(); // อ่านค่าจากอินพุต
            if (newLabel && currentEditField) {
                currentEditField.querySelector(".field-label").textContent = newLabel; // อัปเดตชื่อหัวข้อ
            }
            $("#editLabelModal").modal("hide"); // ปิด Modal
        }

        function addOption() {
            const newOption = document.getElementById("newOptionInput").value.trim();
            if (newOption) {
                options.push(newOption);

                const optionsList = document.getElementById("optionsList");
                optionsList.innerHTML += `
            <li class="list-group-item">
                <input type="text" class="form-control option-input" value="${newOption}"
                    oninput="updateOption(${options.length - 1}, this.value)">
                <button class="btn btn-danger btn-sm pull-right " onclick="deleteOption(${options.length - 1})"><i class="fa-solid fa-minus"></i></button>
            </li>`;
                document.getElementById("newOptionInput").value = "";
            }
        }

        function updateOption(index, value) {
            options[index] = value.trim();
        }

        function deleteOption(index) {
            options.splice(index, 1);
            renderOptions();
        }

        function renderOptions(){
            const optionsList = document.getElementById("optionsList");
            optionsList.innerHTML = options
                .map(
                    (option, idx) =>
                        `<li class="list-group-item">
                    <input type="text" class="form-control option-input" value="${option}"
                        oninput="updateOption(${idx}, this.value)">
                    <button class="btn btn-danger btn-sm pull-right" onclick="deleteOption(${idx})"><i class="fa-solid fa-minus"></button>
                </li>`
                )
                .join("");
        }
        function saveOptions() {
            if (!currentEditField) return;

            const optionInputs = document.querySelectorAll(".option-input");
            let updatedOptions = [];

            optionInputs.forEach(input => {
                if (input.value.trim() !== "") {
                    updatedOptions.push(input.value.trim());
                }
            });

            // อัปเดตค่าลงใน data-options ของฟิลด์
            currentEditField.setAttribute("data-options", JSON.stringify(updatedOptions));

            // อัปเดตตัวเลือกที่แสดงในฟิลด์
            const fieldType = currentEditField.getAttribute("data-type");
            const fieldInput = currentEditField.querySelector(".field-input");

            if (fieldType === "dropdown") {
                fieldInput.innerHTML = `<select class="form-control">
            ${updatedOptions.map(option => `<option>${option}</option>`).join("")}
        </select>`;
            } else if (fieldType === "radio") {
                fieldInput.innerHTML = updatedOptions
                    .map(option => `
                <label>
                    <input type="radio" name="radio_${currentEditField.getAttribute("data-id")}" value="${option}">
                    ${option}
                </label>
            `)
                    .join("");
            } else if (fieldType === "checkbox") {
                fieldInput.innerHTML = updatedOptions
                    .map(option => `
                <label>
                    <input type="checkbox" name="checkbox_${currentEditField.getAttribute("data-id")}[]" value="${option}">
                    ${option}
                </label>
            `)
                    .join("");
            }
            $("#editOptionsModal").modal("hide"); // ปิด Modal
        }


        // ฟังก์ชันที่ใช้สำหรับเปิด/ปิด Modal การแก้ไขฟิลด์
        function openDeleteModal(field) {
            fieldToDelete = field;
            $("#deleteFieldModal").modal("show");
        }

        // เมื่อยืนยันการลบฟิลด์
        document.getElementById("confirmDeleteFieldBtn").onclick = () => {
            if(!fieldToDelete) return;

            const fieldId = fieldToDelete.getAttribute("data-id");

            if(fieldId){
                fetch(`<?= Url::to(['home/delete-field']) ?>?id=${fieldId}`, {
                    method: "POST",
                    headers: {
                        "X-CSRF-Token": "<?= Yii::$app->request->getCsrfToken() ?>"
                    }
                })
                    .then(response => response.json())
                    .then(data => {
                        location.reload();
                    })
                    .catch(error => {
                        console.error("Error:" ,error)
                    });
            }else{
                fieldToDelete.remove();
            }
            fieldToDelete = null;
            $("#deleteFieldModal").modal("hide");
        };

        document.getElementById("saveLabelBtn").addEventListener("click", () => {
            const newLabel = document.getElementById("editLabelInput").value;
            if (currentEditField && newLabel.trim()) {
                currentEditField.querySelector(".field-label").textContent = newLabel;
                $("#editLabelModal").modal("hide");
            }
        });

        function openOptionsModal() {
            options = Array.from(currentEditField.querySelectorAll(".field-input option"))
                .map(option => option.textContent);
            const optionsList = document.getElementById("optionsList");
            optionsList.innerHTML = options.map(opt => `<li class="list-group-item">${opt}</li>`).join("");
            $("#editOptionsModal").modal("show");
        }
    </script>
