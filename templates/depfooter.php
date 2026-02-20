        </div>
    </div>

</body>
<!-- <script>
    // Esperamos a que la página cargue completamente
    document.addEventListener("DOMContentLoaded", function() {
        
        // Verificamos si hay parámetros en la URL (como ?status o ?error)
        if (window.location.search.length > 0) {
            
            // Usamos un pequeño delay para asegurar que cualquier alert() previo se ejecute
            setTimeout(function() {
                if (window.history.replaceState) {
                    // Creamos la nueva URL sin parámetros
                    const cleanUrl = window.location.protocol + "//" + window.location.host + window.location.pathname;
                    
                    // Reemplazamos la URL en el historial sin recargar la página
                    window.history.replaceState({ path: cleanUrl }, '', cleanUrl);
                }
            }, 500); // 500ms de gracia
        }
    });
</script> -->
</html>