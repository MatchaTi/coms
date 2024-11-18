const btnDeletePhoto = document.querySelector(".btn-delete-photo");
const indicatorDeletePhoto = document.querySelector(".indicator-delete-photo");
const profilePhoto = document.querySelector(".profile-avatar img");
const profileFullname = document.querySelector(".profile-fullname");
const profileUsername = document.querySelector(".profile-username");
const profileBio = document.querySelector(".profile-bio");
const inputProfileFullname = document.querySelector("input[name='fullname']");
const inputProfileUsername = document.querySelector("input[name='username']");
const inputProfileBio = document.querySelector("textarea[name='bio']");
const inputProfile = [
  { input: inputProfileFullname, target: profileFullname },
  { input: inputProfileUsername, target: profileUsername },
  { input: inputProfileBio, target: profileBio },
];

inputProfile.forEach(({ input, target }) => {
  input.addEventListener("input", () => {
    target.textContent = input.value;
  });
});

function deletePhoto() {
  const isDelete = confirm("Are you sure you want to delete this photo?");
  if (isDelete) {
    indicatorDeletePhoto.value = 1;
    profilePhoto.src = `https://ui-avatars.com/api/?name=${profileUsername.textContent}`;
    btnDeletePhoto.classList.add("hidden");
  }
}

function addPhoto() {
  btnDeletePhoto.classList.remove("hidden");
}
