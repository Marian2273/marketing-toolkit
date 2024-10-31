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

<!-- //js -->
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
        <div class="promo">
            <h3 class="fav titulo-categorias"> <img src="img/Iconos_Botonera-19.png" class="icono-categoria"/> <span> Archivos </span> </h3>
            <div class="items promo-items" id="resultados">
               <?php get_favoritos(); ?>

            
            </div>
        </div>
    </div>
</div>    
<!-- ..// Fin de Favoritos -->

         

<!-- Categorias -->
<div class="categorias section-wrapper" >
    <div class="promo">
        <h3 class="fav">  <span class="las la-star"></span> Categorías
        </h3>
          <div class="logos-categorias">
            <div class="mainframe">
                <a href=""><img src="img/Iconos_Categoria-05.png"></a>
                    <p>Mainframe</p>
            </div>
            <div class="mainframe">
                <a href=""><img src="img/Iconos_Categoria-09.png"></a>
                    <p>Cobol Studio</p>
            </div>
            <div class="mainframe">
                <a href=""><img src="img/Iconos_Categoria-08.png"></a>
                    <p>Data Innovation</p>
            </div>
        </div>  

        <div class="logos-categorias">
            <div class="mainframe">
                <a href=""><img src="img/Iconos_Categoria-10.png"></a>
                    <p>Software Studio</p>
            </div>
            <div class="mainframe">
                <a href=""><img src="img/Iconos_Categoria-11.png"></a>
                    <p>IT Services</p>
            </div>
            <div class="mainframe">
                <a href=""><img src="img/Iconos_Categoria-12.png"></a>
                    <p>Learning Services</p>
            </div>
        </div>  

        <div class="logos-categorias">
            <div class="mainframe">
                <a href=""><img src="img/Iconos_Categoria-13.png"></a>
                    <p>Digital Talent</p>
            </div>
            <div class="mainframe">
            <a href=""><img src="img/Iconos_Categoria-15.png"></a>
                    <p>Data center</p>
            </div>
            <div class="mainframe">
            <a href=""><img src="img/Iconos_Categoria-14.png"></a>
                    <p>Empresa B</p>
            </div>
        </div>  

        <div class="logos-categorias">
            <div class="mainframe">
                <a href=""><img src="img/Iconos_Categoria-16.png"></a>
                    <p>OPTI</p>
            </div>
            <div class="mainframe">
            <a href=""><img src="img/Iconos_Categoria-18.png"></a>
                    <p>Centreon</p>
            </div>
            <div class="mainframe">
            <a href=""><img src="img/Iconos_Categoria-17.png"></a>
                    <p>Dataiku</p>
            </div>
        </div>  

    </div>  
</div>
<!-- ..// fin categorias -->

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

</body>
</html>