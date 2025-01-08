<?php
use yii\grid\GridView;
use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'All Users';
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view-all">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
//            ['class' => 'yii\grid\SerialColumn'], // เพิ่มลำดับที่
            'id',
            'username',
            'role',

            [
                'class' => 'yii\grid\ActionColumn', // เพิ่มปุ่ม View, Update, Delete
                'buttons' => [
                    'view' => function ($url, $model, $key) {
                        return Html::a('View', $url, ['class' => 'btn btn-primary btn-sm']);
                    },
                    'update' => function ($url, $model, $key) {
                        return Html::a('Update', ['user/update', 'id' => $model->id], [
                            'class' => 'btn btn-warning btn-sm'
                        ]);
                    },
                    'delete' => function ($url, $model, $key) {
                        return Html::a('Delete', $url, [
                            'class' => 'btn btn-danger btn-sm',
                            'data' => [
                                'confirm' => 'Are you sure you want to delete this user?',
                                'method' => 'post',
                            ],
                        ]);
                    },
                ],
            ],
        ],
    ]); ?>

</div>
