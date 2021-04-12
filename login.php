<?php
/* Iniciem sessio */
session_start();

/* Requirim que obtingui el codi de logindb.php perque la connexio a la 
bbdd ha de ser obligatoria */
require('logindb.php');

/* Agafem els valors del POST que hem enviat previament en el HTML*/
$u = $_POST['user'];
$p = $_POST['pwd'];

/*Cridem la funcio que es troba a logindb.php*/
$con = conectar();

/*Verifiquem la connexio a la bbdd*/
if (!$con) {
    echo "No s'ha pogut conectat a la bbdd";
}
else {

/*Definim una variable amb la consulta que voldrem fer a la bbdd,
en username i pwd es posa ? perquè farem la consulta per paràmetres
de forma que es pugui evitar un SQL injection */
$consulta= mysqli_prepare($con, "Select * from usuaris where Email=? and Password=?");

/*Definim els paràmetres de la consulta indicant que es pasarà $u i $p que
son els valors que ens pasa l'usuari desde el HTML i definim (amb ss) que els
dos paràmetres son de tipus cadena (una s per cada paràmetre) */
mysqli_stmt_bind_param($consulta,'ss', $u, $p);

/*Executem la consulta*/
mysqli_stmt_execute($consulta);

/*Definim en variables el resultat de la consulta, com hi han 4 atributs
definim 4 variables (en ordre) per poder agafar l'usuari en cas de que posi 
el correu ($x ja que es el primer atribut)*/
mysqli_stmt_bind_result($consulta, $x, $y, $z, $a);

/* Hem de guardar el resutat anterior de $consulta */
mysqli_stmt_store_result($consulta);
/* Demanarem els rows de la consulta per poder saber si ha trobat la 
bbdd alguna coincidencia amb els valors facilitats*/
$rows= mysqli_stmt_num_rows($consulta);

/*Si no hi ha cap coincidencia a la bbdd tornarem a enviar al usuari al 
HTML i definirem que la sessió guardi el valor validado=no per deixar constància de 
que l'usuari en aquesta sessió no ha accedit correctament */
if ($rows==0) {
    header("location:login.html");
    $_SESSION['validado']='no';
}

/* Remitim a home.php a on mostrarem les dades a l'usuari indicant que 
validado en la sesio es si perquè el guardi en tota la sessió. Guardarem a 
la sessió el nom també per poder utilitzar-lo a home.php.*/
else {
    while ($consulta->fetch()) {
        $_SESSION['validado']='si';
        $_SESSION['email']=$u;
        $_SESSION['password']=$p;
        $_SESSION['nombre']=$x;
        $_SESSION['campos']=$a;
    }

    header("location:home.php");
}
}

?>