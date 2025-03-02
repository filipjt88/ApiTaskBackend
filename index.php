<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Api task backend PHP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="css/main.css">
</head>

<body>

<div class="container">
    <div class="row">
        <div class="col-md-6 offset-3 mt-5">
            <h1>Task</h1>
            <input type="text" id="taskInput" class="form-control" placeholder="Add new task..."><br>
            <button onclick="addTask()" class="btn btn-sm btn btn-success">Add task</button>
        </div>
        <ul id="taskList" class="list-group list-group-flush">
</ul>
    </div>
</div>


<script src="js/main.js"></script>
</body>

</html>