<?php
/**
 * THE EASYMB WEB CONTROL
 *
 * Use this code for a easyBM Setup
 *
 * @file       /opt/easyBM/public_html/index.php
 * @author     DL5RFK <easybm@dl5rfk.org>
 * @copyright  2016 The German BrandMeister Team
 * @license    http://www.gnu.org/licenses/gpl-3.0.html GNU GPL v3
 * @version    2016-09-30
 * @remarks    WITHOUT ANY WARRANTY OR GUARANTEE
 * @see        http://www.bm262.de
 *
 */

include_once("inc.header.php");

$passwd="";
$passwdchgd=false;

if (isset($_POST['password'])) { $password = $_POST['password']; } else { unset($password); }

//CHECK IF POSTpassword is not empty then load config and verify Adminpassword
//Normal LOGIN
if (isset($password) && !empty($password)){
	
	//LOAD CONFIG IF EXISTS
	$filename="config.php";
	if (file_exists($filename)) {
		include_once($filename);
		$cfgpasswd = ADMINPASSWORD;
		$cfgpasswdchgd = ADMINPASSWORDCHANGED;
		$_SESSION['passwdchanged']=ADMINPASSWORDCHANGED;

	} else {
		unset($cfgpasswd);
		$cfgpasswdchgd=FALSE;
		echo "<br />Sorry, no config.php file found !<br />";
		}

	//GIVEN PASSWD EQUAL CONFIG PASSWD
	if ($cfgpasswd === $password) {
		$_SESSION['angemeldet'] = TRUE;
		$_SESSION['loginutime'] = time();
	
		//PASSWD CHANGED IS TRUE
		if ($cfgpasswdchgd) {
		  $feedback='<div class="alert alert-success">Login successfull! <br />Welcome, look at the <a href="status.php">Status-Page</a>.</p></div>';
		  header('Location: /admin/status.php');

		} else { 
		
		//PLEASE CHANGE PASSWD BY changepasswd.php BECAUSE $passwdchgd IS FALSE
		?>
			<div class="container">
			<div class="jumbotron">
			  <h1>easyBM <small>Web Control Center</small></h1>
			  <p>Now, please set your own password:</p>
			  <div class="row">
			  <div class="col-lg-6">
			    <div class="input-group">
			      <form action="changepasswd.php" method="post">
			      <input name="password" type="password" class="form-control" placeholder="Your new password">
			      <input name="password2" type="password" class="form-control" placeholder="Repeat your new password">
			      <span class="input-group-btn">
			        <button class="btn btn-default" type="submit">Change password</button>
			      </form>
			      </span>
			    </div><!-- /input-group -->
			  </div><!-- /.col-lg-6 -->
			</div><!-- /.row -->
			</div><!-- /.jumbotron -->
			</div><!-- /.container -->
<?php
   		   }
	
	} else {
		//Login Failed, wrong password
?>
		<div class="container">
		<div class="jumbotron">
		  <h1>easyBM <small>Web Control Center</small></h1>
		  <div class="alert alert-danger"><strong>Login failed !</strong> <a href="/admin/index.php" class="btn btn-default">please try again</a></div>
		</div>
		</div>
<?php
	}
} else {
	
	//NO CONFIG FOUND, WRITE FILE
	if (!file_exists ("config.php") ) {
		$passwd = getInitialPassword(10);
		$configfile = fopen("config.php", 'w');
		fwrite($configfile,"<?php\n");
		fwrite($configfile,"# This is an auto-generated file by index.php !\n");
		fwrite($configfile,"# Be careful, when manual editing this!\n\n");
		fwrite($configfile,"define(\"ADMINPASSWORD\", \"$passwd\");"."\n");
		fwrite($configfile,"define(\"ADMINPASSWORDCHANGED\", FALSE);"."\n");
		fwrite($configfile,'define("SETUPTIME","'. date("Y-m-d H:i:s") .'");'."\n");
		fwrite($configfile,"define(\"PHPDEBUG\", FALSE);"."\n");
		fwrite($configfile,"?>\n");
		fclose($configfile);
	} else {
		//CONFIG FOUND, LOAD VALUES
		include("config.php");
		$passwd = ADMINPASSWORD;
		$passwdchgd = ADMINPASSWORDCHANGED;
		$phpdebug = PHPDEBUG;
		}
?>

<div class="container">
<div class="jumbotron">
  <h1>easyBM <small>Web Control Center</small></h1>
  <p>A user web interface for digital voice communication in amateur radio.</p>
<?php

	if (!$passwdchgd) {
?>
  <p>It seems to be the first time, that you start easyBM. So please use the following password for login:<br /> <strong><?php echo $passwd; ?></strong></p>
<?php  } else { echo '<p>Enter your password:</p>'; } ?>
  <div class="row">
  <div class="col-lg-6">
      <form class="form-inline" role="form" action="index.php" method="post">    
	<div class="form-group">
		<input name="password" type="password" class="form-control" placeholder="password">
		<button class="btn btn-default" type="submit">Login</button>
	</div>
      </form>
  </div><!-- /.col-lg-6 -->
</div><!-- /.row -->
</div>
</div>
<?php
}

//INC FOOTER
include_once("inc.footer.php");
?>
