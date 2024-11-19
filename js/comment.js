// Menampilkan dan menyembunyikan form balasan
function toggleReplyForm(commentId) {
  const replyForm = document.getElementById(`reply-form-${commentId}`);
  replyForm.style.display = replyForm.style.display === "none" || replyForm.style.display === "" ? "block" : "none";
}

// Fungsi untuk menambahkan komentar baru
function addComment() {
  const commentText = document.getElementById("new-comment").value;
  if (commentText.trim() === "") return;

  const commentContainer = document.createElement("div");
  commentContainer.classList.add("comment__container", "opened");

  commentContainer.innerHTML = `
      <div class="comment__card">
          <div class="comment__profile">
              <img src="assets/2.jpeg" alt="Profile Picture">
            </div>
            <div class="comment__content">
            <h3 class="comment__title">Sunwoo</h3>
            <p>${commentText}</p>
            <div class="comment__card-footer">
                <div>Likes 123</div>
                <div>Disliked 23</div>
                <div class="show-replies" onclick="toggleReplyForm('new-comment}')">Reply 2</div>
            </div>
        </div>
      </div>
  `;

  document.querySelector(".container").appendChild(commentContainer);
  document.getElementById("new-comment").value = ""; // Reset input field
}

// Fungsi untuk menambahkan balasan
function addReply(commentId) {
  const replyForm = document.getElementById(`reply-form-${commentId}`);
  const replyText = replyForm.querySelector("new-comment").value;
  if (replyText.trim() === "") return;

  const replyContainer = document.createElement("div");
  replyContainer.classList.add("comment__container", "opened");

  replyContainer.innerHTML = `
      <div class="comment__card">
          <div class="comment__profile">
              <img src="assets/2.jpeg" alt="Profile Picture">
            </div>
            <div class="comment__content">
            <h3 class="comment__title">Sunwoo</h3>
            <p>${replyText}</p>
            <div class="comment__card-footer">
                <div>Likes 123</div>
                <div>Disliked 23</div>
                <div class="show-replies" onclick="toggleReplyForm('reply-${commentId}')">Reply 2</div>
            </div>
        </div>
      </div>
  `;

  // Menambahkan balasan ke dalam komentar yang relevan
  const comment = document.getElementById(`comment-${commentId}`);
  comment.appendChild(replyContainer);

  // Mengosongkan input balasan dan menyembunyikan form
  replyForm.querySelector("new-comment").value = ""; // Reset reply input
  replyForm.style.display = "none"; // Menyembunyikan form setelah balasan ditambahkan
}