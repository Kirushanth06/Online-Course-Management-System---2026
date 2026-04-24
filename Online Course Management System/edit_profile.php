<?php include('config/db.php'); ?>
<?php
if(!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$msg = "";

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_profile'])) {
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $course = $conn->real_escape_string($_POST['course']);
    $interests = isset($_POST['interests']) ? implode(", ", $_POST['interests']) : '';
    $interests = $conn->real_escape_string($interests);

    $sql_update = "UPDATE users SET name='$name', email='$email', course='$course', interests='$interests' WHERE id='$user_id'";
    if($conn->query($sql_update) === TRUE) {
        $_SESSION['user_name'] = $name;
        $_SESSION['user'] = $email;
        $msg = "<div class='alert'>Profile updated successfully.</div>";
    } else {
        $msg = "<div class='alert alert-danger'>Error: " . $conn->error . "</div>";
    }
}

// Fetch current user details
$sql_fetch = "SELECT * FROM users WHERE id='$user_id'";
$res_fetch = $conn->query($sql_fetch);
$user_data = null;
if($res_fetch && $res_fetch->num_rows > 0) {
    $user_data = $res_fetch->fetch_assoc();
}
$current_interests = explode(", ", $user_data['interests'] ?? '');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile | E-Learning</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <div class="logo"><h2>E-Learning Platform</h2></div>
        <nav>
            <a href="index.php">Home</a>
            <a href="about.php">About</a>
            <a href="courses.php">Courses</a>
            <a href="contact.php">Contact</a>
            <a href="dashboard.php">Dashboard</a>
            <a href="logout.php">Logout</a>
        </nav>
    </header>

    <div class="container">
        <h1 style="text-align: center; margin-bottom: 2rem;">Edit Profile</h1>

        <?php if($msg != "") echo $msg; ?>

        <div class="card" style="max-width: 600px; margin: 0 auto;">
            <form method="POST" action="edit_profile.php" style="box-shadow: none; padding: 0; background: transparent; border: none;">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($user_data['name'] ?? ''); ?>" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user_data['email'] ?? ''); ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="course">Preferred Course</label>
                    <select name="course" id="course">
                        <option value="">--Select a Course--</option>
                        <option value="Web Development" <?php if(($user_data['course']??'') == 'Web Development') echo 'selected'; ?>>Web Development</option>
                        <option value="Data Science" <?php if(($user_data['course']??'') == 'Data Science') echo 'selected'; ?>>Data Science</option>
                        <option value="UX Design" <?php if(($user_data['course']??'') == 'UX Design') echo 'selected'; ?>>UX Design</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Interests</label>
                    <input type="checkbox" name="interests[]" value="Coding" id="coding" <?php if(in_array('Coding', $current_interests)) echo 'checked'; ?>><label for="coding" style="display:inline;font-weight:normal;">Coding</label>
                    <input type="checkbox" name="interests[]" value="Design" id="design" <?php if(in_array('Design', $current_interests)) echo 'checked'; ?>><label for="design" style="display:inline;font-weight:normal;">Design</label>
                    <input type="checkbox" name="interests[]" value="Marketing" id="marketing" <?php if(in_array('Marketing', $current_interests)) echo 'checked'; ?>><label for="marketing" style="display:inline;font-weight:normal;">Marketing</label>
                </div>

                <button type="submit" name="update_profile" class="btn" style="width: 100%;">Update Profile</button>
            </form>
        </div>
    </div>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> E-Learning Platform. All rights reserved.</p>
    </footer>
</body>
</html>
