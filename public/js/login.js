import { AuthService } from './AuthService.js';

const auth = new AuthService('../../api/login_manager.php');

document.getElementById('login-form').addEventListener('submit', async (e) => {
    e.preventDefault();
    
    const cedula = document.getElementById('login-cedula').value;
    const pass = document.getElementById('login-password').value;
    const errorMsg = document.getElementById('login-error');

    try {
        const result = await auth.login(cedula, pass);
        // Guardar nombre en localStorage opcionalmente para la UI
        localStorage.setItem('userName', result.user.nombre);
        // Redirigir al panel principal
        window.location.href = 'index.html'; 
    } catch (err) {
        errorMsg.innerText = err.message;
        errorMsg.classList.remove('hidden');
    }
});