// MODAL AGREGAR
document.getElementById("openModal").onclick = () => {
    document.getElementById("modal").style.display = "flex";
};
document.getElementById("closeModal").onclick = () => {
    document.getElementById("modal").style.display = "none";
};


// MODAL EDITAR
document.querySelectorAll(".edit").forEach(btn => {
    btn.addEventListener("click", () => {
        document.getElementById("modalEditar").style.display = "flex";
    });
});

// MODAL ELIMINAR
document.querySelectorAll(".delete").forEach(btn => {
    btn.addEventListener("click", () => {
        document.getElementById("modalEliminar").style.display = "flex";
    });
});


// CERRA TODOS LOS MODALES CON BOTONES .cancelar
document.querySelectorAll(".cancelar").forEach(btn => {
    btn.addEventListener("click", () => {
        document.querySelectorAll(".modal").forEach(modal => {
            modal.style.display = "none";
        });
    });
});
