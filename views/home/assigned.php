<?php
$this->title = 'Assigned';
?>

<style>
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

<h4 class="text-header">รายการงานที่มอบหมาย</h4>
<br>
<div class="search-group">
    <div class="search-bar">
        <input type="search" id="mainSearch" placeholder="ค้นหา แฟ้มงาน หรือ แผนกที่ต้องการ" class="search">
        <i class="fa-solid fa-magnifying-glass search-icon"></i>
    </div>
</div>

<div class="grid" style="margin-left: 20px; margin-top: 20px;">
    <table class="table table-bordered">
        <thead>
        <tr>
            <th class="text-center">วัน/เดือน/ปี</th>
            <th class="text-center">แผนกที่ติดต่อ</th>
            <th class="text-center">แฟ้ม</th>
            <th class="text-center">จัดการ</th>

        </tr>
        </thead>
        <tbody>
        <tr>
            <td>01/01/2025</td>
            <td>DDS</td>
            <td>รายงานการสรุปการทำงาน</td>
            <td><i class="fa-regular fa-file"></i><span> </span><i class="fa-solid fa-circle-down"></i></td>
        </tr>
        <tr>
            <td>01/01/2025</td>
            <td>HR</td>
            <td>รายงานการจัดกิจกรรมพนักงาน</td>
            <td><i class="fa-regular fa-file"></i><span> </span><i class="fa-solid fa-circle-down"></i></td>
        </tr>
        </tbody>
    </table>
</div>
