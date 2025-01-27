<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Assigned';
?>

<h4 class="text-header">รายการงานที่มอบหมาย</h4>
<br>
<div class="search-group">
    <div class="search-bar">
        <input type="search" id="mainSearch" placeholder="ค้นหาข้อมูลที่ต้องการ" class="search">
        <i class="fa-solid fa-magnifying-glass search-icon"></i>
    </div>
</div>

<div class="grid" style="margin-left: 20px; margin-top: 20px;">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            [
                'attribute' => 'record_created_at',
                'label' => 'วัน/เดือน/ปี',
                'value' => function ($model) {
                    return Yii::$app->formatter->asDate($model['record_created_at'], 'php:d/m/Y');
                },
                'contentOptions' => ['style' => 'width: 13%; text-align: center;'],
                'headerOptions' => ['class' => 'custom-table-header'],
            ],
            [
                'attribute' => 'creator_department_name',
                'label' => 'แผนกที่ติดต่อ',
                'value' => function ($model) {
                    return mb_strtoupper($model['creator_department_name']);
                },
                'contentOptions' => ['style' => 'width: 30%; text-align: center;'],
                'headerOptions' => ['class' => 'custom-table-header'],
            ],
            [
                'attribute' => 'form_name',
                'label' => 'แฟ้ม',
                'contentOptions' => ['style' => 'width: 47%; text-align: center;'],
                'headerOptions' => ['class' => 'custom-table-header'],
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{preview} {download}',
                'header' => '<i class="fa-solid fa-file-circle-check"></i>',
                'buttons' => [
                    'preview' => function ($url, $model) {
                        return Html::a(
                            '<i class="fa-regular fa-file"></i>',
                            Url::to(['home/assigned-preview', 'id' => $model['id']]),
                            ['class' => 'manage-link']
                        );
                    },
                    'download' => function ($url, $model) {
                        return Html::a(
                            '<i class="fa-solid fa-circle-down"></i>',
                            '#',
                            [
                                'class' => 'manage-link',
                                'data-id' => $model['id'],
                                'onclick' => "printPreview('" . Url::to(['home/assigned-preview', 'id' => $model['id']]) . "'); return false;",
                            ]
                        );
                    },
                ],
                'contentOptions' => ['style' => 'width: 10%; text-align: center;'],
                'headerOptions' => ['class' => 'custom-table-header'],
            ],
        ],
        'tableOptions' => ['class' => 'table table-bordered'],
        'summary' => 'แสดง {begin} ถึง {end} จากทั้งหมด {totalCount} รายการ',
        'emptyText' => 'ไม่มีข้อมูลการสั่งงาน',
        'emptyTextOptions' => ['class' => 'text-center'],
    ]); ?>
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
        var printWindow = window.open(url);
        printWindow.onload = function (){
            printWindow.print();
        }
    }
</script>
