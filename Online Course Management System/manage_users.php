<?php include('config/db.php'); ?>
<?php
if(!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit();
}

$msg = "";
$action = isset($_GET['action']) ? $_GET['action'] : '';
$edit_id = isset($_GET['id']) ? $_GET['id'] : '';

// Handle Delete
if($action == 'delete' && !empty($edit_id)) {
    $edit_id = $conn->real_escape_string($edit_id);
    $sql_del = "DELETE FROM users WHERE id='$edit_id'";
    if($conn->query($sql_del) === TRUE) {
        $msg = "<div class='alert'>User deleted successfully.</div>";
    }
}

// Handle Update User
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_user'])) {
    $user_id = $conn->real_escape_string($_POST['user_id']);
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $course = $conn->real_escape_string($_POST['course']);

    $sql_edit = "UPDATE users SET name='$name', email='$email', course='$course' WHERE id='$user_id'";
    if($conn->query($sql_edit) === TRUE) {
        $msg = "<div class='alert'>User updated successfully.</div>";
        $action = ''; // reset edit mode
    } else {
        $msg = "<div class='alert alert-danger'>Error: " . $conn->error . "</div>";
    }
}

// Fetch user for editing
$edit_name = "";
$edit_email = "";
$edit_course = "";
if($action == 'edit' && !empty($edit_id)) {
    $sql_fetch = "SELECT * FROM users WHERE id='$edit_id'";
    $res_fetch = $conn->query($sql_fetch);
    if($res_fetch && $res_fetch->num_rows > 0) {
        $u = $res_fetch->fetch_assoc();
        $edit_name = $u['name'];
        $edit_email = $u['email'];
        $edit_course = $u['course'];
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users | E-Learning</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <div class="logo"><h2>E-Learning Platform</h2></div>
        <nav>
            <a href="index.php">Home</a>
            <a href="dashboard.php">Dashboard</a>
            <a href="manage_courses.php">Manage Courses</a>
            <a href="manage_users.php">Manage Users</a>
            <a href="logout.php">Logout</a>
        </nav>
    </header>

    <div class="container">
        <h1 style="margin-bottom: 2rem; text-align: center;">Manage Users</h1>
        
        <?php if($msg != "") echo $msg; ?>

        <?php if($action == 'edit'): ?>
        <div class="card" style="max-width: 600px; margin: 0 auto 2rem auto;">
            <h2>Edit User</h2>
            <br>
            <form method="POST" action="manage_users.php" style="box-shadow: none; padding: 0; max-width: 100%; background: transparent; border: none;">
                <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($edit_id); ?>">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($edit_name); ?>" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($edit_email); ?>" required>
                </div>
                <div class="form-group">
                    <label for="course">Course Interest</label>
                    <input type="text" id="course" name="course" value="<?php echo htmlspecialchars($edit_course); ?>" required>
                </div>
                <button type="submit" name="update_user" class="btn">Update User</button>
                <a href="manage_users.php" class="btn" style="background:#6c757d;">Cancel</a>
            </form>
        </div>
        <?php endif; ?>

        <div style="overflow-x:auto;">
            <table>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Course Interest</th>
                    <th>Interests</th>
                    <th>Actions</th>
                </tr>
                <?php
                $sql_list = "SELECT * FROM users ORDER BY id DESC";
                $result_list = $conn->query($sql_list);
                if($result_list && $result_list->num_rows > 0) {
                    while($row = $result_list->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['course']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['interests']) . "</td>";
                        echo "<td>";
                        echo "<a href='manage_users.php?action=edit&id=" . $row['id'] . "' class='btn' style='padding:0.4rem 0.8rem; font-size: 0.9rem;'>Edit</a> ";
                        echo "<a href='manage_users.php?action=delete&id=" . $row['id'] . "' class='btn btn-danger' style='padding:0.4rem 0.8rem; font-size: 0.9rem;' onclick='return confirm(\"Are you sure you want to delete this user?\")'>Delete</a>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No users found.</td></tr>";
                }
                ?>
            </table>
        </div>
    </div>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> E-Learning Platform. All rights reserved.</p>
    </footer>
</body>
</html>
