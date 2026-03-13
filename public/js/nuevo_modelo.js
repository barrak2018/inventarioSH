// ==================== CAPA DE DATOS ====================
import { InventoryService } from "./inventoryService.js";
import config from "./config.json" with { type: "json" };

const db = new InventoryService(config.inventoryAPI_url);

// Variables globales
let categorias = [];
// Definimos caracteristicasEjemplo para que el reset no falle
const caracteristicasEjemplo = [
    { nombre: "Procesador", valor: "Intel i5" },
    { nombre: "RAM", valor: "16GB" }
];

// ==================== FUNCIONES DE RENDERIZADO ====================

function renderOptions(data) {
    if (!Array.isArray(data)) return "";
    return data
        .map(
            (item) =>
                `<option value="${item.ID_Categoria || item.ID_Modelo || item.id}">${item.nombre || item.Nombre}</option>`,
        )
        .join("");
}

// ==================== INICIALIZACIÓN ASÍNCRONA ====================

document.addEventListener("DOMContentLoaded", async function () {
    // Referencias a elementos del DOM constantes
    const form = document.getElementById("formNuevoModelo");
    const container = document.getElementById("caracteristicasContainer"); // Asegúrate de que este ID exista en tu HTML
    const successMessage = document.getElementById("successMessage");

    // 1. Carga de datos desde la API
    try {
        categorias = await db.getAll("categorias");
        if (categorias.length === 0) {
            console.warn("No se encontraron categorías.");
        }
    } catch (error) {
        console.error("Error al cargar datos de la API:", error);
    }

    // 2. Poblar los Selects
    const selectCategoria = document.getElementById("categoria");
    if (selectCategoria) {
        selectCategoria.innerHTML += renderOptions(categorias);
    }

    // --- MANEJO DE EVENTOS ---

    // Envío del Formulario
    form.addEventListener("submit", async function (e) {
        e.preventDefault();

        

        
        const payload = {
            Marca: document.getElementById("fabricante").value,
            Modelo: document.getElementById("nombreModelo").value, 
            Categoria: document.getElementById("categoria").value,
            Especificaciones: JSON.stringify(specs), // Ahora 'specs' existe
        };

        try {
            const result = await db.create("modelos", payload);
            if (result) {
                if (successMessage) successMessage.style.display = "block";
                window.scrollTo({ top: 0, behavior: "smooth" });

                setTimeout(() => {
                    this.reset();
                    if (successMessage) successMessage.style.display = "none";
                    // Limpiar o resetear contenedor de características si existe
                    if (container) {
                        // Aquí podrías volver a renderizar los campos vacíos o ejemplos
                        // container.innerHTML = ""; 
                    }
                }, 3000);
            }
        } catch (err) {
            alert("Error al guardar el modelo: " + err.message);
        }
    });

    // Cancelar
    const btnCancelar = document.getElementById("btnCancelar");
    if (btnCancelar) {
        btnCancelar.addEventListener("click", () => {
            if (confirm("¿Desea salir?")) window.history.back();
        });
    }
});