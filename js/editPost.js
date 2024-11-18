const btnDeletePostPhoto = document.querySelector(".btn-delete-post-photo");
const postPhoto = document.querySelector(".post-photo");
const indicatorDeletePhoto = document.querySelector(".indicator-delete-photo");

function deletePhoto() {
  const isDelete = confirm("Are you sure you want to delete this photo?");
  if (isDelete) {
    indicatorDeletePhoto.value = 1;
    postPhoto.remove();
    btnDeletePostPhoto.classList.add("hidden");
  }
}

function addPhoto() {
  btnDeletePostPhoto.classList.remove("hidden");
}
