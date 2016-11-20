<?php 

header('Cache-Control: no-store, no-cache, must-revalidate');

include_once("inc.auth.php");
include_once("inc.header.php");

if (isset($_SESSION['angemeldet'])){
?>

<div class="container">
 <div class="jumbotron">

	<div class="row">
	<h1>easyBM&nbsp;<small>GPIO Port Switch</small></h1>

	<div class="col-md-1"></div>
	<div class="col-md-5">
	<form method="get" action="gpio.php">
	  <center>
	  <div class="form-group">
	   <label for="gpio7">GPIO 21</label>
	   <button id="gpio7" class="btn btn-success" type="submit" value="7on"  name="gpio">On</button>&nbsp;
	   <button id="gpio7" class="btn btn-danger"  type="submit" value="7off" name="gpio">Off</button>&nbsp;
<?php 
		$stat7=trim(@shell_exec("gpio -1 read 29"));
		if ( $stat7 == '0' ) {
			echo '<span class="alert alert-danger glyphicon glyphicon-remove-circle" aria-hidden="true"></span>';
		} elseif ( $stat7 == '1' ) {
			echo '<span class="alert alert-success glyphicon glyphicon-ok-circle" aria-hidden="true"></span>';
		} else { echo '<span class="alert alert-warning glyphicon glyphicon-alert" aria-hidden="true"></span>'; }
?>
   
  </div>
  
  <div class="form-group">
   <label for="gpio8">GPIO22</label>
   <button id="gpio8" class="btn btn-success" type="submit" value="8on"  name="gpio">On</button>&nbsp;
   <button id="gpio8" class="btn btn-danger"  type="submit" value="8off" name="gpio">Off</button>&nbsp;
   <?php 
		$stat8=trim(@shell_exec("gpio -1 read 31"));
		if ( $stat8 == '0' ) {
			echo '<span class="alert alert-danger glyphicon glyphicon-remove-circle" aria-hidden="true"></span>';
		} elseif ( $stat8 == '1' ) {
			echo '<span class="alert alert-success glyphicon glyphicon-ok-circle" aria-hidden="true"></span>';
		} else { echo '<span class="alert alert-warning glyphicon glyphicon-alert" aria-hidden="true"></span>'; }
	?>
  </div>
  
  <div class="form-group">
   <label for="gpio9">GPIO23</label>
   <button id="gpio9" class="btn btn-success" type="submit" value="9on"  name="gpio">On</button>&nbsp;
   <button id="gpio9" class="btn btn-danger"  type="submit" value="9off" name="gpio">Off</button>&nbsp;
   <?php 
		$stat9=trim(@shell_exec("gpio -1 read 33"));
		if ( $stat9 == '0' ) {
			echo '<span class="alert alert-danger glyphicon glyphicon-remove-circle" aria-hidden="true"></span>';
		} elseif ( $stat7 == '1' ) {
			echo '<span class="alert alert-success glyphicon glyphicon-ok-circle" aria-hidden="true"></span>';
		} else { echo '<span class="alert alert-warning glyphicon glyphicon-alert" aria-hidden="true"></span>'; }
	?>
  </div>

  <div class="form-group">
   <label for="gpio10">GPIO24</label>
   <button id="gpio10" class="btn btn-success" type="submit" value="10on"  name="gpio">On</button>&nbsp;
   <button id="gpio10" class="btn btn-danger"  type="submit" value="10off" name="gpio">Off</button>&nbsp;
   <?php 
		$stat10=trim(@shell_exec("gpio -1 read 35"));
		if ( $stat10 == '0' ) {
			echo '<span class="alert alert-danger glyphicon glyphicon-remove-circle" aria-hidden="true"></span>';
		} elseif ( $stat10 == '1' ) {
			echo '<span class="alert alert-success glyphicon glyphicon-ok-circle" aria-hidden="true"></span>';
		} else { echo '<span class="alert alert-warning glyphicon glyphicon-alert" aria-hidden="true"></span>'; }
	?>
  </div>
  
  <div class="form-group">
   <label for="gpio11">GPIO25</label>
   <button id="gpio11" class="btn btn-success" type="submit" value="11on"  name="gpio">On</button>&nbsp;
   <button id="gpio11" class="btn btn-danger"  type="submit" value="11off" name="gpio">Off</button>&nbsp;
   <?php 
		$stat11=trim(@shell_exec("gpio -1 read 37"));
		if ( $stat11 == '0' ) {
			echo '<span class="alert alert-danger glyphicon glyphicon-remove-circle" aria-hidden="true"></span>';
		} elseif ( $stat11 == '1' ) {
			echo '<span class="alert alert-success glyphicon glyphicon-ok-circle" aria-hidden="true"></span>';
		} else { echo '<span class="alert alert-warning glyphicon glyphicon-alert" aria-hidden="true"></span>'; }
	?>
  </div>
  </center>
 </form>
	</diV>
	<div class="col-md-5">
	<p>Please read more about "wiringPi" at <a href="http://wiringpi.com/" target="_blank">http://wiringpi.com/</a></p>
	<?php
                        $output = shell_exec('gpio readall');
                        echo '<pre>'.$output.'</pre>';
        ?>

	</div>
	<div class="col-md-1"></div>

</div>
</div>
</div>


<?php

if (isset($_GET["gpio"])){
	
switch ($_GET["gpio"]) {
	case "7on":
		shell_exec("gpio -1 mode 29 out");
		$val=trim(@shell_exec("gpio -1 write 29 1"));
		
		break;
	case "7off":
		shell_exec("gpio -1 mode 29 out");
		$val=trim(@shell_exec("gpio -1 write 29 0"));
		
		break;
	
	case "8on":
		shell_exec("gpio -1 mode 31 out");
		$val=trim(@shell_exec("gpio -1 write 31 1"));
		break;
	case "8off":
		shell_exec("gpio -1 mode 31 out");
		$val=trim(@shell_exec("gpio -1 write 31 0"));
		break;
	
	case "9on":
		shell_exec("gpio -1 mode 33 out");
		$val=trim(@shell_exec("gpio -1 write 33 1"));
		break;
	case "9off":
		shell_exec("gpio -1 mode 33 out");
		$val=trim(@shell_exec("gpio -1 write 33 0"));
		break;
	
	case "10on":
		shell_exec("gpio -1 mode 35 out");
		$val=trim(@shell_exec("gpio -1 write 35 1"));
		break;
	case "10off":
		shell_exec("gpio -1 mode 35 out");
		$val=trim(@shell_exec("gpio -1 write 35 0"));
		break;
	
	case "11on":
		shell_exec("gpio -1 mode 37 out");
		$val=trim(@shell_exec("gpio -1 write 37 1"));
		break;
	case "11off":
		shell_exec("gpio -1 mode 37 out");
		$val=trim(@shell_exec("gpio -1 write 37 0"));
		break;
	default:
		echo "Please select an GPIO port. ";

}

	print($val);

} else { echo ''; }

} else { echo pleaseLogin(); }
include_once("inc.footer.php");
?>
