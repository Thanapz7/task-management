<?php
?>

<?php

use yii\grid\GridView;
use yii\helpers\Html;

$this->title='รายละเอียดงาน '. $form['form_name'];
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');

        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
            },
            navLinks: true, // คลิกเพื่อดูวัน/สัปดาห์
            editable: true, // ลากเหตุการณ์ได้
            selectable: true, // เลือกวันได้
            eventLimit: true, // แสดงข้อความ "more" เมื่อมีหลายเหตุการณ์ในวันเดียวกัน
            events: [
                {
                    title: 'ประชุมทีม',
                    start: '2025-01-10T10:00:00',
                    end: '2025-01-10T12:00:00',
                    color: '#007bff', // สีน้ำเงิน
                    description: 'ประชุมทีมเพื่อเตรียมงานโครงการใหม่'
                },
                {
                    title: 'วันหยุดราชการ',
                    start: '2025-01-13',
                    end: '2025-01-14',
                    color: '#28a745', // สีเขียว
                    description: 'วันหยุดนักขัตฤกษ์'
                },
                {
                    title: 'เดินทางไปพบลูกค้า',
                    start: '2025-01-16T09:00:00',
                    end: '2025-01-16T17:00:00',
                    color: '#ffc107', // สีเหลือง
                    description: 'เดินทางไปเสนอโปรเจกต์ให้กับลูกค้า'
                },
                {
                    title: 'งานเลี้ยงปีใหม่',
                    start: '2025-01-20T18:00:00',
                    color: '#dc3545', // สีแดง
                    description: 'จัดงานเลี้ยงบริษัทที่โรงแรมใหญ่'
                },
            ],
            eventClick: function(info) {
                alert(
                    'เหตุการณ์: ' + info.event.title + '\n' +
                    'รายละเอียด: ' + (info.event.extendedProps.description || 'ไม่มีรายละเอียด') + '\n' +
                    'เวลาเริ่มต้น: ' + info.event.start.toISOString()
                );
            }
        });
        calendar.render();
    });
</script>
<style>
    .back-btn{
        margin-left: 20px;
        margin-top: 50px;
        font-size: 20px;
        border: none;
        background: none;
        transition: 0.3s;
    }
    .back-btn:hover{
        transform: scale(1.2);
    }
    .head-each-work{
        margin-left: 50px;
        margin-top: 20px;
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        font-size: 36px;
    }
    .head-each-work i{
        margin-right: 20px;
    }
    /*.modal-dialog {*/
    /*    position: absolute;*/
    /*    top: 50%;*/
    /*    left: 50%;*/
    /*    transform: translate(-50%, -50%);*/
    /*}*/
    .modal{
        border-radius: 20px;
    }
    .add-people{
        width: 100px;
        padding: 5px;
        font-size: 14px;
        border: 1px solid #cccccc;
        border-radius: 20px;
        bottom: 10px;
    }
    .search-group{
        margin-left: 20px;
        margin-top: 10px;
        display: flex;
        flex-direction: row;
    }
    .search-bar{
        position: relative;
        margin-right: 10px;
    }
    .search{
        position: relative;
        padding: 7px;
        border: 1px solid #cccccc;
        box-shadow: 0 2px 0 0 rgba(0,0,0,0.2);
        width: 300px;
        border-radius: 20px;
    }
    .search-icon{
        position: absolute;
        right: 15px;
        top: 10px;
        color: #656565cc;
        cursor: pointer;
    }
    .btn-sort{
        border-radius: 20px;
        box-shadow: 0 2px 0 0 rgba(0,0,0,0.2);
    }
    .dropdown-search input{
        margin: 3px;
        padding: 3px;
        border: none;
        border-bottom: 1px solid #cccccc;
    }
    .btn-sort-each{
        display: flex;
        flex-direction: row;
        align-items: center;
        justify-content: center;
    }
    .btn-cus{
        margin: 10px;
        padding: 3px;
        font-weight: bold;
        background-color: #bbbbbb;
    }
    .each-field{
        display: flex;
        flex-direction: row;
        margin-left: 20px;
    }

    /*  switch  */
    .switch {
        position: relative;
        display: inline-block;
        width: 33px;
        height: 17px;
        margin-right: 5px;
    }
    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }
    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        transition: .4s;
        border-radius: 34px;
    }
    .slider:before {
        position: absolute;
        content: "";
        height: 13px;
        width: 13px;
        border-radius: 50%;
        left: 2px;
        bottom: 2px;
        background-color: white;
        transition: .4s;
    }
    input:checked + .slider {
        background-color: #95D2B3;
    }
    input:checked + .slider:before {
        transform: translateX(14px);
    }
    table {
        border-collapse: separate;
        border-spacing: 0;
        border-radius: 15px; /* กำหนดให้มุมของ table โค้ง */
        overflow: hidden; /* ซ่อนส่วนที่ล้นออกมา */
    }
    table th, table td {
        border: 1px solid #ddd; /* กำหนดขอบของ cell */
    }
    .display-area{
        margin-top: 25px;
    }
    .each-list{
        padding: 5px;
        border-bottom: 1px solid #cccccc;
    }
    .list-item{
        font-size: 18px;
    }
    .list-item a{
        color: #000000;
        transition: 0.3s;
    }
    .list-item a:hover{
        text-decoration: none;
        background-color: rgba(109, 178, 229, 0.27);
        padding: 10px;
        border-radius: 20px;
    }
    .gallery-item{
        font-size: 16px;
        padding: 20px;
        margin: 10px;
        /*margin-right: 20px;*/
        /*margin-bottom: 20px;*/
        border: 1px solid #cccccc;
        border-radius: 20px;
    }
    .gallery a,
    .gallery .gallery-item:hover{
        color: #000000;
        text-decoration: none;
        transition: 0.3s;
    }
    .gallery a:hover ,
    .gallery .gallery-item:hover{
        background-color: rgba(109, 178, 229, 0.27);
        transform: scale(1.1);
    }
    #calendar {
        max-width: 90%; /* กำหนดความกว้าง */
        height: 400px;    /* กำหนดความสูง */
        margin: 0 auto;   /* จัดกึ่งกลาง */
        font-size: 0.8em; /* ลดขนาดฟอนต์ */
    }
    .fc .fc-button-primary{
        background-color: #55AD9B;
        border: none;
    }
    .fc .fc-button-primary:hover{
        background-color: #0c5460;
    }
    .fc .fc-button-primary:not(:disabled).fc-button-active, .fc .fc-button-primary:not(:disabled):active{
        background-color: #0c5460;
    }
    .fc .fc-button-primary:disabled{
        background-color: rgba(85, 173, 155, 0.64);
    }
</style>

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
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 style="font-size: 20px; text-align: center">จัดการการเข้าถึง</h4>
                </div>
                <div class="modal-body">
                    <div style="display: flex; flex-direction: row; ">
                        <div style="margin-top: 10px;">
                            <h4>บุคคลที่สามารถเข้ากรอกข้อมูลได้</h4>
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
                    <div style="display: flex; flex-direction: row; ">
                        <div style="margin-top: 10px;">
                            <h4>บุคคลที่สามารถเข้ามาดูข้อมูลได้</h4>
                        </div>
                        <div class="" style="margin-left: 20px;">
                            <button class="btn btn-default btn-sort dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                ตัวเลือก
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a href="">พนักงานทั้งหมด</a></li>
                                <li><a href="">ฝ่าย HR</a></li>
                                <li><a href="">ฝ่าย DDS</a></li>
                            </ul>
                        </div>
                        <div style="margin-left: 10px;">
                            <input type="text" placeholder=" @" class="add-people">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" data-dismiss="modal" >บันทึก</button>
                </div>
            </div>
        </div>
    </div>
</div>
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
            <?php if (!empty($result)): ?>
                <?php foreach ($result as $field): ?>
                    <li class="each-field">
                        <label class="switch submenu-link">
                            <input type="checkbox">
                            <span class="slider round"></span>
                        </label>
                        <p class="field-name"><?= Html::encode($field['field_name']) ?></p>
                    </li>
                <?php endforeach; ?>
            <?php else: ?>
                <li class="each-field">
                    <p>ไม่มีฟิลด์ในฟอร์มนี้</p>
                </li>
            <?php endif; ?>
            <div class="btn-sort-each">
                <button type="submit" class="btn btn-cus">Hide All</button>
                <button type="submit" class="btn btn-cus">Show All</button>
            </div>
        </ul>
    </div>
    <div class="btn-group" style="margin-left: 10px;">
        <button class="btn btn-default btn-sort dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fa-solid fa-bars"></i> รูปแบบการแสดงผล<span class="caret"></span>
        </button>
        <ul class="dropdown-menu">
            <li><?= Html::a('<i class="fa-solid fa-table" style="margin-right: 5px;"></i> ตาราง',['home/work-detail', 'id'=>$form->id, 'viewType'=>'table']) ?></li>
            <li><?= Html::a('<i class="fa-solid fa-list" style="margin-right: 5px;"></i> ลิสต์',['home/work-detail', 'id'=>$form->id, 'viewType'=>'list']) ?></li>
            <li><?= Html::a('<i class="fa-regular fa-rectangle-list" style="margin-right: 5px;"></i> แกลเลอรี่',['home/work-detail', 'id'=>$form->id, 'viewType'=>'gallery']) ?></li>
            <li><?= Html::a('<i class="fa-regular fa-calendar-days" style="margin-right: 5px;"></i> ปฏิทิน',['home/work-detail', 'id'=>$form->id, 'viewType'=>'calendar']) ?></li>
        </ul>
    </div>
</div>
<div class="display-area">
    <?php if($viewType === 'table'): ?>
    <div class="grid" style="margin-left: 20px; margin-top: 20px;">
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>วันที่มอบหมาย</th>
                <th>ผู้มอบหมาย</th>
                <th>ชื่องาน</th>
                <th>ราละเอียด</th>
                <th>วันครบกำหนด</th>
                <th>จัดการ</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>John</td>
                <td>Doe</td>
                <td>john@example.com</td>
                <td>Doe</td>
                <td>Doe</td>
                <td> <?= Html::a('<i class="fa-regular fa-file"></i>',['work-detail-preview']) ?><span> </span><i class="fa-solid fa-circle-down"></i></td>
            </tr>
            <tr>
                <td>John</td>
                <td>Doe</td>
                <td>john@example.com</td>
                <td>Doe</td>
                <td>Doe</td>
                <td><i class="fa-regular fa-file"></i><span> </span><i class="fa-solid fa-circle-down"></i></td>
            </tr>
            </tbody>
        </table>
    </div>
    <?php elseif ($viewType === 'list'): ?>
    <div class="list" style="margin-left: 20px; margin-top: 20px;">
        <div class="each-list">
            <label for="" class="list-item"><a href="">ในรายการลิสต์จะแสดงเฉพาะชื่อรายการที่ผู้ใช้เลือกแสดงได้ 1ฟิลด์ เท่านั้น</a></label>
        </div>
        <div class="each-list">
            <label for="" class="list-item"><a href="">รายงานการใช้จ่ายประจำปี 2024</a></label>
        </div>
        <div class="each-list">
            <label for="" class="list-item"><a href="">รายงานการสมัครงานประจำเดือนมกราคม 2025</a></label>
        </div>
    </div>
    <?php elseif ($viewType === 'gallery'): ?>
    <div class="gallery" style="margin-left: 20px; margin-top: 20px;">
        <div class="row">
            <a href="">
                <div class="col-md-3 gallery-item">
                    <p>กิจกรรมพนักงาน</p>
                    <p>รายละเอียดในกิจกรรมพนักงานรายการรายการรายการ</p>
                    <p>01/01/2025</p>
                </div>
            </a>
            <a href="">
                <div class="col-md-3 gallery-item">
                    <p>กิจกรรมพนักงาน</p>
                    <p>รายละเอียดในกิจกรรมพนักงานรายการรายการรายการ</p>
                    <p>01/01/2025</p>
                </div>
            </a>
            <a href="">
                <div class="col-md-3 gallery-item">
                    <p>กิจกรรมพนักงาน</p>
                    <p>รายละเอียดในกิจกรรมพนักงานรายการรายการรายการ</p>
                    <p>01/01/2025</p>
                </div>
            </a>
            <a href="">
                <div class="col-md-3 gallery-item">
                    <p>กิจกรรมพนักงาน</p>
                    <p>รายละเอียดในกิจกรรมพนักงานรายการรายการรายการ</p>
                    <p>01/01/2025</p>
                </div>
            </a>
        </div>
    </div>
    <?php elseif ($viewType === 'calendar'): ?>
    <div class="text-center">
        <div id='calendar'></div>
    </div>
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


    // ค้นหาใน dropdown menu
    document.getElementById('fieldSearch').addEventListener('input', function () {
        const query = this.value.toLowerCase();
        const fields = document.querySelectorAll('.each-field');

        fields.forEach(field => {
            const fieldName = field.querySelector('.field-name').textContent.toLowerCase();
            if (fieldName.includes(query)) {
                field.style.display = ''; // แสดงผล
            } else {
                field.style.display = 'none'; // ซ่อน
            }
        });
    });

    // ปุ่ม Hide All
    // document.getElementById('hideAll').addEventListener('click', function () {
    //     const checkboxes = document.querySelectorAll('.each-field input[type="checkbox"]');
    //     checkboxes.forEach(checkbox => checkbox.checked = false);
    // });

    // ปุ่ม Show All
    // document.getElementById('showAll').addEventListener('click', function () {
    //     const checkboxes = document.querySelectorAll('.each-field input[type="checkbox"]');
    //     checkboxes.forEach(checkbox => checkbox.checked = true);
    // });

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

