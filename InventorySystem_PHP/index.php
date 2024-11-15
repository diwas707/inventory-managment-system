<?php   
ob_start();
require_once('includes/load.php');
if($session->isUserLoggedIn(true)) { redirect('home.php', false);}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="inv1.css" />
   
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" rel="stylesheet">
    <title>Bhageswor Hardware</title>
    <script type="text/javascript" src="invo1.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>

<body>
<div class="header">
    <div class="container">
        <div class="row">
            <div class="col-md-6"> 
                <h1 class="header-title"><span class="glyphicon glyphicon-wrench"></span> Bhageswor Hardware</h1>
            </div>

            <div class="col-md-2 text-left"> <!-- Align to left -->
            <p class="left-content">
                <span class="glyphicon glyphicon-map-marker"></span> 
                Sangla Kathmandu
            </p>
                <p class="left-content">Tarkeswor Municipality </p>
            </div>
            
            <div class="col-md-2 text-right"> <!-- Align to right -->
            <p class="right-content">
                <span class="glyphicon glyphicon-earphone"></span> 
                9810282537
            </p>
            <p class="right-content">
                <span class="glyphicon glyphicon-earphone"></span> 
                9861085051
            </p>
            </div>
        </div>
    </div>
</div>

<?php include('navbar.php'); ?>

<section id="homeSection">
    <h2>Welcome to Our Hardware Store</h2>
    <p>Discover a world of possibilities at <span style="color: red; font-weight: bold;">Bhageswor Hardware store</span> and suppliers,
        where quality meets craftsmanship - Your one-stop destination for premium tools,
        top-notch hardware, and superior building materials to bring your projects to life.
    </p>
</section>



<!-- Login Modal Structure -->


<div id="loginModal" class="modal" <?php if(isset($_GET['error'])) echo 'style="display: flex;"'; ?>>
    <!-- Modal Content -->
    <div class="modal-content">
        <!-- Close Button -->
        <span class="close" onclick="closeModalAndRedirect()">&times;</span>
        <h2>Login</h2>
        <form method="post" action="auth.php" class="clearfix">
            <div class="form-group">
                <label for="username" class="control-label">Username</label>
                <input type="text" class="form-control" name="username" placeholder="Username" required>
            </div>
            <div class="form-group">
                <label for="password" class="control-label">Password</label>
                <input type="password" name="password" class="form-control" placeholder="Password" required>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-danger" style="border-radius:0%">Login</button>
            </div>
            <?php echo '<div class="error-message">' . display_msg($msg) . '</div>'; ?>
        </form>
    </div>
</div>

<section id="productsSection" >
    
</section>

<?php include_once('layouts/footer.php'); ?>

</body>
</html>
