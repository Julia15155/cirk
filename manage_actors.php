<?php
// Подключение к базе данных
$servername = "localhost";
$username = "yulyasc0_cirk";
$password = "Circus123";
$dbname = "yulyasc0_cirk";

$conn = new mysqli($servername, $username, $password, $dbname);

// Обработка запроса на удаление актера
if (isset($_GET['delete'])) {
    $actorId = $_GET['delete'];
    $sql = "DELETE FROM actor WHERE id_actor = $actorId";
    $conn->query($sql);
}

// Обработка запроса на добавление актера
if (isset($_POST['add'])) {
    $actorName = $_POST['name'];
    $actorSurname = $_POST['surname'];
    $actorAge = $_POST['age'];

    $sql = "INSERT INTO actor (name, surname, age) VALUES ('$actorName', '$actorSurname', '$actorAge')";
    $conn->query($sql);
}

// Получение списка актеров из базы данных
$sql = "SELECT * FROM actor";
$result = $conn->query($sql);
$actors = $result->fetch_all(MYSQLI_ASSOC);

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
  <title>Управление актёрами</title>
  <!-- Подключение стилей Bootstrap -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
</head>
<body>
  <div class="container">
    <h1>Управление актёрами</h1>

    <!-- Форма добавления актёра -->
    <form method="POST" action="">
      <div class="form-row">
        <div class="col-md-3 mb-3">
          <input type="text" name="name" class="form-control" placeholder="Введите имя актёра" required>
        </div>
        <div class="col-md-3 mb-3">
          <input type="text" name="surname" class="form-control" placeholder="Введите фамилию актёра" required>
        </div>
        <div class="col-md-3 mb-3">
          <input type="number" name="age" class="form-control" placeholder="Введите возраст актёра" required>
        </div>
        <div class="col-md-3">
          <button type="submit" name="add" class="btn btn-primary">Добавить актёра</button>
        </div>
      </div>
    </form>

    <!-- Список актёров -->
    <ul class="list-group">
      <?php foreach ($actors as $actor): ?>
        <li class="list-group-item">
          <div class="row">
            <div class="col-md-3">
              <strong><?php echo $actor['name']; ?></strong>
              <strong><?php echo $actor['surname']; ?></strong>
            </div>
            <div class="col-md-3">
              <p>Возраст: <?php echo $actor['age']; ?></p>
            </div>
            <div class="col-md-3">
              <p><?php echo $actor['bio']; ?></p>
            </div>
            <div class="col-md-3">
              <a href="?delete=<?php echo $actor['id_actor']; ?>" class="btn btn-danger">Удалить</a>
            </div>
          </div>
        </li>
      <?php endforeach; ?>
    </ul>
  </div>

  <!-- Подключение скриптов Bootstrap -->
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
</body>
</html>
