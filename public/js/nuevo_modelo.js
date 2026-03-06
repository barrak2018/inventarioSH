// ==================== CAPA DE DATOS ====================
const tiposActivo = [
    { "id": 1, "nombre": "Computadora" },
    { "id": 2, "nombre": "Teclado" },
    { "id": 3, "nombre": "Mouse" },
    { "id": 4, "nombre": "Monitor" },
    { "id": 5, "nombre": "Teléfono" },
    { "id": 6, "nombre": "Router" },
    { "id": 7, "nombre": "Servidor" },
    { "id": 8, "nombre": "Switch" },
    { "id": 9, "nombre": "Firewall" },
    { "id": 10, "nombre": "Impresora" }
];

const categorias = [
    { "id": 1, "nombre": "Hardware" },
    { "id": 2, "nombre": "Redes" },
    { "id": 3, "nombre": "Seguridad" },
    { "id": 4, "nombre": "Almacenamiento" },
    { "id": 5, "nombre": "Periféricos" },
    { "id": 6, "nombre": "Comunicación" }
];

const fabricantes = [
    { "id": 1, "nombre": "Dell" }, { "id": 2, "nombre": "HP" },
    { "id": 3, "nombre": "Lenovo" }, { "id": 4, "nombre": "Cisco" },
    { "id": 5, "nombre": "Fortinet" }, { "id": 6, "nombre": "Synology" },
    { "id": 7, "nombre": "Ubiquiti" }, { "id": 8, "nombre": "Microsoft" },
    { "id": 9, "nombre": "Apple" }, { "id": 10, "nombre": "Asus" }
];

const caracteristicasEjemplo = [
    { "id": 1, "nombre": "Capacidad de RAM", "valor": "32GB" },
    { "id": 2, "nombre": "Almacenamiento", "valor": "1TB SSD" },
    { "id": 3, "nombre": "Procesador", "valor": "Intel Core i7" }
];

// ==================== FUNCIONES DE RENDERIZADO ====================

function renderOptions(data) {
    return data.map(item => `<option value="${item.id}">${item.nombre}</option>`).join("");
}

function renderCaracteristicaField(id, nombre = "", valor = "") {
    return `
        <div class="caracteristica-field border border-gray-200 rounded-lg p-4 bg-gray-50" data-id="${id}">
            <div class="flex justify-between items-start mb-3">
                <span class="text-sm font-medium text-secondary">Característica ${id}</span>
                <button type="button" class="btn-remove-caracteristica text-danger hover:text-danger/80">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="space-y-2">
                <input type="text" class="nombre-caracteristica w-full border border-gray-300 rounded px-3 py-2 text-sm" placeholder="Nombre" value="${nombre}">
                <input type="text" class="valor-caracteristica w-full border border-gray-300 rounded px-3 py-2 text-sm" placeholder="Valor" value="${valor}">
            </div>
        </div>
    `;
}

function renderEjemplos(caracts) {
    return caracts.map(caract => `
        <div class="border border-gray-200 rounded-lg p-3 cursor-pointer hover:border-primary hover:bg-blue-50 transition" 
             data-nombre="${caract.nombre}" data-valor="${caract.valor}">
            <div class="flex justify-between items-center">
                <div class="text-sm font-medium text-dark">${caract.nombre}</div>
                <i class="fas fa-plus text-primary text-xs"></i>
            </div>
        </div>
    `).join("");
}

// ==================== INICIALIZACIÓN Y EVENTOS ====================

document.addEventListener('DOMContentLoaded', function() {
    // Poblar Selects
    document.getElementById('tipoActivo').innerHTML += renderOptions(tiposActivo);
    document.getElementById('categoria').innerHTML += renderOptions(categorias);
    document.getElementById('fabricante').innerHTML += renderOptions(fabricantes);
    
    const container = document.getElementById('caracteristicas-container');
    container.innerHTML = renderEjemplos(caracteristicasEjemplo);
    
    let counter = 1;

    // Agregar Característica
    document.getElementById('btnAgregarCaracteristica').addEventListener('click', () => {
        counter++;
        container.insertAdjacentHTML('beforeend', renderCaracteristicaField(counter));
    });

    // Delegación para eliminar y agregar desde ejemplo
    container.addEventListener('click', (e) => {
        if (e.target.closest('.btn-remove-caracteristica')) {
            e.target.closest('.caracteristica-field').remove();
        }
        
        const ejemplo = e.target.closest('[data-nombre]');
        if (ejemplo && !e.target.closest('.caracteristica-field')) {
            counter++;
            const html = renderCaracteristicaField(counter, ejemplo.dataset.nombre, ejemplo.dataset.valor);
            container.insertAdjacentHTML('beforeend', html);
        }
    });

    // Envío del Formulario
    document.getElementById('formNuevoModelo').addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Simulación de éxito
        const success = document.getElementById('successMessage');
        success.style.display = 'block';
        window.scrollTo({ top: 0, behavior: 'smooth' });

        setTimeout(() => {
            this.reset();
            success.style.display = 'none';
            container.innerHTML = renderEjemplos(caracteristicasEjemplo);
        }, 3000);
    });

    // Cancelar
    document.getElementById('btnCancelar').addEventListener('click', () => {
        if(confirm('¿Desea salir?')) window.history.back();
    });
});