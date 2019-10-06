<?php
session_start();
//Includes
include ("funciones_php.php");
include ("funciones_sql.php");

if(isset($_GET['id'])){
    $id = $_GET['id'];
    $datos = sGetAllUser($id);
    foreach($datos as $person){
        $username = $person['name'];
        $age = $person['edad'];
        $sex = $person['sex'];
        $ocu = $person['ocupacion'];
        $pic = $person['pic'];
    }

    if(isset($_GET['recomendation'])){
        $status = recommendation($id);
        $resultado = 1;    //Ejecutar Script PHP
        if($resultado){
            echo '<div class="alert alert-warning text-center font-weight-bold" role="alert">
            Generando Recomendaciones </div>';
        }
    }

    //Rating made
    if(isset($_POST['edit_username'])){
        //Foto
        if(is_uploaded_file($_FILES['edit_pic']['tmp_name'])){
            $target_dir = "images/";
            $target_name = md5(time().rand()) . ".jpg";
            $target_file = $target_dir . $target_name;
            move_uploaded_file($_FILES["edit_pic"]["tmp_name"], $target_file);
        }else{
            $target_name = "no_pic.jpg";
        }

        $resultado = sEdit($_POST['edit_id'], $_POST['edit_username'], $_POST['edit_age'], $_POST['edit_sex'], $_POST['edit_ocupacion'],  $target_name);
        if($resultado){
            $username = $_POST['edit_username'];
            $age = $_POST['edit_age'];
            $sex = $_POST['edit_sex'];
            $ocu = $_POST['edit_ocupacion'];
            $pic = $target_name;
            echo '<div class="alert alert-success text-center font-weight-bold" role="alert">
            Has editado correctamente tu información. </div>';
        }
    }

}else{
    header("Location: ./index.php");
}

?>

<!DOCTYPE html>
<html lang="es">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title><?php echo $username?></title>

  <!-- Bootstrap core CSS -->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom styles for this template -->
    <link href="css/custom.css" rel="stylesheet">

</head>

<body>

  <!-- Navigation -->
<?php echo getNavigation() ?>

  <!-- Page Content -->
  <div class="container pt-3">

    <!-- Jumbotron Header -->
      <div class="jumbotron p-4 p-md-5 text-white rounded bg-dark ">
          <div class=" px-0">
              <h1 class="display-4 font-italic"><?php echo $username?></h1>
          </div>
      </div>

    <!-- Page Features -->
    <div class="row">

      <div class="col-lg-3 col-md-3 mb-4 h-100">
        <div class="card h-100">
          <img class="card-img-top" src="./images/<?php echo $pic?>" alt="">
        </div>
          <div class="card-footer">
              <div class="row">
                  <div class="col">
                      <label class="font-weight-bold">Age</label>
                  </div>
                  <div class="col">
                      <p><?php echo $age?></p>
                  </div>
              </div>
              <div class="row">
                  <div class="col">
                      <label class="font-weight-bold">Sex</label>
                  </div>
                  <div class="col">
                      <p><?php echo $sex?></p>
                  </div>
              </div>
              <div class="row">
                  <div class="col">
                      <label class="font-weight-bold">Ocupation</label>
                  </div>
                  <div class="col">
                      <p><?php echo $ocu?></p>
                  </div>
              </div>
              <?php
              if(isset($_SESSION['user'])){
                  if(strcmp($_SESSION['user'], $id) == 0){
                      echo '<div class="offset-6 col">
                                <button class="btn btn-dark" data-toggle="modal" data-target="#userModal">Edit</button>
                            </div>';
                  }
              }

              ?>


          </div>
      </div>

      <div class="col-lg-9 col-md-9 mb-4">
        <div class="card h-100">
          <div class="card-body">
            <h4 class="card-title text-center"><a class="btn btn-dark btn-lg" href="user.php?id=<?php echo $id?>&recomendation=1" role="button">Generate Recommendations</a></h4>
            <div class="card-body">
                <div class="mb-3 row col-lg-12 col-md-12 border-bottom border-gray">
                    <!-- AQUI LOS BOTONES -->
                </div>
                <div class="row">
                    <label class="font-weight-bold col-md-12 col-lg-12">Recommendations</label>
                    <?php echo getRecs($_SESSION['user']) ?>
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- /.row -->
  </div>
  <!-- /.container -->

  <!-- Footer -->
  <?php echo getFooter();
  echo getloginModal();
  echo getUserModal($id);?>

  <!-- Bootstrap core JavaScript -->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

</body>

</html>
