const uploadBtn = document.querySelector(".btn-upload-modal");
const dialog = document.querySelector(".dialog");
const cancelBtn = document.querySelector(".cancel-post");

function shareLink(id) {
  const domain = window.location.origin;
  const path = window.location.pathname;
  const name = path.split("/")[1];
  const link = `${domain}/${name}/post.php?id=${id}`;
  navigator.clipboard.writeText(link).then(() => alert("Link copied!"));
}

dialog.addEventListener("click", (e) => {
  const dialogDimensions = dialog.getBoundingClientRect();
  if (
    e.clientX < dialogDimensions.left ||
    e.clientX > dialogDimensions.right ||
    e.clientY < dialogDimensions.top ||
    e.clientY > dialogDimensions.bottom
  ) {
    dialog.close();
  }
});

cancelBtn.addEventListener("click", () => {
  dialog.close();
});

uploadBtn.addEventListener("click", () => {
  dialog.showModal();
});
