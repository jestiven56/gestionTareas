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


$sql = "SELECT * FROM tasks WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $task_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    redirect('dashboard.php');
}

$task = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = sanitize_input($_POST['title']);
    $description = sanitize_input($_POST['description']);
    $priority = sanitize_input($_POST['priority']);
    $status = sanitize_input($_POST['status']);

    $sql = "UPDATE tasks SET title = ?, description = ?, priority = ?, status = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $title, $description, $priority, $status, $task_id);
    
    if ($stmt->execute()) {
        $success_message = "Tarea actualizada exitosamente";
        $task = array_merge($task, ['title' => $title, 'description' => $description, 'priority' => $priority, 'status' => $status]);
    } else {
        $error_message = "Error al actualizar la tarea";
    }
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
        <h2>Editar Tarea</h2>

        <?php if (isset($success_message)): ?>
            <div class="alert alert-success"><?php echo $success_message; ?></div>
        <?php endif; ?>

        <?php if (isset($error_message)): ?>
            <div class="alert alert-danger"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <form method="post" action="">
            <div class="mb-3">
                <label for="title" class="form-label">Título:</label>
                <input type="text" class="form-control" id="title" name="title" value="<?php echo htmlspecialchars($task['title']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Descripción:</label>
                <textarea class="form-control" id="description" name="description" required><?php echo htmlspecialchars($task['description']); ?></textarea>
            </div>
            <div class="mb-3">
                <label for="priority" class="form-label">Prioridad:</label>
                <select class="form-control" id="priority" name="priority" required>
                    <option value="baja" <?php echo $task['priority'] == 'baja' ? 'selected' : ''; ?>>Baja</option>
                    <option value="media" <?php echo $task['priority'] == 'media' ? 'selected' : ''; ?>>Media</option>
                    <option value="alta" <?php echo $task['priority'] == 'alta' ? 'selected' : ''; ?>>Alta</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">Estado:</label>
                <select class="form-control" id="status" name="status" required>
                    <option value="pendiente" <?php echo $task['status'] == 'pendiente' ? 'selected' : ''; ?>>Pendiente</option>
                    <option value="completada" <?php echo $task['status'] == 'completada' ? 'selected' : ''; ?>>Completada</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Actualizar Tarea</button>
            <a href="dashboard.php" class="btn btn-secondary">Volver al Dashboard</a>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>