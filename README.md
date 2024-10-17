# Sistema de Gestión de Tareas

Este proyecto es una aplicación web de gestión de tareas desarrollada con PHP, MySQL y Bootstrap 5. Permite a los usuarios iniciar sesión, crear tareas, editarlas, marcarlas como completadas y visualizarlas en un dashboard responsivo.

## Requisitos previos

- PHP 7.4 o superior
- MySQL 5.7 o superior
- Servidor web (por ejemplo, Apache)

## Instalación

1. Clona este repositorio en tu máquina local:
   ```
   git clone https://github.com/jestiven56/gestionTareas.git
   ```

2. Navega al directorio del proyecto:
   ```
   cd gestionTareas
   ```

3. Configura tu base de datos MySQL:

   - Ejecuta el script sql que se encuentra en la carpeta scripts
   - Este script crea una base de datos llamada task_management con las siguientes tablas:
      * user (guarda los usuarios)
      * task (guarda las tareas creadas por el usuario)
      * user_tasks (tabla relacional que guarda el id del usuario y el id de la tarea para manejar la relacion de MUCHOS a MUCHOS)

   - Este script tambien inserta 5 usuarios de prueba

      user1@test.com
      user2@test.com
      user3@test.com
      user4@test.com
      user5@test.com

    - Contrasena por defecto : 12345678

4. Configura la conexión a la base de datos:
   - Abre el archivo `config/database.php`
   - Modifica las constantes `DB_HOST`, `DB_USER`, `DB_PASS` y `DB_NAME` con tus credenciales de MySQL



## Uso

1. Abre tu navegador y visita la URL de tu proyecto (por ejemplo, `http://localhost/gestionTareas`)
2. Inicia sesión con las credenciales del usuario de prueba:
   - Email: user1@test.com
   - Contraseña: 12345678
3. Explora las funcionalidades de la aplicación:
   - Crear nuevas tareas
   - Ver el listado de tareas en el dashboard
   - Editar tareas existentes
   - Marcar tareas como completadas
   - Ver detalles de cada tarea

[jestiven56@gmail.com](mailto:jestiven56@gmail.com)
