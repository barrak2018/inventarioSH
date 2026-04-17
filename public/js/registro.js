document.getElementById('registro-form').addEventListener('submit', async (e) => {
    e.preventDefault();
    
    const msgDiv = document.getElementById('registro-msg');
    const formData = {
        cedula: document.getElementById('reg-cedula').value,
        password: document.getElementById('reg-password').value,
        nombre_completo: document.getElementById('reg-nombre').value,
        codigo_empleado: document.getElementById('reg-codigo').value,
        cargo: document.getElementById('reg-cargo').value,
        empresa: document.getElementById('reg-empresa').value,
        rol: document.getElementById('reg-rol').value
    };

    try {
        const response = await fetch('../../api/login_manager.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(formData)
        });

        const result = await response.json();

        msgDiv.classList.remove('hidden', 'bg-red-100', 'text-red-700', 'bg-green-100', 'text-green-700');
        
        if (result.success) {
            msgDiv.innerText = result.msg;
            msgDiv.classList.add('bg-green-100', 'text-green-700');
            document.getElementById('registro-form').reset();
        } else {
            msgDiv.innerText = result.msg;
            msgDiv.classList.add('bg-red-100', 'text-red-700');
        }
    } catch (error) {
        console.error("Error en registro:", error);
    }
});