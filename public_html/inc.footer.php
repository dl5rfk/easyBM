
    <footer class="footer">
      <div class="container">
        <p class="text-muted">easyBM WebGUI Version 2016-12-13,&nbsp;is deliverd by <?php echo $_SERVER['SERVER_NAME'].'('.$_SERVER['SERVER_ADDR'].')';?>&nbsp;Your last&nbsp;activity&nbsp;was&nbsp;at&nbsp;<?php if (isset($_SESSION['LAST_ACTIVITY'])){ echo gmdate("d.m.Y H:i:s",$_SESSION['LAST_ACTIVITY']); } else { echo "<small><i>Sorry, not seen jet</i></small>"; } ?><br />Special thank's goes to DG9VH, DL3YK, DH6MBT and the whole BrandMeister Group.</p>
      </div>
    </footer>

  </body>
</html>
