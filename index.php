
<?php
  // ucitavanje xml filea, i var za for loop koji gradi tablicu
  $xml = simplexml_load_file('metadata.xml');
  $i = 0;
?>

<!DOCTYPE html>
<html>
  <head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <title>Image Upload</title>
  </head>
  <body>
    <div style="text-align: center;">
      <h3>Add an image, write a description</h1>
    </div>
    <table class="table">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Image</th>
          <th scope="col">Description</th>
          <th scope="col">Upload date</th>
        </tr>
      </thead>
      <tbody>
		    <?php foreach ($xml->images->image as $image): ?>
			  <?php $i += 1;?>
		      <tr>
			      <th scope="row"><?php echo $i; ?></th>
            <td><img src="<?php echo "images/" . $image->name; ?>" alt="<?php echo "images/" . $image->name; ?>"></td>
            <td><?php echo $image->description; ?></td>
            <td><?php echo $image->date; ?></td>
          </tr>
        <?php endforeach; ?>
        <tr>
          <form action="upload.php" method="post" enctype="multipart/form-data">
            <th scope="row"><?php echo $i+1; ?></th>
            <td><input type="file" name="fileToUpload" id="fileToUpload"></td>
            <td><input type="text" value="" name="desc"></td>
            <td><input type="submit" value="Upload Image" name="submit"></td>  
          </form>
        </tr>
      </tbody>
    </table>
  </body>
</html>
