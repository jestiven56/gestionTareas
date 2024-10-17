<?php

require_once '../config/database.php';
require_once '../includes/functions.php';
require_once '../includes/session.php';

require_login();

$user_id = $_SESSION['user_id'];

$sql_tasks = "SELECT tasks.*, 
       (SELECT COUNT(*) 
        FROM tasks AS t
        INNER JOIN user_tasks AS ut ON t.id = ut.task_id
        WHERE t.status = 'completada' 
        AND ut.user_id = user_tasks.user_id) AS completed_count
FROM tasks 
INNER JOIN user_tasks ON tasks.id = user_tasks.task_id
WHERE user_tasks.user_id = ?";
$stmt = $conn->prepare($sql_tasks);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$tasks = $result->fetch_all(MYSQLI_ASSOC);

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container my-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Bienvenido, <?php echo $_SESSION['user_name']; ?></h2>
            <a href="logout.php" class="btn btn-danger">Cerrar Sesión</a>
        </div>
        <div>
            <h3>Tareas Completadas: <span id="completed-tasks-count"><?php if(!empty($tasks)){ echo $tasks[0]['completed_count']; }else { echo "0"; }  ?></span></h3>
        </div>


        <?php if (isset($success_message)): ?>
            <div class="alert alert-success"><?php echo $success_message; ?></div>
        <?php endif; ?>

        <?php if (isset($error_message)): ?>
            <div class="alert alert-danger"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <h3 class="mt-5">Agregar Nueva Tarea</h3>
        <a href="add_task.php" class="btn btn-primary">Nueva Tarea</a>

        <h3 class="mt-5">Mis Tareas</h3>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            <?php foreach ($tasks as $task): ?>
                <div class="col">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($task['title']); ?></h5>
                            <p class="card-text"><?php echo htmlspecialchars(substr($task['description'], 0, 100)) . '...'; ?></p>
                            <p class="card-text"><small class="text-muted">Prioridad: <?php echo ucfirst($task['priority']); ?></small></p>
                            <p class="card-text"><small class="text-muted">Estado: <?php echo ucfirst($task['status']); ?></small></p>
                        </div>
                        <div class="card-footer">
                            <a href="task_detail.php?id=<?php echo $task['id']; ?>" class="btn btn-info btn-sm">Ver Detalles</a>
                            <a href="edit_task.php?id=<?php echo $task['id']; ?>" class="btn btn-warning btn-sm">Editar</a>
                            <?php if ($task['status'] !== 'completada'): ?>
                                <button class="btn btn-sm btn-success mark-complete" data-task-id="<?php echo $task['id']; ?>">Marcar como Completada</button>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../public/js/main.js"></script>
</body>
</html>