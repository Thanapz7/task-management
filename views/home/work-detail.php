<?php
?>

<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JsExpression;
use yii\widgets\ActiveForm;

$this->title='รายละเอียดงาน '. $form['form_name'];
?>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>
<?php
$encodedEvents = json_encode($events, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK);

?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // รับข้อมูล events จาก PHP ที่ถูกแปลงเป็น JSON
        var eventsData = <?php echo $encodedEvents; ?>;
        // เริ่มต้นการทำงานของ FullCalendar
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
            },
            events: eventsData, // ใช้ข้อมูล events ที่ส่งมาจาก PHP
            eventContent: function(info) {
                // แสดงเนื้อหาของ event (เช่น title)
                var eventTitle = info.event.title;
                var content = document.createElement('div');
                content.innerText = eventTitle; // ใช้ title หรือข้อมูลอื่นๆ ที่คุณต้องการ
                return { domNodes: [content] };
            },
        });
        calendar.render();
    });
</script>

<?= Html::button('<i class="fa-solid fa-arrow-left back-btn"></i>', [
    'class' => 'back-btn',
    'onclick' => 'window.history.back();',
    'encode' => false,
]) ?>

<div class="head-each-work">
    <h4 style="font-size: 36px"><?= Html::encode($form['form_name'])?></h4>
    <button style="background: none; border: none" data-toggle="modal" data-target="#myModal" id="openModalButton">
        <i class="fa-solid fa-gear"></i>
    </button>

    <!-- Modal -->
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" style="font-size: 20px; text-align: center;">อัปเดตการเข้าถึง</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <!-- ส่วนการจัดการการอัปเดตแผนกที่สามารถกรอกข้อมูลได้ -->
                    <div class="d-flex align-items-center mb-3">
                        <h6 class="mb-0">เลือกแผนกที่สามารถกรอกข้อมูลได้</h6>
                        <div class="dropdown ml-3">
                            <button class="btn btn-default btn-sort dropdown-toggle" type="button" id="dropdownDepartments" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                ตัวเลือก
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownDepartments">
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
                    </div>

                    <!-- ส่วนการจัดการการอัปเดตแผนกที่สามารถดูข้อมูลได้ -->
                    <div class="d-flex align-items-center mb-3">
                        <h6 class="mb-0">เลือกแผนกที่สามารถดูข้อมูลได้</h6>
                        <div class="dropdown ml-3">
                            <button class="btn btn-default btn-sort dropdown-toggle" type="button" id="dropdownViewDepartments" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                ตัวเลือก
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownViewDepartments">
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
                    </div>

                    <!-- ส่วนการจัดการการเลือกผู้ใช้ -->
                    <div class="mb-3">
                        <h6 class="mb-0">เลือกบุคคลที่สามารถดูข้อมูลได้</h6>
                        <select class="form-control" name="view_users[]" id="view_users" multiple>
                            <?php foreach ($users as $user) : ?>
                                <option value="<?= $user->id ?>" <?= in_array($user->id, $selectedViewUsers) ? 'selected' : '' ?>>
                                    <?= Html::encode($user->name) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" data-dismiss="modal">บันทึกการอัปเดต</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript ส่วนการใช้งาน AJAX -->
<script>
    $(document).ready(function() {
        $('#submit-permission-form').on('click', function(e) {
            e.preventDefault(); // ป้องกันการส่งฟอร์มแบบปกติ

            var formId = $('#formId').val(); // สมมติว่า formId ถูกเก็บใน input hidden
            var departments = [];
            var viewDepartments = [];
            var viewUsers = [];

            // เก็บข้อมูลที่เลือกจากแผนกที่สามารถกรอกข้อมูล
            $('input[name="departments[]"]:checked').each(function() {
                departments.push($(this).val());
            });

            // เก็บข้อมูลที่เลือกจากแผนกที่สามารถดูข้อมูล
            $('input[name="view_departments[]"]:checked').each(function() {
                viewDepartments.push($(this).val());
            });

            // เก็บข้อมูลที่เลือกจากผู้ใช้ที่สามารถดูข้อมูล
            $('#view_users option:selected').each(function() {
                viewUsers.push($(this).val());
            });

            console.log('Form ID:', formId);
            console.log('Departments:', departments);
            console.log('View Departments:', viewDepartments);
            console.log('View Users:', viewUsers);

            // ส่งข้อมูลผ่าน AJAX
            $.ajax({
                url: '/Home/UpdatePermissions',
                type: 'POST',
                data: {
                    form_id: formId,
                    departments: departments, // ใช้ข้อมูลที่เก็บจากการเลือก
                    view_departments: viewDepartments, // ใช้ข้อมูลที่เก็บจากการเลือก
                    view_users: viewUsers // ใช้ข้อมูลที่เก็บจากการเลือก
                },
                success: function(response) {
                    if (response.status === 'success') {
                        alert('อัปเดตสิทธิ์เรียบร้อย');
                    } else {
                        alert('เกิดข้อผิดพลาด: ' + response.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.log('Error: ' + error);
                }
            });
        });
    });
</script>

<div class="search-group">
    <div class="search-bar">
        <input type="search" id="mainSearch" placeholder="ค้นหา แฟ้มงาน หรือ แผนกที่ต้องการ" class="search">
        <i class="fa-solid fa-magnifying-glass search-icon"></i>
    </div>
    <div class="btn-group">
        <button class="btn btn-default btn-sort dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fa-solid fa-eye-slash"></i>
            <span class="caret"></span>
        </button>
        <ul class="dropdown-menu">
            <div class="dropdown-search" style="margin-bottom: 5px;">
                <input type="search" id="fieldSearch" placeholder="ค้นหา fields">
                <i class="fa-solid fa-magnifying-glass search-icon"></i>
            </div>
            <?php if (!empty($fields)): ?>
                <?php foreach ($fields as $fieldName => $fieldValue): ?>
                    <li class="each-field">
                        <label class="switch submenu-link mb-0">
                            <input type="checkbox" class="field-toggle" data-field="<?= Html::encode($fieldName) ?>" checked>
                            <span class="slider round"></span>
                        </label>
                        <p class="field-name"><?= Html::encode($fieldName) ?></p>
                    </li>
                <?php endforeach; ?>
            <?php else: ?>
                <li class="each-field">
                    <p>ไม่มีฟิลด์ในฟอร์มนี้</p>
                </li>
            <?php endif; ?>
            <div class="btn-sort-each">
                <button type="button" class="btn btn-cus" id="hideAllFields">Hide All</button>
                <button type="button" class="btn btn-cus" id="showAllFields">Show All</button>
            </div>
        </ul>
    </div>
    <div class="btn-group" style="margin-left: 10px;">
        <button class="btn btn-default btn-sort dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fa-solid fa-bars"></i> รูปแบบการแสดงผล <span class="caret"></span>
        </button>
        <div class="dropdown-menu">
            <div class="dropdown-item">
                <?= Html::a('<i class="fa-solid fa-table" style="margin-right: 5px;"></i> ตาราง', ['home/work-detail', 'id' => $form->id, 'viewType' => 'table'], ['class' => 'submenu-link']) ?>
            </div>
            <div class="dropdown-item">
                <?= Html::a('<i class="fa-solid fa-list" style="margin-right: 5px;"></i> ลิสต์', ['home/work-detail', 'id' => $form->id, 'viewType' => 'list'], ['class' => 'submenu-link']) ?>
            </div>
            <div class="dropdown-item">
                <?= Html::a('<i class="fa-regular fa-rectangle-list" style="margin-right: 5px;"></i> แกลเลอรี่', ['home/work-detail', 'id' => $form->id, 'viewType' => 'gallery'], ['class' => 'submenu-link']) ?>
            </div>
            <div class="dropdown-item">
                <?= Html::a('<i class="fa-regular fa-calendar-days" style="margin-right: 5px;"></i> ปฏิทิน', ['home/work-detail', 'id' => $form->id, 'viewType' => 'calendar'], ['class' => 'submenu-link']) ?>
            </div>
        </div>
    </div>
</div>
    <div class="display-area">
        <!-- การแสดงผลตาม $viewType -->
        <?php if ($viewType == 'table'): ?>
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'summary' => false,
                'columns' => array_merge(
                    array_values(array_filter(array_map(function ($fieldName) {
                        if ($fieldName !== 'record_id') {  // ลบ record_id ออกจากคอลัมน์
                            return [
                                'attribute' => $fieldName,
                                'label' => str_replace('_', ' ', $fieldName),
                                'contentOptions' => ['class' => 'field-column-' . $fieldName, 'style' => 'max-width:150px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap'],
                                'headerOptions' => ['class' => 'field-column-' . $fieldName],
                                'value' => function($model) use ($fieldName) {
                                    $value = $model[$fieldName] ?? '';
                                    if (is_string($value)) {
                                        $value = str_replace(["\r", "\n"], '', $value);
                                    }
                                    if ($value === null || $value === '') {
                                        return '(ไม่ได้กรอก)';
                                    }
                                    $isFilePath = (bool) preg_match('/\.(jpg|jpeg|png|gif|pdf|docx?|xlsx?|txt)$/i', $value);
                                    $baseUrl = Yii::getAlias('@web/uploads/');
                                    if(strpos($value, 'uploads/') !== false){
                                        $fileUrl = Yii::getAlias('@web/' ) . ltrim($value, '/');
                                    }else{
                                        $fileUrl = $baseUrl .ltrim($value, '/');
                                    }

                                    if($isFilePath){
                                        $fileExtension = strtolower(pathinfo($value, PATHINFO_EXTENSION));
                                        if(in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif'])){
                                            return Html::a('<i class="fa-solid fa-image"></i> เปิดรูปภาพ', $fileUrl,
                                                ['target' => '_blank',
                                                 'class' => 'btn-link-file']);
                                        }elseif ($fileExtension == 'pdf') {
                                            return Html::a('<i class="fa-solid fa-file-pdf"></i> เปิด PDF', $fileUrl,
                                                ['target' => '_blank',
                                                 'class' => 'btn-link-file']);
                                        }else{
                                            return Html::a('<i class="fa-solid fa-file"></i> ดาวน์โหลดไฟล์', $fileUrl,
                                                ['target' => '_blank',
                                                 'class' => 'btn-link-file',
                                                 'download' => true]);
                                        }
                                    }
                                    return nl2br(Html::encode($value));
                                },
                                'format' => 'raw',
                            ];
                        }
                        return null;
                    }, array_keys($dataProvider->allModels[0] ?? [])))),
                    // เพิ่มคอลัมน์เพิ่มเติม เช่น ActionColumn และซ่อน record_id
                    [
                        [
                            'attribute' => 'record_id',
                            'visible' => false,  // ซ่อน record_id ไม่ให้แสดงในตาราง
                        ],
                        [
                            'class' => 'yii\grid\ActionColumn',
                            'template' => '{preview} {download}',
                            'header' => '<i class="fa-solid fa-file-circle-check"></i>',
                            'buttons' => [
                                'preview' => function ($url, $model) {
                                    return Html::a(
                                        '<i class="fa-regular fa-file"></i>',
                                        ['work-detail-preview', 'id' => $model['record_id']],
                                        ['class' => 'manage-link', 'title' => 'preview']
                                    );
                                },
                                'download' => function ($url, $model) {
                                    // ตรวจสอบว่า record_id มีข้อมูล
                                    if (isset($model['record_id']) && !empty($model['record_id'])) {
                                        Yii::debug('Generated preview link for record_id: ' . $model['record_id']);

                                        return Html::a(
                                            '<i class="fa-solid fa-circle-down"></i>',
                                            'javascript:void(0)', // ใช้ javascript:void(0) เพื่อไม่ให้หน้ารีเฟรช
                                            [
                                                'class' => 'manage-link',
                                                'title' => 'Download PDF',
                                                'onclick' => "window.open('" . Url::to(['work-detail-preview', 'id' => $model['record_id']]) . "', '_blank').print();", // เรียก window.print
                                            ]
                                        );
                                    } else {
                                        return null; // ถ้าไม่มี record_id ก็จะไม่แสดงปุ่ม download
                                    }
                                },
                            ],
                            'contentOptions' => ['style' => 'text-align: center'],
                            'headerOptions' => ['class' => 'custom-table-header']
                        ],
                    ]
                ),
            ]); ?>

        <?php elseif ($viewType == 'list'): ?>
            <div class="list" style="margin-left: 20px; margin-top: 20px;">
            <?php $models = $dataProvider->allModels; ?>
            <?php foreach ($models as $row): ?>
                <?php
                $recordId = $row['record_id'];
                // ลบ record_id ออกจาก row ถ้ามี
                unset($row['record_id']);
                ?>
                <div class="each-list">
                    <div class="list-item">
                        <a href="<?= Url::to(['work-detail-preview', 'id'=>$recordId])?>">
                            <?php foreach ($row as $fieldName => $fieldValue): ?>
                                <span class="field-column-<?= $fieldName ?>">
                                    <?= $fieldValue ?>
                                </span>
                            <?php endforeach; ?>
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <?php elseif ($viewType == 'gallery'): ?>
        <div class="gallery" style="margin-left: 20px; margin-top: 20px;">
            <div class="row">
                <?php $models = $dataProvider->allModels; ?>
                <?php foreach ($models as $row): ?>
                    <?php
                    $recordId = $row['record_id'] ?? null;
                    // ลบ record_id ออกจาก row ถ้ามี
                    unset($row['record_id']);
                    ?>
                    <a href="<?= Url::to(['work-detail-preview', 'id' => $recordId]) ?>">
                        <div class="col-xs-3 gallery-item">
<!--                            --><?php //= implode(', ', $row) ?>
                            <?php foreach ($row as $fieldName => $fieldValue): ?>
                                <span class="field-column-<?= $fieldName?>">
                                    <?= $fieldValue ?>
                                </span>
                            <?php endforeach; ?>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>

        <?php elseif ($viewType == 'calendar' && isset($events) && !empty($events)): ?>
            <div id="calendar"></div>
        <?php else: ?>
            <p>No events available for the calendar view.</p>
        <?php endif; ?>

    </div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.1/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        // ป้องกันการปิด dropdown เมื่อคลิกที่ submenu
        var submenuLinks = document.querySelectorAll(".submenu-link");

        submenuLinks.forEach(function (link) {
            link.addEventListener("click", function (e) {
                e.stopPropagation(); // หยุดการกระทำ default ของ dropdown
            });
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        // ค้นหาคอลัมน์ที่ต้องการ
        document.getElementById('fieldSearch').addEventListener('input', function() {
            let query = this.value.toLowerCase();
            let items = document.querySelectorAll('.each-field');
            console.log("Searching for: " + query); // ตรวจสอบคำค้นหา

            items.forEach(function(item) {
                let fieldName = item.querySelector('.field-name').textContent.toLowerCase();
                console.log("Field Name: " + fieldName); // ตรวจสอบชื่อฟิลด์

                if (fieldName.indexOf(query) > -1) {
                    item.style.display = '';
                } else {
                    item.style.display = 'none';
                }
            });
        });
        // ตรวจสอบการเลือกแสดง/ซ่อนคอลัมน์
        let fieldToggles = document.querySelectorAll('.field-toggle');
        fieldToggles.forEach(function(toggle) {
            toggle.addEventListener('change', function() {
                let fieldName = this.getAttribute('data-field');
                let isChecked = this.checked;
                console.log("Toggled: " + fieldName + " Checked: " + isChecked);
                let columnElements = document.querySelectorAll(`.field-column-${fieldName}`);
                columnElements.forEach(function(columnElement) {
                    if (isChecked) {
                        columnElement.style.display = ''; // แสดงคอลัมน์
                    } else {
                        columnElement.style.display = 'none'; // ซ่อนคอลัมน์
                    }
                });
            });
        });

        // ปุ่ม Hide All
        document.getElementById('hideAllFields').addEventListener('click', function() {
            let fieldToggles = document.querySelectorAll('.field-toggle');
            fieldToggles.forEach(function(toggle) {
                toggle.checked = false;
            });
            let allColumns = document.querySelectorAll('[class^="field-column-"]');
            allColumns.forEach(function (column){
                column.style.display = 'none';
            });
        });

        // ปุ่ม Show All
        document.getElementById('showAllFields').addEventListener('click', function() {
            let fieldToggles = document.querySelectorAll('.field-toggle');
            fieldToggles.forEach(function(toggle) {
                toggle.checked = true;
            });
            let allColumns = document.querySelectorAll('[class^="field-column-"]');
            allColumns.forEach(function (column){
                column.style.display = '';
            });
        });
    });

    //  Search
    document.getElementById('mainSearch').addEventListener('input', function () {
        const searchTerm = this.value.toLowerCase();

        // table
        const tableRows = document.querySelectorAll('.table tbody tr');
        tableRows.forEach(row => {
            const cells = Array.from(row.querySelectorAll('td'));
            const match = cells.some(cell => cell.textContent.toLowerCase().includes(searchTerm));
            row.style.display = match ? '' : 'none';
        });

        // list
        const listItems = document.querySelectorAll('.list .each-list');
        listItems.forEach(item => {
            const text = item.querySelector('a').textContent.toLowerCase();
            item.style.display = text.includes(searchTerm) ? '' : 'none';
        });

        // gallery
        const galleryItems = document.querySelectorAll('.gallery .gallery-item');
        galleryItems.forEach(item => {
            const text = item.textContent.toLowerCase();
            item.style.display = text.includes(searchTerm) ? '' : 'none';
        });

    });

</script>

