<?php
// Подключение к базе данных
$servername = "localhost";
$username = "yulyasc0_cirk";
$password = "Circus123";
$dbname = "yulyasc0_cirk";

$conn = new mysqli($servername, $username, $password, $dbname);

// Обработка запроса на удаление представления
if (isset($_GET['delete'])) {
    $viewId = $_GET['delete'];
    $sql = "DELETE FROM perfomance WHERE id = $viewId";
    $conn->query($sql);
}

// Обработка запроса на добавление или редактирование представления
if (isset($_POST['save']) || isset($_POST['add'])) {
    $viewId = $_POST['view_id'];
    $newTitle = $_POST['title'];
    $newStartDate = $_POST['start_date'];
    $newEndDate = $_POST['end_date'];
    $newDescription = $_POST['description']; // Новое поле описания
    $newPrice = $_POST['price']; // Новое поле цены
    $newImage = $_FILES['image'];

    // Проверка загруженного изображения
    if (isset($newImage) && $newImage['error'] === UPLOAD_ERR_OK) {
        $imagePath = 'uploads/' . $newImage['name'];
        move_uploaded_file($newImage['tmp_name'], $imagePath);
    } else {
        $imagePath = '';
    }

    if ($viewId) {
        // Редактирование представления
        $sql = "UPDATE perfomance SET title = '$newTitle', start_date = '$newStartDate', end_date = '$newEndDate', description = '$newDescription', price = '$newPrice', image_url = '$imagePath' WHERE id = $viewId";
    } else {
        // Добавление нового представления
        $sql = "INSERT INTO perfomance (title, start_date, end_date, description, price, image_url) VALUES ('$newTitle', '$newStartDate', '$newEndDate', '$newDescription', '$newPrice', '$imagePath')";
    }

    $conn->query($sql);
}

// Получение списка представлений из базы данных
$sql = "SELECT * FROM perfomance";
$result = $conn->query($sql);
$views = $result->fetch_all(MYSQLI_ASSOC);

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Список представлений</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1 class="mt-4 mb-4">Управление представлениями</h1>

        <!-- Форма для добавления/редактирования представления -->
        <form method="POST" action="" enctype="multipart/form-data">
            <input type="hidden" name="view_id" value="">
            <div class="form-group">
                <label for="title">Название представления</label>
                <input type="text" class="form-control" id="title" name="title" placeholder="Введите название представления">
            </div>
            <div class="form-group">
                <label for="start_date">Дата начала</label>
                <input type="date" class="form-control" id="start_date" name="start_date" placeholder="Выберите дату начала">
            </div>
            <div class="form-group">
                <label for="end_date">Дата окончания</label>
                <input type="date" class="form-control" id="end_date" name="end_date" placeholder="Выберите дату окончания">
            </div>
            <div class="form-group">
                <label for="description">Описание представления</label>
                <textarea class="form-control" id="description" name="description" placeholder="Введите описание представления"></textarea>
            </div>
            <div class="form-group">
                <label for="price">Цена представления</label>
                <input type="text" class="form-control" id="price" name="price" placeholder="Введите цену представления">
            </div>
            <div class="form-group">
                <label for="image">Изображение представления</label>
                <input type="file" class="form-control-file" id="image" name="image" accept="image/*">
            </div>
            <?php if (isset($_POST['add'])): ?>
                <button type="submit" class="btn btn-primary" name="add">Добавить</button>
            <?php else: ?>
                <button type="submit" class="btn btn-primary" name="save">Сохранить</button>
            <?php endif; ?>
        </form>

        <!-- Список представлений -->
        <div class="row">
            <?php foreach ($views as $view): ?>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <?php if (!empty($view['image_url'])): ?>
                            <img src="<?php echo $view['image_url']; ?>" class="card-img-top" alt="Изображение представления">
                        <?php endif; ?>
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $view['title']; ?></h5>
                            <p class="card-text"><?php echo $view['description']; ?></p>
                            <p class="card-text">Цена: <?php echo $view['price']; ?></p>
                            <a href="?delete=<?php echo $view['id']; ?>" class="btn btn-danger">Удалить</a>
                            <a href="#" onclick="editView('<?php echo $view['id']; ?>', '<?php echo $view['title']; ?>', '<?php echo $view['start_date']; ?>', '<?php echo $view['end_date']; ?>', '<?php echo $view['description']; ?>')" class="btn btn-primary">Редактировать</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <script>
        function editView(id, title, startDate, endDate, description) {
            document.querySelector('input[name="view_id"]').value = id;
            document.querySelector('input[name="title"]').value = title;
            document.querySelector('input[name="start_date"]').value = startDate;
            document.querySelector('input[name="end_date"]').value = endDate;
            document.querySelector('textarea[name="description"]').value = description;
        }
    </script>
</body>
</html>
