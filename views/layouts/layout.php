<?php

use yii\helpers\Html;

$username = isset($this->params['username']) ? $this->params['username'] : 'Guest';
$department = isset($this->params['department']) ? $this->params['department'] : 'บุคคลภายนอก';

\app\assets\AppAsset::register($this);
?>



<?php $this->beginPage() ?>

    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= Html::encode($this->title) ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Thai:wght@100..900&display=swap" rel="stylesheet">
        <?php $this->head() ?>
    </head>
    <body>
    <?php $this->beginBody() ?>
    <div class="container-fluid">
        <div class="row content">
            <div class="col-md-2 sidenav" style="background-color:#55AD9B;">
                <a href="<?= Yii::$app->urlManager->createUrl(['home/work'])?>" class="logo d-flex align-items-center">
                    <i class="fa-solid fa-briefcase"></i>
                </a>
                <div class="user-info mb-4">
                    <p class="nav-fonts mb-1"><?= htmlspecialchars($username)?></p>
                    <p class="nav-fonts mb-1">แผนก: <?= !empty($department) ? htmlspecialchars(mb_strtoupper($department)) : 'บุคคลภายนอก'?></p>
                </div>
                <ul class="nav flex-column">
                    <?php if (!Yii::$app->user->isGuest): ?>
                        <li class="<?= Yii::$app->controller->id ==='home' && Yii::$app->controller->action->id ==='work' ? 'actived' : '' ?> nav-item">
                            <a href="<?= Yii::$app->urlManager->createUrl(['home/work']) ?>" class="nav-link nav-fonts"><i class="fa-regular fa-clipboard" style="margin-right: 10px;"></i>งาน</a>
                        </li>
                        <li class="<?= Yii::$app->controller->id === 'home' && Yii::$app->controller->action->id === 'add-form' ? 'actived' : '' ?> nav-item">
                            <a href="<?= Yii::$app->urlManager->createUrl(['home/add-form']) ?>" class="nav-link nav-fonts"><i class="fa-regular fa-folder-open" style="margin-right: 10px;"></i>สร้างฟอร์ม</a>
                        </li>
                        <li class="<?= Yii::$app->controller->id === 'home' && Yii::$app->controller->action->id === 'assigned' ? 'actived' : '' ?> nav-item">
                            <a href="<?= Yii::$app->urlManager->createUrl(['home/assigned']) ?>" class="nav-link nav-fonts"><i class="fa-solid fa-paper-plane" style="margin-right: 10px;"></i>งานที่มอบหมาย</a>
                        </li>
                        <li class="<?= Yii::$app->controller->id === 'home' && Yii::$app->controller->action->id === 'assignment' ? 'actived' : '' ?> nav-item">
                            <a href="<?= Yii::$app->urlManager->createUrl(['home/assignment']) ?>" class="nav-link nav-fonts"><i class="fa-solid fa-circle-plus" style="margin-right: 10px;"></i>เพิ่มงาน</a>
                        </li>
                    <?php else: ?>
                        <li class="<?= Yii::$app->controller->id === 'job' && Yii::$app->controller->action->id === 'assignment' ? 'actived' : '' ?> nav-item">
                            <a href="<?= Yii::$app->urlManager->createUrl(['job/assignment']) ?>" class="nav-link nav-fonts"><i class="fa-solid fa-paper-plane" style="margin-right: 10px;"></i>จ้างงาน</a>
                        </li>
                        <li class="<?= Yii::$app->controller->id === 'job' && Yii::$app->controller->action->id === 'assigned' ? 'actived' : '' ?> nav-item">
                            <a href="<?= Yii::$app->urlManager->createUrl(['job/assigned']) ?>" class="nav-link nav-fonts"><i class="fa-solid fa-scroll" style="margin-right: 10px;"></i>งานที่สั่ง</a>
                        </li>
                    <?php endif; ?>
                </ul>
                <div class="logout">
                    <?= Html::beginForm(['logout'], 'post', ['onsubmit' => 'return confirm("ต้องการออกจากระบบ ? ")']) ?>
                    <button type="submit" style="background: none; border: none">
                        <i class="fa-solid fa-power-off" style="color: #cc5555"></i>
                    </button>
                    <?= Html::endForm() ?>
                </div>
            </div>

            <div class="col-sm-10 main-content">
                <?= $content ?>
            </div>
        </div>
    </div>
    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage() ?>