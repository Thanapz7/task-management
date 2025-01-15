<?php

use yii\helpers\Html;

$username = isset($this->params['username']) ? $this->params['username'] : 'Guest';
$department = isset($this->params['department']) ? $this->params['department'] : 'บุคคลภายนอก';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= Html::encode($this->title) ?></title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Thai:wght@100..900&display=swap" rel="stylesheet">
    <style>
        body{
            font-family: "Noto Sans Thai", serif;
        }
        /* Set height of the grid so .sidenav can be 100% (adjust if needed) */
        .row.content {height: 100vh}

        /* Set gray background color and 100% height */
        .sidenav {
            background-color: #f1f1f1;
            height: 100%;
        }
        .nav .nav-pills .nav-stacked li a{
            color:#ffffff ;
            font-weight: bold;
        }
        .logout{
            /*position: absolute;*/
            /*bottom: 15px;*/
            /*left: 110px;*/
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 30px;
            color: #FF1317;
            margin-top: 200px;
            cursor: pointer;
            transition: 0.3s;
        }
        .logout:hover{
            transform: scale(1.3);
        }
        .text-header{
            font-size: 30px;
            font-weight: bold;
            margin-top: 100px;
            margin-left: 30px;
        }
        .folder{
            padding: 10px;
            border: 1px solid #cccccc;
            border-radius: 15px;
            width:240px;
            height: 130px;
            margin:25px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
            transition: 0.3s;
        }
        .folder:hover{
            background-color: #B7E0FF;
        }
        .folders{
            margin: 30px;
        }
        .folder-head i{
            color: #95D2B3;
        }
        .folder-head-add{
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 5px;
        }
        .folder-head-add i{
            font-size: 30px;
            color: #95D2B3;
        }
        .folder-head-add h5{
            font-size: 19px;
            margin-left: 15px;
            font-weight: bold;
        }
        .actived{
            background-color: #95D2B3;
            border-radius: 10px;
            font-size: 19px;
        }
        .logo {
            color: #95D2B3;
            margin: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 50px;
        }
        .user-info{
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            margin-bottom: 10px ;
        }
        .folder-head{
            display: flex;
            flex-direction: row;
            padding: 5px;
        }
        .folder-head i{
            font-size: 30px;
        }
        .folder-head h5{
            font-size: 19px;
            margin-left: 15px;
            font-weight: bold;
        }
        .nav-fonts{
            color: #ffffff; !important;
            font-size: 19px;
            font-weight: bold;
        }
        .department{
            font-size: 20px;
        }
        .group-btn{
            display: flex;
            flex-direction: row;
            justify-content: end;
            margin-right: 100px;
        }
        .btn-d{
            font-size: 20px;
            font-weight: bold;
            padding: 10px;
            width: 120px;
            border-radius: 30px;
            border: 1px solid #ffffff;
            margin: 5px;
        }
        .btn-d:hover{
            opacity: 0.7;
        }
        .btn-show{
            background-color: #F0B754;
            color: #ffffff;
        }
        .btn-add{
            background-color: #B7E0FF;
            color: #ffffff;
        }


        /* On small screens, set height to 'auto' for sidenav and grid */
        @media screen and (max-width: 767px) {
            .sidenav {
                height: auto;
                padding: 15px;
            }
            .row.content {height: auto;}
        }
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="row content">
        <div class="col-sm-2 sidenav" style="background-color:#55AD9B;">
            <a class="logo"><i class="fa-solid fa-briefcase"></i></a>
            <div class="user-info">
                <p class="nav-fonts"><?= htmlspecialchars($username)?></p>
                <p class="nav-fonts">แผนก: <?= htmlspecialchars(strtoupper($department)) ?></p>
            </div>
            <ul class="nav nav-pills nav-stacked">
                <?php if (!Yii::$app->user->isGuest): ?>
                    <li><a href="<?= Yii::$app->urlManager->createUrl(['home/work']) ?>" class="nav-fonts"><i class="fa-regular fa-clipboard" style="margin-right: 10px;"></i>งาน</a></li>
                    <li><a href="<?= Yii::$app->urlManager->createUrl(['home/add-form']) ?>" class="nav-fonts"><i class="fa-regular fa-folder-open" style="margin-right: 10px;"></i>สร้างฟอร์ม</a></li>
                    <li><a href="<?= Yii::$app->urlManager->createUrl(['home/assigned']) ?>" class="nav-fonts"><i class="fa-solid fa-paper-plane" style="margin-right: 10px;"></i>งานที่มอบหมาย</a></li>
                    <li><a href="<?= Yii::$app->urlManager->createUrl(['home/assignment']) ?>" class="nav-fonts"><i class="fa-solid fa-circle-plus" style="margin-right: 10px;"></i>เพิ่มงาน</a></li>
                <?php else: ?>
                    <li><a href="<?= Yii::$app->urlManager->createUrl(['home/assignment']) ?>" class="nav-fonts"><i class="fa-solid fa-paper-plane" style="margin-right: 10px;"></i>จ้างงาน</a></li>
                <?php endif; ?>
            </ul>
            <div class="logout">
                <?= Html::a(
                    '<button type="submit" style="background: none; border: none">
                         <i class="fa-solid fa-power-off" style="color: #cc5555"></i>
                    </button>',
                            ['logout'],
                            [
                                'data-method' => 'post',
                                'data-confirm' => 'Are you sure you want to logout?',
                                'class' => 'logout-link',
                            ]
                ) ?>
            </div>

        </div>

        <div class="col-sm-10">
            <?= $content ?>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        // เมื่อคลิกที่เมนู
        $('.nav-pills li a').click(function() {
            // ลบคลาส active จากเมนูทั้งหมด
            $('.nav-pills li').removeClass('actived');

            // เพิ่มคลาส active ไปยังเมนูที่ถูกคลิก
            $(this).parent().addClass('actived');
        });
    });
</script>
</body>
</html>
