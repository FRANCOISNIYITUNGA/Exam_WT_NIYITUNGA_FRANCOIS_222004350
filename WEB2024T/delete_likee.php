<?php
    // Connection details
    include('connection1.php');

// Check if id is set
if(isset($_REQUEST['id'])) {
    $id = $_REQUEST['id'];
    
    // Prepare and execute the DELETE statement
    $stmt = $connection->prepare("DELETE FROM likee WHERE id=?");
    $stmt->bind_param("i", $id);
    ?>
     <!DOCTYPE html>
    <html>
    <head>
        <title>Delete Record</title>
        <script>
            function confirmDelete() {
                return confirm("Are you sure you want to delete this record?");
            }
        </script>
    </head>
    <body>
        <form method="post" onsubmit="return confirmDelete();">
            <input type="hidden" name="pid" value="<?php echo $id; ?>">
            <input type="submit" value="Delete">
        </form>

        <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($stmt->execute()) {
        echo "Record deleted successfully.<br><br> 
             <a href='like.php'>well deleted go click here to go back</a>";
    } else {
        echo "Error deleting data: " . $stmt->error;
    }
}
?>
</body>
</html>
<?php

    $stmt->close();
} else {
    echo "id is not set.";
}

$connection->close();
?>
