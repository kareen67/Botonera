// Modal
document.getElementById("openModal").onclick = () => {
    document.getElementById("modal").style.display = "flex";
};
document.getElementById("closeModal").onclick = () => {
    document.getElementById("modal").style.display = "none";
};

// Tabs
const tabs = document.querySelectorAll('.tab');
const grids = document.querySelectorAll('.fx-grid, .fx-tabla, .fx-inst');

if (tabs.length && grids.length) {
    tabs.forEach(tab => {
        tab.addEventListener('click', () => {
            tabs.forEach(t => t.classList.remove('active'));
            tab.classList.add('active');
            grids.forEach(grid => grid.classList.add('hidden'));
            document.getElementById(tab.dataset.target).classList.remove('hidden');
        });
    });
}
