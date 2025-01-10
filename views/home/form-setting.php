<?php
?>
<?php
$this->title = 'Create Form';
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
    .input-form{
        border: 1px solid #cccccc;
        border-radius: 20px;
        padding: 7px;
    }
    .btn-sort{
        border-radius: 20px;
        box-shadow: 0 2px 0 0 rgba(0,0,0,0.2);
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
<i class="fa-solid fa-arrow-left back-icon"></i>
<div class="row" style="margin: 13px">
    <div class="col-md-8 form-preview" id="form-preview">
        <!-- content here! -->
    </div>
    <div class="col-md-3 data-type form-setting">
        <form class="form-horizontal" style="padding: 5px">
            <div class="form-group">
                <label for="" class="label-text">ชื่อแฟ้ม<span style="color: #cc5555">*</span>:</label>
                <input type="text" placeholder="ชื่อแฟ้ม" class="input-form">
            </div>
            <div class="form-group">
                <label for="" class="label-text">icon:</label>
                <button class="btn btn-default btn-sort dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    ตัวเลือก
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu">
                    <li><a href=""><i class="fa-regular fa-folder-closed"></i></a></li>
                    <li><a href=""><i class="fa-solid fa-suitcase"></i></a></li>
                    <li><a href=""><i class="fa-regular fa-star"></i></a></li>
                    <li><a href=""><i class="fa-solid fa-chart-column"></i></a></li>
                </ul>
            </div>
            <div class="">
                <div class="text-center">
                    <label for="" class="label-text" style="margin-top: 10px;">จัดการการเข้าถึง</label>
                </div>

                <div class="form-group">
                    <label for="" class="label-content">บุคคลที่สามารถเข้ากรอกข้อมูลได้</label>
                    <button class="btn btn-default btn-sort dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        ตัวเลือก
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a href="">พนักงานทั้งหมด</a></li>
                        <li><a href="">บุคคลภายนอก</a></li>
                    </ul>
                </div>
                <div class="form-group">
                    <label for="" class="label-content">บุคคลที่สามารถเข้ามาดูข้อมูลได้</label>
                    <button class="btn btn-default btn-sort dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        ตัวเลือก
                        <span class="caret"></span>
                    </button>
                    <input type="text" placeholder=" @" class="add-people" style="width: 50px; padding: 6px">
                    <ul class="dropdown-menu">
                        <li><a href="">พนักงานทั้งหมด</a></li>
                        <li><a href="">บุคคลภายนอก</a></li>
                    </ul>
                </div>
            </div>
            <div class="">
                <div class="text-center">
                    <label for="" class="label-text" style="margin-top: 10px;">การแสดงผล</label>
                </div>
                <div class="text-center" style="margin-top: 10px; margin-bottom: 10px;">
                    <div class="radio">
                        <input type="radio" class="radio-input" value="grid" name="display" id="radio1">
                        <label for="radio1" class="radio-label">ตาราง</label>
                        <input type="radio" class="radio-input" value="list" name="display" id="radio2">
                        <label for="radio2" class="radio-label">รายการ</label>
                        <input type="radio" class="radio-input" value="gallery" name="display" id="radio3">
                        <label for="radio3" class="radio-label">แกลเลอรี่</label>
                        <input type="radio" class="radio-input" value="calendar" name="display" id="radio4">
                        <label for="radio4" class="radio-label">ปฏิทิน</label>
                    </div>
                </div>
                <div class="form-group">
                    <label class="label-content">เลือกฟิลด์ที่จะแสดง</label>
                    <div style="margin-left: 15px; margin-top: -5px;">
                        <div class="checkbox">
                            <label><input type="checkbox" value="">Option 1</label>
                        </div>
                        <div class="checkbox">
                            <label><input type="checkbox" value="">Option 2</label>
                        </div>
                        <div class="checkbox disabled">
                            <label><input type="checkbox" value="" >Option 3</label>
                        </div>
                    </div>
                </div>

            </div>
        </form>
    </div>
    <div class="col-md-12 text-right">
        <button class="btn btn-default btn-save">บันทึก</button>
    </div>
</div>



    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.1/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>

    </script>

