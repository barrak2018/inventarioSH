console.log('script');

import {InventoryService} from './inventoryService.js';
import config from './config.json' with { type: "json" };
// import { renderNavigationMenu, navigationItems } from './script.js';

// script.js
const navigationItems = [
    { "icon": "fas fa-tachometer-alt", "label": "Dashboard", "active": false, "badge": "", "path": "/inventarioSH/public/vistas/_index.html" },
    { "icon": "fas fa-boxes", "label": "Inventory", "active": false, "badge": "", "path": "/inventarioSH/public/vistas/inventario.html" },
    // ... resto de items
];

function renderNavigationMenu(items) {
    const menuContainer = document.getElementById("nav-menu");
    if (!menuContainer) return;

    const _path = window.location.pathname;
    
    const menuHTML = items.map(item => {
        // Lógica de active basada en la ruta actual
        const isActive = _path.endsWith(item.path);
        const activeClass = isActive 
            ? "bg-gray-800 text-white" 
            : "text-gray-300 hover:bg-gray-800 hover:text-white";
        
        return `
            <li>
                <a href="${item.path}" class="flex items-center px-4 py-3 rounded-lg ${activeClass} transition-colors">
                    <i class="${item.icon} mr-3"></i>
                    <span class="flex-1">${item.label}</span>
                </a>
            </li>
        `;
    }).join("");

    menuContainer.innerHTML = menuHTML;
}



class TabManager {
    constructor() {
        this.buttons = document.querySelectorAll('.tab-btn');
        this.sections = document.querySelectorAll('.tab-section');
        this.pageTitle = document.getElementById('page-title');
        this.pageSubtitle = document.getElementById('page-subtitle');
        this.init();
    }

    init() {
        if (this.buttons.length === 0) return;

        this.buttons.forEach(btn => {
            btn.addEventListener('click', () => {
                const targetId = btn.getAttribute('data-target');
                this.switchTab(targetId, btn);
                this.updateHeader(btn.innerText);
                console.log('click');
                
            });
        });
    }

    switchTab(targetId, activeBtn) {
        // 1. Gestión de secciones: Alternamos entre 'hidden' y 'flex'
        this.sections.forEach(section => {
            if (section.id === targetId) {
                section.classList.remove('hidden');
                section.classList.add('flex');
            } else {
                section.classList.add('hidden');
                section.classList.remove('flex');
            }
        });

        // 2. Gestión de estilos de botones con Tailwind
        this.buttons.forEach(btn => {
            if (btn === activeBtn) {
                btn.classList.add('bg-primary', 'text-white', 'border-primary');
                btn.classList.remove('bg-white', 'text-gray-600', 'border-gray-200');
            } else {
                btn.classList.remove('bg-primary', 'text-white', 'border-primary');
                btn.classList.add('bg-white', 'text-gray-600', 'border-gray-200');
            }
        });
    }

    updateHeader(tabName) {
        if (this.pageTitle) {
            this.pageTitle.innerText = tabName;
        }
        if (this.pageSubtitle) {
            this.pageSubtitle.innerText = `Gestión detallada de ${tabName.toLowerCase()}`;
        }
    }
}

// Inicialización centralizada del sistema
document.addEventListener('DOMContentLoaded', () => {
    console.log("Iniciando Sistema de Control");
    
    try {
        // 1. Renderizar el Menú de Navegación (Capa Compartida)
        // Esto asegura que el menú esté listo antes de cualquier interacción
        renderNavigationMenu(navigationItems);

        // 2. Inicializar el Servicio de Datos
        const inventoryAPI = new InventoryService(config.inventoryAPI_url);
        
        // 3. Inicializar el Gestor de Pestañas (Lógica de la Vista)
        const tabs = new TabManager();

        console.log("Inventory System Fully Initialized");
    } catch (error) {
        console.error("Error crítico durante la carga del sistema:", error);
    }
});