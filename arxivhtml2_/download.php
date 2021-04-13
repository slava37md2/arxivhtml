You need <a href="https://arxiv.org/e-print/<?php echo $_GET['file']; ?>">to download file <?php echo $_GET['file']; ?></a> on your computer and then to upload it to our server. It is necessary because the site arxiv.org disallows to download tex-files on our server directly.


<form action="readtargz.php" method="post" enctype="multipart/form-data">
  <div>
    <label for="texarchive">Choose file <?php echo $_GET['file']; ?> to upload from folder "Downloads" to our server.  </label>
    <input type="hidden" name="MAX_FILE_SIZE" value="20000000" />
    <input type="hidden" name="file" value="<?php echo $_GET['file']; ?>" />
    <input type="file" id="texarchive" name="texarchive"
          accept=".<?php echo pathinfo( $_GET['file'], PATHINFO_EXTENSION ); ?>">
  </div>
  <div>
    <button>Submit</button>
  </div>
</form>







