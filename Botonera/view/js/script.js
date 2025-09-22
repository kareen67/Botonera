document.getElementById("form-login").addEventListener("submit", function(e) {
  e.preventDefault();

  let correo = document.getElementById("correo").value.trim();
  let clave = document.getElementById("clave").value;
  let repetir = document.getElementById("clave-repetir").value;
  let mensaje = document.getElementById("mensaje");

  mensaje.classList.remove("error");

  if (clave !== repetir) {
    mensaje.textContent = "⚠️ Las contraseñas no coinciden.";
    mensaje.classList.add("error");
    return;
  }

  if (clave.length < 6) {
    mensaje.textContent = "⚠️ La contraseña debe tener al menos 6 caracteres.";
    mensaje.classList.add("error");
    return;
  }

});
