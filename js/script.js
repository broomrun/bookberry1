window.addEventListener('scroll', function() {
    const navbar = document.querySelector('header');
    if (window.scrollY > 0) {
        navbar.classList.add('navbar-shadow');
    } else {
        navbar.classList.remove('navbar-shadow');
    }
});

function searchBooks(genre = null) {
    let query = $('#searchInput').val().trim();
    console.log("Initial Query: ", query); // Debug input awal

    if ($('#genreFilter').val() === 'allgenre') {
        $('#genreFilter').val(''); // Hapus nilai default jika ada
    }

    if (genre) {
        query = `subject:${genre}`;
    } else if ($('#genreFilter').val() && query) {
        query += ` +subject:${$('#genreFilter').val()}`;
    } else if ($('#genreFilter').val()) {
        query = `subject:${$('#genreFilter').val()}`;
    } else {
        query = query; // Biarkan apa adanya jika hanya judul
    }

    if (!query) {
        alert("Please enter a search term or select a genre.");
        return;
    }

    console.log("Final Query Sent to API: ", query); // Debug query akhir

    $.ajax({
        url: 'https://www.googleapis.com/books/v1/volumes',
        type: 'GET',
        dataType: 'json',
        data: {
            'key': 'AIzaSyCgSMM_Z01E6VjNuD4MibkPgGGFDNsQnfA',
            q: query
        },
        success: function(result) {
            console.log("API Response: ", result); // Debug hasil API
            if (result.totalItems > 0) {
                let books = result.items;
                let output = '';
                $.each(books, function(index, book) {
                    let bookInfo = book.volumeInfo;
                    let imageUrl = bookInfo.imageLinks ? bookInfo.imageLinks.thumbnail : 'path/to/default-image.jpg';
                    let averageRating = bookInfo.averageRating ? bookInfo.averageRating : 'N/A';
                    output += `
                        <div class="col-md-3">
                            <div class="card mb-5">
                                <a href="#" class="card-link see-detail" data-bs-toggle="modal" data-bs-target="#exampleModal" 
                                   data-title="${bookInfo.title}" 
                                   data-authors="${bookInfo.authors ? bookInfo.authors.join(', ') : 'Unknown'}" 
                                   data-date="${bookInfo.publishedDate ? bookInfo.publishedDate : 'N/A'}" 
                                   data-description="${bookInfo.description ? bookInfo.description : 'No description available'}" 
                                   data-image="${imageUrl}" 
                                   data-rating="${averageRating}">
                                   <img src="${imageUrl}" class="card-img-top" alt="${bookInfo.title}">
                                </a>
                                <div class="book-card">
                                    <h5 class="book-title">${bookInfo.title}</h5>
                                    <p class="author-name">By ${bookInfo.authors ? bookInfo.authors.join(', ') : 'Unknown'}</p>
                                    <p class="card-text"><strong>Rating ⭐</strong> ${averageRating}</p>
                                </div>
                            </div>
                        </div>
                    `;
                });
                $('#searchInput').val('');
                $('#book-list').html(output);
            } else {
                $('#book-list').html(`<div class="col"><h1 class="text-center">No books found.</h1></div>`);
            }
        },
        error: function(error) {
            console.error("API Error: ", error); // Debug jika API gagal
            $('#book-list').html(`<div class="col"><h1 class="text-center">Error retrieving data. Please try again later.</h1></div>`);
        }
    });
}


// Event listener untuk genre filter
$('#genreFilter').on('change', function() {
    searchBooks(); // Trigger pencarian ketika genre berubah
});

// Event listeners untuk tombol pencarian dan tombol Enter
$('#search-button').on('click', function() {
    searchBooks();
});

$('#searchInput').on('keyup', function(event) {
    if (event.keyCode === 13) {
        searchBooks();
    }
});

$(document).ready(function() {
    // Klik pada kategori tertentu
    $('#fantasy-tile').on('click', function() {
        searchBooks('Fantasy');
    });
    $('#fiction-tile').on('click', function() {
        searchBooks('Fiction');
    });
    $('#history-tile').on('click', function() {
        searchBooks('History');
    });
    $('#science-tile').on('click', function() {
        searchBooks('Science');
    });
    $('#biography-tile').on('click', function() {
        searchBooks('Biography');
    });
});

$(document).on('click', '.see-detail', function () {
    const title = $(this).data('title');
    const authors = $(this).data('authors');
    const date = $(this).data('date');
    const description = $(this).data('description');
    const image = $(this).data('image');
    const rating = $(this).data('rating');

    $('#exampleModalLabel').text(title);
    $('#book-detail').html(`
        <div class="text-center mb-3">
            <img src="${image}" class="img-fluid" alt="${title}" style="max-height: 200px;">
        </div>
        <p><strong>Authors:</strong> ${authors}</p>
        <p><strong>Published Date:</strong> ${date}</p>
        <p><strong>Description:</strong> ${description}</p>
        <p><strong>Rating:</strong> ${rating}</p>
    `);

    // Clear previous comments
    $('#commentSection').html('');
    fetchComments(title); // Load comments
});

$('#submitComment').on('click', function () {
    const comment = $('#commentInput').val().trim();
    const title = $('#exampleModalLabel').text();

    if (comment) {
        $.post('comments.inc.php', { title: title, comment: comment }, function (response) {
            console.log('Response:', response); // Debug response
            if (response.success) {
                alert('Comment submitted successfully!');
                $('#commentInput').val(''); // Kosongkan input
                fetchComments(title);
            } else {
                alert('Error: ' + (response.error || 'Failed to submit comment.'));
            }
        }, 'json').fail(function (xhr, status, error) {
            console.error('AJAX Error:', status, error); // Debug AJAX error
            console.log('Response Text:', xhr.responseText); // Debug response mentah
        });
    } else {
        alert("Comment cannot be empty.");
    }
});

function fetchComments(title) {
    $.get('comments.inc.php', { title: title }, function (response) {
        console.log('Comments fetched:', response); // Debug data komentar
        if (Array.isArray(response)) {
            let output = '';
            response.forEach(comment => {
                output += renderComment(comment);
            });
            $('#commentSection').html(output);
        } else if (response.error) {
            alert('Error fetching comments: ' + response.error);
        }
    }, 'json').fail(function (xhr, status, error) {
        console.error('AJAX Error:', status, error);
    });
}

// Render komentar dan reply
function renderComment(comment) {
    let replies = '';
    if (comment.replies && comment.replies.length > 0) {
        comment.replies.forEach(reply => {
            replies += renderComment(reply);
        });
    }

    return `
        <div class="comment" data-id="${comment.id}">
            <div class="comment-header">
                <img src="${comment.profile_image}" alt="Profile Image" class="profile-image" width="40" height="40">
                <strong>${comment.username}</strong>
                <small>${new Date(comment.created_at).toLocaleString()}</small> <!-- Waktu komentar -->
            </div>
            <p>${comment.text}</p>
            <br>
            <button class="btn btn-link like-btn" data-id="${comment.id}">👍 ${comment.likes}</button>
            <button class="btn btn-link dislike-btn" data-id="${comment.id}">👎 ${comment.dislikes}</button>
            <button class="btn btn-link reply-btn">Reply</button>
            <div class="replies ms-3">
                ${replies}
            </div>
        </div>
    `;
}




// Saat membuka modal, muat komentar
$(document).on('click', '.see-detail', function () {
    const title = $(this).data('title');
    $('#exampleModalLabel').text(title);
    fetchComments(title); // Muat komentar untuk buku yang sesuai

});
$(document).on('click', '.reply-btn', function () {
    const commentId = $(this).closest('.comment').data('id');
    const replyInput = `
        <div class="reply-input mt-2">
            <textarea class="form-control reply-text" placeholder="Write your reply..."></textarea>
            <button class="btn btn-primary mt-1 submit-reply" data-parent-id="${commentId}">Submit</button>
        </div>
    `;
    $(this).after(replyInput);
    $(this).hide(); // Sembunyikan tombol Reply setelah diklik
});

$(document).on('click', '.submit-reply', function () {
    const parentId = $(this).data('parent-id');
    const replyText = $(this).prev('.reply-text').val().trim();
    const title = $('#exampleModalLabel').text();

    if (replyText) {
        $.post('comments.inc.php', { title: title, comment: replyText, parent_id: parentId }, function (response) {
            console.log('Reply Response:', response);
            if (response.success) {
                fetchComments(title); // Muat ulang komentar
            } else {
                alert('Error: ' + (response.error || 'Failed to submit reply.'));
            }
        }, 'json').fail(function (xhr, status, error) {
            console.error('AJAX Error:', status, error);
        });
    } else {
        alert("Reply cannot be empty.");
    }
});
$(document).on('click', '.like-btn', function () {
    const commentId = $(this).data('id');
    updateLikeDislike(commentId, 'like');
});

$(document).on('click', '.dislike-btn', function () {
    const commentId = $(this).data('id');
    updateLikeDislike(commentId, 'dislike');
});

function updateLikeDislike(commentId, action) {
    const title = $('#exampleModalLabel').text(); // Ambil judul buku

    $.post('comments.inc.php', { 
        title: title, 
        commentId: commentId, 
        action: action 
    }, function (response) {
        console.log('Like/Dislike Response:', response);
        if (response.success) {
            fetchComments(title); // Muat ulang komentar
        } else {
            alert('Error: ' + (response.error || 'Failed to update like/dislike.'));
        }
    }, 'json').fail(function (xhr, status, error) {
        console.error('AJAX Error:', status, error);
    });
}








