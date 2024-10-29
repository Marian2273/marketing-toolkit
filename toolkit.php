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
            <span class="las la-search"></span>
            <input type="text" placeholder="Buscador">
        </div>

    </header>
<main>   
    <!-- Favoritos -->
<div class="favoritos section-wrapper">
        <div class="promo">
            <h3 class="fav">  <span class="las la-heart"></span> Favoritos </h3>
            <div class="items promo-items">
                <div class="promo-item">
                  
                    <div class="promo-info">
                            <img src="preview/preview-pdf.png" class="img-responsive" />
                            <p>Minframe Caso de éxito</p>
                            <div class="seccion-compartir">
                            <a href="https://wa.me/?text=Mira%20este%20archivo%20PDF:%20<?php echo urlencode($archivoUrl); ?>" target="_blank"><img src="img/whatsapp_icon.png" class="compartir" /></a>
                            <a href=""><img src="img/envelope_email_icon.png" class="compartir" /></a>
                            <a href=""><img src="img/fav-negro.png" class="compartir" /></a>
                            </div>
                    </div>
                </div>

                <div class="promo-item">
                  
                    <div class="promo-info">
                        <img src="preview/preview-pdf.png" class="img-responsive" />
                        <p>Minframe Caso de éxito</p>
                        <div class="seccion-compartir">
                            <a href="https://wa.me/?text=Mira%20este%20archivo%20PDF:%20<?php echo urlencode($archivoUrl); ?>" target="_blank"><img src="img/whatsapp_icon.png" class="compartir" /></a>
                            <a href=""><img src="img/envelope_email_icon.png" class="compartir" /></a>
                            <a href=""><img src="img/fav-negro.png" class="compartir" /></a>
                        </div>
                    </div>
                </div>
               

            </div>
        </div>
    </div>
</div>    
<!-- ..// Fin de Favoritos -->
<!-- Articulos -->
<div class="articulos section-wrapper" >
    <div class="promo">
        <div class="">
            <h3 class="fav"><span class="las la-file-alt"></span> Últimos artículos</h3>
            <a href="" class="btn btn-primary btn-tags mas">+ artículos</a>
        </div>
        
        
            <div class="items promo-items pdf">
            <div class="promo-item" style="background-image: url(preview/preview-pdf.png)">
                    <div class="promo-info">
                    
                     
                        <a href="">Caso de éxito</a>
                    </div>
                </div>
                <div class="promo-item" style="background-image: url(preview/preview-pdf.png)">
                    <div class="promo-info">
                    
                       
                        <a href="">Compartir</a>
                    </div>
                </div>

                <div class="promo-item" style="background-image: url(preview/preview-pdf.png)">
                    <div class="promo-info">
                    
                        
                        <a href="">Compartir</a>
                    </div>
                </div>

                <div class="promo-item" style="background-image: url(preview/preview-pdf.png)">
                    <div class="promo-info">
                    
                        
                        <a href="">Compartir</a>
                    </div>
                </div>
               

            </div>
    </div>  
</div>
<!-- ..// fin articulos -->

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
        <h3 class="fav titulo-tags">   # Popular tags  </h3>
        <hr>
          <div class="">
          <div class="content-tags">
                <a href="" class="btn btn-primary btn-tags">#lorenints</a>
                    
            </div>
            <div class="content-tags">
                <a href="" class="btn btn-primary btn-tags">#lorenints</a>
                    
            </div>
            <div class="content-tags">
                <a href="" class="btn btn-primary btn-tags">#lorenints</a>
                    
            </div>
          </div>
              

            </div>
    </div>  
</div>
<!-- ..// fin popular tags -->

</main>



<div class="bottom-nav">
        <div class="bottom-inner">
            <div class="bottom-main">
                <div class="nav-items">
                    <div class="nav-item">
                        <a href="hola.php"><img src="img/Iconos_Botonera-17.png"/></a>
                       
                    </div>
                    <div class="nav-item">
                    <a href="hola.php"><img src="img/Iconos_Botonera-22.png"/></a>
                       
                    </div>
                
                
                
                
                    <div class="nav-item">
                    <a href="hola.php"><img src="img/Iconos_Botonera-23.png"/></a>
                      
                    </div>
                    <div class="nav-item">
                    <a href="hola.php"><img src="img/Iconos_Botonera-24.png"/></a>
                      
                    </div>
                
            </div>
        </div>
    </div>
    </div>        
</body>
</html>