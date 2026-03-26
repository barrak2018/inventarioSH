console.log('script');

import {InventoryService} from './inventoryService.js';
import config from './config.json' with { type: "json" };
import { renderNavigationMenu, navigationItems } from './script.js';
import { TabManager } from "./TabManager.js";



// renders
function table_render_modelos (data){
    if (data.length != 0){
        const tbody = document.getElementById('tbody-modelos')
        data.forEach(item => {
            const fila = document.createElement('tr');
            fila.classList.add("hover:bg-gray-50", "transition-colors")
            fila.innerHTML = `
                <td class="px-6 py-4"><span class="px-2 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800"># ${item.ID_Modelo}</span></td>
                <td class="px-6 py-4 font-medium text-gray-900">${item.Marca}   </td>
                <td class="px-6 py-4 text-gray-600">${item.Modelo} R740</td>
                <td class="px-6 py-4 text-gray-600">${item.Categoria}</td>
                <td class="px-6 py-4 text-right space-x-3">
                    <button class="text-blue-600 hover:text-blue-900"><i class="fas fa-edit"></i></button>
                    <button class="text-red-600 hover:text-red-900"><i class="fas fa-trash"></i></button>
                </td>
            `;
            tbody.appendChild(fila); 
        });
    }
}

// Inicialización centralizada del sistema
document.addEventListener('DOMContentLoaded', async () => {
    console.log("Iniciando Sistema de Control");
    
    try {
        // 1. Renderizar el Menú de Navegación (Capa Compartida)
        // Esto asegura que el menú esté listo antes de cualquier interacción
        renderNavigationMenu(navigationItems);
        
        // 2. Inicializar el Servicio de Datos
        const inventoryAPI = new InventoryService(config.inventoryAPI_url);
        const datos_modelos = await inventoryAPI.getAll("modelos");
        table_render_modelos(datos_modelos);
        
        // 3. Inicializar el Gestor de Pestañas (Lógica de la Vista)
        const tabs = new TabManager();
        
        console.log("Inventory System Fully Initialized");
    } catch (error) {
        console.error("Error crítico durante la carga del sistema:", error);
    }
});