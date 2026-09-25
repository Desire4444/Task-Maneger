const taskInput = document.getElementById("taskInput");
const addTask = document.getElementById("addTask");
const taskList = document.getElementById("taskList");

let tasks = [];

function addNewTask() {
    const task = taskInput.value.trim();

    if(task === ""){
        alert("Input Field can not be empty!");
        return;
    }

    tasks.push(task);
    taskInput.value = "";
    displayTasks();
}

function displayTasks(){
    taskList.innerHTML = "";

    tasks.forEach(function(task) {
        const li = document.createElement("li");
        li.textContent = task;
        taskList.appendChild(li);
    });
}

addTask.addEventListener("click", addNewTask);

tasks.forEach(function(task, index) {
    const li = document.createElement("li");
    li.textContent = task;

    const button = document.createElement("button");
    button.textContent = "Delete";

    button.addEventListener("click", function() {
        tasks.splice(index, 1);
        displayTasks();
    });
    li.appendChild(button);
    taskList.appendChild(li);
});

localStorage.setItem(
    "tasks",
    JSON.stringify(tasks)
);

let savedTasks = JSON.parse(localStorage.getItem("tasks")) || [];

tasks = savedTasks;
displayTasks();
