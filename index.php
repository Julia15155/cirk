<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="style/style.css">
    <style>
        /* Дополнительные CSS стили */
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            width: 300px;
            padding: 20px;
            background-color: #c8e0e9;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .container p {
            font-size: 18px;
            margin-bottom: 20px;
        }

        h1 {
            margin-bottom: 20px;
        }

        form {
            margin-top: 20px;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        input[type="submit"] {
            width: 100%;
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px;
            cursor: pointer;
            border-radius: 5px;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        p {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Добро пожаловать <br>на сайт цирка</h1>
        <p>Для дальнейшей работы необходимо авторизоваться.</p>
        <form method="post" action="login.php"> 
            <input type="text" name="username" placeholder="Логин или Email">
            <input type="password" name="password" placeholder="Пароль">
            <input type="submit" value="Войти">
        </form>
        <p>Еще нет аккаунта? <a href="registration.html">Зарегистрируйтесь</a></p>
    </div>
</body>
</html>
 
