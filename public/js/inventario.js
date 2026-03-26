/**
 * inventario.js
 * Gestión principal de la interfaz de inventario, carga de datos y eventos.
 */
import { InventoryService } from './inventoryService.js';
import { renderNavigationMenu, navigationItems } from './script.js';
import { TabManager } from "./TabManager.js";

// --- Configuración Manual (Plan B por si el import de JSON falla) ---
const CONFIG = {
    inventoryAPI_url: "http://localhost/inventarioSH/api/inventory_manager.php"
};

/**
 * Renderiza las filas de la tabla de modelos
 * @param {Array} data - Lista de modelos desde la API
 */
function table_render_modelos(data) {
    const tbody = document.getElementById('tbody-modelos');
    if (!tbody) return;

    tbody.innerHTML = ""; // Limpiar tabla

    if (data.length === 0) {
        tbody.innerHTML = `<tr><td colspan="5" class="px-6 py-4 text-center text-gray-500">No se encontraron modelos registrados.</td></tr>`;
        return;
    }

    data.forEach(item => {
        const fila = document.createElement('tr');
        fila.classList.add("hover:bg-gray-50", "transition-colors");
        
        // Usamos data-id en los botones para identificar el registro en los eventos
        fila.innerHTML = `
            <td class="px-6 py-4">
                <span class="px-2 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                    # ${item.ID_Modelo}
                </span>
            </td>
            <td class="px-6 py-4 font-medium text-gray-900">${item.Marca}</td>
            <td class="px-6 py-4 text-gray-600">${item.Modelo}</td>
            <td class="px-6 py-4 text-gray-600">${item.Categoria}</td>
            <td class="px-6 py-4 text-right space-x-3">
                <button class="btn-edit text-blue-600 hover:text-blue-900" data-id="${item.ID_Modelo}" title="Editar">
                    <i class="fas fa-edit pointer-events-none"></i>
                </button>
                <button class="btn-delete text-red-600 hover:text-red-900" data-id="${item.ID_Modelo}" title="Eliminar">
                    <i class="fas fa-trash pointer-events-none"></i>
                </button>
            </td>
        `;
        tbody.appendChild(fila);
    });
}

// --- Inicialización del Sistema ---
document.addEventListener('DOMContentLoaded', async () => {
    console.log("Iniciando Sistema de Control...");
    
    try {
        // 1. Componentes Globales
        renderNavigationMenu(navigationItems);
        const tabs = new TabManager();

        // 2. Inicializar API
        // Intentamos usar la URL de config.json si está disponible, si no, la constante CONFIG
        const apiURL = CONFIG.inventoryAPI_url; 
        const inventoryAPI = new InventoryService(apiURL);

        // 3. Carga Inicial de Datos
        const datos_modelos = await inventoryAPI.getAll("modelos");
        table_render_modelos(datos_modelos);

        // 4. Gestión de Eventos de la Tabla (Delegación de eventos)
        const tbodyModelos = document.getElementById('tbody-modelos');
        
        tbodyModelos.addEventListener('click', async (e) => {
            // Lógica para el botón ELIMINAR
            const deleteBtn = e.target.closest('.btn-delete');
            if (deleteBtn) {
                const id = deleteBtn.dataset.id;
                const confirmar = confirm(`¿Estás seguro de que deseas eliminar el modelo #${id}?`);
                
                if (confirmar) {
                    try {
                        await inventoryAPI.delete("modelos", id);
                        // Refrescar tabla tras eliminar
                        const nuevosDatos = await inventoryAPI.getAll("modelos");
                        table_render_modelos(nuevosDatos);
                        alert("Modelo eliminado correctamente.");
                    } catch (err) {
                        alert("Error al eliminar: " + err.message);
                    }
                }
            }

            // Lógica para el botón EDITAR
            const editBtn = e.target.closest('.btn-edit');
            if (editBtn) {
                const id = editBtn.dataset.id;
                console.log("Iniciando edición del ID:", id);
                // Aquí podrías disparar la apertura de un modal de edición
                alert(`Funcionalidad de edición para el ID ${id} en desarrollo.`);
            }
        });

    } catch (error) {
        console.error("Error crítico en la inicialización:", error);
    }
});