<!DOCTYPE html>
<html>
<head>
    <title>Страница администратора</title>
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
            padding: 20px; /* Обновлен отступ для основной части */
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            font-size: 20px; /* Увеличение размера шрифта на основной части страницы */
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
        <h1>Страница администратора</h1>
        <!-- Навигационное меню -->
        <nav>
            <ul>
                <li><a href="ismen_perfomance.php">Управление представлениями</a></li>
                <li><a href="manage_actors.php">Управление актёрами</a></li>
                <li><a href="nomer_in_perfomance.php">Номера в представлениях</a></li>
                <li><a href="manage_tickets.php">Статистика по проданным билетам</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <h1>Добро пожаловать на главную страницу администратора!</h1>
        <p>Здесь вы можете управлять и администрировать различные аспекты системы.</p>
        <ul>
            <li>Добавлять, редактировать и удалять представления</li>
            <li>Добавлять и удалять актёров</li>
            <li>Добавлять новые номера в представления</li>
            <li>Статистика по билетам: изменять количество проданных, просматривать текущую выручку по представлению</li>
        </ul>
        <p>Воспользуйтесь навигационным меню для перехода к нужным разделам.</p>
    </main>

    <footer>
        <p>&copy; 2023 Звёздный цирк. Все права защищены.</p>
    </footer>
</body>
</html>
