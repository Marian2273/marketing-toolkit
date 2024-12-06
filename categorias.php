<?php include ("functions/functions.php");?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no, viewport-fit=cover"/>
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <title>Marketing Toolkit</title>
    <link rel="manifest" crossorigin="use-credentials" href="manifest.json" />
    <link rel="stylesheet" href="dist/add-to-homescreen.min.css" />
    <script defer src="dist/add-to-homescreen_es.min.js"></script>
    <link rel="stylesheet" href="css/line-awesome.min.css">
    <link rel="stylesheet" href="css/style.css">
    <meta name="theme-color" content="#070713">
    <!-- js -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript" src="js/bootstrap-3.1.1.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<script src="js/jquery.min.js"></script>

</head>

<body class="toolkit">

<header>
        <nav>
      
            <div class="info">
             <img src="img/logo-ITP_blanco.png" id="logo" />
            <p class="hola"> ¡Hola <?php echo   get_user_activo($user_toolkit); ?>!</p>
          </div>
        </nav> 

        <div class="search">
        
            <input type="text" placeholder="Buscador" id="busqueda">
            <button class="btn-buscar" onclick="buscar()"><span class="las la-search"></span></button>
        </div>

    </header>
<main>   
    <!-- Favoritos -->
<div class="favoritos section-wrapper">

<!-- Contenedor donde se mostrarán los resultados -->
<div class="items promo-items" id="resultados"> </div>
    <div class="items promo-items" id="results"> </div>
</div>    
<!-- ..// Fin de Favoritos -->


<?php include ("includes/categorias.php");?>


<!-- Popular tags -->
<div class="tags section-wrapper" >
    <div class="promo">
        <h3 class="fav titulo-tags">   #Popular tags  </h3>
        <hr>
          <div class="">
          <?php get_tags();?>
        </div>
              

         </div>
    </div>  
</div>
<!-- ..// fin popular tags -->

</main>


<?php include('includes/nav-footer.php'); ?>
    <script>
   // Selecciona todos los botones de "like" en la página
        document.querySelectorAll('.like-btn').forEach(button => {
        button.addEventListener('click', function() {
        const heart = this.querySelector('.heart');
        const postId = this.getAttribute('data-postid');
        const userId = this.getAttribute('data-userid');

        // Cambia el estado visual del like
        heart.classList.toggle('liked');

        // Define el estado de "liked" (1 si está liked, 0 si no)
        const liked = heart.classList.contains('liked') ? 1 : 0;

        // Envía la información al servidor
        fetch('like.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ postId, userId, liked })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                console.log(`Like actualizado para post ${postId}`);
            } else {
                console.error('Error al actualizar el like');
            }
        })
        .catch(error => console.error('Error:', error));
    });
});

</script>  
<script>
        $(document).ready(function() {
            $('.search-link').on('click', function(e) {
                e.preventDefault(); // Evita que el enlace recargue la página
                
                // Obtén el id_categoria desde el atributo data
                let idCategoria = $(this).data('id-categoria');
                
                // Realiza la petición AJAX
                $.ajax({
                    url: 'buscar-categoria.php', // Archivo PHP que procesará la solicitud
                    type: 'GET',
                    data: { id_categoria: idCategoria },
                    success: function(response) {
                        // Muestra los resultados en el div
                        $('#results').html(response);
                         // Desplazar la página hacia arriba
                        $('html, body').animate({
                        scrollTop: 0
                        }, 500); // 500 ms para el desplazamiento
                    },
                    
                    error: function() {
                        $('#results').html('<p>Error al realizar la búsqueda.</p>');
                    }
                });
            });
        });
    </script>
    <script>
// Escuchar el evento 'keydown' en el campo de entrada
document.getElementById('busqueda').addEventListener('keydown', function(event) {
    if (event.key === 'Enter') {  // Detecta la tecla Enter
        event.preventDefault();   // Evita el comportamiento predeterminado
        buscar();                 // Llama a la función buscar
    }
});

function buscar() {
    const query = document.getElementById('busqueda').value;

    // Crear la petición AJAX
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'buscar.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function () {
        if (this.status === 200) {
            document.getElementById('resultados').innerHTML = this.responseText;
        }
    };

    // Enviar los datos de la búsqueda
    xhr.send('query=' + encodeURIComponent(query));
}

</script>
</body>
</html>