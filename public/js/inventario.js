import InventoryService from './inventoryService.js';
import config from './config.json' assert { type: "json" };

class TabManager {
    constructor() {
        this.buttons = document.querySelectorAll('.tab-btn');
        this.sections = document.querySelectorAll('.tab-section');
        this.init();
    }

    init() {
        // Configuramos el estado inicial basado en el primer botón activo
        const initialBtn = this.buttons[0];
        if (initialBtn) this.switchTab(initialBtn.getAttribute('data-target'), initialBtn);

        this.buttons.forEach(btn => {
            btn.addEventListener('click', () => {
                const targetId = btn.getAttribute('data-target');
                this.switchTab(targetId, btn);
            });
        });
    }

    switchTab(targetId, activeBtn) {
        // 1. Gestionar secciones
        this.sections.forEach(section => {
            if (section.id === targetId) {
                section.classList.remove('hidden');
                section.classList.add('flex'); // Mantiene tu diseño de columnas
            } else {
                section.classList.add('hidden');
                section.classList.remove('flex');
            }
        });

        // 2. Gestionar estilos de botones
        this.buttons.forEach(btn => {
            // Clases para estado INACTIVO
            btn.classList.remove('border-primary', 'bg-primary', 'text-white');
            btn.classList.add('border-gray-200', 'bg-white', 'text-gray-600');
        });

        // Clases para estado ACTIVO
        activeBtn.classList.remove('border-gray-200', 'bg-white', 'text-gray-600');
        activeBtn.classList.add('border-primary', 'bg-primary', 'text-white');
    }
}

// Inicialización
document.addEventListener('DOMContentLoaded', () => {
    const db = new InventoryService(config.inventoryAPI_url);
    const tabs = new TabManager();
});