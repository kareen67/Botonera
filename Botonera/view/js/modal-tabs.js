// Modal
document.getElementById("openModal").onclick = () => {
    document.getElementById("modal").style.display = "flex";
};
document.getElementById("closeModal").onclick = () => {
    document.getElementById("modal").style.display = "none";
};

// Tabs
const tabs = document.querySelectorAll('.tab');
const grids = document.querySelectorAll('.fx-grid');

tabs.forEach(tab => {
    tab.addEventListener('click', () => {
        // quitar active a todas
        tabs.forEach(t => t.classList.remove('active'));
        tab.classList.add('active');
        // ocultar todas las grids
        grids.forEach(grid => grid.classList.add('hidden'));
        // mostrar la grid correspondiente
        document.getElementById(tab.dataset.target).classList.remove('hidden');
    });
});