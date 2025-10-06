document.getElementById("form-login").addEventListener("submit", function(e) {
  e.preventDefault();

  let correo = document.getElementById("correo").value.trim();
  let clave = document.getElementById("clave").value;
  let mensaje = document.getElementById("mensaje");

  mensaje.classList.remove("error");


  if (clave.length < 6) {
    mensaje.textContent = "⚠️ La contraseña debe tener al menos 6 caracteres.";
    mensaje.classList.add("error");
    return;
  }

});
