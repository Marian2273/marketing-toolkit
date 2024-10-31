
<!-- Nav Abajo -->
<div class="bottom-nav">
    <div class="bottom-inner">
        <div class="bottom-main">
            
            <div class="nav-items">
            <?php foreach ($iconos as $nombre => $datos): ?>
                <div class="nav-item">
                <a href="<?php echo $datos['link']; ?>">
                <img src="<?php echo $datos[$nombre === $seccion ? 'blanco' : 'azul']; ?>" alt="Icono <?php echo $nombre; ?>">
                   
                </div>
           
            <?php endforeach; ?>
                
            
        </div>
    </div>
</div>
</div>    
<!-- ..// Nav Abajo -->  