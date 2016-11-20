<?php 
//DEBUG
//print_r($_SESSION);
?>

    <footer class="footer">
      <div class="container">
        <p class="text-muted">The easyBM WebGUI, Version 2016-07-23;&nbsp;&nbsp;Your last&nbsp;activity&nbsp;was&nbsp;at&nbsp;<?php if (isset($_SESSION['LAST_ACTIVITY'])){ echo gmdate("d.m.Y H:i:s",$_SESSION['LAST_ACTIVITY']); } else { echo "<small><i>Sorry, not seen jet</i></small>"; } ?></p>
        <p class="text-muted">Special thank's goes to DG9VH, DL3YK, DH6MBT and the whole BrandMeister Group.</p>
      </div>
    </footer>

  </body>
</html>
