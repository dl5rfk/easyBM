<?php
include_once('inc.header.php');
if (isset($_SESSION['angemeldet'])){
?>

<div class="container"><div class="row">
<h2>Helping Hand for easyBM Web Control</h2>
<h3>Topic´</h3>

<a href="#nutzung" type="button" class="btn btn-default btn-xs">Nutzung</a>
<a href="#flow" type="button" class="btn btn-default btn-xs">Flow Chart</a>
<a href="#rollen" type="button" class="btn btn-default btn-xs">Rollen</a>
<a href="#dashboard" type="button"   class="btn btn-default btn-xs">Dashboard</a>
<a href="#servicetest" type="button" class="btn btn-default btn-xs">Servicetest</a>
<a href="#testcases" type="button"   class="btn btn-default btn-xs">Testcase</a>

<hr>

<h4><a name="Nutzung">Vorraussetung</a></h4>
<p class="text-left"><b>User:</b>Um DB korrekt benutzen zu k&ouml;nnen, ist der erforderlich.  Als Web-Browser empfiehlt sich der Firefox-Browser in einer aktuellen Version. Bei anderen wird eine Warnung am obeneren Fensterrand zu sehen sein, die keine weitere Auswirkung hat. Der Internet-Explorer kleiner Version 9 wird nicht unterst&uuml;tzt, da die Webseite auf JavaScript und teilweise HTML5 aufbaut.  </p>

<p class="text-left"><b>Server:</b>Die nutzt die Technologieen HTML, PHP5, JavaScript, MySQL. So wir ein entsprechender Webserver ben&ouml;tigt, der dies zur Verf&uuml;gung stellt. </p>

<h4><a name="dashboard">Dashboard</a></h4>
<p class="text-left">Das Dashboard stellt die Startseite der Regression Test Datenbank dar. Sie dient als zentraler Einstiegspunkt und beheimatet alle </p>

<hr>
<p class="text-center muted">
<small>Created and maintained by BrandMeister Team Germany, Sep 2016</small>
</p>

</div></div>

<?php
} else { echo pleaseLogin(); }
include_once('inc.footer.php');
?>
