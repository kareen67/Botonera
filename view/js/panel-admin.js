document.addEventListener("DOMContentLoaded", () => {
    const tabs = document.querySelectorAll('.tab');
    const sections = document.querySelectorAll('.panel-section');

    // --- Cambio de pestañas ---
    tabs.forEach(tab => {
        tab.addEventListener('click', () => {
            tabs.forEach(t => t.classList.remove('active'));
            sections.forEach(s => s.classList.add('hidden'));
            tab.classList.add('active');
            document.getElementById(tab.dataset.target).classList.remove('hidden');
        });
    });

    // --- Menú de opciones ---
    const botones = document.querySelectorAll('.menu-btn');
    botones.forEach(boton => {
        boton.addEventListener('click', (e) => {
            e.stopPropagation();
            const acciones = boton.closest('.acciones');
            const activo = acciones.classList.contains('activo');
            document.querySelectorAll('.acciones').forEach(a => a.classList.remove('activo'));
            if (!activo) acciones.classList.add('activo');
        });
    });
    document.addEventListener('click', () => {
        document.querySelectorAll('.acciones').forEach(a => a.classList.remove('activo'));
    });

    // --- Abrir modales según la sección activa ---
    const abrirModal = (id) => document.getElementById(id).style.display = "flex";
    const cerrarModal = (modal) => modal.style.display = "none";

    document.querySelectorAll('.edit, .delete').forEach(btn => {
        btn.addEventListener('click', () => {
            const seccionActiva = document.querySelector('.panel-section:not(.hidden)').id;
            const esEditar = btn.classList.contains('edit');
            let modalId = "";

            if (seccionActiva === "usuarios") {
                modalId = esEditar ? "modalEditarUsuario" : "modalEliminarUsuario";
            } else if (seccionActiva === "programas") {
                modalId = esEditar ? "modalEditarPrograma" : "modalEliminarPrograma";
            } else if (seccionActiva === "asignaciones") {
                modalId = esEditar ? "modalEditarAsignacion" : "modalEliminarAsignacion";
            }

            abrirModal(modalId);
        });
    });

    // --- Cerrar modales ---
    document.querySelectorAll('.cerrar').forEach(cerrar => {
        cerrar.addEventListener('click', () => cerrarModal(cerrar.closest('.modal')));
    });
    window.addEventListener('click', (e) => {
        if (e.target.classList.contains('modal')) cerrarModal(e.target);
    });
});
