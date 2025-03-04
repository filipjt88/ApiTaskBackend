document.addEventListener("DOMContentLoaded", fetchTasks);
function fetchTasks() {
    fetch("tasks.php")
        .then(response => response.json())
        .then(data => {
            const taskList = document.getElementById("taskList");
            taskList.innerHTML = "";

            data.forEach(task => {
                const li = document.createElement("li");
                li.innerHTML = `
                   <div class="container">
                   <div class="row">
                   <div class="col-md-6 offset-3 mt-5">
                    <li class="list-group-item">${task.title}</li>
                    <div></br>
                    <button class="btn-sm btn btn-warning edit-btn" onclick="editTask(${task.id}, '${task.title}')">Edit</button>  
                     <button class=" btn-sm btn btn-danger delete-btn" onclick="deleteTask(${task.id}, '${task.title}')">Delete</button>
                    </div>
                   </div>
                   </div>
                   </div>
                `;
                taskList.appendChild(li);
            });
        });
}


// Show message
function showMessage(text, type = "success") {
    const messageBox = document.getElementById("message");
    messageBox.textContent = text;
    messageBox.className = type;
    messageBox.style.display = "block";
    setTimeout(() => {
        messageBox.style.display = "none";
    }, 3000);
}

// Add new task
function addTask() {
    const taskInput = document.getElementById("taskInput").value.trim();
    if (taskInput === "") return showMessage("Enter the task!", "error");
    fetch("tasks.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ title: taskInput })
    })
        .then(response => response.json())
        .then(() => {
            document.getElementById("taskInput").value = "";
            fetchTasks();
            showMessage("Task is added")
        })
}

// Delete task
function deleteTask(id) {
    if (!confirm("Are you sure you want to delete?")) return;

    fetch("tasks.php", {
        method: "DELETE",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ id: id })
    })
        .then(response => response.json())
        .then(() => fetchTasks());
    showMessage("Task is deleted!")
}

// Edit task
function editTask(id, oldTitle) {
    const newTitle = prompt("Do you want to make changes?", oldTitle);
    if (!newTitle) return;
    fetch("tasks.php", {
        method: "PUT",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ id: id, title: newTitle, completed: false })
    })
        .then(response => response.json())
        .then(() => fetchTasks());
    showMessage("Task is updated!")
}