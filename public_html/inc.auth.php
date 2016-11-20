<?php

//if ($_SESSION['angemeldet'] === TRUE ){
 if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 900)) {

	session_unset('angemeldet');     
	session_unset('loginutime');     
	session_unset('passwdchanged');     
	session_unset();   
	session_destroy();

	header('Location: http://'.$_SERVER['SERVER_NAME'].'/admin/index.php');	

 }
//}

?>
