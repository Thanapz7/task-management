<?php
$this->title='Add Forms';
?>

<h4 class="text-header">เพิ่มแฟ้มงาน</h4>
<div class="row folders">
    <?php foreach ($forms as $form):?>
    <div class="col-sm-3 folder" style="cursor: pointer">
        <div style="margin: 10px">
            <div class="folder-head">
                <i class="fa-regular fa-folder"></i>
                <h5><?= $form->form_name?></h5>
            </div>
            <p class="department">แผนก:
                <?php
                    if($form->users->department == 1){
                        echo 'SALE';
                    }elseif($form->users->department == 2){
                        echo 'DDS';
                    }elseif($form->users->department == 3){
                        echo 'HR';
                    }elseif($form->users->department == 4){
                        echo 'MARKETING';
                    }else{
                        echo'แผนกอื่น';
                    }
                ?>
            </p>
        </div>
    </div>
    <?php endforeach; ?>

    <form method="post" action="<?= \yii\helpers\Url::to(['home/add-form']) ?>">
        <?= \yii\helpers\Html::hiddenInput(Yii::$app->request->csrfParam, Yii::$app->request->getCsrfToken()) ?>
        <button type="submit" name="createForm" style="border:none; background-color: white;">
            <div class="col-sm-3 folder" style="cursor: pointer">
                <div style="margin: 10px">
                        <div class="folder-head-add">
                            <i class="fa-solid fa-folder-plus"></i>
                            <h5>สร้างฟอร์ม</h5>
                        </div>
                </div>
            </div>
        </button>
    </form>

</div>
<!--<div class="group-btn">-->
<!--    <button type="submit" class="btn-d btn-show">แสดง</button>-->
<!--    <button type="submit" class="btn-d btn-add">เพิ่ม</button>-->
<!--</div>-->
