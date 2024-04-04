-- Create the 'login_register' database if it doesn't exist
CREATE DATABASE IF NOT EXISTS `todolist`;

-- Use the 'login_register' database
USE `todolist`;

-- This SQL statement creates a table named 'tasks' to store task-related information.

CREATE TABLE IF NOT EXISTS `tasks` (
    -- Define the primary key column 'taskid' with auto-increment feature
    `taskid` INT AUTO_INCREMENT PRIMARY KEY,
    -- 'task' column to store the description of the task, not nullable
    `task` VARCHAR(255) NOT NULL,
    -- 'duedate' column to store the due date of the task, not nullable
    `duedate` DATE NOT NULL,
    -- 'status' column to store the status of the task, represented as a tinyint (0 or 1), not nullable
    `status` TINYINT(1) NOT NULL
);

-- End of SQL statement
