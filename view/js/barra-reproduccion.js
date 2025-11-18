let audioActual = null;
let reproduciento = false;

const barra = document.getElementById("global-player");
const titulo = document.getElementById("gp-title");
const btnPlay = document.getElementById("gp-play");
const seek = document.getElementById("gp-seek");
const vol = document.getElementById("gp-volume");

function reproducirGlobalPlayer(nombreFx) {
    titulo.textContent = nombreFx;
    mostrarBarra();
}

function pausarGlobalPlayer() {
    ocultarBarra();
}


function mostrarBarra() {
    barra.classList.add("active");
}

function ocultarBarra() {
    barra.classList.remove("active");
}


document.querySelectorAll(".fx-item .play").forEach((btn, i) => {
    btn.addEventListener("click", () => {

        // Simulación de un audio distinto por cada tarjeta
        let url = `../../audios/fx${i + 1}.mp3`;

        if (audioActual) audioActual.pause();

        audioActual = new Audio(url);
        audioActual.volume = vol.value / 100;
        audioActual.play();

        titulo.textContent = btn.closest(".fx-item").querySelector("h4").textContent;

        mostrarBarra();
        reproduciento = true;

        btnPlay.innerHTML = `<i class="fa-solid fa-pause"></i>`;
    });
});

// Botón de play/pause
btnPlay.onclick = () => {
    if (!audioActual) return;

    if (reproduciento) {
        audioActual.pause();
        btnPlay.innerHTML = `<i class="fa-solid fa-play"></i>`;
        ocultarBarra();
    } else {
        audioActual.play();
        btnPlay.innerHTML = `<i class="fa-solid fa-pause"></i>`;
        mostrarBarra();
    }

    reproduciento = !reproduciento;
};

// Avanzar y retroceder
document.getElementById("gp-forward").onclick = () => {
    if (audioActual) audioActual.currentTime += 3;
};

document.getElementById("gp-back").onclick = () => {
    if (audioActual) audioActual.currentTime -= 3;
};

// Volumen
vol.oninput = () => {
    if (audioActual) audioActual.volume = vol.value / 100;
};

// Seek
seek.oninput = () => {
    if (audioActual) {
        audioActual.currentTime = (seek.value / 100) * audioActual.duration;
    }
};

// Actualizar seek mientras reproduce
setInterval(() => {
    if (audioActual && audioActual.duration) {
        seek.value = (audioActual.currentTime / audioActual.duration) * 100;
    }
}, 200);
