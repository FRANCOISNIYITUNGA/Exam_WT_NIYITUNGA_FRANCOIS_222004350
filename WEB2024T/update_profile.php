<?php
include('connection1.php');

// Check if id is set
if (isset($_REQUEST['id'])) {
    $id = $_REQUEST['id'];
    // Prepare a statement with a parameterized query to prevent SQL injection (security improvement)
    $stmt = $connection->prepare("SELECT * FROM profile WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $b = $row['user_id'];
        $c = $row['full_name'];
        $d = $row['bio'];
    } else {
        echo "Profile not found.";
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
    <h2><u>Update Profile Form</u></h2>
    <form method="POST" onsubmit="return confirmUpdate();">
        <label for="user_id">User ID:</label>
        <input type="number" name="user_id" value="<?php echo isset($b) ? $b : ''; ?>">
        <br><br>

        <label for="full_name">Full Name:</label>
        <input type="text" name="full_name" value="<?php echo isset($c) ? $c : ''; ?>">
        <br><br>

        <label for="bio">Bio:</label>
        <textarea name="bio"><?php echo isset($d) ? $d : ''; ?></textarea>
        <br><br>

        <input type="submit" name="update" value="Update">
    </form>
</body>
</html>

<?php
if (isset($_POST['update'])) {
    // Retrieve updated values from the form
    $user_id = $_POST['user_id'];
    $full_name = $_POST['full_name'];
    $bio = $_POST['bio'];

    // Update the profile in the database (prepared statement again for security)
    $stmt = $connection->prepare("UPDATE profile SET user_id=?, full_name=?, bio=? WHERE id=?");
    $stmt->bind_param("issi", $user_id, $full_name, $bio, $id);
    $stmt->execute();

    // Redirect to the page where profiles are listed
    header('Location: profile.php');
    exit(); // Ensure no other content is sent after redirection
}

// Close the connection (important to close after use)
mysqli_close($connection);
?>
