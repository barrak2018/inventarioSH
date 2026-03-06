// ==================== DATOS DE EJEMPLO ====================
const dataActivos = [
    { id: "ACT-001", nombre: "Dell Latitude 5420", categoria: "Laptop", serie: "7XW2K93", estado: "Disponible", color: "bg-success/10 text-success" },
    { id: "ACT-002", nombre: "MacBook Pro M2", categoria: "Laptop", serie: "MVH23LL/A", estado: "Asignado", color: "bg-primary/10 text-primary" },
    { id: "ACT-003", nombre: "Monitor LG 27\"", categoria: "Monitor", serie: "LG27-9902", estado: "Mantenimiento", color: "bg-warning/10 text-warning" }
];

const dataModelos = [
    { nombre: "Dell PowerEdge R740", fabricante: "Dell", tipo: "Servidor", stock: 12 },
    { nombre: "Cisco ISR 4451", fabricante: "Cisco", tipo: "Router", stock: 8 },
    { nombre: "ThinkPad X1 Carbon", fabricante: "Lenovo", tipo: "Laptop", stock: 25 }
];

const dataAsignaciones = [
    { activo: "ACT-002", usuario: "Juan Pérez", fecha: "2024-03-15", depto: "IT" },
    { activo: "ACT-005", usuario: "María García", fecha: "2024-03-10", depto: "RRHH" }
];

// ==================== RENDERIZADO DE TABLAS ====================
function renderTablaActivos() {
    let html = `<table class="w-full text-left border-collapse">
        <thead class="bg-gray-50 text-secondary text-xs uppercase font-bold">
            <tr>
                <th class="px-6 py-4">Activo</th><th class="px-6 py-4">Categoría</th>
                <th class="px-6 py-4">S/N</th><th class="px-6 py-4">Estado</th>
                <th class="px-6 py-4 text-center">Acciones</th>
            </tr>
        </thead>
        <tbody class="divide-y">`;
    
    dataActivos.forEach(item => {
        html += `
            <tr class="hover:bg-gray-50 transition">
                <td class="px-6 py-4"><span class="font-medium text-dark">${item.nombre}</span><br><span class="text-xs text-secondary">${item.id}</span></td>
                <td class="px-6 py-4 text-sm">${item.categoria}</td>
                <td class="px-6 py-4 text-sm font-mono">${item.serie}</td>
                <td class="px-6 py-4"><span class="status-badge ${item.color}">${item.estado}</span></td>
                <td class="px-6 py-4 text-center">
                    <button class="text-blue-500 hover:text-blue-700 mx-1" title="Editar"><i class="fas fa-edit"></i></button>
                    <button class="text-red-500 hover:text-red-700 mx-1" title="Eliminar"><i class="fas fa-trash"></i></button>
                </td>
            </tr>`;
    });
    html += `</tbody></table>`;
    document.getElementById('tablaActivos').innerHTML = html;
}

// ==================== INICIALIZACIÓN DE GRÁFICOS ====================
function initCharts() {
    const ctxCategory = document.getElementById('categoryChart').getContext('2d');
    new Chart(ctxCategory, {
        type: 'doughnut',
        data: {
            labels: ['Laptops', 'Monitores', 'Servidores', 'Periféricos'],
            datasets: [{
                data: [45, 25, 15, 15],
                backgroundColor: ['#2563eb', '#0ea5e9', '#475569', '#10b981'],
                borderWidth: 0
            }]
        },
        options: { plugins: { legend: { position: 'bottom' } }, cutout: '70%' }
    });
}

// ==================== GESTIÓN DE PESTAÑAS ====================
document.addEventListener('DOMContentLoaded', () => {
    // Renderizado inicial
    renderTablaActivos();
    initCharts();

    // Eventos de Pestañas
    const tabs = document.querySelectorAll('.tab-btn');
    const contents = document.querySelectorAll('.tab-content');

    tabs.forEach(tab => {
        tab.addEventListener('click', () => {
            const target = tab.dataset.tab;
            
            tabs.forEach(t => t.classList.remove('active', 'bg-white', 'text-primary', 'shadow-sm'));
            tab.classList.add('active', 'bg-white', 'text-primary', 'shadow-sm');

            contents.forEach(c => c.classList.add('hidden'));
            document.getElementById(target).classList.remove('hidden');

            // Cargar datos específicos si es necesario
            if (target === 'modelos') renderTablaModelos();
            if (target === 'asignacion') renderTablaAsignaciones();
        });
    });
});