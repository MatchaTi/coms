const navDialog = document.querySelector(".navbar-dialog");
const titleEl = document.querySelector(".dialog-title");
const promptEl = document.querySelector(".dialog-prompt");
let actionURL = "";

function confirmPrompt(title, prompt, redirectURL) {
  navDialog.showModal();
  titleEl.textContent = title;
  promptEl.textContent = prompt;
  actionURL = redirectURL;
  return false;
}

function cancel() {
  navDialog.close();
}

function confirm() {
  window.location.href = actionURL;
}

navDialog.addEventListener("click", (e) => {
  const dialogDimensions = navDialog.getBoundingClientRect();
  if (
    e.clientX < dialogDimensions.left ||
    e.clientX > dialogDimensions.right ||
    e.clientY < dialogDimensions.top ||
    e.clientY > dialogDimensions.bottom
  ) {
    navDialog.close();
  }
});
