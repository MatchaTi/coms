const navDialog = document.querySelector(".next-navbar-dialog");
const titleEl = document.querySelector(".next-dialog-title");
const promptEl = document.querySelector(".next-dialog-prompt");

let title = "";
let promptDial = "";

function next(titleDialog, promptDialog) {
  title = titleDialog;
  promptDial = promptDialog;

  titleEl.textContent = title;
  promptEl.textContent = promptDial;

  navDialog.showModal();
}

function nextConfirm(actionURL) {
  console.log(actionURL, "actionURL");
  window.location.href = actionURL;
}
