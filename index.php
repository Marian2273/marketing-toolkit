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

<body class="inicio">
 <div class="container-centro">
 <div class="centro">
<a href="login.php"class="btn btn-primary btn-ingresar"> Ingresar </a> 
</div> 
</div>
 <!-- ====================  BEGIN: initialize add-to-homescreen library  ==================== -->

    <script>
      window.addEventListener("load", function () {
        window.AddToHomeScreenInstance = window.AddToHomeScreen({
          appName: "Marketing Toolkit", // Name of the app. [Required]
          appNameDisplay: "standalone", // Display position of the app name [Optional]
          appIconUrl: "./dist/assets/sample/img/icono-s-toolkit.png", // App icon link (square, at least 40 x 40 pixels) [Required]
          assetUrl: "dist/assets/img/", // Link to directory of library image assets [Required]
          maxModalDisplayCount: -1, // If set, the modal will only show this many times [Optional. Default: -1 (no limit).]
          // (Debugging: Use this.clearModalDisplayCount() to reset the count)
        });
        window.AddToHomeScreenInstance.show("es"); // popup is only shown if web app is not already added to homescreen
      });
    </script>
  <!--  ====================  END: initialize add-to-homescreen library  ==================== -->
 
</body>
</html>