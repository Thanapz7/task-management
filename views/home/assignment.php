<?php
$this->title = 'Assignment';
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

</style>
<?php if(!Yii::$app->user->isGuest): ?>
    <h4 class="text-header">เพิ่มงาน</h4>
<?php else: ?>
    <h4 class="text-header">จ้างงาน</h4>
<?php endif; ?>
<br>
<div class="search-group">
    <div class="search-bar">
        <input type="search" id="mainSearch" placeholder="ค้นหา แฟ้มงาน หรือ แผนกที่ต้องการ" class="search">
        <i class="fa-solid fa-magnifying-glass search-icon"></i>
    </div>
</div>
<div class="row folders">
    <div class="col-sm-3 folder" style="cursor: pointer" '">
        <div style="margin: 10px">
            <div class="folder-head">
                <i class="fa-regular fa-folder"></i>
                <h5>งาน A</h5>
            </div>
            <p class="department" style="color: #454d55">
                แผนก : B
            </p>
        </div>
    </div>
    <div class="col-sm-3 folder" style="cursor: pointer" '">
        <div style="margin: 10px">
            <div class="folder-head">
                <i class="fa-regular fa-folder"></i>
                <h5>งาน C</h5>
            </div>
            <p class="department" style="color: #454d55">
                แผนก : D
            </p>
        </div>
    </div>
    <div class="col-sm-3 folder" style="cursor: pointer" '">
        <div style="margin: 10px">
            <div class="folder-head">
                <i class="fa-regular fa-folder"></i>
                <h5>แฟ้ม</h5>
            </div>
            <p class="department" style="color: #454d55">
                แผนก : DDS
            </p>
        </div>
    </div>
    <div class="col-sm-3 folder" style="cursor: pointer" '">
        <div style="margin: 10px">
            <div class="folder-head">
                <i class="fa-regular fa-folder"></i>
                <h5>งาน ABC</h5>
            </div>
            <p class="department" style="color: #454d55">
                แผนก : ABC
            </p>
        </div>
    </div>
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
