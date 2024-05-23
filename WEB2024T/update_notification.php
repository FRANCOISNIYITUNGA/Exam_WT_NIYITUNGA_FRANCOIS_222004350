<?php
include('connection1.php');

// Check if id is set
if (isset($_REQUEST['id'])) {
    $id = $_REQUEST['id'];
    // Prepare a statement with a parameterized query to prevent SQL injection (security improvement)
    $stmt = $connection->prepare("SELECT * FROM notification WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $b = $row['user_id'];
        $c = $row['content'];
        $d = $row['date_created'];
    } else {
        echo "notification not found.";
    }

    $stmt->close(); // Close the statement after use
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Profile</title>
    <!-- JavaScript validation and content load for updating or modifying data-->
    <script>
        function confirmUpdate() {
            return confirm('Are you sure you want to update this record?');
        }
    </script>
</head>
<body>
    <!-- Update profile form -->
    <h2><u>Update notification Form</u></h2>
    <form method="POST" onsubmit="return confirmUpdate();">
        <label for="user_id">User ID:</label>
        <input type="number" name="user_id" value="<?php echo isset($b) ? $b : ''; ?>">
        <br><br>

        <label for="content">content:</label>
        <input type="text" name="content" value="<?php echo isset($c) ? $c : ''; ?>">
        <br><br>

        <label for="date_created">date_created:</label>
        <input type="date" name="date_created" value="<?php echo isset($c) ? $c : ''; ?>">
        <br><br>

        <br><br>

        <input type="submit" name="update" value="Update">
    </form>
</body>
</html>

<?php
if (isset($_POST['update'])) {
    // Retrieve updated values from the form
    $user_id = $_POST['user_id'];
    $content = $_POST['content'];
    $date_created = $_POST['date_created'];

    // Update the profile in the database (prepared statement again for security)
    $stmt = $connection->prepare("UPDATE notification SET user_id=?, content=?, date_created=? WHERE id=?");
    $stmt->bind_param("isss", $user_id, $content, $date_created, $id);
    $stmt->execute();

    // Redirect to the page where profiles are listed
    header('Location: notification.php');
    exit(); // Ensure no other content is sent after redirection
}

// Close the connection (important to close after use)
mysqli_close($connection);
?>
