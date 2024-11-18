const dashboard = document.querySelector(".dashboard");
const profile = document.querySelector(".profile");
const posts = document.querySelector(".posts");
const pathName = window.location.pathname;

if (pathName.startsWith("/coms/admin.php")) {
  dashboard.classList.add("active");
} else if (
  pathName.startsWith("/coms/manajemenUser.php") ||
  pathName.startsWith("/coms/userDetail.php")
) {
  profile.classList.add("active");
} else if (
  pathName.startsWith("/coms/manajemenPost.php") ||
  pathName.startsWith("/coms/postDetail.php")
) {
  posts.classList.add("active");
}
