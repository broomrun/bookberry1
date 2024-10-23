// Function to search for books based on user input
function searchBooks() {
    const query = $('#searchInput').val().toLowerCase();
    const genreFilter = $('#genreFilter').val();
    
    if (!query) {
        alert('Please enter a search term');
        return;
    }

    $.ajax({
        url: 'https://www.googleapis.com/books/v1/volumes',
        type: 'GET',
        dataType: 'json',
        data: {
            key: 'AIzaSyBqUPg1Itse_NYH1z7r8lA7-oA27aXBCW8', // Replace with your API key
            q: query
        },
        success: function(data) {
            const books = data.items || [];
            const filteredBooks = filterBooksByGenre(books, genreFilter);
            displayBooks(filteredBooks, 'searchResults'); // Display search results
        },
        error: function(xhr, status, error) {
            console.error('Error fetching books:', error);
            alert('Failed to fetch books. Please try again later.');
        }
    });
}

// Function to filter books by genre
function filterBooksByGenre(books, genre) {
    return books.filter(book => {
        const bookGenre = book.volumeInfo.categories ? book.volumeInfo.categories[0] : ''; // Get the first genre/category
        return genre === '' || bookGenre.toLowerCase() === genre.toLowerCase();
    });
}

// Function to display books in the specified container
function displayBooks(books, containerId) {
    let output = '';

    books.forEach(book => {
        const bookInfo = book.volumeInfo;
        const title = bookInfo.title || 'No Title';
        const authors = bookInfo.authors ? bookInfo.authors.join(', ') : 'Unknown Author';
        const thumbnail = bookInfo.imageLinks ? bookInfo.imageLinks.thumbnail : 'no_image_available.png';
        const ratingsCount = bookInfo.ratingsCount || 0;
        const averageRating = bookInfo.averageRating || 'N/A';

        output += `
            <div class="book-card">
                <img src="${thumbnail}" alt="${title}">
                <h3>${title}</h3>
                <p><strong>Author(s):</strong> ${authors}</p>
                <p><strong>Reads:</strong> ${ratingsCount}</p>
                <p><strong>Rating:</strong> ${averageRating}</p>
            </div>
        `;
    });

    document.getElementById(containerId).innerHTML = output;
}

// Event listener for search button
document.getElementById('searchButton').addEventListener('click', searchBooks);

// Event listeners for the search input and genre filter
document.getElementById('searchInput').addEventListener('keyup', function(event) {
    if (event.keyCode === 13) { // Trigger search on Enter key
        searchBooks();
    }
});
document.getElementById('genreFilter').addEventListener('change', searchBooks);
