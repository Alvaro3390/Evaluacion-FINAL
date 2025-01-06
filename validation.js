document.getElementById('loginForm').addEventListener('submit', function (e) {
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;

    let isValid = true;

    // Validación del formato de correo electrónico
    const emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
    if (!emailPattern.test(email)) {
        document.getElementById('emailError').textContent = 'Por favor, ingresa un correo electrónico válido.';
        isValid = false;
    } else {
        document.getElementById('emailError').textContent = '';
    }

    // Validación de la seguridad de la contraseña
    const passwordPattern = /^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
    if (!passwordPattern.test(password)) {
        document.getElementById('passwordError').textContent = 'La contraseña debe tener al menos 8 caracteres, incluir una letra mayúscula, un número y un carácter especial.';
        isValid = false;
    } else {
        document.getElementById('passwordError').textContent = '';
    }

    if (!isValid) {
        e.preventDefault(); // Evita que el formulario se envíe si los datos no son válidos
    }
});
