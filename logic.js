const uploadBtn = document.querySelector(".btn-upload-modal");
const dialog = document.querySelector(".dialog");
const cancelBtn = document.querySelector(".cancel-post");
console.log("hello");

function shareLink(id) {
  console.log(id);
  const domain = window.location.origin;
  const path = window.location.pathname;
  const name = path.split("/")[1];
  const link = `${domain}/${name}/post.php?id=${id}`;

  if (navigator.clipboard && navigator.clipboard.writeText) {
    navigator.clipboard
      .writeText(link)
      .then(() => alert("Link copied!"))
      .catch((err) => {
        console.error("Clipboard API error: ", err);
        fallbackCopyTextToClipboard(link);
      });
  } else {
    fallbackCopyTextToClipboard(link);
  }
}

function fallbackCopyTextToClipboard(text) {
  const textArea = document.createElement("textarea");
  textArea.value = text;
  textArea.style.position = "fixed"; // Prevent scrolling to bottom
  document.body.appendChild(textArea);
  textArea.focus();
  textArea.select();
  try {
    document.execCommand("copy");
    alert("Link copied!");
  } catch (err) {
    console.error("Fallback copy error: ", err);
    alert("Failed to copy the link");
  }
  document.body.removeChild(textArea);
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
