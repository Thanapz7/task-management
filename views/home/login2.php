<?php
use app\assets\AppAsset;
AppAsset::register($this);
?>
<style>
    body {
        background-color: #cccccc;
        color: white;
        font-family: "Noto Sans Thai", serif;
    }
</style>
<div class="container-fluid">
    <div class="row w-100">
        <div class="col-md-6 info">
            <h2>Welcome to Our Service</h2>
            <p>Here you can find some information about our service. We provide the best solutions for your needs. Join us and enjoy the benefits.</p>
        </div>
        <div class="col-md-1 divider"></div>
        <div class="col-md-5 login">
            <form class="login-form">
                <h2 class="logo"><i class="fa-solid fa-briefcase"></i></h2>
                <div class="form-group w-100">
                    <label for="email">ชื่อผู้ใช้ หรือ อีเมล <span class="needed">*</span></label>
                    <input type="email" class="form-control" id="email" placeholder="ชื่อผู้ใช้ หรือ อีเมล">
                </div>
                <br>
                <div class="form-group w-100 password-input">
                    <label for="password">รหัสผ่าน <span class="needed">*</span></label>
                    <input type="password" class="form-control" id="password" placeholder="รหัสผ่าน">
                    <i class="fa-solid fa-eye-slash login-eye"></i>
                </div>
                <div class="form-group w-100 forgot-pass">
                    <p>ลืมรหัสผ่าน</p>
                </div>
                <button type="submit" class="btn btn-custom">เข้าสู่ระบบ</button>
            </form>
        </div>
    </div>
</div>

