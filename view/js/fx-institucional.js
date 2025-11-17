function cargarFxSistema() {
    fetch("../../../model/getFXinstitucional.php")
    .then(res => res.json())
    .then(data => {
        let tbody = document.getElementById("tbody_fx_sistema");
        tbody.innerHTML = "";

        data.forEach(fx => {
            let tr = document.createElement("tr");

            tr.innerHTML = `
                <td>${fx.nombre}</td>
                <td>--:--</td>
                <td><span class="categoria">${fx.clasificacion_fx}</span></td>
                <td>${fx.ruta_archivo}</td>
                <td>Sistema</td>
                <td class="acciones">
                    <button class="play-2" onclick="reproducirFX('../../${fx.ruta_archivo}')">
                        <i class="fa-solid fa-play"></i>
                    </button>
                </td>
            `;

            tbody.appendChild(tr);
        });
    })
    .catch(error => console.error("Error:", error));
}

document.addEventListener("DOMContentLoaded", cargarFxSistema);