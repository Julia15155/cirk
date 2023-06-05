<!DOCTYPE html>
<html>
<head>
    <title>Панель управления пользователя</title>
    <style>
        body {
            background-color: #e9f2f9; /* Изменение цвета фона на бледно голубой */
            padding: 20px;
        }
        /* Стили для шапки */
        header {
            background-color: #c8e0e9; /* Пастельно голубой цвет для шапки */
            padding: 20px 10px; /* Добавлен вертикальный отступ сверху и снизу */
            text-align: center;
        }
        
        header img {
            max-width: 150px; /* Максимальная ширина логотипа */
            display: block; /* Размещение логотипа в блочном стиле */
            margin-right: auto; /* Выравнивание логотипа по правому краю */
        }
        
        /* Стили для навигации */
        nav {
            background-color: #3498db; /* Синий цвет для панели навигации */
            color: #fff;
            padding: 10px;
        }
        
        nav ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
        }
        
        nav ul li {
            display: inline-block;
            margin-right: 10px;
        }
        
        nav ul li a {
            color: #fff;
            text-decoration: none;
            padding: 5px;
            font-size: 18px; /* Увеличение размера надписей в навигации */
            font-weight: bold; /* Добавление жирного стиля к надписям в навигации */
        }
        /* Стили для основной части страницы */
        main {
            padding: 400px;
            background-image: url("главная заставка.jpg"); /* Замените путь_к_картинке.jpg на путь к вашей картинке */
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }
        
        /* Стили для футера */
        footer {
            background-color: #c8e0e9; /* Пастельно голубой цвет для футера */
            padding: 20px;
            text-align: center;
            margin-top: 20px; /* Добавлен отступ сверху */
        }
    </style>
</head>
<body>
    <header>
        <img src="логотип.png" alt="Логотип">
    </header>
    
    <nav>
        <ul>
            <li><a href="perfomance.php">Представления</a></li>
            <li><a href="timetable.php">Расписание</a></li>
            <li><a href="mestopologenie.php">Местоположение</a></li>
        </ul>
    </nav>
    
    <main>
        <!-- Основная часть страницы -->
        <!--<h1>Добро пожаловать, <?php echo $username; ?>!</h1>
        <p>Здесь вы можете управлять своим профилем, настройками и другими функциями.</p>-->
    </main>
    
    <footer>
        &copy; 2023 Все права защищены.
    </footer>
</body>
</html>
