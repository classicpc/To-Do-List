// Initialize an empty array to store tasks
let tasks = [];

// When the DOM content is loaded, execute the following code
document.addEventListener('DOMContentLoaded', function() {
    // Load tasks from local storage
    loadTasksFromLocalStorage();

    // Add an event listener to the "Add Task" button
    document.getElementById("addButton").addEventListener("click", function(event) {
        // Prevent the default form submission behavior
        event.preventDefault();
        // Call the addTask function
        addTask();
    });
});

// Function to add a new task
function addTask() {
    // Get references to the task input and due date input elements
    const newTaskInput = document.getElementById("newTaskInput");
    const newTaskDueDate = document.getElementById("dueDateInput");
    // Extract the task text and due date from the input elements
    const taskText = newTaskInput.value.trim();
    const dueDate = newTaskDueDate.value;

    // Validate that both task text and due date are provided
    if (!taskText || !dueDate) {
        alert("Both task and due date are required.");
        return;
    }

    // Create a new task object with unique ID, text, due date, and completion status
    const newTask = {
        id: Date.now(), // Unique ID (ideally from the server)
        text: taskText,
        dueDate: dueDate,
        completed: false,
    };

    // Add the new task to the tasks array
    tasks.push(newTask);
    // Display updated tasks
    displayTasks();
    // Save tasks to local storage
    saveTasksToLocalStorage();

    // Clear the task input and due date input fields
    newTaskInput.value = '';
    newTaskDueDate.value = '';
}

// Function to display tasks in the UI
function displayTasks() {
    // Get reference to the tasks container element
    const tasksList = document.getElementById("tasks");
    // Clear the existing tasks
    tasksList.innerHTML = '';

    // Iterate over each task in the tasks array
    tasks.forEach((task, index) => {
        // Create a new task element
        const taskElement = document.createElement("div");
        // Add classes and attributes to the task element
        taskElement.className = "task";
        taskElement.draggable = true;
        taskElement.setAttribute('data-index', index);
        taskElement.setAttribute('data-id', task.id);

        // Determine completion class based on task status
        const completionClass = task.completed ? "completed" : "";
        // Set inner HTML of the task element
        taskElement.innerHTML = `
            <div class="${completionClass}" onclick="toggleTaskCompletion(${task.id}, event)">
                ${task.text} ---> Due: ${task.dueDate}
                <button onclick="deleteTask(${task.id}, event)">Delete</button>
            </div>
        `;

        // Attach drag event handlers to the task element
        attachDragHandlers(taskElement, index);

        // Append the task element to the tasks container
        tasksList.appendChild(taskElement);
    });
}

// Function to attach drag event handlers to task elements
function attachDragHandlers(element, index) {
    // Add event listener for drag start
    element.addEventListener("dragstart", (e) => {
        e.dataTransfer.setData("text/plain", index);
    });

    // Add event listener for drag over
    element.addEventListener("dragover", (e) => {
        e.preventDefault();
    });

    // Add event listener for drop
    element.addEventListener("drop", (e) => {
        e.preventDefault();
        const fromIndex = e.dataTransfer.getData("text/plain");
        const toIndex = index;
        moveTask(fromIndex, toIndex);
    });
}

// Function to move a task within the tasks array
function moveTask(fromIndex, toIndex) {
    const taskToMove = tasks.splice(fromIndex, 1)[0];
    tasks.splice(toIndex, 0, taskToMove);
    displayTasks();
    saveTasksToLocalStorage();
}

// Function to toggle task completion status
function toggleTaskCompletion(taskId, event) {
    event.stopPropagation();

    const task = tasks.find(task => task.id === taskId);
    if (task) {
        task.completed = !task.completed;
        displayTasks();
        saveTasksToLocalStorage();
        updateTaskOnServer(taskId, task.completed);
    }
}

// Function to update task completion status on the server
function updateTaskOnServer(taskId, newStatus) {
    // Fetch API to update task status on the server
    fetch('update_task_status.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `taskId=${taskId}&status=${newStatus ? 1 : 0}`
    })
    .then(response => response.json())
    .then(data => console.log(data.message))
    .catch(error => console.error('Error:', error));
}

// Function to delete a task
function deleteTask(taskId, event) {
    event.stopPropagation();

    // Remove the task with the specified ID from the tasks array
    tasks = tasks.filter(task => task.id !== taskId);
    // Display updated tasks
    displayTasks();
    // Save tasks to local storage
    saveTasksToLocalStorage();
    // Delete task from the server
    deleteTaskFromServer(taskId);
}

// Function to delete a task from the server
function deleteTaskFromServer(taskId) {
    // Fetch API to delete task from the server
    fetch('delete_task.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `taskId=${taskId}`
    })
    .then(response => response.json())
    .then(data => console.log(data.message))
    .catch(error => console.error('Error:', error));
}

// Function to save tasks to local storage
function saveTasksToLocalStorage() {
    localStorage.setItem("tasks", JSON.stringify(tasks));
}

// Function to load tasks from local storage
function loadTasksFromLocalStorage() {
    const storedTasks = localStorage.getItem("tasks");
    if (storedTasks) {
        tasks = JSON.parse(storedTasks);
        displayTasks();
    }
}
