/**
 * IntranetService.js
 * Servicio para interactuar exclusivamente con la API de la Intranet (Solo Lectura)
 */
export class IntranetService {
    constructor(baseURL) {
        // URL base: http://localhost/inventarioSH/api/intranet_manager.php
        this.baseURL = baseURL;
    }

    /**
     * Método genérico para peticiones GET
     */
    async request(resource, id = null) {
        try {
            let url = new URL(this.baseURL);
            url.searchParams.append('resource', resource);
            
            // Si hay un ID o Cédula, se añade a la URL
            if (id) url.searchParams.append('id', id);

            const response = await fetch(url, {
                method: 'GET',
                headers: { 'Content-Type': 'application/json' }
            });

            if (!response.ok) {
                const errorData = await response.json();
                throw new Error(errorData.error || 'Error en la petición a Intranet');
            }

            return await response.json();
        } catch (error) {
            console.error(`Error en IntranetService [${resource}]:`, error.message);
            throw error;
        }
    }

    /**
     * Obtiene la ficha completa de un empleado usando su cédula
     * @param {string} cedula 
     */
    async getFicha(cedula) {
        return this.request('ficha_empleado', cedula);
    }

    /**
     * Obtiene todos los registros de una tabla (datos_empleado o datos_personales)
     */
    async getAll(resource) {
        return this.request(resource);
    }

    /**
     * Obtiene un registro específico por su ID de tabla
     */
    async getById(resource, id) {
        return this.request(resource, id);
    }
}