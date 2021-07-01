<?php 
	defined('BASEPATH') OR exit('No direct script access allowed'); 
	$this->load->helper('url');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CI3 Shopping Cart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
</head>
<body>
<div class="container">
    <h3>Stock Edit</h3>

    <form action="<?php echo base_url('stockEdit/'.$product[0]['id']); ?>" method="post" enctype="multipart/form-data">
        <input type="text" class="form-control" name="id" value="<?php echo($product[0]['id']); ?>"  readonly> <br>

        <input type="text" class="form-control" name="name" value="<?php echo($product[0]['name']); ?>"  placeholder="ชื่อ"> <br>

        <small>ขนาดรูป < 1MB</small>
        <input type="file" class="form-control" name="image" value="<?php echo($product[0]['image']); ?>"  accept="image/*" > <br>
        
        <img src="<?php echo base_url('uploaded/'.$product[0]['image']); ?>" class="mb-3" width="100" height="100">
    
        <input type="text" class="form-control" name="price" value="<?php echo($product[0]['price']); ?>"    placeholder="ราคา"> <br>

        <input type="submit" class="btn btn-primary" value="Edit">

        <a href="<?php echo base_url("stock"); ?>" class="btn btn-link">Cancel</a>
    </form>

</div>
</body>
</html>