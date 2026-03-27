class RenderTable {
    constructor(containerId, options = {}) {
        this.tbody = document.getElementById(containerId);
        this.columns = options.columns || [];
        this.onEdit = options.onEdit || (() => {});
        this.onDelete = options.onDelete || (() => {});
        this.idField = options.idField || 'id';

        this.init();
    }

    init() {
        if (!this.tbody) return;
        
        // Delegación de eventos para optimizar memoria
        this.tbody.addEventListener('click', (e) => {
            const btnEdit = e.target.closest('.btn-edit');
            const btnDelete = e.target.closest('.btn-delete');

            if (btnEdit) {
                this.onEdit(btnEdit.dataset.id);
            } else if (btnDelete) {
                this.onDelete(btnDelete.dataset.id);
            }
        });
    }

    render(data) {
        if (!this.tbody) return;
        this.tbody.innerHTML = "";

        if (data.length === 0) {
            this.tbody.innerHTML = `
                <tr>
                    <td colspan="${this.columns.length + 2}" class="px-6 py-4 text-center text-gray-500">
                        No se encontraron registros.
                    </td>
                </tr>`;
            return;
        }

        data.forEach(item => {
            const row = document.createElement('tr');
            row.classList.add("hover:bg-gray-50", "transition-colors", "border-b", "border-gray-100");

            row.innerHTML = `
                <td class="px-6 py-4">
                    <span class="px-2 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                        # ${item[this.idField]}
                    </span>
                </td>
                ${this.columns.map(col => `
                    <td class="px-6 py-4 ${col.className || 'text-gray-600'}">
                        ${item[col.field]}
                    </td>
                `).join('')}
                <td class="px-6 py-4 text-right space-x-3">
                    <button class="btn-edit text-blue-600 hover:text-blue-900" data-id="${item[this.idField]}" title="Editar">
                        <i class="fas fa-edit pointer-events-none"></i>
                    </button>
                    <button class="btn-delete text-red-600 hover:text-red-900" data-id="${item[this.idField]}" title="Eliminar">
                        <i class="fas fa-trash pointer-events-none"></i>
                    </button>
                </td>
            `;
            this.tbody.appendChild(row);
        });
    }
}