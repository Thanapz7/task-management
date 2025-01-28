<?php

use yii\helpers\Html;

$this->title = "Assigned";
?>

<h4 class="text-header">งานที่สั่ง</h4>

<h5 class="ml-5 text-key" style="margin-top: 10px">ค้นหางานด้วยคีย์ <i class="fa-solid fa-key" style="color: #55AD9B"></i>์</h5>
<div class="search-form ml-5">
    <?= Html::beginForm('assigned', 'get', ['class' => 'form-inline']) ?>
        <div class="form-group">
            <?= Html::textInput('auth_key', $authKey ?? '', ['class' => 'form-control search', 'placeholder' => '   กรอกคีย์ของคุณ','style'=>'width:350px']) ?>
        </div>
        <?= Html::submitButton('ค้นหา', ['class' => 'btn btn-key']) ?>
    <?= Html::endForm() ?>
</div>

<?php if ($record):?>
    <div class="assignment-preview-key" style="width: auto">
        <div class="apply">
            <?php foreach ($record as $result): ?>
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
            <div class="group-btn-preview text-center" style="margin-top: -10px; background-color: ">
                <button type="submit" class="btn-d-preview btn-preview-detail" onclick="printPage()">ดาวน์โหลด</button>
            </div>
        </div>
    </div>
<?php endif; ?>

<script>
    function printPage(){
        window.print();
    }
</script>

