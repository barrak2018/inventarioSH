// ==================== CAPA DE DATOS ====================
import { InventoryService } from './inventoryService.js';
// Usamos la importación de JSON con la sintaxis moderna
import config from './config.json' with { type: 'json' };

const db = new InventoryService(config.inventoryAPI_url);

// Variables globales para almacenar los datos del servidor
let tiposActivo = [];

// Datos estáticos para el resto de los campos
const categorias = [
    { "id": 1, "nombre": "Hardware" }, 
    { "id": 2, "nombre": "Redes" },
    { "id": 3, "nombre": "Seguridad" },
    { "id": 4, "nombre": "Almacenamiento" }
];

const fabricantes = [
    { "id": 1, "nombre": "Dell" }, 
    { "id": 2, "nombre": "HP" },
    { "id": 3, "nombre": "Lenovo" }, 
    { "id": 4, "nombre": "Cisco" }
];

const caracteristicasEjemplo = [
    { "id": 1, "nombre": "Capacidad de RAM", "valor": "32GB" },
    { "id": 2, "nombre": "Almacenamiento", "valor": "1TB SSD" },
    { "id": 3, "nombre": "Procesador", "valor": "Intel Core i7" }
];

// ==================== FUNCIONES DE RENDERIZADO ====================

function renderOptions(data) {
    // Verificamos que 'data' sea un array para evitar errores si la API falla
    if (!Array.isArray(data)) return "";
    return data.map(item => `<option value="${item.id || item.ID_Modelo}">${item.nombre || item.Modelo}</option>`).join("");
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

// ==================== INICIALIZACIÓN ASÍNCRONA ====================

// Convertimos el callback de DOMContentLoaded en async para usar await
document.addEventListener('DOMContentLoaded', async function() {
    
    // 1. Carga de datos desde la API
    try {
        // En tu crud.php el recurso se llama 'modelos'
        tiposActivo = await db.getAll('modelos');
        
        if (tiposActivo.length === 0) {
            console.warn('No se encontraron modelos. Verifica la base de datos.');
        }
    } catch (error) {
        console.error("Error al cargar datos de la API:", error);
        // Opcional: Cargar datos de respaldo si la API falla
        tiposActivo = [{ id: 0, nombre: "Error al cargar modelos" }];
    }

    // 2. Poblar los Selects
    // Ahora 'tiposActivo' ya tiene los datos reales gracias al 'await'
    document.getElementById('tipoActivo').innerHTML += renderOptions(tiposActivo);
    document.getElementById('categoria').innerHTML += renderOptions(categorias);
    document.getElementById('fabricante').innerHTML += renderOptions(fabricantes);
    
    const container = document.getElementById('caracteristicas-container');
    container.innerHTML = renderEjemplos(caracteristicasEjemplo);
    
    let counter = 1;

    // --- MANEJO DE EVENTOS ---

    // Agregar Característica Manual
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
    document.getElementById('formNuevoModelo').addEventListener('submit', async function(e) {
        e.preventDefault();
        
        // Recopilar características dinámicas
        const specs = Array.from(document.querySelectorAll('.caracteristica-field')).map(div => ({
            nombre: div.querySelector('.nombre-caracteristica').value,
            valor: div.querySelector('.valor-caracteristica').value
        }));

        const payload = {
            Marca: document.getElementById('fabricante').value,
            Modelo: document.getElementById('nombreModelo').value, // Verifica que este ID exista en tu HTML
            Categoria: document.getElementById('categoria').value,
            Especificaciones: JSON.stringify(specs)
        };

        try {
            const result = await db.create('modelos', payload);
            if (result) {
                const success = document.getElementById('successMessage');
                success.style.display = 'block';
                window.scrollTo({ top: 0, behavior: 'smooth' });

                setTimeout(() => {
                    this.reset();
                    success.style.display = 'none';
                    container.innerHTML = renderEjemplos(caracteristicasEjemplo);
                }, 3000);
            }
        } catch (err) {
            alert("Error al guardar el modelo: " + err.message);
        }
    });

    // Cancelar
    document.getElementById('btnCancelar').addEventListener('click', () => {
        if(confirm('¿Desea salir?')) window.history.back();
    });
});