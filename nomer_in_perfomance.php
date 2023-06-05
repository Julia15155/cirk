<?php
// Подключение к базе данных
$servername = "localhost";
$username = "yulyasc0_cirk";
$password = "Circus123";
$dbname = "yulyasc0_cirk";

$conn = new mysqli($servername, $username, $password, $dbname);

// Проверка соединения с базой данных
if ($conn->connect_error) {
    die("Ошибка подключения к базе данных: " . $conn->connect_error);
}

// Проверка наличия POST-запроса для добавления номера
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["add_number"])) {
    $nomerTitle = $_POST["nomer_title"];
    $genreId = $_POST["genre_id"];
    $performanceId = $_POST["performance_id"];

    // Вставка нового номера
    $insertNomerQuery = "INSERT INTO nomer (title, id_genre) VALUES (?, ?)";
    $stmt = $conn->prepare($insertNomerQuery);
    $stmt->bind_param("si", $nomerTitle, $genreId);
    if ($stmt->execute()) {
        $nomerId = $stmt->insert_id;

        // Связывание номера с представлением
        $insertNomerInPerformanceQuery = "INSERT INTO nomer_in_perfomance (id_perfomance, id_nomer) VALUES (?, ?)";
        $stmt = $conn->prepare($insertNomerInPerformanceQuery);
        $stmt->bind_param("ii", $performanceId, $nomerId);
        if ($stmt->execute()) {
            echo "Номер успешно добавлен.";
        } else {
            echo "Ошибка при связывании номера с представлением: " . $stmt->error;
        }
    } else {
        echo "Ошибка при добавлении номера: " . $stmt->error;
    }
    $stmt->close();
}

// Проверка наличия POST-запроса для редактирования номера
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["edit_number"])) {
    $nomerId = $_POST["nomer_id"];
    $nomerTitle = $_POST["nomer_title"];
    $genreId = $_POST["genre_id"];

    // Обновление номера
    $updateNomerQuery = "UPDATE nomer SET title = ?, id_genre = ? WHERE id_nomer = ?";
    $stmt = $conn->prepare($updateNomerQuery);
    $stmt->bind_param("sii", $nomerTitle, $genreId, $nomerId);
    if ($stmt->execute()) {
        echo "Номер успешно обновлен.";
    } else {
        echo "Ошибка при обновлении номера: " . $stmt->error;
    }
    $stmt->close();
}

// Проверка наличия POST-запроса для удаления номера
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["delete_number"])) {
    $nomerId = $_POST["nomer_id"];

    // Удаление связанных строк в таблице `nomer_in_perfomance`
    $deleteNomerInPerformanceQuery = "DELETE FROM nomer_in_perfomance WHERE id_nomer = ?";
    $stmt = $conn->prepare($deleteNomerInPerformanceQuery);
    $stmt->bind_param("i", $nomerId);
    if ($stmt->execute()) {
        // Удаление номера
        $deleteNomerQuery = "DELETE FROM nomer WHERE id_nomer = ?";
        $stmt = $conn->prepare($deleteNomerQuery);
        $stmt->bind_param("i", $nomerId);
        if ($stmt->execute()) {
            echo "Номер успешно удален.";
        } else {
            echo "Ошибка при удалении номера: " . $stmt->error;
        }
    } else {
        echo "Ошибка при удалении связанных строк в таблице `nomer_in_perfomance`: " . $stmt->error;
    }
    $stmt->close();
}

// Выполнение запроса для получения списка представлений, номеров и жанров
$sql = "SELECT p.id AS `performance_id`, p.title AS `performance_title`, n.id_nomer, n.title AS `nomer_title`, g.id_genre, g.title AS `genre_title`
        FROM `nomer_in_perfomance` nip
        JOIN perfomance p ON nip.id_perfomance = p.id
        JOIN nomer n ON nip.id_nomer = n.id_nomer
        JOIN genre g ON n.id_genre = g.id_genre
        ORDER BY p.title";

$result = $conn->query($sql);

// Проверка результатов запроса
if ($result->num_rows > 0) {
    // Вывод представлений, номеров и их жанров
    echo "<html>
<head>
    <title>Список представлений и номеров</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }

        h1 {
            margin-bottom: 20px;
        }

        .performance {
            margin-bottom: 20px;
            border: 1px solid;
            padding: 10px;
        }

        .performance:nth-child(odd) {
            background-color: #EADFF7; /* Светлый цвет фона для нечетных представлений */
        }

        .performance:nth-child(even) {
            background-color: #BDC5FF; /* Светлый цвет фона для четных представлений */
        }

        .performance-title {
            font-size: 20px;
            font-weight: bold;
        }

        .nomer {
            margin-top: 10px;
        }

        .nomer-title {
            font-size: 16px;
            font-weight: bold;
        }

        .genre-title {
            margin-top: 5px;
            margin-left: 20px;
            font-size: 14px;
        }

        .edit-form,
        .delete-form {
            margin-top: 10px;
        }

        .edit-form input[type='text'],
        .edit-form select,
        .delete-form input[type='submit'] {
            margin-top: 5px;
        }

        .add-form {
            margin-top: 20px;
        }

        .add-form input[type='text'],
        .add-form select,
        .add-form input[type='submit'] {
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <h1>Управление номерами</h1>";

    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $stmt->bind_result($performanceId, $performanceTitle, $nomerId, $nomerTitle, $genreId, $genreTitle);

    $currentPerformance = '';
    while ($stmt->fetch()) {
        if ($performanceTitle !== $currentPerformance) {
            // Начало нового представления
            if ($currentPerformance !== '') {
                echo "</div>"; // Закрыть блок номера и представления
            }
            echo "<div class='performance' style='border-color: #" . substr(md5($performanceTitle), 0, 6) . "'>
                    <div class='performance-title'>Представление: " . $performanceTitle . "</div>";
            $currentPerformance = $performanceTitle;
        }

        echo "<div class='nomer'>
                <div class='nomer-title'>Номер: " . $nomerTitle . "</div>
                <div class='genre-title'>Жанр: " . $genreTitle . "</div>";

        // Форма редактирования номера
        echo "<form class='edit-form' method='post' action='" . $_SERVER["PHP_SELF"] . "'>
                <input type='hidden' name='nomer_id' value='" . $nomerId . "'>
                <input type='text' name='nomer_title' value='" . $nomerTitle . "' placeholder='Название номера' required>
                <select name='genre_id' required>";
        // Получение списка жанров
        $genresQuery = "SELECT * FROM genre";
        $genresResult = $conn->query($genresQuery);
        if ($genresResult->num_rows > 0) {
            while ($genreRow = $genresResult->fetch_assoc()) {
                $selected = ($genreRow["id_genre"] == $genreId) ? "selected" : "";
                echo "<option value='" . $genreRow["id_genre"] . "' " . $selected . ">" . $genreRow["title"] . "</option>";
            }
        }
        echo "</select>
                <input type='submit' name='edit_number' value='Редактировать'>
            </form>";

        // Форма удаления номера
        echo "<form class='delete-form' method='post' action='" . $_SERVER["PHP_SELF"] . "' onsubmit='return confirm(\"Вы уверены, что хотите удалить номер?\")'>
                <input type='hidden' name='nomer_id' value='" . $nomerId . "'>
                <input type='submit' name='delete_number' value='Удалить'>
            </form>
        </div>";
    }
    echo "</div>"; // Закрыть блок номера и представления

    // Форма добавления нового номера
    echo "<form class='add-form' method='post' action='" . $_SERVER["PHP_SELF"] . "'>
            <h2>Добавить номер</h2>
            <input type='text' name='nomer_title' placeholder='Название номера' required>
            <select name='genre_id' required>";
    // Получение списка жанров
    $genresQuery = "SELECT * FROM genre";
    $genresResult = $conn->query($genresQuery);
    if ($genresResult->num_rows > 0) {
        while ($genreRow = $genresResult->fetch_assoc()) {
            echo "<option value='" . $genreRow["id_genre"] . "'>" . $genreRow["title"] . "</option>";
        }
    }
    echo "</select>
            <select name='performance_id' required>";
    // Получение списка представлений
    $performanceQuery = "SELECT * FROM perfomance";
    $performanceResult = $conn->query($performanceQuery);
    if ($performanceResult->num_rows > 0) {
        while ($performanceRow = $performanceResult->fetch_assoc()) {
            echo "<option value='" . $performanceRow["id"] . "'>" . $performanceRow["title"] . "</option>";
        }
    }
    echo "</select>
            <input type='submit' name='add_number' value='Добавить'>
        </form>";

    echo "</body>
</html>";

    $stmt->close();
} else {
    echo "Нет доступных данных.";
}

$conn->close();
?>
