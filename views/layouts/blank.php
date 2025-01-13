<!DOCTYPE html>
<html lang="en">
<head>
    <title>เข้าสู่ระบบ</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Thai:wght@100..900&display=swap" rel="stylesheet">
    <style>
        body {
            background-color: #cccccc;
            color: white;
            font-family: "Noto Sans Thai", serif;
        }
        .w-100{
            width: 100%;
        }
        .info{
            margin-top: 300px;
            padding: 20px;
            display: flex;
            align-items: center;
            flex-direction: column;
            justify-content: center;
        }
        .logo {
            color: #95D2B3;
            margin: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 100px;
        }
        .login {
            background-color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 50px;
            height: 100vh;
        }
        .login form {
            width: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .login-form{
            color: #000000;
        }
        .form-group label{
            font-size: 20px;
        }
        .needed{
            color: #FF1317;
        }
        .btn-custom {
            background-color: #55AD9B;
            border: 1px solid #ffffff;
            margin-top: 20px;
            border-radius: 30px;
            padding: 10px 18px;
            width: 130px;
            color: white;
            font-size: 18px;
            font-weight: bold;
        }
        .btn-custom:hover {
            opacity: 0.8;
        }
        .divider {
            border-left: 10px solid white;
            height: 100%;
        }
        .form-control {
            border-radius: 20px;
            padding: 20px;
        }
        .password-input{
            position: relative;
        }
        .login-eye {
            position: absolute;
            right: 10px;
            top: 48px;
            color: #656565cc;
            cursor: pointer;
        }
        .forgot-pass p{
            text-decoration: underline;
            font-size: 16px;
            color: #656565cc;
        }
    </style>
</head>
<body>
<?= $content ?>
</body>
</html>