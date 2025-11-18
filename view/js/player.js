// --- Crear barra global automáticamente ---
(function crearPlayer() {
    if (document.getElementById("global-player")) return;

    const html = `
    <div id="global-player" class="hidden">
        
        <div class="gp-left">
            <span id="gp-title">Reproduciendo...</span>
        </div>

         <!-- Mini Waveform -->
            <div class="gp-wave">
                <div class="wave"></div>
                <div class="wave"></div>
                <div class="wave"></div>
                <div class="wave"></div>
                <div class="wave"></div>
            </div>

        <div class="gp-controls">
        
            <button id="gp-back" class="glow"><i class="fa-solid fa-backward"></i></button>
            <button id="gp-play" class="glow"><i class="fa-solid fa-pause"></i></button>
            <button id="gp-forward" class="glow"><i class="fa-solid fa-forward"></i></button>
            
            <!-- Tiempos -->
            <span id="gp-current-time">00:00</span>

            <!-- Seek -->
            <input type="range" id="gp-seek" value="0" min="0" max="100">

            <span id="gp-total-time">00:00</span>

            <!-- SOLO volumen -->
            <input type="range" id="gp-volume" class="glow" value="100" min="0" max="100">
        </div>

    </div>`;

    document.body.insertAdjacentHTML("beforeend", html);
})();
