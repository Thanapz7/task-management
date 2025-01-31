<?php
$this->title = 'Assignment';
?>

<h4 class="text-header">จ้างงาน</h4>
<br>
<div class="search-group">
    <div class="search-bar">
        <input type="search" id="mainSearch" placeholder="ค้นหา แฟ้มงาน หรือ แผนกที่ต้องการ" class="search">
        <i class="fa-solid fa-magnifying-glass search-icon"></i>
    </div>
</div>
<div class="row folders">
    <?php foreach ($forms as $form): ?>
        <div class="col-xs-3 folder" style="cursor: pointer" onclick="location.href='<?= Yii::$app->urlManager->createUrl(['job/assignment-form', 'id' => $form['id']]) ?>'">
            <div style="margin: 10px">
                <div class="folder-head">
                    <i class="fa-regular fa-folder-open"></i>
                    <h5><?= htmlspecialchars($form['form_name']) ?></h5>
                </div>
                <p class="department" style="color: #454d55">
                    แผนก : <?= htmlspecialchars(mb_strtoupper($form['owner_department_name'])) ?>
                </p>
            </div>
        </div>
    <?php endforeach; ?>
</div>
<script>
    document.getElementById('mainSearch').addEventListener('input', function (){
        const searchTerm = this.value.toLowerCase();
        const folders = document.querySelectorAll('.folders .folder');

        folders.forEach(folder => {
            const name = folder.querySelector('h5').textContent.toLowerCase();
            const department = folder.querySelector('.department').textContent.toLowerCase();

            if(name.includes(searchTerm) || department.includes(searchTerm)){
                folder.style.display = '';
            }else {
                folder.style.display = 'none';
            }
        })
    })
</script>