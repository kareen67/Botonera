
document.addEventListener("DOMContentLoaded", () => {
    const botonesMenu = document.querySelectorAll(".menu-btn");
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