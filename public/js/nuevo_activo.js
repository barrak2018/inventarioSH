// Capa de Datos Original
const tiposActivo = [
    { id: 1, nombre: "Computadora" }, { id: 2, nombre: "Teclado" },
    { id: 3, nombre: "Mouse" }, { id: 4, nombre: "Monitor" },
    { id: 5, nombre: "Teléfono" }, { id: 6, nombre: "Router" },
    { id: 7, nombre: "Servidor" }, { id: 8, nombre: "Switch" },
    { id: 9, nombre: "Firewall" }, { id: 10, nombre: "Impresora" }
];

const categorias = [
    { id: 1, nombre: "Hardware" }, { id: 2, nombre: "Redes" },
    { id: 3, nombre: "Seguridad" }, { id: 4, nombre: "Almacenamiento" },
    { id: 5, nombre: "Periféricos" }, { id: 6, nombre: "Comunicación" }
];

const fabricantes = [
    { id: 1, nombre: "Dell" }, { id: 2, nombre: "HP" },
    { id: 3, nombre: "Lenovo" }, { id: 4, nombre: "Cisco" },
    { id: 5, nombre: "Fortinet" }, { id: 6, nombre: "Synology" }
];

const caracteristicasEjemplo = [
    { id: 1, nombre: "Capacidad de RAM", valor: "32GB" },
    { id: 2, nombre: "Almacenamiento", valor: "1TB SSD" }
];

// Funciones de Renderizado
function renderOptions(data) {
    return data.map(item => `<option value="${item.id}">${item.nombre}</option>`).join("");
}

function renderCaracteristicaField(id, nombre = "", valor = "") {
    return `
        <div class="caracteristica-field border border-gray-200 rounded-lg p-4 bg-gray-50" data-id="${id}">
            <div class="flex justify-between items-start mb-3">
                <span class="text-sm font-medium text-secondary">Característica ${id}</span>
                <button type="button" class="btn-remove-caracteristica text-danger"><i class="fas fa-times"></i></button>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <input type="text" class="nombre-caracteristica border rounded px-3 py-2 text-sm" placeholder="Nombre" value="${nombre}">
                <input type="text" class="valor-caracteristica border rounded px-3 py-2 text-sm" placeholder="Valor" value="${valor}">
            </div>
        </div>`;
}

// Inicialización
document.addEventListener('DOMContentLoaded', () => {
    document.getElementById('tipoActivo').innerHTML += renderOptions(tiposActivo);
    document.getElementById('categoria').innerHTML += renderOptions(categorias);
    document.getElementById('fabricante').innerHTML += renderOptions(fabricantes);

    const container = document.getElementById('caracteristicas-container');
    let counter = 1;

    document.getElementById('btnAgregarCaracteristica').addEventListener('click', () => {
        counter++;
        container.insertAdjacentHTML('beforeend', renderCaracteristicaField(counter));
    });

    container.addEventListener('click', (e) => {
        if (e.target.closest('.btn-remove-caracteristica')) {
            e.target.closest('.caracteristica-field').remove();
        }
    });

    // Validación y Envío
    document.getElementById('formNuevoModelo').addEventListener('submit', function(e) {
        e.preventDefault();
        document.getElementById('successMessage').style.display = 'block';
        window.scrollTo({ top: 0, behavior: 'smooth' });
        setTimeout(() => {
            this.reset();
            document.getElementById('successMessage').style.display = 'none';
        }, 3000);
    });

    document.getElementById('btnCancelar').addEventListener('click', () => {
        if(confirm('¿Desea salir?')) window.history.back();
    });
});