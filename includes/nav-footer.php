
<!-- Nav Abajo -->
<div class="bottom-nav">
    <div class="bottom-inner">
        <div class="bottom-main">
            
            <div class="nav-items">
            <?php 
           foreach ($iconos as $nombre => $datos): ?>
            <div class="nav-item">
                <?php if ($nombre === 'perfil'): ?>
                    <!-- Logout con confirmación -->
                    <a href="<?php echo $datos['link']; ?>" onclick="confirmLogout(event, '<?php echo $datos['link']; ?>')">
                        <img src="<?php echo $datos[$nombre === $seccion ? 'blanco' : 'azul']; ?>" alt="Icono <?php echo $nombre; ?>">
                    </a>
                <?php else: ?>
                    <!-- Otros enlaces normales -->
                    <a href="<?php echo $datos['link']; ?>">
                        <img src="<?php echo $datos[$nombre === $seccion ? 'blanco' : 'azul']; ?>" alt="Icono <?php echo $nombre; ?>">
                    </a>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
        
                
            
        </div>
    </div>
</div>
</div>
<script>
function confirmLogout(event, link) {
    event.preventDefault(); // Previene la redirección inmediata
    Swal.fire({
        title: '¿Estás seguro que queres salir?',
        text: "Se cerrará tu sesión.",
     
        showCancelButton: true,
        confirmButtonColor: '#16b2fba1',
        cancelButtonColor: '#16b2fba1',
        confirmButtonText: 'Sí, salir',
        cancelButtonText: 'No'
    }).then((result) => {
        if (result.isConfirmed) {
            // Si el usuario confirma, redirige al enlace proporcionado
            window.location.href = link;
        }
    });
}
</script>    
<!-- ..// Nav Abajo -->  