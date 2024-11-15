<?php
require_once('includes/load.php');
$recent_products = find_recent_product_added('4');
$products = join_product_table();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="libs/css/display00.css">


  
</head>
<body>
<div class="container">

     
<div class="text-right">
    <button id="showContactForm"class="btn btn-primary btn-lg custom-btn" onclick="window.location.href = 'query.php';">product query</button>
</div>

    <!-- Recently Added Products -->
    <div class="col-md-4">
        <div class="panel panel-default">
            <div class="panel-heading">
                <strong>
                    <span class="glyphicon glyphicon-th"></span>
                    <span>Recently Added Products</span>
                </strong>
            </div>
            <div class="panel-body">
                <div class="list-group">
                    <?php foreach ($recent_products as $recent_product): ?>
                    <div class="list-group-item clearfix">
                        <div class="media">
                            <div class="media-left">
                                <?php if($recent_product['media_id'] === '0'): ?>
                                <img class="img-avatar img-circle" src="uploads/products/no_image.png" alt="No Image">
                                <?php else: ?>
                                <img class="img-avatar img-circle" src="uploads/products/<?php echo $recent_product['image'];?>" alt="Product Image">
                                <?php endif;?>
                            </div>
                            <div class="media-body">
                                <h4 class="media-heading"><?php echo remove_junk(first_character($recent_product['name']));?></h4>
                                <p>
                                    <span class="label label-warning">
                                        <?php echo (int)$recent_product['sale_price']; ?> rs
                                    </span> 
                                    <br>
                                    <?php echo remove_junk(first_character($recent_product['categorie'])); ?>
                                </p>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Available Products -->
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <strong>
                    <span class="glyphicon glyphicon-shopping-cart"></span>
                    <span style="color: green;">Available Products</span>
                </strong>
            </div>
            <div class="panel-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 50px;">#</th>
                            <th>Product</th>
                            <th>Product Name</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($products as $product):?>
                        <tr>
                            <td class="text-center"><?php echo count_id();?></td>
                            <td>
                                <?php if($product['media_id'] === '0'): ?>
                                <img class="img-avatar img-circle" src="uploads/products/no_image.png" alt="No Image">
                                <?php else: ?>
                                <img class="img-avatar img-circle" src="uploads/products/<?php echo $product['image']; ?>" alt="Product Image">
                                <?php endif; ?>
                            </td>
                            <td><?php echo remove_junk($product['name']); ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
 


</body>

</html>

