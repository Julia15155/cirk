<!DOCTYPE html>
<html>
<head>
    <title>Местоположение</title>
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
            min-height: 228px;
        }
        
        header img {
            max-width: 150px; /* Максимальная ширина логотипа */
            display: block; /* Размещение логотипа в блочном стиле */
            margin-right: auto; /* Выравнивание логотипа по правому краю */
        }

        
        /* Стили для футера */
        footer {
            background-color: #c8e0e9; /* Пастельно голубой цвет для футера */
            padding: 20px;
            text-align: center;
            margin-top: 20px; /* Добавлен отступ сверху */
        }
        /* Стили для карты */
        #map {
            height: 400px;
            width: 400px; /* Установите одинаковые значения для высоты и ширины, чтобы сделать карту квадратной */
            margin: 0 auto; /* Добавляем автоматические отступы слева и справа для выравнивания карты по центру */
            margin-bottom: 20px; /* Добавляем отступ снизу для адреса */
        }
    </style>
    <!-- Подключение API Яндекс.Карт -->
    <script src="https://api-maps.yandex.ru/2.1/?apikey=c2968433-f16f-46d6-9330-b02a9019642f&lang=ru_RU" type="text/javascript"></script>
</head>
<body>
    <header>
        <img src="логотип.png" alt="Логотип">
        <h1>Местоположение</h1>
        <div id="map-header"></div>
    </header>

    <h1></h1>
    <div id="map"></div>

    <!-- Добавление блока для адреса точки -->
    <div id="address"></div>

    <script>
        // Функция для инициализации карты в шапке
        function initHeaderMap() {
            // Координаты метки в шапке
            var headerCoords = [55.845441, 37.489338];

            // Создание карты в шапке
            var headerMap = new ymaps.Map("map-header", {
                center: headerCoords,
                zoom: 12
            });

            // Создание метки в шапке
            var headerPlacemark = new ymaps.Placemark(headerCoords, {
                hintContent: '',
                balloonContent: 'Москва, Пулковская улица, 10'
            });

            // Добавление метки в шапке на карту
            headerMap.geoObjects.add(headerPlacemark);
        }

        // Функция для инициализации основной карты
        function initMainMap() {
            // Координаты метки в основной части
            var mainCoords = [55.845441, 37.489338];

            // Создание основной карты
            var mainMap = new ymaps.Map("map", {
                center: mainCoords,
                zoom: 12
            });

            // Создание метки в основной части
            var mainPlacemark = new ymaps.Placemark(mainCoords, {
                hintContent: '',
                balloonContent: 'Москва, Пулковская улица, 10'
            });

            // Добавление метки в основную часть на карту
            mainMap.geoObjects.add(mainPlacemark);

            // Получение адреса по координатам
            ymaps.geocode(mainCoords).then(function (res) {
                // Извлечение объекта с полной информацией об адресе
                var addressObject = res.geoObjects.get(0).getAddress();

                // Вывод адреса под картой
                document.getElementById('address').innerHTML = 'Адрес: ' + addressObject.text;
            });
        }

        // Загрузка API Яндекс.Карт и инициализация карт
        ymaps.ready(function () {
            initHeaderMap();
            initMainMap();
        });
    </script>
</body>
</html>
