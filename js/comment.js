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
          <h3 class="comment__title">New Comment</h3>
          <p>${commentText}</p>
          <div class="comment__card-footer">
              <div>Likes 0</div>
              <div>Disliked 0</div>
              <div class="show-replies" onclick="toggleReplyForm('new-comment')">Reply</div>
          </div>
      </div>
      <div class="reply-form" id="reply-form-new-comment">
          <textarea placeholder="Write your reply..."></textarea>
          <button onclick="addReply('new-comment')">Post Reply</button>
      </div>
  `;

  document.querySelector(".container").appendChild(commentContainer);
  document.getElementById("new-comment").value = ""; // Reset input field
}

// Fungsi untuk menambahkan balasan
function addReply(commentId) {
  const replyForm = document.getElementById(`reply-form-${commentId}`);
  const replyText = replyForm.querySelector("textarea").value;
  if (replyText.trim() === "") return;

  const replyContainer = document.createElement("div");
  replyContainer.classList.add("comment__container", "opened");

  replyContainer.innerHTML = `
      <div class="comment__card">
          <h3 class="comment__title">Reply</h3>
          <p>${replyText}</p>
          <div class="comment__card-footer">
              <div>Likes 0</div>
              <div>Disliked 0</div>
              <div class="show-replies" onclick="toggleReplyForm('reply-${commentId}')">Reply</div>
          </div>
      </div>
  `;

  replyForm.before(replyContainer); // Insert reply above the form
  replyForm.querySelector("textarea").value = ""; // Reset reply input
}
