<?php
// Database connection parameters.
define('DB_USER', 'root');
define('DB_PASS', 'omi1983');
define('DB_NAME', 'todolist'); 
define('DB_HOST', '127.0.0.1'); 
define('DB_PORT', '3306');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todo List</title>
    <style>
        .todo {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }
        .done {
            text-decoration: line-through;
        }
    </style>
</head>
<body>
    <form id="todo-form">
        <input type="text" id="task-title" name="task-title" placeholder="Task Title" required>
        <button type="submit" name="action" value="new">Add</button>
    </form>

    <div id="todo-list">
    </div>

    <script>
        document.getElementById('todo-form').addEventListener('submit', function(event) {
            event.preventDefault();

            const taskTitle = document.getElementById('task-title');
            const action = document.querySelector('input[name="action"]:checked').value;

            const taskDiv = document.createElement('div');
            taskDiv.classList.add('todo');

            const taskLabel = document.createElement('label');
            taskLabel.textContent = taskTitle.value;

            const taskInput = document.createElement('input');
            taskInput.type = 'checkbox';
            taskInput.addEventListener('change', function() {
                this.parentElement.parentElement.classList.toggle('done');
            });

            const deleteButton = document.createElement('button');
            deleteButton.textContent = 'Delete';
            deleteButton.addEventListener('click', function() {
                this.parentElement.parentElement.remove();
            });

            taskDiv.appendChild(taskInput);
            taskDiv.appendChild(taskLabel);
            taskDiv.appendChild(deleteButton);

            document.getElementById('todo-list').appendChild(taskDiv);

            taskTitle.value = '';
        });
    </script>
</body>
</html>