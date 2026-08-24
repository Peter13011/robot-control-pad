# Robot Control Pad

This is a simple web-based robot control panel built with **PHP** and **MySQL**. The idea is that a user can control a robot from a browser, while the robot reads the latest command from the database.

## Features

-  Simple control pad interface
-  Forward command
-  Backward command
-  Left command
-  Right command
-  Stop command
-  MySQL database for storing the latest robot state
-  Easy polling endpoint for the robot
-  Works on shared hosting and local PHP servers

## How It Works

The project stores one row in the database that represents the robot's current command.

When the user presses a button, the frontend sends a request to:

```text
update_command.php
```

That file converts the command into a short letter and saves it in the database.

Example mapping:

| Button     | Stored As |
|-----------|-----------|
| forward   | f         |
| backward  | b         |
| left      | l         |
| right     | r         |
| stop      | S         |

The robot can then repeatedly request:

```text
get_state.php
```

to get the latest command.

Example response:

```json
{
  "command": "f",
  "updated_at": "2026-01-01 12:00:00"
}
```

## Tech Stack

- HTML
- CSS
- JavaScript
- PHP
- MySQL

## Project Structure

```text
robot-control-pad/
│
├── index.html          # Control pad interface
├── update_command.php  # Receives button command and saves it
├── get_state.php       # Returns current robot command
├── db.php              # Database connection
└── setup.sql           # Database setup file
```

## Setup Instructions

### 1. Create a MySQL database

Create a database for the project. You can name it something like:

```text
robot_control
```

### 2. Import the SQL file

Import `setup.sql` into your database using phpMyAdmin or the MySQL command line.

The SQL file creates the following table:

```sql
CREATE TABLE robot_state (
    id INT PRIMARY KEY,
    command CHAR(1) NOT NULL,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
```

It also inserts the default row:

```sql
INSERT INTO robot_state (id, command) VALUES (1, 'S');
```

The default command is `S`, which means **stop**.

### 3. Configure database connection

Open `db.php` and update these values:

```php
$host = "your host name";
$user = "username";
$pass = "password";
$dbname = "DBname";
```

For local XAMPP setup, it will usually look something like this:

```php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "robot_control";
```

### 4. Run the project

If you are using XAMPP, put the project folder inside:

```text
htdocs/
```

Then open it in your browser:

```text
http://localhost/robot-control-pad/index.html
```

## Usage

Open the control page and press one of the robot control buttons.

The command will be saved into the database.

Your robot, microcontroller, or hardware client can repeatedly call:

```text
get_state.php
```

to check what it should do next.

Example:

```text
http://localhost/robot-control-pad/get_state.php
```

## API Endpoints

### Get current robot state

```http
GET /get_state.php
```

Example response:

```json
{
  "command": "f",
  "updated_at": "2026-01-01 12:00:00"
}
```

### Update robot command

```http
POST /update_command.php
```

Example body:

```text
command=forward
```

Example successful response:

```json
{
  "status": "success",
  "button": "forward",
  "stored_as": "f"
}
```

