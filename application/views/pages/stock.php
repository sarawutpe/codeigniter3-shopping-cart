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

<h3>Stock page</h3>

<div class="mt-3 mb-2">
	<a href="<?php echo base_url('stockCreate'); ?>" class="btn btn-primary w-100">Create</a>
</div>

<table class="table table-bordered">
	<thead>
		<tr>
			<th>Id</th>
			<th>Name</th>
			<th>Image</th>
			<th>Price</th>
			<th>Actions</th>
		</tr>
	</thead>

	<tbody>
		<?php if($products): ?>
		<?php foreach($products as $product): ?>
		<tr>
			<td><?php echo $product['id']; ?></td>
			<td><?php echo $product['name']; ?></td>
			<td>
				<img src="<?php echo base_url('uploaded/'.$product['image']); ?>" width="100" height="100">
			</td>
			<td><?php echo $product['price']; ?></td>
			<td>
			<a href="<?php echo base_url('stockEdit/'.$product['id']); ?>" class="btn btn-link">Edit</a>
			<a href="<?php echo base_url('stockDelete/'.$product['id']); ?>" class="btn btn-link" onclick="return confirm('ต้องการลบหรือไม่?')">Delete</a>

			</td>
		</tr>
		<?php endforeach; ?>
		<?php endif; ?>
	</tbody>

 </table>
 </div>

    
</body>
</html>