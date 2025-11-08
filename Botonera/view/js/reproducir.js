        document.addEventListener("DOMContentLoaded", () => {
            const botonesPlay = document.querySelectorAll(".play");
            const botonesMenu = document.querySelectorAll(".menu-btn");

            // Reproducir
            botonesPlay.forEach((btn) => {
                btn.addEventListener("click", () => {
                    const fxItem = btn.closest(".fx-item");

                    if (fxItem.classList.contains("reproduciendo")) {
                        fxItem.classList.remove("reproduciendo");
                        btn.innerHTML = '<i class="fa-solid fa-play"></i>';
                    } else {
                        document.querySelectorAll(".fx-item.reproduciendo").forEach(item => {
                            item.classList.remove("reproduciendo");
                            item.querySelector(".play").innerHTML = '<i class="fa-solid fa-play"></i>';
                        });
                        fxItem.classList.add("reproduciendo");
                        btn.innerHTML = '<i class="fa-solid fa-pause"></i>';
                    }
                });
            });

            // Menú opciones
            botonesMenu.forEach(menu => {
                menu.addEventListener("click", (e) => {
                    e.stopPropagation();
                    const item = menu.closest(".fx-item");
                    const opciones = item.querySelector(".menu-opciones");
                    opciones.classList.toggle("activo");

                    // Cerrar otros menús
                    document.querySelectorAll(".menu-opciones").forEach(m => {
                        if (m !== opciones) m.classList.remove("activo");
                    });
                });
            });

            // Cerrar menú al hacer clic fuera
            document.addEventListener("click", () => {
                document.querySelectorAll(".menu-opciones").forEach(m => m.classList.remove("activo"));
            });
        });