<?php
// Database connection parameters.
define('DB_USER', 'root');
define('DB_PASS', 'omi1983');
define('DB_NAME', 'todolist'); 
define('DB_HOST', '127.0.0.1'); 
define('DB_PORT', '3306');

// Establish a database connection
$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Handle actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['actionADD']) && $_POST['actionADD'] === 'new') {
        // Add a new task to the "todo" table
        if (isset($_POST['task-title']) && !empty($_POST['task-title'])) {
            $taskTitle = $mysqli->real_escape_string($_POST['task-title']);
            $sql = "INSERT INTO todo (task_title) VALUES ('$taskTitle')";
            $mysqli->query($sql);
        }
    } elseif (isset($_POST['delete']) && $_POST['delete'] === 'Delete') {
        // Delete a task from the "todo" table
        if (isset($_POST['delete_id'])) {
            $taskId = $mysqli->real_escape_string($_POST['delete_id']);
            $sql = "DELETE FROM todo WHERE id = $taskId";
            $mysqli->query($sql);
        }
    } elseif (isset($_POST['toggle']) && $_POST['toggle'] === 'Toggle') {
        // Toggle the "done" field of a task in the "todo" table
        if (isset($_POST['toggle_id'])) {
            $taskId = $mysqli->real_escape_string($_POST['toggle_id']);
            $sql = "UPDATE todo SET done = 1 - done WHERE id = $taskId";
            $mysqli->query($sql);
        }
    }

    // Redirect to avoid form resubmission on refresh
    header("Location: index.php");
    exit();
}

// Fetch tasks from the "todo" table and store them in $taches
$sql = "SELECT * FROM todo ORDER BY creation_date DESC";
$result = $mysqli->query($sql);

$taches = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $taches[] = $row;
    }
}

// Close the database connection
$mysqli->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todo List</title>
</head>
<body>
    <form id="todo-form" method="post">
        <input type="text" id="task-title" name="task-title" placeholder="Task Title" required>
        <input type="hidden" name="actionADD" value="new">
        <button type="submit">Add</button>
    </form>

    <div id="todo-list">
        <?php foreach ($taches as $tache): ?>
            <form method="post">
                <div class="todo <?php echo $tache['done'] ? 'done' : ''; ?>">
                    <input type="checkbox" name="toggle_id" value="<?php echo $tache['id']; ?>" <?php echo $tache['done'] ? 'checked' : ''; ?>>
                    <label><?php echo $tache['task_title']; ?></label>
                    <button type="submit" name="delete" value="Delete">
                        Delete
                        <input type="hidden" name="delete_id" value="<?php echo $tache['id']; ?>">
                    </button>
                    <input type="hidden" name="toggle" value="Toggle">
                </div>
            </form>
        <?php endforeach; ?>
    </div>
</body>
</html>
