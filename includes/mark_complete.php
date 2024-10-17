<?php

require_once '../config/database.php';
require_once 'functions.php';
require_once 'session.php';

require_login();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['task_id'])) {
    $task_id = sanitize_input($_POST['task_id']);
    $userId = $_SESSION['user_id'];

    $sql = "UPDATE tasks SET status = 'completada' WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $task_id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
      
      $countQuery = "SELECT tasks.*, 
       (SELECT COUNT(*) 
        FROM tasks AS t
        INNER JOIN user_tasks AS ut ON t.id = ut.task_id
        WHERE t.status = 'completada' 
        AND ut.user_id = user_tasks.user_id) AS completed_count
      FROM tasks 
      INNER JOIN user_tasks ON tasks.id = user_tasks.task_id
      WHERE user_tasks.user_id = ?";
      $countStmt = $conn->prepare($countQuery);
      $countStmt->bind_param('i', $userId);
      $countStmt->execute();
      $result = $countStmt->get_result();
      $row = $result->fetch_assoc();

      echo json_encode([
          'success' => true,
          'completed_count' => $row['completed_count']
      ]);
    } else {
      echo json_encode(['success' => false,]);
    }

} else {
    echo json_encode(['success' => false, 'error' => 'Error al actualizar la tarea']);
}

?>