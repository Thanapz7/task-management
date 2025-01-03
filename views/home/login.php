<?php

use app\assets\AppAsset;
AppAsset::register($this);

?>
<?php $this->beginPage() ?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>
</head>
<body>
<div class="container">
    <div>
<!--            <span class="arcticons--jobbkk"></span>-->
            <h3>เข้าสู่ระบบ</h3>
            <form action="login.php" method="POST">
                username: <input type="text" name="username" placeholder="Enter your name"> <br>
                password: <input type="password" name="password" placeholder="Enter your password"> <br>
                <button type="submit">Login</button>
            </form>
    </div>

</div>
</body>>
</html>
