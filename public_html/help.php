<?php
include_once('inc.header.php');
if (isset($_SESSION['angemeldet'])){
?>

<div class="container"><div class="row">
<h2>A helping hand for easyBM web control center</h2>
<h3>Topic´</h3>

<a href="#nutzung" type="button" class="btn btn-default btn-xs">Nutzung</a>
<a href="#flow" type="button" class="btn btn-default btn-xs">Flow Chart</a>
<a href="#dashboard" type="button"   class="btn btn-default btn-xs">Dashboard</a>

<hr>

<h4><a name="Nutzung">Vorraussetung</a></h4>
<p class="text-left"><b>User:</b>Der Internet-Explorer kleiner Version 9 wird nicht unterst&uuml;tzt, da die Webseite auf JavaScript und teilweise HTML5 aufbaut.  </p>


<h4><a name="dashboard">Dashboard</a></h4>
<p class="text-left"></p>

<hr>
<p class="text-center muted">
<small>Created and maintained by BrandMeister Team Germany, Sep 2016</small>
</p>

</div></div>

<?php
} else { echo pleaseLogin(); }
include_once('inc.footer.php');
?>
