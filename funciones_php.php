<?php

//FUNCIONES GENERALES//
function getNavigation(){

    $devolver = '';
    $devolver .= '  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">
      <a class="navbar-brand" href="./index.php">September Movies</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item active">
            <a class="nav-link" href="./index.php">Inicio
              <span class="sr-only">(current)</span>
            </a>
          </li>';
    if(isset($_SESSION['user'])){
        $username = sGetUsername($_SESSION['user']);
        $devolver.= '<li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'.$username.'</a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="user.php?id='.$_SESSION['user'].'">'.$username.'</a>
            <a class="dropdown-item" href="index.php?logout">Close Session</a>
        </div>
        
      </li><img src="images/'.sGetProfilePic($_SESSION['user']).'" alt="'.$username.'" height="42" width="42" class="rounded-circle">';
    }else{
        $devolver.= '<li class="nav-item"><a class="nav-link" href="#" data-toggle="modal" data-target="#loginModal">Registro / Login</a>';
    }

    $devolver.= '
          </li>
        </ul>
      </div>
    </div>
  </nav>';

    return $devolver;
}

function getFooter(){
    $devolver = '';
    $devolver .= '  
    <footer class="py-5 bg-dark">
    <div class="container">
      <p class="m-0 text-center text-white">Copyright &copy; 2019</p>
    </div>
    <!-- /.container -->
  </footer>';

    return $devolver;
}

function getloginModal(){
    $devolver = '';
    $devolver.= '
    <div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="loginModalLabel">Registro / Login</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <label class=""><h5>Login</h5></label>
      <form class="" action="index.php" method="POST">
        <div class="row">
          <div class="col-md-6 mb-3">
            <label for="id">Username</label>
            <input type="text" class="form-control" name= "username" id="id" placeholder="" value="" required>
          </div>
          <div class="col-md-6 mb-3">
            <label for="passwd">Password</label>
            <input type="password" class="form-control" name= "passwd" id="passwd" placeholder="" value="" required>
          </div>
          <div class="col-md-3 mb-3">
                <button type="submit" class=" btn btn-dark">Login</button>
            </div>
        </div>
        </form>
              <label class=""><h5>¿Aún no estás registrado? Regístrate</h5></label>
      <form enctype="multipart/form-data" class="" method="post" action="index.php">
        <div class="row">
          <div class="col-md-6 mb-3">
            <label for="reg_nombre">Nombre</label>
            <input type="text" class="form-control" id="reg_nombre" name="reg_nombre" placeholder="" value="" required>
          </div>
          <div class="col-md-6 mb-3">
            <label for="reg_edad">Edad</label>
            <input type="number" class="form-control" id="reg_edad" name="reg_edad" placeholder="" value="" min="0" max="255" required>
          </div>
            <div class="col-md-6 mb-3">
            <label for="reg_sexo">Sexo</label><br>
            <input type="radio" name="reg_sexo" value="M" checked required>
            <label class="" for="M">M</label>
            <input type="radio" name="reg_sexo" value="F" required>
            <label class="" for="M">F</label>
          </div>
          <div class="col-md-6 mb-3">
            <label for="reg_ocupacion">Ocupation</label>
            <select id="reg_ocupacion" class="form-control" name="reg_ocupacion" required>
                <option value="administrator" style="text-transform: capitalize">administrator</option>
                <option value ="artist" style="text-transform: capitalize">artist</option>
                <option value="doctor" style="text-transform: capitalize">doctor</option>
                <option value ="educator" style="text-transform: capitalize">educator</option>
                <option value="engineer" style="text-transform: capitalize">engineer</option>
                <option value ="entertainment" style="text-transform: capitalize">entertainment</option>
                <option value="executive" style="text-transform: capitalize">executive</option>
                <option value ="healthcare" style="text-transform: capitalize">healthcare</option>
                <option value="homemaker" style="text-transform: capitalize">homemaker</option>
                <option value ="lawyer" style="text-transform: capitalize">lawyer</option>
                <option value="librarian" style="text-transform: capitalize">librarian</option>
                <option value ="marketing" style="text-transform: capitalize">marketing</option>
                <option value="none" style="text-transform: capitalize">none</option>
                <option value ="other" style="text-transform: capitalize">other</option>
                <option value="programmer" style="text-transform: capitalize">programmer</option>
                <option value ="retired" style="text-transform: capitalize">retired</option>
                <option value="salesman" style="text-transform: capitalize">salesman</option>
                <option value ="scientist" style="text-transform: capitalize">scientist</option>
                <option value ="student" style="text-transform: capitalize">student</option>
                <option value="technician" style="text-transform: capitalize">technician</option>
                <option value ="writer" style="text-transform: capitalize">writer</option>
            </select>
          </div>
          <div class="col-md-6 mb-3">
            <label for="">Password</label>
            <input type="password" class="form-control" id="reg_password" name="reg_password" placeholder="" value="" required>
          </div>
            <div class="col-md-6 mb-3">
                <label for="reg_pic">Subir foto de perfil</label>
                <input type="file" class="form-control-file" id="reg_pic" name="reg_pic">
            </div>
          <div class="col-md-3 mb-3">
          <br>
                <button type="submit" class=" btn btn-dark btn-lg">Registro</button>
            </div>
        </div>
        </form>
      </div>
    </div>
  </div>
</div>
    ';
    return $devolver;
}

//FUNCIONES CATALOGO//
function getJumbo(){
    $devolver = '      
      <header class="my-4">
          <div class="overlay"></div>
          <video playsinline="playsinline" autoplay="autoplay" muted="muted" loop="loop">
              <source src="./videos/jumbo.mp4" type="video/mp4">
          </video>
          <div class="container h-100">
              <div class="d-flex h-100 text-center align-items-center">
                  <div class="w-100 text-white">
                      <h1 class="display-1">September Movies</h1>
                      <p class="lead mb-0">Tus películas favoritas en época de exámenes.</p>
                  </div>
              </div>
          </div>
      </header>';
    return $devolver;
}

function getCatalog($offset, $movies_per_page, $total_movies, $total_avg_score, $mode){
    $devolver = '
    <div class="row">';
    $datos = sGetPages($offset, $movies_per_page, $mode);
    foreach($datos as $movie){
        $id = $movie['id'];
        $title = $movie['title'];
        $date = $movie['date'];
        $pic = $movie['url_pic'];
        $desc = $movie['desc'];
        $ratings_movie = sGetTotalRatingsMovie($id);
        $avg_score_movie = sGetAvgRatingsMovie($id);
        $final_rating = weightedRating($total_movies, $total_avg_score, $ratings_movie, $avg_score_movie);
        $devolver.= '
          <div class="col-lg-3 col-md-4 mb-4">
              <div class="card h-100">
                  <a href="#"><img class="card-img-top" src="./images/'.$pic.'" alt="" height="330px" width="250px"></a>
                  <div class="card-body">
                      <h4 class="card-title">
                          <a href="./movie.php?id='.$id.'">'.$title.'</a>
                      </h4>
                      <ul class="list-group list-group-flush">
                          <li class="list-group-item ">'.$desc.'</li>
                          <li class="list-group-item">'.$date.'</li>
                          <li class="list-group-item"><strong>Rating:</strong> '.$avg_score_movie.' Stars ('.$ratings_movie.')</li>
                          <li class="list-group-item"><strong>Weighted Rating:</strong> '.$final_rating.' Stars</li>
                      </ul>
                  </div>
              </div>
          </div>';
    }

    $devolver.='
      </div>
    ';
    return $devolver;
}

function getPagination($page, $total_pages, $mode){
    //Para las paginas
    if($page <= 1){
        $state_first = 'disabled';
        $href_first = '#';
    }else{
        $state_first = '';
        $href_first = '?page='.($page - 1).'&mode='.$mode;
    }

    if($page >= $total_pages){
        $state_last = 'disabled';
        $href_last = '#';
    }else{
        $state_last = '';
        $href_last = '?page='.($page + 1).'&mode='.$mode;
    }
    $devolver = '
<label class="col-lg-2">ORDER BY</label><a class="btn btn-dark col-lg-1 mx-2" href="index.php?mode=TITLE" role="button">Title</a><a class="btn btn-dark col-lg-1" href="index.php?mode=RATE" role="button">Rating</a>
          <!-- Pagination -->
      <ul class="pagination justify-content-center">
          <li class="page-item">
              <a class="page-link" href="?page=1&mode='.$mode.'" aria-label="First">
                  <span aria-hidden="true">&laquo;</span>
                  <span class="sr-only">First</span>
              </a>
          </li>
          <li class="page-item '.$state_first.'">
              <a class="page-link" href="'.$href_first.'">Prev</a>
          </li>
          <li class="page-item '.$state_last.'">
              <a class="page-link" href="'.$href_last.'">Next</a>
          </li>
          <li class="page-item">
              <a class="page-link" href="?page='.$total_pages.'&mode='.$mode.'" aria-label="Next">
                  <span aria-hidden="true">&raquo;</span>
                  <span class="sr-only">Last</span>
              </a>
          </li>
      </ul> 
    ';
    return $devolver;
}


//FUNCIONES MOVIES//
function getComments($id){
    $devolver = '';
    $datos = sGetAllComments($id);
    foreach($datos as $data){
        $usuario = sGetUsername($data['user_id']);
        $comment = $data['comment'];
        $devolver.= '
                    <div class="media text-muted col-md-12 col-lg-12x">
                        <p class="media-body pb-3 mb-0">
                            <strong class="d-block text-dark">'.$usuario.'</strong>
                            '.$comment.'
                        </p>
                    </div>
    ';
    }

    return $devolver;
}

function getRatingModal($id_movie, $id_user){
    $check = sCheckRatingUser($id_user, $id_movie);
    if(isset($check)){
        $score = $check;
    }else{
        $score = '0';
    }
    $devolver = '';
    $devolver.= '
    <div class="modal fade" id="ratingModal" tabindex="-1" role="dialog" aria-labelledby="ratingModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="loginModalLabel">Rating</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <label class=""><h5>Your rating</h5></label>
      <form class="" action="movie.php?id='.$id_movie.'" method="POST">
        <div class="row">
          <div class="col-md-6 mb-3">
            <input type="number" class="form-control" name= "rating" id="rate" min="1" max="5" step="1" value="'.$score.'" required>
          </div>
          <input type="text" name="rate_user" value="'.$id_user.'"hidden>
          <div class="col-md-6 mb-3">
                <button type="submit" class=" btn btn-dark">Rate</button>
            </div>
        </div>
        </form>
      </div>
    </div>
  </div>
</div>
    ';
    return $devolver;
}

function getGenres($id){
    $devolver = '
    <div class="row">';
    $datos = sGetGenres($id);
    foreach($datos as $movie){
        $genre = $movie['name'];
        $devolver.= '
          <div class="col-lg-2">
          <span class="badge badge-pill badge-dark">'.$genre.'</span>
          </div>';
    }

    $devolver.='
      </div>
    ';
    return $devolver;
}

//FUNCIONES USER//
function getUserModal($id){
    $datos = sGetAllUser($id);
    foreach($datos as $person){
        $username = $person['name'];
        $age = $person['edad'];
        $sex = $person['sex'];
        $ocu = $person['ocupacion'];
        $pic = $person['pic'];
    }
    if($sex == 'M'){
        $checked_m = 'checked';
        $checked_f = '';
    }else{
        $checked_m = '';
        $checked_f = 'checked';
    }

    $devolver = '';
    $devolver.= '
    <div class="modal fade" id="userModal" tabindex="-1" role="dialog" aria-labelledby="userModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="userModalLabel">Edit</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <label class=""><h5>Edit your info</h5></label>
      <form enctype="multipart/form-data" class="" action="user.php?id='.$id.'" method="POST">
        <div class="row">
          <div class="col-md-6 mb-3">
          <label for="edit_username">Username</label>
            <input type="text" class="form-control" name= "edit_username" id="edit_username"  value="'.$username.'" required>
          </div>
        <div class="col-md-6 mb-3">
          <label for="edit_age">Age</label>
            <input type="number" class="form-control" name= "edit_age" id="edit_age" min="0" max="255" step="1" value="'.$age.'" required>
         </div>
         <div class="col-md-6 mb-3">
            <label for="edit_sex">Sexo</label><br>
            <input type="radio" name="edit_sex" value="M" '.$checked_m.' required>
            <label class="" for="M">M</label>
            <input type="radio" name="edit_sex" value="F" '.$checked_f.' required>
            <label class="" for="F">F</label>
         </div>
          <div class="col-md-6 mb-3">
            <label for="edit_ocupacion">Ocupation</label>
            <select id="edit_ocupacion" class="form-control" name="edit_ocupacion" required>
                <option value="administrator" style="text-transform: capitalize">administrator</option>
                <option value ="artist" style="text-transform: capitalize">artist</option>
                <option value="doctor" style="text-transform: capitalize">doctor</option>
                <option value ="educator" style="text-transform: capitalize">educator</option>
                <option value="engineer" style="text-transform: capitalize">engineer</option>
                <option value ="entertainment" style="text-transform: capitalize">entertainment</option>
                <option value="executive" style="text-transform: capitalize">executive</option>
                <option value ="healthcare" style="text-transform: capitalize">healthcare</option>
                <option value="homemaker" style="text-transform: capitalize">homemaker</option>
                <option value ="lawyer" style="text-transform: capitalize">lawyer</option>
                <option value="librarian" style="text-transform: capitalize">librarian</option>
                <option value ="marketing" style="text-transform: capitalize">marketing</option>
                <option value="none" style="text-transform: capitalize">none</option>
                <option value ="other" style="text-transform: capitalize">other</option>
                <option value="programmer" style="text-transform: capitalize">programmer</option>
                <option value ="retired" style="text-transform: capitalize">retired</option>
                <option value="salesman" style="text-transform: capitalize">salesman</option>
                <option value ="scientist" style="text-transform: capitalize">scientist</option>
                <option value ="student" style="text-transform: capitalize">student</option>
                <option value="technician" style="text-transform: capitalize">technician</option>
                <option value ="writer" style="text-transform: capitalize">writer</option>
            </select>
          </div>
          <div class="col-md-6 mb-3">
                <label for="edit_pic">Subir foto de perfil</label>
                <input type="file" class="form-control-file" id="edit_pic" name="edit_pic">
            </div>
            <input type="text" name="edit_id" value="'.$id.'" hidden>
          <div class="col-md-6 mb-3">
                <button type="submit" class=" btn btn-dark">Edit</button>
            </div>
        </div>
        </form>
      </div>
    </div>
  </div>
</div>
    ';
    return $devolver;
}

function getRecs($id_user){
    $devolver = '
    <div class="row">';
    $datos = sGetRecs($id_user);
    foreach($datos as $movie){
        $id = $movie['id'];
        $title = $movie['title'];
        $date = $movie['date'];
        $pic = $movie['url_pic'];
        $desc = $movie['desc'];
        $avg_score_movie = sGetAvgRatingsMovie($id);
        $ratings_movie = sGetTotalRatingsMovie($id);

        $devolver.= '
          <div class="col-lg-4 col-md-4 mb-4">
              <div class="card h-100">
                  <a href="#"><img class="card-img-top" src="./images/'.$pic.'" alt="" height="330px" width="250px"></a>
                  <div class="card-body">
                      <h4 class="card-title">
                          <a href="./movie.php?id='.$id.'">'.$title.'</a>
                      </h4>
                      <ul class="list-group list-group-flush">
                          <li class="list-group-item ">'.$desc.'</li>
                          <li class="list-group-item">'.$date.'</li>
                          <li class="list-group-item"><strong>Rating:</strong> '.$avg_score_movie.' Stars ('.$ratings_movie.')</li>
                      </ul>
                  </div>
              </div>
          </div>';
    }

    $devolver.='
      </div>
    ';
    return $devolver;
}
//FUNCIONES MISC//
function weightedRating($total_movies, $total_avg_score, $ratings_movie, $avg_score_movie){
    return (($total_movies*$total_avg_score) + ($ratings_movie*$avg_score_movie)) / ($total_movies+$ratings_movie);
}

function recommendation($id_user){
    $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
    socket_connect($socket, "localhost", 4450);

    $ruta="C:\\xampp7\htdocs\ai\matlab\r\n";
    $fun = "recommendation(".$id_user.")\r\n";

    $info = $ruta.$fun.chr(0);
    $sent=socket_write($socket, $info, strlen($info));

    socket_close($socket);

    if($sent > 0){
        $resultado = true;
    }else{
        $resultado = false;
    }

    return $resultado;
}







