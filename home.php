<?php
session_start();
/* Si rep una sessió amb la variable validado */
if ($_SESSION['validado']=='si'){
        $u=$_SESSION['email'];
        $p=$_SESSION['password'];
        $x=$_SESSION['nombre'];
        $a=$_SESSION['campos'];
        echo 'Benvingut/da, '. $_SESSION['nombre'] . "<br>"; 
        echo "Les teves dades son: ";
        echo  "<br>" . $u . "<br>" . $p . "<br>" . $x . "<br>" . $a;
    
}
/* A menys que tingui la sessió remitirà directament al HTML 
de forma que si s'intenta accedir a aquest fitxer directament per 
el navegador no podrà accedir al contingut de la bbdd perquè no 
hi haurà la verificació*/
else {
    header("location:login.html");
}
 
?>