<?php

require_once '../config/database.php';
require_once '../includes/functions.php';
require_once '../includes/session.php';

require_login();

$user_id = $_SESSION['user_id'];




if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $title = sanitize_input($_POST['title']);
  $description = sanitize_input($_POST['description']);
  $priority = sanitize_input($_POST['priority']);
  $status = sanitize_input($_POST['status']);

  $sql = "INSERT INTO tasks (title, description, priority, status) VALUES (?, ?, ?, ?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("ssss", $title, $description, $priority, $status);
  $stmt->execute();

  $task_id = $conn->insert_id;

  $sql_user_tasks = "INSERT INTO user_tasks (user_id, task_id) VALUES (?, ?)";
  $stmt_user_tasks = $conn->prepare($sql_user_tasks);
  $stmt_user_tasks->bind_param("ii", $user_id, $task_id);
  $stmt_user_tasks->execute();

  $stmt->close();

  redirect('dashboard.php');



}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Tarea</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
    <h3>Agregar Nueva Tarea</h3>
        <form method="post" action="">
            <div class="mb-3">
                <label for="title" class="form-label">Título:</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Descripción:</label>
                <textarea class="form-control" id="description" name="description" required></textarea>
            </div>
            <div class="mb-3">
                <label for="priority" class="form-label">Prioridad:</label>
                <select class="form-control" id="priority" name="priority" required>
                    <option value="baja">Baja</option>
                    <option value="media">Media</option>
                    <option value="alta">Alta</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">Estado:</label>
                <select class="form-control" id="status" name="status" required>
                    <option value="pendiente">Pendiente</option>
                    <option value="completada">Completada</option>
                </select>
            </div>
            <a href="dashboard.php" class="btn btn-secondary">Volver al Dashboard</a>
            <button type="submit" class="btn btn-primary">Agregar Tarea</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>