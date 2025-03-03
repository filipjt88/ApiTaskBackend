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
                    <div> 
                    <button class="btn-sm btn btn-danger edit-btn" onclick="editTask(${task.id}, '${task.title}')">Edit</button>  
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

// Add new task
function addTask() {
    const taskInput = document.getElementById("taskInput").value.trim();
    if (taskInput === "") return alert("Enter the task!");

    fetch("tasks.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ title: taskInput })
    })
        .then(response => response.json())
        .then(() => {
            document.getElementById("taskInput").value = "";
            fetchTasks();
        })
}

// Delete task
function deleteTask(id) {
    if (!confirm("Da li ste sigurni da zelite da obrisete?")) return;

    fetch("tasks.php", {
        method: "DELETE",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ id: id })
    })
        .then(response => response.json())
        .then(() => fetchTasks());
}

// Edit task
function editTask(id, oldTitle) {
    const newTitle = prompt("Da li zelite da izvrsite izmene?", oldTitle);
    if (!newTitle) return;
    fetch("tasks.php", {
        method: "PUT",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ id: id, title: newTitle, completed: false })
    })
        .then(response => response.json())
        .then(() => fetchTasks());
}