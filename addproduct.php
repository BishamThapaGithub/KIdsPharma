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
  <title>dashboard</title>
  <!-- custome css -->
  <link rel="stylesheet" href="../dashboard/assets/css/dashboard.css">
  <!-- For icons -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined"
  rel="stylesheet">
  <link rel="stylesheet" href="add.css">

<body>
<div class="grid-container">

  <!-- header -->
  <header class="header">
    <div class="menu-icon" onclick="openSidebar()">
      <span class="material-icons-outlined">menu</span>
    </div>
    <div class="class-left">
      <span class="material-icons-outlined"> search </span> 
    </div>
    <div class="class-right">
      <span class="material-icons-outlined" >account_circle </a></span>
      
    </div>
  </header>
  <!-- end header -->

  <!-- slidebar -->
   <aside id="sidebar">
   <div class="sidebar-title">
    <div class="sidebar-brand">
      <span class="material-icons-outlined">
        store
        </span> Shopping
    </div>
    <span class="material-icons-outlined" onclick="closeSidebar()">close </span>
   </div>

   <ul class="sidebar-list">
        <li class="sidebar-list-item">
        <span class="material-icons-outlined">dashboard</span> Dashboard</li>

      <li class="sidebar-list-item">
       <a href="dashboard.html"><span class="material-icons-outlined">inventory_2 </span> Product</li></a>
      
     <li class="sidebar-list-item"><span class="material-icons-outlined">groups</span> Customers</li>
     <li class="sidebar-list-item"><span class="material-icons-outlined">
      category
      </span> Category</li>
      <li class="sidebar-list-item"><span class="material-icons-outlined">
        shopping_cart
        </span> orders</li>
    <li class="sidebar-list-item"> <span class="material-icons-outlined">settings </span> Setting</li>
   </ul>
  </aside>
  <!-- Endsidebar -->
  <main class="main-container">
    
<?php

if(isset($message)){
   foreach($message as $message){
      echo '<span class="message">'.$message.'</span>';
   }
}

?>
   
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

</div>
  





  </main>
  <!-- end main -->
 


  
 
</div>















<!-- custom js -->
  <script src="../jsfolder/dashboard.js"></script>
  <script src="../assets/js/first.js"></script>
  <script src="../assets/js/drop_down.js"></script>
</body>
</body>
</html>
