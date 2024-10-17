<?php

require_once '../config/database.php';
require_once '../includes/functions.php';
require_once '../includes/session.php';

require_login();

$user_id = $_SESSION['user_id'];
$task_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($task_id === 0) {
    redirect('dashboard.php');
}


$sql = "SELECT * FROM tasks WHERE id = ? ";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $task_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    redirect('dashboard.php');
}

$task = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles de la Tarea</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Detalles de la Tarea</h2>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title"><?php echo htmlspecialchars($task['title']); ?></h5>
                <p class="card-text"><?php echo htmlspecialchars($task['description']); ?></p>
                <p class="card-text"><strong>Prioridad:</strong> <?php echo ucfirst($task['priority']); ?></p>
                <p class="card-text"><strong>Estado:</strong> <?php echo ucfirst($task['status']); ?></p>
                <p class="card-text"><strong>Creada el:</strong> <?php echo $task['created_at']; ?></p>
            </div>
            <div class="card-footer">
                <a href="edit_task.php?id=<?php echo $task['id']; ?>" class="btn btn-primary">Editar</a>
                <a href="dashboard.php" class="btn btn-secondary">Volver al Dashboard</a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>