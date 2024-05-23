<?php
include('connection1.php');

// Check if id is set
if (isset($_REQUEST['id'])) {
    $id = $_REQUEST['id'];
    // Prepare a statement with a parameterized query to prevent SQL injection (security improvement)
    $stmt = $connection->prepare("SELECT * FROM post_tag WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $b = $row['Post_id'];
        $c = $row['Tag_id'];
    } else {
        echo "Post not found.";
    }

    $stmt->close(); // Close the statement after use
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Post Tag</title>
    <!-- JavaScript validation and content load for updating or modifying data-->
    <script>
        function confirmUpdate() {
            return confirm('Are you sure you want to update this record?');
        }
    </script>
</head>
<body>
    <!-- Update post_tag form -->
    <h2><u>Update Post Tag Form</u></h2>
    <form method="POST" onsubmit="return confirmUpdate();">
        <label for="Post_id">Post ID:</label>
        <input type="number" name="Post_id" value="<?php echo isset($b) ? $b : ''; ?>">
        <br><br>

        <label for="Tag_id">Tag ID:</label>
        <input type="number" name="Tag_id" value="<?php echo isset($c) ? $c : ''; ?>">
        <br><br>

        <input type="submit" name="update" value="Update">
    </form>
</body>
</html>

<?php
if (isset($_POST['update'])) {
    // Retrieve updated values from the form
    $Post_id = $_POST['Post_id'];
    $Tag_id = $_POST['Tag_id'];

    // Update the post_tag in the database (prepared statement again for security)
    $stmt = $connection->prepare("UPDATE post_tag SET Post_id=?, Tag_id=? WHERE id=?");
    $stmt->bind_param("iii", $Post_id, $Tag_id, $id);
    $stmt->execute();

    // Redirect to the page where post_tags are listed
    header('Location: post_tag.php');
    exit(); // Ensure no other content is sent after redirection
}

// Close the connection (important to close after use)
mysqli_close($connection);
?>
