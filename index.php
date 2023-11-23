<?php
require_once('Controller.php');

$taskManager = new TaskManager();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['addTask'])) {
        $taskName = $_POST['taskName'];
        $userId = $_POST['userId'];
        $taskManager->addTask($taskName, $userId);
    } elseif (isset($_POST['markDone'])) {
        $taskId = $_POST['taskId'];
        $taskManager->markTaskAsDone($taskId);
    } elseif (isset($_POST['deleteTask'])) {
        $taskId = $_POST['taskId'];
        $taskManager->deleteTask($taskId);
    } elseif (isset($_POST['updateTaskUser'])) {
        $taskId = $_POST['taskId'];
        $userId = $_POST['userId'];
        $taskManager->updateTaskUser($taskId, $userId);
    }

    if (isset($_POST['addUser'])) {
        $userName = $_POST['userName'];
        $taskManager->addUser($userName);
    } elseif (isset($_POST['deleteUser'])) {
        $userId = $_POST['userId'];
        $taskManager->deleteUser($userId);
    } elseif (isset($_POST['updateUser'])) {
        $userId = $_POST['userId'];
        $userName = $_POST['userName'];
        $taskManager->updateUser($userId, $userName);
    }
}

$tasks = $taskManager->getTasks();
$users = $taskManager->getUsers();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Manager</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <form method="post" class="mt-5">
            <label for="taskName" class="form-label">New Task</label>
            <div class="input-group mb-3">
                <input type="text" class="form-control" id="taskName" name="taskName" placeholder="Task" aria-label="Task" aria-describedby="button-addon2">
                <select class="form-select" name="userId" id="userId">
                    <?php foreach ($users as $user) : ?>
                        <option value="<?php echo $user['userId']; ?>"><?php echo $user['name']; ?></option>
                    <?php endforeach; ?>
                </select>
                <button type="submit" class="btn btn-primary" name="addTask" type="button" id="button-addon2">Add Task</button>
            </div>
        </form>

        <form method="post" class="mt-3">
            <label for="userName" class="form-label">New User</label>
            <div class="input-group mb-3">
                <input type="text" class="form-control" id="userName" name="userName" placeholder="User" aria-label="User" aria-describedby="button-addon2">
                <button type="submit" class="btn btn-primary" name="addUser" type="button" id="button-addon2">Add User</button>
            </div>
        </form>

        <h3>Tasks</h3>
        <ul class="list-group">
            <?php foreach ($tasks as $task) : ?>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <div class="col">
                        <small>ID: <?php echo $task['taskId'] ?></small>
                        <h5 class="mb-1">Task: <?php echo $task['taskName']; ?></h5>
                        <p>User: <?php echo $task['userId']; ?></p>
                    </div>
                    <form method="post">
                        <input type="hidden" name="taskId" value="<?php echo isset($task['taskId']) ? $task['taskId'] : ''; ?>">
                        <button type="submit" class="btn <?php echo isset($task['is_done']) && $task['is_done'] ? 'btn-success' : 'btn-danger'; ?> btn-sm" name="markDone"><?php echo isset($task['is_done']) && $task['is_done'] ? 'Done' : 'Pending'; ?></button>
                        <button type="submit" class="btn btn-danger btn-sm" name="deleteTask">Delete</button>
                        <select class="form-select" name="userId">
                            <?php foreach ($users as $user) : ?>
                                <option value="<?php echo $user['userId']; ?>" <?php echo $user['userId'] == $task['userId'] ? 'selected' : ''; ?>><?php echo $user['name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <button type="submit" class="btn btn-primary btn-sm" name="updateTaskUser">Update User</button>
                    </form>
                </li>
            <?php endforeach; ?>
       
