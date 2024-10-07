document.getElementById('registroForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Evitar el envío del formulario

    // Obtener los valores del formulario
    const nombre = document.getElementById('nombre').value;
    const email = document.getElementById('email').value;
    const contrasena = document.getElementById('contrasena').value;
    const contrasenaConfirmar = document.getElementById('contrasenaConfirmar').value;

    // Verificar si las contraseñas coinciden
    if (contrasena !== contrasenaConfirmar) {
        alert('Las contraseñas no coinciden.'); // Mensaje de error
        return;
    }

    // Aquí podrías guardar la información (ejemplo en consola)
    console.log(`Nombre: ${nombre}, Email: ${email}, Contraseña: ${contrasena}`);

    // Mostrar mensaje de éxito
    alert('Registro exitoso.');

    // Reiniciar el formulario
    document.getElementById('registroForm').reset();
});