// Capa de Datos
let navigationItems = [
    { "icon": "fas fa-tachometer-alt", "label": "Dashboard", "active": false, "badge": "", "path": "/inventarioSH/public/vistas/_index.html" },
    { "icon": "fas fa-boxes", "label": "Inventory", "active": false, "badge": "", "path": "/inventarioSH/public/vistas/inventario.html" },
    { "icon": "fas fa-chart-bar", "label": "Analytics", "active": false, "badge": "", "path": "/inventarioSH/public/vistas/.html" },
    { "icon": "fas fa-clipboard-list", "label": "Reports", "active": true, "badge": "", "path": "/inventarioSH/public/vistas/_x.html" },
];

/**
 * Genera el HTML para el menú de navegación
 * @param {Array} items - Lista de objetos de navegación
 */
function renderNavigationMenu(items) {
    const menuContainer = document.getElementById("nav-menu");
    
    const menuHTML = items.map(item => {
        const activeClass = item.active 
            ? "bg-gray-800 text-white" 
            : "text-gray-300 hover:bg-gray-800 hover:text-white";
        
        const badge = item.badge 
            ? `<span class="ml-auto bg-primary text-white text-xs px-2 py-1 rounded-full">${item.badge}</span>` 
            : "";

        return `
            <li>
                <a href="${item.path}" class="flex items-center px-4 py-3 rounded-lg ${activeClass} transition-colors">
                    <i class="${item.icon} mr-3"></i>
                    <span class="flex-1">${item.label}</span>
                    ${badge}
                </a>
            </li>
        `;
    }).join("");

    if (menuContainer) {
        menuContainer.innerHTML = menuHTML;
    }
}
// manejador de rutas
const _path = window.location.pathname;
console.log(_path)

navigationItems.forEach(item => {
    if (item.path === _path) {
        item.active = true;
    }
    else{
        item.active = false;
    }
});
// Inicializar la página cuando el DOM esté listo
document.addEventListener("DOMContentLoaded", () => {
    renderNavigationMenu(navigationItems);
});