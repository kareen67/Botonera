document.addEventListener("DOMContentLoaded", () => {

    const botonesPlay = document.querySelectorAll(".play");

    botonesPlay.forEach((btn) => {

        btn.addEventListener("click", () => {

            const fxItem = btn.closest(".fx-item");
            const tituloFx = fxItem.querySelector("h4").textContent;

            // Si YA está reproduciendo → pausar + esconder barra
            if (fxItem.classList.contains("reproduciendo")) {

                fxItem.classList.remove("reproduciendo");
                btn.innerHTML = '<i class="fa-solid fa-play"></i>';

                // 🔥 Detener barra global
                pausarGlobalPlayer();

            } else {

                // Quitar reproducción en los otros
                document.querySelectorAll(".fx-item.reproduciendo").forEach(item => {
                    item.classList.remove("reproduciendo");
                    item.querySelector(".play").innerHTML = '<i class="fa-solid fa-play"></i>';
                });

                fxItem.classList.add("reproduciendo");
                btn.innerHTML = '<i class="fa-solid fa-pause"></i>';

                // 🔥 Iniciar barra global
                reproducirGlobalPlayer(tituloFx, fxItem);
            }

        });
    });
});
