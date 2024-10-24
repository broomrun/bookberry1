<?php
date_default_timezone_set('Asia/Jakarta');

// Database connection
function getDatabaseConnection() {
    $conn = new mysqli("localhost", "root", "", "bookberry");
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    return $conn;
}

// Function to set a comment
function setComment() {
    if (isset($_POST['commentSubmit'])) {
        $uid = $_POST['uid'];
        $date = $_POST['date'];
        $message = $_POST['message'];

        // Koneksi ke database
        $conn = getDatabaseConnection();

        // Query untuk menyimpan komentar
        $sql = "INSERT INTO comments (uid, date, message) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $uid, $date, $message);

        if ($stmt->execute()) {
            // Return the new comment HTML for appending
            echo "<div class='comment-box'>";
            echo "<p><strong>" . htmlspecialchars($uid) . "</strong> at " . htmlspecialchars($date) . "</p>";
            echo "<p>" . nl2br(htmlspecialchars($message)) . "</p>";
            echo "</div><br>";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
        $conn->close();
    }
}

// Function to get comments
function getComments($conn) {
    $sql = "SELECT * FROM comments ORDER BY date DESC";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<div class='comment-box'>";
            echo "<p><strong>" . htmlspecialchars($row['uid']) . "</strong> at " . htmlspecialchars($row['date']) . "</p>";
            echo "<p>" . nl2br(htmlspecialchars($row['message'])) . "</p>";
            
            // Delete comment form
            echo "<form class='delete-form' method='POST' action='delete_comment.php'>"; // Update action to your delete script
            echo "<input type='hidden' name='comment_id' value='" . htmlspecialchars($row['id']) . "' />"; // Assuming you have an ID column
            echo "<input type='submit' name='deleteSubmit' value='Delete' />";
            echo "</form>";
            
            echo "</div><br>";
        }
    } else {
        echo "No comments yet!";
    }
}

// Run the function to save comment if the form is submitted
setComment();

// Display comments
$conn = getDatabaseConnection();
getComments($conn);
$conn->close();
?>
