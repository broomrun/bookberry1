<?php
date_default_timezone_set('Asia/Jakarta');

function setComment() {
    if (isset($_POST['commentSubmit'])) {
        $uid = $_POST['uid'];
        $date = $_POST['date'];
        $message = $_POST['message'];

        // Koneksi ke database
        $conn = new mysqli("localhost", "root", "", "bookberry");

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Query untuk menyimpan komentar
        $sql = "INSERT INTO comments (uid, date, message) VALUES ('$uid', '$date', '$message')";

        if ($conn->query($sql) === TRUE) {
            // Return the new comment HTML for appending
            echo "<div class='comment-box'>";
            echo "<p><strong>" . htmlspecialchars($uid) . "</strong> at " . htmlspecialchars($date) . "</p>";
            echo "<p>" . nl2br(htmlspecialchars($message)) . "</p>";
            echo "</div><br>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        $conn->close();
    }
}

function getComments() {
    $conn = new mysqli("localhost", "root", "", "commentsection");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM comments ORDER BY date DESC";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<div class='comment-box'>";
            echo "<p><strong>" . htmlspecialchars($row['uid']) . "</strong> at " . htmlspecialchars($row['date']) . "</p>";
            echo "<p>" . nl2br(htmlspecialchars($row['message'])) . "</p>";
            echo "</div><br>";
        }
    } else {
        echo "No comments yet!";
    }

    $conn->close();
}

// Jalankan fungsi untuk menyimpan komentar jika form disubmit
setComment();

function getComments($conn) {
    $sql = "SELECT * FROM comments";
    $result = $conn->query($sql); // Remove extra $ from variable
    while ($row = $result->fetch_assoc()) {
        echo "<div class='comment-box'><p>";
        echo htmlspecialchars($row['uid'])."<br>"; // Sanitize output
        echo htmlspecialchars($row['date'])."<br>"; // Sanitize output
        echo nl2br(htmlspecialchars($row['message'])); // Sanitize output and convert newlines to <br>
        echo "</p></div>"

        <form class = 'delete-form' method='POST' action='".deleteComments($conn)."'>
            <input
        
    }
}
?>
