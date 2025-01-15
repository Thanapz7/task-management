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
    .head-table{
        font-size: 16px;
    }
    .manage-link i{
        font-size: 16px;
        transition: 0.3s;
    }
    .manage-link i:hover{
        transform: scale(1.2);
    }
    .manage-link .fa-file{
        color: #F0B754;
    }
    .manage-link .fa-circle-down{
        color: #6DB2E5;
    }
</style>

<h4 class="text-header">รายการงานที่มอบหมาย</h4>
<br>
<div class="search-group">
    <div class="search-bar">
        <input type="search" id="mainSearch" placeholder="ค้นหาข้อมูลที่ต้องการ" class="search">
        <i class="fa-solid fa-magnifying-glass search-icon"></i>
    </div>
</div>

<div class="grid" style="margin-left: 20px; margin-top: 20px;">
    <table class="table table-bordered">
        <thead>
        <tr>
            <th class="text-center head-table">วัน/เดือน/ปี</th>
            <th class="text-center head-table">แผนกที่ติดต่อ</th>
            <th class="text-center head-table">แฟ้ม</th>
            <th class="text-center head-table">จัดการ</th>

        </tr>
        </thead>
        <tbody>
        <?php if (!empty($records)): ?>
            <?php foreach ($records as $record): ?>
                <tr>
                    <td style="width: 13%;"><?= Yii::$app->formatter->asDate($record['record_created_at'], 'php:d/m/Y')?></td>
                    <td style="width: 30%;"><?= htmlspecialchars(strtoupper($record['department_name']), ENT_QUOTES, 'UTF-8')?></td>
                    <td style="width: 47%"><?= htmlspecialchars($record['form_name'], ENT_QUOTES, 'UTF-8')?></td>
                    <td class="text-center" style="width: 10%;">
                        <a class="manage-link" href="<?= Yii::$app->urlManager->createUrl(['home/assigned-preview', 'id' => $record['id']]) ?>"><i class="fa-regular fa-file"></i></a>
                        <span style="color: #95999c"> | </span>
                        <a class="manage-link" href="" id="myLink" data-id="<?= $record['id']?>"><i class="fa-solid fa-circle-down"></i></a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else:?>
            <tr>
                <td colspan="4" class="text-center">ไม่มีข้อมูลการสั่งงาน</td>
            </tr>
        <?php endif;?>
        </tbody>
    </table>
</div>
<script>
    document.getElementById('mainSearch').addEventListener('input', function (){
        const searchTerm = this.value.toLowerCase();
        const rows = document.querySelectorAll('table tbody tr');

        if(searchTerm === ''){
            rows.forEach(row =>{
                row.style.display = '';
            });
        }else{
            rows.forEach(row => {
                const cells = row.querySelectorAll('td');
                let rowText = '';

                cells.forEach(cell => {
                    rowText += cell.textContent.toLowerCase();
                });

                if(rowText.includes(searchTerm)){
                    row.style.display = '';
                }else{
                    row.style.display = 'none';
                }
            });
        }
    });
    function printPreview(url){
        var printWindow = window.open(url, '_blank');
        printWindow.onload = function (){
            printWindow.print();
        }
    }
    document.getElementById('myLink').addEventListener('click', function (event){
        event.preventDefault()
        var recordId = this.getAttribute('data-id');
        var url = '<?= Yii::$app->urlManager->createUrl(['home/assigned-preview', 'id' => '']) ?>' + recordId;

        printPreview(url);
    })
</script>
