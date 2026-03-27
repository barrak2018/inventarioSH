/**
 * inventario.js
 * Gestión principal de la interfaz de inventario, carga de datos y eventos.
 */
import { InventoryService } from './inventoryService.js';
import { renderNavigationMenu, navigationItems } from './script.js';
import { TabManager } from "./TabManager.js";
import { RenderTabla } from "./RenderTabla.js";

// --- Configuración Manual (Plan B por si el import de JSON falla) ---
const CONFIG = {
    inventoryAPI_url: "http://localhost/inventarioSH/api/inventory_manager.php"
};










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

        // table_render_modelos(datos_modelos);
        function btnDelete(paramid) {
        const getID = document.getElementById(paramid);
    
            getID.addEventListener('click', async (e) => {
            const deleteBtn = e.target.closest('.btn-delete');

                if (deleteBtn) {
                    const id = deleteBtn.dataset.id;
                    const confirmar = confirm(`¿Estás seguro de que deseas eliminar el modelo #${id}?`);

                    if (confirmar) {
                        try {
                            await inventoryAPI.delete("modelos", id);
                            const nuevosDatos = await inventoryAPI.getAll("modelos");
                            modelos.render(nuevosDatos);
                            alert("Modelo eliminado correctamente.");
                        } catch (err) {
                            alert("Error al eliminar: " + err.message);
                        }
                    }
                }
            });
        }
        const modelos = new RenderTabla("tbody-modelos", {
            idField: "ID_Modelo",
            columns: [
                {field: "Marca"},
                {field: "Modelo"},
                {field: "Categoria"},
            ],
            onEdit: (id) => console.log("Editando ID:", id),
            onDelete: btnDelete("tbody-modelos")
        });
        modelos.render(datos_modelos);

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
                        modelos.render(nuevosDatos);
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

        // logica de formularios
        const formModelos = document.getElementById("form-modelos");
        formModelos.addEventListener("submit", async (e) => {
            e.preventDefault();
            
            // 1. Convertimos el formulario en un objeto JS puro
            const data = Object.fromEntries(new FormData(formModelos));
            
            console.log("Datos a enviar:", data);

            try {
                // 2. Usamos el método create de tu clase InventoryService
                // El objeto 'data' viaja directo al body de la petición
                await inventoryAPI.create("modelos", data);
                
                alert("¡Modelo guardado con éxito!");
                formModelos.reset(); // Limpiar formulario
                
                // 3. Recargar la tabla automáticamente
                const nuevosDatos = await inventoryAPI.getAll("modelos");
                modelos.render(nuevosDatos);
                
            } catch (error) {
                alert("Error al guardar: " + error.message);
            }
        });

        

    } catch (error) {
        console.error("Error crítico en la inicialización:", error);
    }
});

