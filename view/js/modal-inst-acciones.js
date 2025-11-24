// ========== ABRIR MODAL EDITAR ==========
document.querySelectorAll(".edit").forEach(btn => {
    btn.addEventListener("click", () => {
        document.getElementById("modalEditar").style.display = "flex";
        // Acá podrías precargar datos del FX en el modal si hace falta
    });
});

// ========== ABRIR MODAL ELIMINAR ==========
document.querySelectorAll(".delete").forEach(btn => {
    btn.addEventListener("click", () => {
        document.getElementById("modalEliminar").style.display = "flex";
    });
});

// ========== CERRAR MODALES AL TOCAR CANCELAR ==========
document.querySelector(".editar-cancelar").addEventListener("click", () => {
    document.getElementById("modalEditar").style.display = "none";
});

document.querySelector(".eliminar-cancelar").addEventListener("click", () => {
    document.getElementById("modalEliminar").style.display = "none";
});

// ========== CERRAR AL TOCAR FUERA DEL CONTENIDO ==========
document.querySelectorAll(".modal").forEach(modal => {
    modal.addEventListener("click", (e) => {
        if (e.target === modal) {
            modal.style.display = "none";
        }
    });
});
