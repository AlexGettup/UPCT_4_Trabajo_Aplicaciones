<?php
session_start();
//Includes
include ("funciones_php.php");
include ("funciones_sql.php");

//Session close
if(isset($_GET['logout'])){
    session_unset();
    session_destroy();
    echo '<div class="alert alert-success text-center font-weight-bold" role="alert">
            Has cerrado la sesión correctamente. 
                </div>';
}

//Check Registro
if(isset($_POST['reg_nombre']) AND isset($_POST['reg_password'])) {
    //Foto
    if(is_uploaded_file($_FILES['reg_pic']['tmp_name'])){
        $target_dir = "images/";
        $target_name = md5(time().rand()) . ".jpg";
        $target_file = $target_dir . $target_name;
        move_uploaded_file($_FILES["reg_pic"]["tmp_name"], $target_file);
    }else{
        $target_name = "no_pic.jpg";
    }
    $resultado = sRegister($_POST['reg_nombre'], $_POST['reg_edad'], $_POST['reg_sexo'], $_POST['reg_ocupacion'], sha1($_POST['reg_password']), $target_name);
    if(isset($resultado)){
        $_SESSION['user'] = $resultado;
        echo '<div class="alert alert-success text-center font-weight-bold" role="alert">
            Te has registrado correctamente, bienvenido '.sGetUsername($resultado).'. </div>';
    }
}

//Check Login
if(isset($_POST['username']) AND isset($_POST['passwd'])){
    $resultado = sCheckPassword($_POST['username'], sha1($_POST['passwd']));
    if(isset($resultado)){
        $_SESSION['user'] = $resultado;
        echo '<div class="alert alert-success text-center font-weight-bold" role="alert">
            Bienvenido otra vez '.sGetUsername($resultado).'.
                </div>';
    }else{
        echo '<div class="alert alert-danger text-center font-weight-bold" role="alert">
            Usuario o contraseña incorrecta.
                </div>';
    }
}





//Current page number
if (isset($_GET['page'])) {
    $page = $_GET['page'];
} else {
    $page = 1;
}

//Php pagination
$movies_per_page = 12;
$offset = ($page-1) * $movies_per_page;

//Total number of pages
$total_movies = sGetTotalMovies();
$total_pages = ceil($total_movies / $movies_per_page);


//Puntuation
$total_avg_score = sGetTotalAvgRating();

//Order
if(isset($_GET['mode'])){
    $mode = $_GET['mode'];
}else{
    $mode = 'TITLE';
}

?>

<!DOCTYPE html>
<html lang="es">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>September Movies</title>

  <!-- Bootstrap core CSS -->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom styles for this template -->
    <link href="css/custom.css" rel="stylesheet">

</head>

<body>

  <!-- Navigation -->
<?php echo getNavigation() ?>

  <!-- Page Content -->
  <div class="container">

    <!-- Jumbotron Header -->
    <?php if ($page == 1)  echo getJumbo(); ?>

    <!-- Page Features -->
    <?php echo getPagination($page, $total_pages, $mode);
    echo getCatalog($offset, $movies_per_page, $total_movies, $total_avg_score, $mode);
    echo getPagination($page, $total_pages, $mode);?>


    </div>
    <!-- /.row -->

  </div>
  <!-- /.container -->

  <!-- Footer -->
<?php echo getFooter();
echo getloginModal();?>

  <!-- Bootstrap core JavaScript -->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

</body>

</html>
