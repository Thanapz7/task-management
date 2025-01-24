<?php

use yii\helpers\Html;

$this->title = 'Assigned Preview';
?>

<?= Html::button('<i class="fa-solid fa-arrow-left back-btn"></i>', [
    'class' => 'back-btn',
    'onclick' => 'window.history.back();',
    'encode' => false,
]) ?>
    <div class="assignment-preview">
        <div class="info text-center">
            <?php foreach ($results_info as $info):?>
                <h4>ชื่อแฟ้ม <?= htmlspecialchars($info['form_name']) ?></h4>
                <h4>ลงเมื่อวันที่ <?= htmlspecialchars((new DateTime($info['created_at']))->format('d/m/Y H:i')) ?></h4>
                <h4>แผนกที่ติดต่อ <?= htmlspecialchars(mb_strtoupper($info['department_name'])) ?></h4>
            <?php endforeach; ?>
        </div>
        <hr>
        <div class="apply">
            <?php foreach ($results as $result): ?>
                <div class="field-name">
                    <?= $result['field_name'] ?>
                </div>
                <div class="value" style="margin-bottom: 20px">
                    <?php
                        $value = $result['value'];
                        if(is_string($value) && is_array(json_decode($value, true))){
                            $decodedArray = json_decode($value, true);
                            $translateValue = array_map(function($item){
                                return json_decode('"'.$item.'"');
                            }, $decodedArray);
                            echo implode(', ', $translateValue);
                        }elseif(is_array($value)){
                            $translateValue = array_map(function($item){
                                return json_decode('"'.$item.'"');
                            }, $value);
                            echo implode(', ', $translateValue);
                        }else{
                            echo $value;
                        }
                    ?>
                </div>
            <?php endforeach; ?>
        </div>
        <hr style="margin-top: 20px;">
        <div class="contact text-right">
            <h5 class="applyer">ผู้กรอก : <span><?= $user->name?> <?= $user->lastname?></span></h5>
            <br class="for-print">
            <div class="for-print">
                <p>......................................</p>
                <p style="margin-right: 25px;">( <?= htmlspecialchars((new DateTime($info['created_at']))->format('d/m/Y')) ?> ) </p>
            </div>
        </div>
    </div>


<script>
    function printPage(){
        window.print();
    }
</script>

