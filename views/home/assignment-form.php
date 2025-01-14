<?php
$this->title = 'Assignment Form';
?>

<style>
    .assignment-form{
        margin-top: 20px;
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

</div>
<div class="group-btn-preview text-center" style="margin-top: 5px;">
    <button type="submit" class="btn-d-preview btn-cancel">ยกเลิก</button>
    <button type="submit" class="btn-d-preview btn-confirm">ตกลง</button>
</div>