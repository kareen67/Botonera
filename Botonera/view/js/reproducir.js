        document.addEventListener("DOMContentLoaded", () => {
            const botonesPlay = document.querySelectorAll(".play");

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

        });