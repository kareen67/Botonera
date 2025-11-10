document.addEventListener("DOMContentLoaded", () => {

    // === MENÚ DE OPCIONES (Editar / Eliminar) ===
    const botonesMenu = document.querySelectorAll(".menu-btn");

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

    // === TABS ===
    const tabs = document.querySelectorAll(".tab");
    const sections = document.querySelectorAll("#misFx, #institucionales");
    const openModalBtn = document.getElementById("openModal");

    tabs.forEach(tab => {
        tab.addEventListener("click", () => {
            tabs.forEach(t => t.classList.remove("active"));
            tab.classList.add("active");

            sections.forEach(s => s.classList.add("hidden"));
            document.getElementById(tab.dataset.target).classList.remove("hidden");

            // Ocultar o mostrar el botón Agregar FX según la pestaña
            if (tab.dataset.target === "misFx") {
                openModalBtn.style.display = "inline-flex"; // visible
            } else {
                openModalBtn.style.display = "none"; // oculto
            }
        });
    });

    // === MODALES ===
    const modalAgregar = document.getElementById("modalAgregar");
    const modalEditar = document.getElementById("modalEditar");
    const modalEliminar = document.getElementById("modalEliminar");

    // Abrir modal de AGREGAR (solo FX personal)
    openModalBtn.addEventListener("click", () => {
        modalAgregar.querySelector("h2").textContent = "Agregar Nuevo FX Personal";
        modalAgregar.style.display = "flex";
    });

    // Cerrar botones genéricos de los modales
    document.querySelectorAll(".modal .cancelar").forEach(btn => {
        btn.addEventListener("click", (e) => {
            e.target.closest(".modal").style.display = "none";
        });
    });

    // === ABRIR MODAL DE EDITAR ===
    const editButtons = document.querySelectorAll(".edit");
    editButtons.forEach(btn => {
        btn.addEventListener("click", () => {
            const fxName = btn.closest(".fx-item").querySelector("h4").textContent;
            modalEditar.querySelector("input[type='text']").value = fxName;
            modalEditar.style.display = "flex";
        });
    });

    // === ABRIR MODAL DE ELIMINAR ===
    const deleteButtons = document.querySelectorAll(".delete");
    deleteButtons.forEach(btn => {
        btn.addEventListener("click", () => {
            const fxName = btn.closest(".fx-item").querySelector("h4").textContent;
            modalEliminar.querySelector("p").textContent = `¿Seguro que querés eliminar "${fxName}"? Esta acción no se puede deshacer.`;
            modalEliminar.style.display = "flex";
        });
    });

    // === Cerrar modal si hace clic fuera del contenido ===
    document.querySelectorAll(".modal").forEach(modal => {
        modal.addEventListener("click", (e) => {
            if (e.target === modal) {
                modal.style.display = "none";
            }
        });
    });
});
