<?php
?>

<?php

use yii\grid\GridView;
use yii\helpers\Html;

$this->title='Each Work';
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<style>
    .back-btn{
        margin-left: 20px;
        margin-top: 50px;
        font-size: 20px;
        border: none;
        background: none;
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
            <i class="fa-solid fa-bars"></i> รูปแบบการแสดงผล
            <span class="caret"></span>
        </button>
        <ul class="dropdown-menu">
            <li>
                <a href="">
                    <i class="fa-solid fa-table" style="margin-right: 5px;"></i>
                    ตาราง
                </a>
            </li>
            <li>
                <a href="">
                    <i class="fa-solid fa-list" style="margin-right: 5px;"></i>
                    ลิสต์
                </a>
            </li>
            <li>
                <a href="">
                    <i class="fa-regular fa-rectangle-list" style="margin-right: 5px;"></i>
                    แกลเลอรี่
                </a>
            </li>
            <li>
                <a href="">
                    <i class="fa-regular fa-calendar-days" style="margin-right: 5px;"></i>
                    ปฏิทิน
                </a>
            </li>
        </ul>
    </div>
</div>
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
            <td><i class="fa-regular fa-file"></i><span> </span><i class="fa-solid fa-circle-down"></i></td>
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
    document.getElementById('hideAll').addEventListener('click', function () {
        const checkboxes = document.querySelectorAll('.each-field input[type="checkbox"]');
        checkboxes.forEach(checkbox => checkbox.checked = false);
    });

    // ปุ่ม Show All
    document.getElementById('showAll').addEventListener('click', function () {
        const checkboxes = document.querySelectorAll('.each-field input[type="checkbox"]');
        checkboxes.forEach(checkbox => checkbox.checked = true);
    });
</script>

