<?php
session_start();
header('Content-Type: application/json'); // Pastikan respons dalam format JSON

// Koneksi ke database
$conn = new mysqli('localhost', 'root', '', 'bookberry');

// Periksa koneksi database
if ($conn->connect_error) {
    echo json_encode(['error' => 'Database connection failed: ' . $conn->connect_error]);
    exit;
}

// Menangani permintaan POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Menangani Like/Dislike
    if (isset($_POST['action']) && isset($_POST['commentId'])) {
        $commentId = $_POST['commentId'] ?? null;
        $action = $_POST['action'] ?? null; // 'like' or 'dislike'

        if (!$commentId || !$action || !in_array($action, ['like', 'dislike'])) {
            echo json_encode(['error' => 'Invalid data']);
            exit;
        }

        // Tentukan kolom yang perlu diperbarui
        $column = $action === 'like' ? 'likes' : 'dislikes';
        $stmt = $conn->prepare("UPDATE comments SET $column = $column + 1 WHERE id = ?");
        if ($stmt) {
            $stmt->bind_param("i", $commentId);
            if ($stmt->execute()) {
                echo json_encode(['success' => 'Like/Dislike updated!']);
            } else {
                echo json_encode(['error' => 'Failed to update like/dislike']);
            }
            $stmt->close();
        } else {
            echo json_encode(['error' => 'Failed to prepare statement']);
        }
        exit;
    }

    // Menangani penyimpanan komentar
    $title = $_POST['title'] ?? null;
    $comment = $_POST['comment'] ?? null;
    $parent_id = $_POST['parent_id'] ?? null; // Tambahkan parent_id
    $username = $_SESSION['user_name'] ?? null;

    if (!$title || !$comment || !$username) {
        echo json_encode(['error' => 'Incomplete data']);
        exit;
    }

    // Simpan komentar
    $stmt = $conn->prepare("INSERT INTO comments (book_title, username, text, parent_id) VALUES (?, ?, ?, ?)");
    if ($stmt) {
        $stmt->bind_param("sssi", $title, $username, $comment, $parent_id);
        if ($stmt->execute()) {
            echo json_encode(['success' => 'Comment saved!']);
        } else {
            echo json_encode(['error' => 'Failed to execute statement']);
        }
        $stmt->close();
    } else {
        echo json_encode(['error' => 'Failed to prepare statement']);
    }
    exit;
}

// Menangani permintaan GET untuk mengambil komentar
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $title = $_GET['title'] ?? null;

    if (!$title) {
        echo json_encode(['error' => 'Missing book title']);
        exit;
    }

    $stmt = $conn->prepare("SELECT comments.*, user_form.image FROM comments 
                            LEFT JOIN user_form ON comments.username = user_form.name
                            WHERE comments.book_title = ? ORDER BY comments.created_at ASC");
    if ($stmt) {
        $stmt->bind_param("s", $title);
        $stmt->execute();
        $result = $stmt->get_result();

        $comments = [];
        while ($row = $result->fetch_assoc()) {
            // Add profile image to the comment data
            $profile_image = !empty($row['image']) ? 'uploaded_profile_images/' . $row['image'] : 'uploaded_profile_images/default_image.jpg';
            $row['profile_image'] = $profile_image;
            $comments[] = $row;
        }

        // Organize comments in a nested format
        $nestedComments = [];
        foreach ($comments as $comment) {
            if ($comment['parent_id'] === null) {
                $nestedComments[$comment['id']] = $comment;
                $nestedComments[$comment['id']]['replies'] = [];
            } else {
                $nestedComments[$comment['parent_id']]['replies'][] = $comment;
            }
        }

        echo json_encode(array_values($nestedComments));
        $stmt->close();
    } else {
        echo json_encode(['error' => 'Failed to prepare statement']);
    }
    exit;
}


$conn->close();
?>
