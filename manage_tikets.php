<!DOCTYPE html>
<html>
<head>
    <title>Управление билетами</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            background-color: #e9f2f9;
            padding: 20px;
        }

        h1 {
            text-align: center;
        }

        table {
            margin-top: 20px;
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

        canvas {
            margin-top: 20px;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
            display: block;
        }
    </style>
</head>
<body>
    <h1>Статистика по проданным билетам</h1>

    <table>
        <tr>
            <th>Название представления</th>
            <th>Дата начала</th>
            <th>Дата окончания</th>
            <th>Цена</th>
            <th>Общее количество билетов</th>
            <th>Продано билетов</th>
            <th>Выручка</th>
        </tr>
        <?php
            // Подключение к базе данных и получение данных
            $servername = "localhost";
            $username = "yulyasc0_cirk";
            $password = "Circus123";
            $dbname = "yulyasc0_cirk";

            $conn = new mysqli($servername, $username, $password, $dbname);

            if ($conn->connect_error) {
                die("Ошибка подключения к базе данных: " . $conn->connect_error);
            }

            $sql = "SELECT * FROM perfomance";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['title'] . "</td>";
                    echo "<td>" . $row['start_date'] . "</td>";
                    echo "<td>" . $row['end_date'] . "</td>";
                    echo "<td>" . $row['price'] . "</td>";
                    echo "<td>" . $row['kolichestvo_biletov'] . "</td>";
                    echo "<td><input type='number' value='" . $row['kolichestvo_prodannix_biletov'] . "' data-id='" . $row['id'] . "' onchange='updateTickets(this)'></td>";
                    echo "<td>" . ($row['price'] * $row['kolichestvo_prodannix_biletov']) . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4'>Нет доступных представлений.</td></tr>";
            }

            $conn->close();
        ?>
    </table>

    <canvas id="ticketChart" width="800" height="400"></canvas>

    <script>
        // Получение данных для графика из PHP
        <?php
            $conn = new mysqli($servername, $username, $password, $dbname);

            if ($conn->connect_error) {
                die("Ошибка подключения к базе данных: " . $conn->connect_error);
            }

            $sql = "SELECT title, kolichestvo_prodannix_biletov FROM perfomance";
            $result = $conn->query($sql);

            $labels = [];
            $data = [];

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $labels[] = $row['title'];
                    $data[] = $row['kolichestvo_prodannix_biletov'];
                }
            }

            $conn->close();
        ?>

        // Создание графика
        var ctx = document.getElementById('ticketChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($labels); ?>,
                datasets: [{
                    label: 'Проданные билеты',
                    data: <?php echo json_encode($data); ?>,
                    backgroundColor: 'rgba(54, 162, 235, 0.5)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        stepSize: 1
                    }
                }
            }
        });

        // Функция для обновления количества проданных билетов
        function updateTickets(input) {
            var id = input.dataset.id;
            var quantity = input.value;

            // Отправка AJAX-запроса на обновление данных
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'update_tickets.php', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                if (xhr.status === 200) {
                    // Обновление графика после успешного обновления данных
                    myChart.data.datasets[0].data = JSON.parse(xhr.responseText);
                    myChart.update();
                }
            };
            xhr.send('id=' + id + '&quantity=' + quantity);
        }
    </script>
</body>
</html>
