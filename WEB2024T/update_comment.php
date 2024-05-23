<?php
include('connection1.php');

// Check if Product_Id is set
if (isset($_REQUEST['id'])) {
    $id = $_REQUEST['id'];
    // Prepare statement with parameterized query to prevent SQL injection (security improvement)
    $stmt = $connection->prepare("SELECT * FROM comment WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $b = $row['Post_id'];
        $c = $row['User_id'];
        $d = $row['Comment_text'];
    } else {
        echo "Post not found.";
    }

    $stmt->close(); // Close the statement after use
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update post</title>
    <!-- JavaScript validation and content load for update or modify data-->
    <script>
        function confirmUpdate() {
            return confirm('Are you sure you want to update this record?');
        }
    </script>
</head>
<body>
    <!-- Update products form -->
    <h2><u>Update Form of post</u></h2>
    <form method="POST" onsubmit="return confirmUpdate();">
        <label for="Post_id">Post_id:</label>
        <input type="number" name="Post_id" value="<?php echo isset($b) ? $b : ''; ?>">
        <br><br>

        <label for="User_id">User_id:</label>
        <input type="number" name="User_id" value="<?php echo isset($c) ? $c : ''; ?>">
        <br><br>

        <label for="Comment_text">Comment_text:</label>
        <input type="text" name="Comment_text" value="<?php echo isset($d) ? $d : ''; ?>">
        <br><br>

        <input type="submit" name="up" value="Update">
    </form>
</body>
</html>

<?php
if (isset($_POST['up'])) {
    // Retrieve updated values from form
    $Post_id = $_POST['Post_id'];
    $User_id = $_POST['User_id'];
    $Comment_text = $_POST['Comment_text'];

    // Update the post in the database (prepared statement again for security)
    $stmt = $connection->prepare("UPDATE comment SET Post_id=?, User_id=?, Comment_text=? WHERE id=?");
    $stmt->bind_param("iisi", $Post_id, $User_id, $Comment_text, $id);
    $stmt->execute();

    // Redirect to post.php
    header('Location: comment.php');
    exit(); // Ensure no other content is sent after redirection
}

// Close the connection (important to close after use)
mysqli_close($connection);
?>
