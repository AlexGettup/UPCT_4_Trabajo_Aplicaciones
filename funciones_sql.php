<?php

//FUNCIONES GENERALES//
function conect(){
    $usuario = 'root';
    $pwd = '';
    $bd="ai";


    $conexion = mysqli_connect("localhost", $usuario, $pwd, $bd);
    if (mysqli_connect_errno()) {
        printf("La conexión falló: %s\n", mysqli_connect_error());
        exit();
    }
    $conexion->set_charset("utf8");
    /* Imprimir el juego de caracteres en uso */
    return $conexion;
}

function sGetAllMovie($id){
    $conexion=conect();

    $sentencia="SELECT * FROM MOVIE WHERE ID = '$id'";

    $ejecucion=$conexion->query($sentencia);
    $devolver=array();
    while($datos=$ejecucion->fetch_assoc()){

        $devolver[]=$datos;
    }
    mysqli_close($conexion);
    return $devolver;
}

function sGetTotalMovies(){

    $conexion=conect();

    $sentencia="SELECT COUNT(*) AS CUENTA FROM MOVIE";

    $ejecucion=$conexion->query($sentencia);
    $devolver='';
    while($datos=$ejecucion->fetch_assoc()){

        $devolver=$datos['CUENTA'];
    }
    mysqli_close($conexion);
    return $devolver;

}

function sGetTotalAvgRating(){

    $conexion=conect();

    $sentencia="SELECT SUM(SCORE)/COUNT(*) AS CUENTA FROM USER_SCORE ";

    $ejecucion=$conexion->query($sentencia);
    $devolver='';
    while($datos=$ejecucion->fetch_assoc()){

        $devolver=$datos['CUENTA'];
    }
    mysqli_close($conexion);
    return $devolver;

}

function sGetTotalRatingsMovie($id){

    $conexion=conect();

    $sentencia="SELECT COUNT(*) AS CUENTA FROM `user_score` WHERE id_movie='$id'";

    $ejecucion=$conexion->query($sentencia);
    $devolver='';
    while($datos=$ejecucion->fetch_assoc()){

        $devolver=$datos['CUENTA'];
    }
    mysqli_close($conexion);
    return $devolver;

}

function sGetAvgRatingsMovie($id){

    $conexion=conect();

    $sentencia="SELECT SUM(SCORE)/COUNT(*) AS CUENTA FROM `user_score` WHERE id_movie = '$id'";

    $ejecucion=$conexion->query($sentencia);
    $devolver='';
    while($datos=$ejecucion->fetch_assoc()){

        $devolver=$datos['CUENTA'];
    }
    mysqli_close($conexion);
    return $devolver;

}

function sWeightedRating($id){
    $conexion=conect();
    $sentencia = "SELECT
    ((SELECT COUNT(*) FROM MOVIE) * (SELECT SUM(SCORE)/COUNT(*) FROM USER_SCORE) + (SELECT COUNT(SCORE))*(SELECT SUM(SCORE)/COUNT(SCORE))) / ((SELECT COUNT(*) FROM MOVIE) + (SELECT COUNT(SCORE))) AS FINAL
    FROM `user_score` GROUP BY ID_MOVIE WHERE ID_MOVIE = '$id'";

    $ejecucion=$conexion->query($sentencia);
    $devolver='';

    if($ejecucion->num_rows<>0){
        while($datos=$ejecucion->fetch_assoc()){

            $devolver=$datos['FINAL'];
        }
    }
    else{
        $devolver = NULL;
    }

    mysqli_close($conexion);
    return $devolver;
}

//FUNCIONES CATALOGO//
function sGetPages($offset, $movies_per_page, $mode){
    $conexion=conect();

    if(strcmp($mode,'TITLE') == 0){
        $sentencia="SELECT * FROM MOVIE ORDER BY title LIMIT $offset, $movies_per_page";
    }else{
        /*$sentencia = "SELECT MOVIE.id, MOVIE.title, MOVIE.date, MOVIE.url_imdb, MOVIE.url_pic, MOVIE.desc,
                      ((SELECT COUNT(*) FROM MOVIE) * (SELECT SUM(USER_SCORE.SCORE)/COUNT(*) FROM USER_SCORE) + (SELECT COUNT(USER_SCORE.SCORE))*(SELECT SUM(USER_SCORE.SCORE)/COUNT(USER_SCORE.SCORE))) / ((SELECT COUNT(*) FROM MOVIE) + (SELECT COUNT(USER_SCORE.SCORE))) AS FINAL
                      FROM MOVIE INNER JOIN USER_SCORE ON MOVIE.id = USER_SCORE.id_movie GROUP BY USER_SCORE.ID_MOVIE ORDER BY FINAL DESC LIMIT $offset, $movies_per_page";
        */
        $sentencia = "SELECT MOVIE.id, MOVIE.title, MOVIE.date, MOVIE.url_imdb, MOVIE.url_pic, MOVIE.desc,
                      (SELECT SUM(USER_SCORE.SCORE)/COUNT(USER_SCORE.SCORE)) AS FINAL
                      FROM MOVIE INNER JOIN USER_SCORE ON MOVIE.id = USER_SCORE.id_movie GROUP BY USER_SCORE.ID_MOVIE ORDER BY FINAL DESC LIMIT $offset, $movies_per_page";
    }

    $ejecucion=$conexion->query($sentencia);
    $devolver=array();
    while($datos=$ejecucion->fetch_assoc()){

        $devolver[]=$datos;
    }
    mysqli_close($conexion);
    return $devolver;
}

//FUNCIONES MOVIE//
function sGetAllComments($id){
    $conexion=conect();

    $sentencia="SELECT * FROM MOVIECOMMENTS WHERE MOVIE_ID = '$id'";

    $ejecucion=$conexion->query($sentencia);
    $devolver=array();
    while($datos=$ejecucion->fetch_assoc()){

        $devolver[]=$datos;
    }
    mysqli_close($conexion);
    return $devolver;
}

function sComment($movie_id, $user_id, $comment){
    $conexion=conect();

    $sentencia="INSERT INTO moviecomments (movie_id, user_id, comment) VALUES ('$movie_id','$user_id', '$comment')";

    $ejecucion=$conexion->query($sentencia);
    if($ejecucion){

        $resultado = true;
    }else{
        $resultado = NULL;
    }
    mysqli_close($conexion);
    return $resultado;

}

function sCheckRatingUser($id_user, $id_movie){
    $conexion=conect();

    $sentencia="SELECT score FROM USER_SCORE WHERE id_movie = '$id_movie' AND id_user = '$id_user'";

    $ejecucion=$conexion->query($sentencia);
    $devolver='';

    if($ejecucion->num_rows<>0){
        while($datos=$ejecucion->fetch_assoc()){

            $devolver=$datos['score'];
        }
    }
    else{
        $devolver = NULL;
    }

    mysqli_close($conexion);
    return $devolver;
}

function sInsertRating($id_movie, $id_user, $score){
    $conexion=conect();

    $sentencia="INSERT INTO user_score (id_user, id_movie, score, time) VALUES ('$id_user','$id_movie','$score', CURRENT_TIMESTAMP())";

    $ejecucion=$conexion->query($sentencia);
    if($ejecucion){
        $resultado = true;
    }else{
        $resultado = NULL;
    }
    mysqli_close($conexion);
    return $resultado;

}

function sUpdateRating($id_movie, $id_user, $score){
    $conexion=conect();

    $sentencia="UPDATE user_score SET score = '$score' WHERE id_user = '$id_user' AND id_movie = '$id_movie'";

    $ejecucion=$conexion->query($sentencia);
    if($ejecucion){
        $resultado = true;
    }else{
        $resultado = NULL;
    }
    mysqli_close($conexion);
    return $resultado;

}

function sGetGenres($id){

    $conexion=conect();

    $sentencia="SELECT name FROM `genre` WHERE id IN 
(SELECT genre FROM moviegenre WHERE movie_id = '$id')";

    $ejecucion=$conexion->query($sentencia);
    $devolver=array();
    while($datos=$ejecucion->fetch_assoc()){

        $devolver[]=$datos;
    }
    mysqli_close($conexion);
    return $devolver;

}

//FUNCIONES USER//
function sGetUsername($id){

    $conexion=conect();

    $sentencia="SELECT NAME FROM USERS WHERE ID = '$id'";

    $ejecucion=$conexion->query($sentencia);
    $devolver='';
    while($datos=$ejecucion->fetch_assoc()){

        $devolver=$datos['NAME'];
    }
    mysqli_close($conexion);
    return $devolver;

}

function sGetProfilePic($id){

    $conexion=conect();

    $sentencia="SELECT pic FROM USERS WHERE ID = '$id'";

    $ejecucion=$conexion->query($sentencia);
    $devolver='';
    while($datos=$ejecucion->fetch_assoc()){

        $devolver=$datos['pic'];
    }
    mysqli_close($conexion);
    return $devolver;

}

function sCheckPassword($username, $password){
    $conexion=conect();

    $sentencia="SELECT id FROM USERS WHERE name = '$username' AND passwd = '$password'";

    $ejecucion=$conexion->query($sentencia);
    $devolver='';

    if($ejecucion->num_rows<>0){
        while($datos=$ejecucion->fetch_assoc()){

            $devolver=$datos['id'];
        }
    }
    else{
        $devolver = NULL;
    }

    mysqli_close($conexion);
    return $devolver;
}

function sRegister($nombre, $edad, $sexo, $ocupacion, $password, $pic){
    $conexion=conect();

    $sentencia="INSERT INTO USERS (name, edad, sex, ocupacion, passwd, pic) VALUES ('$nombre','$edad', '$sexo', '$ocupacion','$password', '$pic')";

    $ejecucion=$conexion->query($sentencia);
    if($ejecucion){
        $resultado = mysqli_insert_id($conexion);
    }
    mysqli_close($conexion);
    return $resultado;

}

function sGetAllUser($id){
    $conexion=conect();

    $sentencia="SELECT * FROM USERS WHERE ID = '$id'";

    $ejecucion=$conexion->query($sentencia);
    $devolver=array();
    while($datos=$ejecucion->fetch_assoc()){

        $devolver[]=$datos;
    }
    mysqli_close($conexion);
    return $devolver;
}

function sEdit($id, $username, $age, $sex, $ocu, $pic){
    $conexion=conect();

    $sentencia="UPDATE users SET name = '$username', edad = '$age' , sex= '$sex', ocupacion= '$ocu', pic='$pic'  WHERE id = '$id'";

    $ejecucion=$conexion->query($sentencia);
    if($ejecucion){
        $resultado = true;
    }else{
        $resultado = NULL;
    }
    mysqli_close($conexion);
    return $resultado;

}

function sGetRecs($id_user){
    $conexion=conect();
    $sentencia = "SELECT * FROM MOVIE WHERE id IN 
                  (SELECT MOVIE_ID FROM RECS WHERE USER_ID = '$id_user' ORDER BY REC_SCORE DESC)";


    $ejecucion=$conexion->query($sentencia);
    $devolver=array();
    while($datos=$ejecucion->fetch_assoc()){

        $devolver[]=$datos;
    }
    mysqli_close($conexion);
    return $devolver;
}



