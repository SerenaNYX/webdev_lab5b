<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update User</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <h1>Update User</h1>
    <?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "lab_5b";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['matric'])) {
        $matric = $_GET['matric'];
        $sql = "SELECT * FROM users WHERE matric='$matric'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            ?>
            <form action="update_action.php" method="POST">
                <input type="hidden" name="original_matric" value="<?php echo $row['matric']; ?>" />

                <label for="matric">Matric:</label>
                <input type="text" id="matric" name="matric" value="<?php echo $row['matric']; ?>" required><br><br>

                <label for="name">Name:</label>
                <input type="text" id="name" name="name" value="<?php echo $row['name']; ?>" required><br><br>

                <label for="role">Access Level:</label>
                <select id="role" name="role" required>
                    <option value="student" <?php if ($row['role'] == 'student') echo 'selected'; ?>>Student</option>
                    <option value="staff" <?php if ($row['role'] == 'staff') echo 'selected'; ?>>Staff</option>
                </select><br><br>

                <button type="submit">Update</button>
                <a href="display_users.php"><button type="button">Cancel</button></a>
            </form>
            <?php
        } else {
            echo "<p>User not found.</p>";
        }
    }

    $conn->close();
    ?>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script> 
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js">
    </script> <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
