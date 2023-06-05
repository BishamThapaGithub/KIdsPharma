<?php
@include '../components/connect.php';
if(isset($_POST['add_product'])){

   $product_name = $_POST['product_name'];
   $product_price = $_POST['product_price'];
   $product_image = $_FILES['product_img']['name'];
   $product_image_tmp_name = $_FILES['product_img']['tmp_name'];
   $product_image_folder = 'upload_image/'.$product_image;

   if(empty($product_name) || empty($product_price) || empty($product_image)){
      $message[] = 'please fill out all';
   }else{
      $insert = "INSERT INTO products(product_name, product_price, product_img) VALUES('$product_name', '$product_price', '$product_image')";
      $upload = mysqli_query($conn,$insert);
      if($upload){
         move_uploaded_file($product_image_tmp_name, $product_image_folder);
         $message[] = 'new product added successfully';
      }else{
         $message[] = 'could not add the product';
      }
   }

};

if(isset($_GET['delete'])){
   $id = $_GET['delete'];
   mysqli_query($conn, "DELETE FROM products WHERE product_id = $id");
   header('location:abcd.php');
};
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
     <!--Boxicons-->
     <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
     <link rel="stylesheet" href="astyle.css">
     <link rel="stylesheet" href="add.css">
</head>
<body>
        <!--SIDEBAR-->
        <section id="sidebar">
            <a href="#" class="brand">
                <i class="bx bxs-smile"></i>
                <span class="text">User Hub</span>
            </a>
            <ul class="side-menu top">
                <li class="active">
                    <a href="#">
                        <i class="bx bxs-dashboard"></i>
                        <span class="text">Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class='bx bxs-store'></i>
                        <span class="text">My order</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class='bx bxs-shopping-bag' ></i>
                        <span class="text">Analytics</span>
                    </a>
                </li>
                
            </ul>
    
            <ul class="side-menu">
                <li>
                    <a href="#">
                        <i class='bx bx-cog' ></i>
                        <span class="text">Settings</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class='bx bx-log-out-circle' ></i>
                        <span class="text">Logout</span>
                    </a>
                </li>
                </ul>
        </section>
         <!--SIDEBAR-->
         <!-- CONTENT -->
        <section id="content">
            <!-- NAVBAR -->
            <nav>
                <i class='bx bx-menu' ></i>
                <a href="#" class="nav-link">Categories</a>
                <form action="#">
                    <div class="form-input">
                        <input type="search" placeholder="Search...">
                        <button type="submit" class="search-btn"><i class='bx bx-search' ></i></button>
                    </div>
                </form>
                <input type="checkbox" id="switch-mode" hidden>
                <label for="switch-mode" class="switch-mode"></label>
                <a href="#" class="notification">
                    <i class='bx bxs-bell' ></i>
                    <span class="num">8</span>
                </a>
                <a href="#" class="profile">
                    <img src="image/1.jpg">
                </a>
            </nav>
            <!-- NAVBAR -->
    
            <!-- MAIN -->
            <main>
                <div class="form-container">

                    <div class="admin-product-form-container">
                 
                       <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
                          <h3>add a new product</h3>
                          <input type="text" placeholder="enter product name" name="product_name" class="box">
                          <input type="number" placeholder="enter product price" name="product_price" class="box">
                          <input type="file" accept="image/jpg, image/png, image/jpeg" name="product_img" class="box">
                          <input type="submit" class="btn" name="add_product" value="add product">
                       </form>
    

                       
<?php

$select = mysqli_query($conn, "SELECT * FROM products");

?>
<div class="product-display">
<table class="product-display-table">
   <thead>
   <tr>
      <th>product image</th>
      <th>product name</th>
      <th>product price</th>
      <th>action</th>
   </tr>
   </thead>
   <?php while($row = mysqli_fetch_assoc($select)){ ?>
   <tr>
      <td><img src="upload_image/<?php echo $row['product_img']; ?>" height="100"  style="b"></td>
      <td><?php echo $row['product_name']; ?></td>
      <td>$<?php echo $row['product_price']; ?>/-</td>
      <td>
       <a href="update.php?edit=<?php echo $row['product_id']; ?>" class="box-btn"> <i class="fas fa-edit"></i> edit </a>
       <a href="abcd.php?delete=<?php echo $row['product_id']; ?>" class="box-btn"> <i class="fas fa-trash"></i> delete </a>

      </td>
   </tr>
<?php } ?>
</table>
</div>

            

                        <script src="script.js"></script>
</body>
</html>