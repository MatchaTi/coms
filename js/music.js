const musicContainer = document.querySelector(".music-container");
const musicToggler = document.querySelector(".music-toggler");
const audioSources = [
  { src: "assets/musics/rain.mp3", label: "Rain" },
  { src: "assets/musics/campire.mp3", label: "Campire" },
  { src: "assets/musics/cafe.mp3", label: "Cafe" },
  { src: "assets/musics/delta.mp3", label: "Delta" },
  { src: "assets/musics/theta.mp3", label: "Theta" },
  { src: "assets/musics/milk-tea.m4a", label: "Milk Tea" },
  { src: "assets/musics/letsgo.mp3", label: "Let's Go!!!!!" },
];

musicToggler.addEventListener("click", () => {
  musicContainer.classList.toggle("hidden");
});

audioSources.forEach((audioData, index) => {
  musicContainer.insertAdjacentHTML(
    "beforeend",
    `
        <div class="flex flex-col mb-2">
            <label for="${audioData.label}">${audioData.label}</label>
            <button type="button" class="music-player flex items-center gap-2" data-index="${index}">
              <img src="assets/icons/play.svg" alt="Controller">
              <input type="range" name="${audioData.label}" id="${audioData.label}" min="0" max="100" value="0">
            </button>
        </div>
    `
  );
});

const musicBtns = document.querySelectorAll(".music-player");

musicBtns.forEach((button, index) => {
  const audio = new Audio(audioSources[index].src);
  const volumeSlider = button.querySelector("input[type='range']");

  button.addEventListener("click", () => {
    if (audio.paused) {
      volumeSlider.value = audio.volume * 100;
      audio.play();
      button.querySelector("img").src = "assets/icons/pause.svg";
    } else {
      audio.pause();
      button.querySelector("img").src = "assets/icons/play.svg";
    }
  });

  audio.loop = true;
  volumeSlider.addEventListener("input", (event) => {
    audio.volume = event.target.value / 100;
  });
});
