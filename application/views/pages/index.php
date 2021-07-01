<?php 
    session_start();
	defined('BASEPATH') OR exit('No direct script access allowed'); 
	$this->load->helper('url');

    // เพิ่มสินค้าในตะกร้า
    if(isset($_GET['action']) && $_GET['action'] === 'add') {

        $id = $_GET['id'];
        $name = $_GET['name'];
        $image = $_GET['image'];
        $price = $_GET['price'];

        if (isset($_SESSION['id'])) {
            if (array_key_exists($id, $_SESSION['id'])) {
                $_SESSION['qty'][$id] += 1;
            } else {
                $_SESSION['id'][$id] = $id; 
                $_SESSION["name"][$id] = $name;
                $_SESSION["image"][$id] = $image;
                $_SESSION["price"][$id] = $price;
                $_SESSION["qty"][$id] = 1;
            }
        } else {
            $_SESSION['id'][$id] = $id; 
            $_SESSION["name"][$id] = $name;
            $_SESSION["image"][$id] = $image;
            $_SESSION["price"][$id] = $price;
            $_SESSION["qty"][$id] = 1;
        }

        // ป้อนกัน refresh
        // redirect(base_url());
    }

    // ลบตะกร้าสินค้า
    if(isset($_GET['action']) && $_GET['action'] === 'delete') {
    if (isset($_SESSION['id'])) {

        $id = $_GET['id'];

            if (array_key_exists($id, $_SESSION['id']) && $_SESSION['qty'][$id] > 1) {
                $_SESSION['qty'][$id] -= 1;
            } else {
                unset($_SESSION['id'][$id]);
                unset($_SESSION["name"][$id]);;
                unset($_SESSION["image"][$id]);
                unset($_SESSION["price"][$id]);
                unset($_SESSION["qty"][$id]);
            }
            
        // ป้อนกัน refresh
        // redirect(base_url());
        }
    }

    // เคลียร์ตะกร้าสินค้า
    if(isset($_GET['action']) && $_GET['action'] === 'clear' && isset($_SESSION['id'])) {
        unset($_SESSION['id']);
        unset($_SESSION["name"]);;
        unset($_SESSION["image"]);
        unset($_SESSION["price"]);
        unset($_SESSION["qty"]);
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CI3 Shopping Cart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">

    <style>
    .flex-container {
        display: flex;
        flex-direction: row;
    }

    @media (max-width: 1200px) {
    .flex-container {
        flex-direction: column;
    }

    }
    </style>
</head>
<body>
    <div class="container">
        
        <div class="flex-container">
 
            <!-- รายการสินค้า -->
            <div class="product-lists m-2 p-2" style="flex-grow: 1;">
            <h3>รายการสินค้า</h3>
                <?php if(!$products) echo "<h6>ไม่สินค้า</h6>"; ?>
                <div class="row">
                    
                    <!-- ถ้ามีสินค้าให้ทำการ foreach -->
                    <?php if($products): ?>
                    <?php foreach($products as $product): ?>
                    <div class="col-lg-3 col-md-4 col-sm-12 p-2">
                        <img src="<?php echo base_url('uploaded/'.$product['image']); ?>" width="150" height="150">
                        <h6>
                            <?php echo $product['id'];?>
                        </h6>
                        <h6>
                            <?php echo $product['name'];?>
                        </h6>
                        <h6>
                            <?php echo $product['price'];?>
                        </h6>
                        <a href="<?php echo base_url('?action=add&id='.$product['id'].'&name='.$product['name'].'&image='.$product['image'].'&price='.$product['price']); ?>" class="btn btn-primary">+</a>
                    
                        <a href="<?php echo base_url('?action=delete&id='.$product['id'].'&name='.$product['name'].'&image='.$product['image'].'&price='.$product['price']); ?>" class="btn btn-primary">-</a>
                    </div>
                    <?php endforeach; ?>
                    <?php endif; ?>

                </div>
            </div>

            <!-- ตะกร้าสินค้า -->
            <div class="cart-lists m-2 p-2">
            <h3>ตะกร้าสินค้า</h3>
            <table class="table table-bordered">
                <thead>
                    <tr>
                    <th></th>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Image</th>
                    <th>Price</th>
                    <th>Amount</th>
                    </tr>
                </thead>
                <tbody>

                <?php $total = 0; ?>

                <?php if(isset($_SESSION['id'])): ?>
                <?php foreach($_SESSION['id'] as $id): ?>
                <tr>
                    <th><?php echo $_SESSION['qty'][$id]."X";?></th>
                    <td><?php echo $_SESSION['id'][$id]; ?></td>
                    <td><?php echo $_SESSION['name'][$id]; ?></td>
                    <td>
                        <img src="<?php echo base_url('uploaded/').$_SESSION['image'][$id]; ?>" width="50" height="50">
                    </td>
                    <td><?php echo $_SESSION['price'][$id]; ?></td>
                    <td><?php echo number_format(($_SESSION['price'][$id] * $_SESSION['qty'][$id]),2); ?></td>
                </tr>

                <?php 
                    $total += ($_SESSION['price'][$id] * $_SESSION['qty'][$id]);
                ?>

                <?php endforeach; ?>
                <?php endif; ?>
            </table>

            <h6>สินค้าทั้งหมด <?php if(isset($_SESSION['id'])) echo count($_SESSION['id']); ?></h6>
            <h6>รวม <?php echo number_format($total,2); ?></h6>

            <!-- ถ้ามี SESSION['cart'] ให้ show ปุ่ม checkout -->
            <?php 
                if(isset($_SESSION['id'])) {
                 echo "<a href=".base_url('checkout/')." class='btn btn-success w-100 m-2'>Checkout</a>"; 
                }
            ?>

            <a href="<?php echo base_url('?action=clear'); ?>" class="btn btn-warning w-100 m-2">Clear</a>

            </div>

        </div>

    </div>
</body>
</html>