<?php
include_once('inc.header.php');
if (isset($_SESSION['angemeldet'])){
?>

<div class="container"><div class="row">
<h2>A helping hand for easyBM web control center</h2>
<h3>Topic</h3>

<a href="#nutzung" type="button" class="btn btn-default btn-xs">Nutzung</a>
<a href="#flow" type="button" class="btn btn-default btn-xs">Flow Chart</a>
<a href="#dashboard" type="button"   class="btn btn-default btn-xs">Dashboard</a>

<hr>

<h4><a name="Nutzung">MMDVM</a></h4>
<p class="text-left">For futher informationen, please visit the <a href="http://mmdvm.blogspot.de/" target="_blank">MMDVM Blog</a>.</p>

<h4><a name="dashboard">ntpd</a></h4>
<p class="text-left">One of disadvantages designing so cheap computer is that you have to give up some features which are too expensive. One of these features is RTC - real-time clock. RTC chip has its own battery to store actual time even when device isn`t plugged in. So we installed ntpd as a timeserver for RPi.</p>
<p class="text-left">For futher informationen, please visit the <a href="https://en.wikipedia.org/wiki/Ntpd" target="_blank">NTP Wiki Page</a>.</p>

<hr>
<p class="text-center muted">
<small>Created and maintained by BrandMeister Team Germany, Sep 2016</small>
</p>

</div></div>

<?php
} else { echo pleaseLogin(); }
include_once('inc.footer.php');
?>
