
<?php
    session_start();
    defined('BASEPATH') OR exit('No direct script access allowed'); 
    $this->load->helper('url');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Add meta tags for mobile and IE -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>CI3 Shopping Cart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
</head>

<body>

<div class="container">
    <h3>Checkout</h3>

    <!-- ส่งข้อมูลไปยัง controller checkout  -->
    <form action="<?php echo base_url('checkout'); ?>" method="post" id="formCheckout">

        <h5>รายการสินค้า</h5>
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

                <?php $total = 0; $order = ""; ?>

                <?php if(isset($_SESSION['id'])): ?>
                <?php foreach($_SESSION['id'] as $id): ?>

                <!-- สร้างออร์เดอร์สั่งซื้อ -->
                <?php 
                   $order .= ("รหัสสินค้า ".(string)$_SESSION['id'][$id]." จำนวน ".(string)$_SESSION['qty'][$id].",");
                 ?>

                <tr>
                    <th><?php echo $_SESSION['qty'][$id]."X";?></th>
                    <td><?php echo $id ?></td>
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

            <div style="text-align: right">
                <h6>สินค้าทั้งหมด <?php if(isset($_SESSION['id'])) echo count($_SESSION['id']); ?></h6>
                <h6>รวม <?php echo number_format($total,2); ?></h6>
            </div>
            
        <h5>รายละเอียดการจัดส่ง</h5>

        <div class="form-group">
            <label>ชื่อ</label>
            <input type="text" name="name" class="form-control" value="ชื่อ..." placeholder="ชื่อ-สกุล" required>
        </div>
        <div class="form-group">
            <label>ที่อยู่</label>
            <input type="text" name="addresses" class="form-control" value="ที่อยู่..." placeholder="ที่อยู่" required>
        </div>
        <div class="form-group">
            <label>เบอร์โทรศํพท์</label>
            <input type="text" name="mobile_phone" class="form-control" value="เบอร์โทรศํพท์..." placeholder="เบอร์โทรศํพท์" required>
        </div>

        <div class="form-group">
            <label>ออร์เดอร์</label>
            <input type="text" name="order" class="form-control" value="<?php echo $order; ?>" readonly>
        </div>

        <div class="form-group m-2">
            <h6>Paypal</h6>
            <!-- Set up a container element for the button -->
            <div id="paypal-button-container"></div>

            <!-- PAYPAL SCRIPT SDK-->
            <script src="https://www.paypal.com/sdk/js?client-id=ARQOKx8ig1DFQnWoCkZGwyFbxxyF_DHFds9GqUcohrCzZIlUZ5aeonPstE3YirXaWvgWviYpfYPcBYiR&currency=THB"></script>

            <!-- PAYPAL SCRIPT -->
            <script>
                // Render the PayPal button into #paypal-button-container
                paypal.Buttons({
                    // Set ค่าเริ่มต้นชำระเงิน
                    createOrder: function(data, actions) {
                        return actions.order.create({
                            purchase_units: [{
                                amount: {
                                    value: '<?php echo $total; ?>'
                                }
                            }]
                        });
                    },
                    // ชำระเงินสำเร็จ
                    onApprove: function(data, actions) {
                        return actions.order.capture().then(function(details) {
                            // สั่ง submit form
                            formCheckout.submit();
                            alert('ชำระเงินสำเร็จ');
                        });
                    },

                    style: {
                color:  'blue',
                shape:  'pill',
                label:  'pay',
                height: 40
            }

                }).render('#paypal-button-container');
            </script>
        
        </div>

        <a href="<?php echo base_url(); ?>" class="btn btn-link">Home</a>

    </form>
</div>

</body>

</html>
    