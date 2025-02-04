<?php
$this->title='Add Forms';
?>

<h4 class="text-header">เพิ่มแฟ้มงาน</h4>
<div class="row folders">
    <?php foreach ($forms as $form):?>
    <div class="col-xs-3 folder" style="cursor: pointer" onclick="location.href='<?= Yii::$app->urlManager->createUrl(['home/create-from-template', 'templateId' => $form->id]) ?>'">
        <div style="margin: 10px">
            <div class="folder-head">
                <i class="fa-regular fa-folder-open"></i>
                <h5><?= $form->form_name?></h5>
            </div>
                <p class="department" style="color: #5a6268">แม่แบบฟอร์ม <i class="fa-brands fa-wpforms"></i></p>
        </div>
    </div>
    <?php endforeach; ?>

    <form method="post" action="<?= \yii\helpers\Url::to(['home/add-form']) ?>">
        <?= \yii\helpers\Html::hiddenInput(Yii::$app->request->csrfParam, Yii::$app->request->getCsrfToken()) ?>
        <button type="submit" name="createForm" style="border:none; background-color: white;">
            <div class="col-xs-3 folder" style="cursor: pointer">
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

