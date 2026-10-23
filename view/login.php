<?php
session_start();
?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login - ParkirKu</title>

    <style>

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: #f5f7fb;

            min-height: 100vh;

            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-container {
            width: 380px;

            background: white;

            padding: 35px;

            border-radius: 15px;

            box-shadow: 0 5px 25px rgba(0,0,0,.08);
        }

        .logo {
            text-align: center;

            font-size: 28px;

            font-weight: bold;

            color: #172b4d;

            margin-bottom: 8px;
        }

        .subtitle {
            text-align: center;

            color: #8993a4;

            font-size: 13px;

            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 18px;
        }

        label {
            display: block;

            margin-bottom: 7px;

            font-size: 13px;

            font-weight: bold;

            color: #344054;
        }

        input {
            width: 100%;

            padding: 12px 14px;

            border: 1px solid #dfe4ea;

            border-radius: 8px;

            outline: none;

            font-size: 14px;
        }

        input:focus {
            border-color: #2f80ed;

            box-shadow: 0 0 0 3px rgba(47,128,237,.10);
        }

        .btn-login {
            width: 100%;

            padding: 12px;

            border: none;

            border-radius: 8px;

            background: #2f80ed;

            color: white;

            font-size: 14px;

            font-weight: bold;

            cursor: pointer;
        }

        .btn-login:hover {
            background: #216bd0;
        }

        .error {
            background: #fff0f0;

            color: #d64545;

            padding: 10px;

            border-radius: 7px;

            font-size: 13px;

            margin-bottom: 18px;

            text-align: center;
        }

    </style>

</head>

<body>


<div class="login-container">

    <div class="logo">
        🚗 ParkirKu
    </div>

    <p class="subtitle">
        Sistem Informasi Parkir
    </p>


    <?php if (isset($_GET['error'])): ?>

        <div class="error">
            <?= htmlspecialchars($_GET['error']); ?>
        </div>

    <?php endif; ?>


    <form action="../controller/c_login.php" method="POST">


        <div class="form-group">

            <label>
                Username
            </label>

            <input
                type="text"
                name="username"
                placeholder="Masukkan username"
                required
            >

        </div>


        <div class="form-group">

            <label>
                Password
            </label>

            <input
                type="password"
                name="password"
                placeholder="Masukkan password"
                required
            >

        </div>


        <button
            type="submit"
            name="login"
            class="btn-login"
        >
            Login
        </button>


    </form>

</div>


</body>

</html>