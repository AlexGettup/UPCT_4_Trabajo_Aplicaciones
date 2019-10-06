<?php
session_start();
//Includes
include ("funciones_php.php");
include ("funciones_sql.php");

if(isset($_GET['id'])){
    $id = $_GET['id'];
    $datos = sGetAllMovie($id);
    foreach($datos as $movie){
        $title = $movie['title'];
        $date = $movie['date'];
        $imdb = $movie['url_imdb'];
        $pic = $movie['url_pic'];
        $desc = $movie['desc'];
    }
    $avgRating = sGetAvgRatingsMovie($id);
    $numRating = sGetTotalRatingsMovie($id);

    //Comment made
    if(isset($_POST['comment'])){
        $resultado = sComment($id, $_POST['comment_user'], $_POST['comment']);
        if($resultado){
            echo '<div class="alert alert-success text-center font-weight-bold" role="alert">
            Comentario realizado. </div>';
        }
    }

    //Rating made
    if(isset($_POST['rating'])){
        $check = sCheckRatingUser($_POST['rate_user'], $id);
        if(isset($check)){
            $resultado = sUpdateRating($id, $_POST['rate_user'], $_POST['rating']);
        }else{
            $resultado = sInsertRating($id, $_POST['rate_user'], $_POST['rating']);
        }
        if($resultado){
            echo '<div class="alert alert-success text-center font-weight-bold" role="alert">
            Puntuación realizada. </div>';
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

  <title><?php echo $title?></title>

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
              <h1 class="display-4 font-italic"><?php echo $title?></h1>
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
                      <label class="font-weight-bold">Date</label>
                  </div>
                  <div class="col">
                      <p><?php echo $date?></p>
                  </div>
              </div>
              <div class="row">
                  <div class="col">
                      <label class="font-weight-bold">Rating</label>
                  </div>
                  <div class="col">
                      <p><?php echo $avgRating." (".$numRating.")"?></p>
                  </div>
              </div>
              <?php
              if(isset($_SESSION['user'])){
                  echo '
                <div class="row">
                  <div class="col">
                      <label class="font-weight-bold">Your rating</label>
                  </div>
                  <div class="col">';
                      $score = sCheckRatingUser($_SESSION['user'], $id);
                      if(isset($score)){
                          echo "<p>".$score."</p>";
                      }else{
                          echo "NA";
                      }
                      echo '
                  </div>
                </div>
                <div class="offset-6 col">
                  <button class="btn btn-dark" data-toggle="modal" data-target="#ratingModal">Rate</button>
                </div>';
              }
              ?>


          </div>
      </div>

      <div class="col-lg-9 col-md-9 mb-4">
        <div class="card h-100">
          <div class="card-body">
            <h4 class="card-title text-center"><?php echo $title?></h4>
            <div class="card-body">
                <?php echo getGenres($id) ?>
                <div class="mb-3 row col-lg-12 col-md-12 border-bottom border-gray">

                <label class="font-weight-bold">Description</label>
                <p><?php echo $desc?></p>
                </div>
                <div class="row">
                    <label class="font-weight-bold col-md-12 col-lg-12">Comments</label>
                    <?php echo getComments($id)?>
                </div>
                <div class="row">
                    <?php
                    if(isset($_SESSION['user'])){
                        echo '<form class="col-lg-12" method="post" action="movie.php?id='.$id.'">
                        <div class="form-row">
                                <label for="miComentario">Deja tu comentario:</label>
                                <textarea class="form-control" name="comment" id="miComentario" rows="1"></textarea>
                                <input type="text" name="comment_user" value="'.$_SESSION['user'].'"hidden>
                                <button class="btn btn-dark mt-2" type="submit">Comentar</button>
                        </div>
                    </form>';
                    }else{
                        echo '<div class="form-row text-muted"><div class="col-lg-12 col-md-12">Haz login para escribir un mensaje.</div></div>';
                    }
                    ?>

                </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- /.row -->
      <div class="text-center py-2">
          <a class="btn btn-dark" href="./movie.php?id=<?php echo $id-1 ?>"> BACK</a>
          <a class="btn btn-dark" href="./movie.php?id=<?php echo $id+1 ?>"> NEXT</a>
      </div>
  </div>
  <!-- /.container -->

  <!-- Footer -->
  <?php echo getFooter();
  echo getloginModal();
  if (isset($_SESSION['user'])){
      echo getRatingModal($id, $_SESSION['user']);
  }
?>

  <!-- Bootstrap core JavaScript -->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

</body>

</html>
