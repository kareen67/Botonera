let currentAudio = null;

const globalPlayer = document.getElementById("global-player");
const gpTitle = document.querySelector(".gp-title");
const gpPlayPause = document.getElementById("gp-playpause");
const gpStop = document.getElementById("gp-stop");
const gpRewind = document.getElementById("gp-rewind");
const gpForward = document.getElementById("gp-forward");
const gpVolume = document.getElementById("gp-volume");

// Cada tarjeta FX
document.querySelectorAll(".fx-item").forEach(fx => {

    const playBtn = fx.querySelector(".play");

    playBtn.addEventListener("click", () => {

        // Si ya había un audio sonando, detenerlo
        if (currentAudio) {
            currentAudio.pause();
            currentAudio.currentTime = 0;
        }

        // Crear nuevo audio (cambiar por tu ruta real)
        const audio = new Audio("ruta/a/tu/fx.mp3");
        currentAudio = audio;

        // Mostrar info del FX abajo
        const title = fx.querySelector("h4").textContent;
        gpTitle.textContent = title;

        // Mostrar barra animada
        globalPlayer.classList.add("active");

        // Reproducir
        audio.play();
        gpPlayPause.innerHTML = `<i class="fa-solid fa-pause"></i>`;

        // Volume
        audio.volume = gpVolume.value;

        gpVolume.addEventListener("input", () => {
            audio.volume = gpVolume.value;
        });

        // Controles globales
        gpPlayPause.onclick = () => {
            if (audio.paused) {
                audio.play();
                gpPlayPause.innerHTML = `<i class="fa-solid fa-pause"></i>`;
            } else {
                audio.pause();
                gpPlayPause.innerHTML = `<i class="fa-solid fa-play"></i>`;
            }
        };

        gpStop.onclick = () => {
            audio.pause();
            audio.currentTime = 0;
            gpPlayPause.innerHTML = `<i class="fa-solid fa-play"></i>`;
            globalPlayer.classList.remove("active"); // esconder barra
        };

        gpRewind.onclick = () => {
            audio.currentTime = Math.max(0, audio.currentTime - 5);
        };

        gpForward.onclick = () => {
            audio.currentTime = Math.min(audio.duration, audio.currentTime + 5);
        };

        // Cuando termina el audio → ocultar barra
        audio.addEventListener("ended", () => {
            globalPlayer.classList.remove("active");
        });

    });
});
