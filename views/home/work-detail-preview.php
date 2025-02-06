<?php

use yii\helpers\Html; ?>

<?= Html::button('<i class="fa-solid fa-arrow-left back-btn"></i>', [
    'class' => 'back-btn',
    'onclick' => 'window.history.back();',
    'encode' => false,
]) ?>
<!--<p>แสดงข้อมูลสำหรับ Record ID: --><?php //= Html::encode(Yii::$app->request->get('id')) ?><!--</p>-->

<div style="margin-left: 20px;">
    <div class="detail-preview pad-lr20">
        <div class="info text-center">
            <?php if (!empty($data)): ?>
                <h4>รายละเอียดข้อมูล - <?= Html::encode($data[0]['form_name'])?></h4>
            <?php endif; ?>
            <?php if(!empty($resultsinfo)):?>
                <?php foreach ($resultsinfo as $info): ?>
                    <h4>ผู้กรอก : <?= htmlspecialchars($info['name'])?> <?= htmlspecialchars($info['lastname'])?> | แผนก : <?= htmlspecialchars(mb_strtoupper($info['department_name']))?></h4>
                    <h4>วันที่กรอก : <?= htmlspecialchars((new DateTime($info['create_at']))->format('d/m/y H:i'))?></h4>
                <?php endforeach; ?>
            <?php else: ?>
                <h4>ผู้กรอก : บุคคลภายนอก</h4>
            <?php endif; ?>
        </div>
        <div class="apply">
            <?php foreach ($data as $item): ?>
                <div class="field-name">
                    <?= Html::encode($item['field_name']) ?>
                </div>
                <div class="value" style="margin-bottom: 20px;">
                    <?php
                    $value = $item['value'];
                    // ตรวจสอบว่าเป็น path ของไฟล์ภาพในโฟลเดอร์ uploads หรือไม่
                    if (strpos($value, 'uploads/') === 0) {
                        $fileInfo = pathinfo($value);
                        $fileExtension = isset($fileInfo['extension']) ? strtolower($fileInfo['extension']) : '';

                        if (in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif'])) {
                            // สร้าง URL ที่สามารถเข้าถึงได้จากเว็บ
                            $fileUrl = Yii::getAlias('@web/' . $value);
                            echo '<img src="' . $fileUrl . '" alt="Image" class="mx-auto d-block" style="margin:auto; display:block;" width="500">';
                        } elseif ($fileExtension === 'pdf') {
                            // ถ้าเป็นไฟล์ PDF แสดงลิงก์ให้ดาวน์โหลด
                            $fileUrl = Yii::getAlias('@web/' . $value);
                            echo '<a href="' . $fileUrl . '" target="_blank" class="btn btn-primary show-info">เปิดไฟล์ PDF</a>';
                            echo '<iframe src="'. $fileUrl .'" width="100%" height="600px" class="show-info"></iframe>';
                        } elseif (in_array($fileExtension, ['xls', 'xlsx', 'doc', 'docx', 'ppt', 'pptx', 'txt', 'csv'])) {
                            $fileUrl = Yii::getAlias('@web/' . $value);
                            echo '<a href="'. $fileUrl . '" target="_blank" class="btn btn-primary show-info">เปิดไฟล์</a>';

                        } else {
                            // ถ้าไม่ใช่ไฟล์ภาพหรือ PDF แสดงข้อความหรือข้อมูลอื่น ๆ
                            echo Html::encode($value);
                        }
                    } elseif (is_string($value) && is_array(json_decode($value, true))) {
                        $decodedArray = json_decode($value, true);
                        $translateValue = array_map(function($item) {
                            return json_decode('"' . $item . '"');
                        }, $decodedArray);
                        echo implode(', ', $translateValue);
                    } elseif (is_array($value)) {
                        $translateValue = array_map(function($item) {
                            return json_decode('"' . $item . '"');
                        }, $value);
                        echo implode(', ', $translateValue);
                    } else {
                        echo Html::encode($value);
                    }
                    ?>
                </div>
            <?php endforeach; ?>
        </div>

    </div>
</div>

<div class="group-btn-preview text-center" style="margin-top: -16px;">
    <button type="submit" class="btn-d-preview btn-preview-detail" onclick="printPage()">ดาวน์โหลด</button>
</div>

<script>
    function printPage(){
        window.print();
    }
</script>



