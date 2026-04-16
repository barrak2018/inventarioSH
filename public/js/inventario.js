/**
 * inventario.js
 * Gestión de la interfaz de inventario, carga de datos y eventos.
 * * MEJORAS REALIZADAS:
 * 1. Eliminación de la función btnDelete que se autoejecutaba incorrectamente.
 * 2. Unificación de la lógica de eventos mediante Delegación de Eventos.
 * 3. Validaciones de existencia de elementos del DOM para evitar errores de JS.
 */

import { InventoryService } from './inventoryService.js';
import {IntranetService} from './intranetService.js';
import { renderNavigationMenu, navigationItems } from './script.js';
import { TabManager } from "./TabManager.js";
import { RenderTabla } from "./RenderTabla.js";

// Configuración de la API
const CONFIG = {
    inventoryAPI_url: "http://localhost/inventarioSH/api/inventory_manager.php",
    intranetAPI_url:  "http://localhost/inventarioSH/api/intranet_manager.php"
};

document.addEventListener('DOMContentLoaded', async () => {
    console.log("Iniciando Sistema de Control...");
    
    try {
        // carga de CONFIG
        // const response = await fetch('../js/config.json'); // Ajusta la ruta según tu carpeta
        // if (!response.ok) throw new Error("No se pudo cargar la configuración");
        
        // CONFIG = await response.json();
        // console.log("Configuración cargada:", CONFIG);
        // --- 1. Inicialización de Componentes ---
        renderNavigationMenu(navigationItems);
        new TabManager(); // No se requiere asignar a variable si no se usará después

        // Inicializar el servicio de datos
        const inventoryAPI = new InventoryService(CONFIG.inventoryAPI_url);
        const intranetAPI = new IntranetService(CONFIG.intranetAPI_url);

        // --- 2. Configuración de la Tabla de Modelos ---
        // Definimos la estructura pero no asignamos eventos aquí para evitar conflictos
        const tablaModelos = new RenderTabla("tbody-modelos", {
            idField: "ID_Modelo",
            columns: [
                { field: "Marca" },
                { field: "Modelo" },
                { field: "Categoria" }
            ]
        });

        const tablaActivos = new RenderTabla("tbody-activos", {
            idField: "ID_Activo",
            columns: [
                { field: "Nombre" },
                { field: "ID_Modelo" },
                { field: "Estado" },
                { field: "Observaciones" }, 
                { field: "Modificado" }
            ]
        })
        const tablaAsignaciones = new RenderTabla("tbody-asignaciones", {
            idField: "ID_Asignacion",
            columns: [
                { field: "ID_empleado" },
                { field: "Fecha_Asignacion" },
                { field: "Ultimo_Soporte" },
                { field: "ID_Activo" }
            ]
        })

        // Carga inicial de datos desde el servidor
        const datos_modelos = await inventoryAPI.getAll("modelos");
        tablaModelos.render(datos_modelos);
        const datos_activos = await inventoryAPI.getAll("activos");
        tablaActivos.render(datos_activos);
        const datos_asignaciones = await inventoryAPI.getAll("asignaciones");
        tablaAsignaciones.render(datos_asignaciones);

        const datos_personales = await intranetAPI.getAll("datos_personales");
        const datos_empleado = await intranetAPI.getAll("datos_empleado");
        // Manejamos Editar y Eliminar en un solo bloque para mayor eficiencia

        // --------modelos---------------------------------------------
        const tbodyModelos = document.getElementById('tbody-modelos');
        
        if (tbodyModelos) {
            tbodyModelos.addEventListener('click', async (e) => {
                // Buscamos el botón más cercano al clic (por si hacen clic en el icono dentro del botón)
                const targetBtn = e.target.closest('button');
                if (!targetBtn) return;

                const id = targetBtn.dataset.id;

                // Lógica para el botón ELIMINAR
                if (targetBtn.classList.contains('btn-delete')) {
                    const confirmar = confirm(`¿Estás seguro de que deseas eliminar el modelo #${id}?`);
                    
                    if (confirmar) {
                        try {
                            await inventoryAPI.delete("modelos", id);
                            
                            // Refrescar datos localmente tras éxito
                            location.reload();
                            const nuevosDatos = await inventoryAPI.getAll("modelos");
                            tablaModelos.render(nuevosDatos);
                            
                            alert("Modelo eliminado correctamente.");
                        } catch (err) {
                            alert("Error al eliminar: " + err.message);
                        }
                    }
                }
        
                // Lógica para el botón EDITAR
                if (targetBtn.classList.contains('btn-edit')) {
                    console.log("Iniciando edición del ID:", id);
                    alert(`Funcionalidad de edición para el ID ${id} en desarrollo.`);
                }
            });
        }
        // ----------Activos-----------------------------------
        const tbodyActivos = document.getElementById('tbody-activos');
        
        if (tbodyActivos) {
            tbodyActivos.addEventListener('click', async (e) => {
                // Buscamos el botón más cercano al clic (por si hacen clic en el icono dentro del botón)
                const targetBtn = e.target.closest('button');
                if (!targetBtn) return;

                const id = targetBtn.dataset.id;

                // Lógica para el botón ELIMINAR
                if (targetBtn.classList.contains('btn-delete')) {
                    const confirmar = confirm(`¿Estás seguro de que deseas eliminar el Activo #${id}?`);
                    
                    if (confirmar) {
                        try {
                            await inventoryAPI.delete("activos", id);
                            
                            // Refrescar datos localmente tras éxito
                            location.reload();
                            const nuevosDatos = await inventoryAPI.getAll("activos");
                            tablaActivos.render(nuevosDatos);
                            
                            alert("Activo eliminado correctamente.");
                        } catch (err) {
                            alert("Error al eliminar: " + err.message);
                        }
                    }
                }
        
                // Lógica para el botón EDITAR
                if (targetBtn.classList.contains('btn-edit')) {
                    console.log("Iniciando edición del ID:", id);
                    alert(`Funcionalidad de edición para el ID ${id} en desarrollo.`);
                }
            });
        }
        //--------------asiganciones---------------------------------
        const tbodyAsignaciones = document.getElementById('tbody-asignaciones');
        
        if (tbodyAsignaciones) {
            tbodyAsignaciones.addEventListener('click', async (e) => {
                // Buscamos el botón más cercano al clic (por si hacen clic en el icono dentro del botón)
                const targetBtn = e.target.closest('button');
                if (!targetBtn) return;

                const id = targetBtn.dataset.id;

                // Lógica para el botón ELIMINAR
                if (targetBtn.classList.contains('btn-delete')) {
                    const confirmar = confirm(`¿Estás seguro de que deseas eliminar la asignacion #${id}?`);
                    
                    if (confirmar) {
                        try {
                            await inventoryAPI.delete("asignaciones", id);
                            
                            // Refrescar datos localmente tras éxito
                            location.reload();
                            const nuevosDatos = await inventoryAPI.getAll("asignaciones");
                            tablaAsignaciones.render(nuevosDatos);
                            
                            alert("Asignacion eliminada correctamente.");
                        } catch (err) {
                            alert("Error al eliminar: " + err.message);
                        }
                    }
                }
        
                // Lógica para el botón EDITAR
                if (targetBtn.classList.contains('btn-edit')) {
                    console.log("Iniciando edición del ID:", id);
                    alert(`Funcionalidad de edición para el ID ${id} en desarrollo.`);
                }
            });
        }

        // --- 4. Gestión del Formulario de Alta ---
        const formModelos = document.getElementById("form-modelos");
        const fomrActivos = document.getElementById("form-activos");
        const formAsignaciones = document.getElementById("form-asignaciones");
        const Fecha_produccion = formModelos.querySelector('[name="Fecha_produccion"]');
        const Fin_soporte = formModelos.querySelector('[name="Fin_soporte"]');

        const fecha_Compra = fomrActivos.querySelector('[name="Fecha_compra"]');
        const garantia = fomrActivos.querySelector('[name="Garantia"]');

        const fecha_asignacion = formAsignaciones.querySelector('[name="Fecha_Asignacion"]');
        const fecha_ultimo = formAsignaciones.querySelector('[name="Ultimo_Soporte"]');
        // 1. Obtenemos la fecha actual en formato YYYY-MM-DD
        const hoy = new Date().toISOString().split('T')[0];

        // 2. Asignamos el valor por defecto
        Fecha_produccion.value = hoy;
        Fin_soporte.value = hoy;
        garantia.value = hoy;
        fecha_Compra.value = hoy;
        fecha_asignacion.value = hoy;
        fecha_ultimo.value = hoy;

        
        if (formModelos) {
            formModelos.addEventListener("submit", async (e) => {
                e.preventDefault();
                
                // Conversión automática de campos del formulario a objeto JSON
                const data = Object.fromEntries(new FormData(formModelos));
                
                try {
                    // Enviar datos a la API
                    await inventoryAPI.create("modelos", data);
                    
                    alert("¡Modelo guardado con éxito!");
                    formModelos.reset(); // Limpiar campos
                    
                    // Recargar la tabla para mostrar el nuevo registro
                    location.reload();
                    const nuevosDatos = await inventoryAPI.getAll("modelos");
                    tablaModelos.render(nuevosDatos);
                    
                } catch (error) {
                    alert("Error al guardar: " + error.message);
                }
            });
        }
        //---------------activos----------------------------
        const selccionModelo = fomrActivos.querySelector('[name="ID_Modelo"]')
        if (datos_modelos) {
            datos_modelos.forEach(item  => {
                const option = document.createElement("option");
    
                option.value = item.ID_Modelo;
                option.textContent = item.Modelo;
                selccionModelo.appendChild(option);
            });
            
        }

        if (fomrActivos) {
            fomrActivos.addEventListener("submit", async (e) => {
                e.preventDefault();
                
                // Conversión automática de campos del formulario a objeto JSON
                const data = Object.fromEntries(new FormData(fomrActivos));
                console.log(data);
                
                
                try {
                    // Enviar datos a la API
                    await inventoryAPI.create("activos", data);
                    
                    alert("¡Modelo guardado con éxito!");
                    fomrActivos.reset(); // Limpiar campos
                    
                    // Recargar la tabla para mostrar el nuevo registro
                    location.reload();
                    const nuevosDatos = await inventoryAPI.getAll("activos");
                    tablaActivos.render(nuevosDatos);
                    
                } catch (error) {
                    alert("Error al guardar: " + error.message);
                }
            });
        }
        //-----------------asignaciones-------------------------
        // 1. Seleccionamos el elemento del DOM (el select)
        const selectActivo = formAsignaciones.querySelector('[name="ID_Activo"]');
        const ID_empleado = formAsignaciones.querySelector('[name="ID_Empleado"]');
        const indicador = document.getElementById('datos_empleado');
        let cedula_valida = false;

        // 2. Verificamos que el select exista Y que tengamos datos para insertar
        if (selectActivo && datos_activos) {
            datos_activos.forEach(item => {
                //console.log("I'm runing");
                let condition = item.Estado
                if(condition.toLowerCase() == "disponible"){
                    const option = document.createElement("option");

                    option.value = item.ID_Activo;
                    let contenido = `${item.ID_Activo}: ${item.Nombre} S/N: ${item.N_Serial}`
                    option.textContent = contenido;
                    selectActivo.appendChild(option);
                }
            });
        }
        // verificar que la cedula exista en la tabla datos_personales 
        if (ID_empleado && datos_personales && datos_empleado) {
            ID_empleado.addEventListener('input', async(event) => {
                // // Obtenemos el valor actual
                const valorActual = event.target.value;
                const comparado = parseInt(valorActual, 10)
                //console.log("El usuario está escribiendo:", typeof(comparado));

                if(valorActual.length >= 6){
                    const resultado = datos_personales.find(persona => persona.cedula === comparado)
                    //console.log(resultado);
                    
                    if (resultado) {
                        console.log("encontrado");
                        console.log(resultado);
                        cedula_valida = true;
                        indicador.className = 'text-green-600'
                        indicador.textContent = resultado.nombres + " " + resultado.apellidos
                        
                    }else{
                        indicador.className = 'text-red-600'
                        indicador.textContent = 'No encontrado'
                        cedula_valida = false;
                        
                    }
                }
                
                // // Aquí puedes ejecutar tu lógica (validaciones, búsquedas, etc.)
                // if (valorActual.length > 5) {
                //     try {
                //         const dato = await intranetAPI.getFicha(valorActual);
                //     } catch (error) {
                //         console.log(error);
                        
                //     }
                // }
            });
        }

        if (formAsignaciones) {
            
            formAsignaciones.addEventListener("submit", async (e) => {
                e.preventDefault();
                
                // Conversión automática de campos del formulario a objeto JSON
                const data = Object.fromEntries(new FormData(formAsignaciones));
                console.log(data);
                
                if (cedula_valida) {
                
                    try {
                        // Enviar datos a la API
                        await inventoryAPI.create("asignaciones", data);
                        
                        alert("¡Asignacion guardada con éxito!");
                        fomrActivos.reset(); // Limpiar campos
                        
                        // Recargar la tabla para mostrar el nuevo registro
                        location.reload();
                        const nuevosDatos = await inventoryAPI.getAll("asignaciones");
                        tablaAsignaciones.render(nuevosDatos);
                        
                    } catch (error) {
                        alert("Error al guardar: " + error.message);
                    }
                }else{
                    console.log("cedula invalida");
                    
                }
            });

        }










    } catch (error) {
        console.error("Error crítico en la inicialización:", error);
    }


});