document.addEventListener("DOMContentLoaded", () => {

    const botonesPlay = document.querySelectorAll(".play");

    botonesPlay.forEach((btn) => {

        btn.addEventListener("click", () => {

            const fxItem = btn.closest(".fx-item");
            const tituloFx = fxItem.querySelector("h4").textContent;

            // Si ya está reproduciendo → pausar
            if (fxItem.classList.contains("reproduciendo")) {

                fxItem.classList.remove("reproduciendo");

                // ICONO: barras → play
                btn.innerHTML = '<i class="fa-solid fa-play"></i>';

                // Detener barra global
                pausarGlobalPlayer();

                // Detener audio actual
                if (audioActual) audioActual.pause();

            } else {

                // Detener cualquier otro FX
                document.querySelectorAll(".fx-item.reproduciendo").forEach(item => {
                    item.classList.remove("reproduciendo");
                    item.querySelector(".play").innerHTML = '<i class="fa-solid fa-play"></i>';
                });

                // Activar reproducción
                fxItem.classList.add("reproduciendo");

                // ICONO: play → dos lineas verticales
                btn.innerHTML = '<i class="fa-solid fa-grip-lines-vertical"></i>';

                // Reproducir barra global
                reproducirGlobalPlayer(tituloFx, fxItem);
            }

        });
    });
});
