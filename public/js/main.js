
document.addEventListener('DOMContentLoaded', function() {
  const markCompleteButtons = document.querySelectorAll('.mark-complete');
  const completedTasksCount = document.querySelector('#completed-tasks-count');

  markCompleteButtons.forEach(button => {
      button.addEventListener('click', function() {
          const taskId = this.getAttribute('data-task-id');
          markTaskAsComplete(taskId);
      });
  });

  function markTaskAsComplete(taskId) {
      fetch('../includes/mark_complete.php', {
          method: 'POST',
          headers: {
              'Content-Type': 'application/x-www-form-urlencoded',
          },
          body: 'task_id=' + taskId
      })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
            
              const taskCard = document.querySelector(`[data-task-id="${taskId}"]`).closest('.card');
              taskCard.querySelector('small:last-of-type').textContent = 'Estado: Completada';
            taskCard.querySelector('.mark-complete').style.display = 'none';
            
            // Actualizar el contador de tareas completadas
            completedTasksCount.textContent = data.completed_count; 
          } else {
              alert('Error al marcar la tarea como completada');
          }
      })
      .catch(error => {
          console.error('Error:', error);
          alert('Error al marcar la tarea como completada');
      });
  }
});