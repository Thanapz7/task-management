<?php
use app\assets\AppAsset;
use yii\helpers\Html;
AppAsset::register($this);

$this->title='work';

?>
<h4 class="text-header">แฟ้มของฉัน</h4>
<div class="row folders">
    <?php if (!empty($data)): ?>
        <?php foreach ($data as $item): ?>
            <?php if (!empty($item['forms'])): ?>
                <?php foreach ($item['forms'] as $form): ?>
                    <div class="col-xs-3 folder" style="cursor: pointer" onclick="location.href='<?= Yii::$app->urlManager->createUrl(['home/work-detail', 'id' => $form['id']]) ?>'">
                        <div style="margin: 10px">
                            <div class="folder-head">
                                <i class="fa-regular fa-folder-open"></i>
                                <h5><?= Html::encode($form['form_name'] ?? 'Unnamed Form') ?></h5>
                            </div>
                            <p class="department" style="color: #454d55">
                                แผนก : <?= Html::encode(strtoupper($item['department_name'] ?? 'N/A')) ?>
                            </p>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="text-center" style="border: 1px solid #cccccc; border-radius: 20px; padding: 30px"><h4 style="font-size: 20px">ไม่มีแฟ้ม</h4></div>
    <?php endif; ?>
</div>



