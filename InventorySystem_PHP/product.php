<?php
$page_title = 'All Products Categorically';
require_once('includes/load.php');

page_require_level(3);

// Fetch all categories
$categories = find_all('categories');
?>

<?php include_once('layouts/header.php'); ?>


<div class="row">
  <div class="col-md-12">
    <?php echo display_msg($msg); ?>
  </div>
</div>

<div class="row">
  <div class="col-md-4">
    <div class="panel panel-default">
      <div class="panel-heading clearfix">
        <h4 class="panel-title">Categories</h4>
      </div>
      <div class="panel-body">
        <ul class="list-group">
          <?php foreach ($categories as $category): ?>
            <li class="list-group-item"><a href="?category=<?php echo (int)$category['id']; ?>"><?php echo remove_junk($category['name']); ?></a></li>
          <?php endforeach; ?>
        </ul>
      </div>
    </div>
  </div>

  <div class="col-md-8">
    <div class="panel panel-default">
      <div class="panel-heading clearfix">
        <h4 class="panel-title">Products</h4>
      </div>
      <div class="panel-body">
        <?php
        if (isset($_GET['category'])) {
          $category_id = (int)$_GET['category'];
          $category_name = find_by_id('categories', $category_id)['name'];
          $products = find_products_by_category_id($category_id);
          if ($products) {
            echo "<h4> {$category_name}</h4>";
            echo "<table class=\"table table-bordered\">";
            echo "<thead>";
            echo "<tr>";
            echo "<th>#</th>";
            echo "<th>Product Title</th>";
            echo "<th>In-Stock</th>";
            echo "<th>Buying Price</th>";
            echo "<th>Selling Price</th>";
            echo "<th>Product Added</th>";
            echo "<th>Actions</th>";
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";
            foreach ($products as $product) {
              echo "<tr>";
              echo "<td>{$product['id']}</td>";
              echo "<td>{$product['name']}</td>";
              echo "<td>{$product['quantity']}</td>";
              echo "<td>{$product['buy_price']}</td>";
              echo "<td>{$product['sale_price']}</td>";
              echo "<td>{$product['date']}</td>";
              echo "<td>";
              echo "<div class=\"btn-group\">";
              echo "<a href=\"edit_product.php?id={$product['id']}\" class=\"btn btn-info btn-xs\" title=\"Edit\" data-toggle=\"tooltip\">";
              echo "<span class=\"glyphicon glyphicon-edit\"></span>";
              echo "</a>";
              echo "<a href=\"delete_product.php?id={$product['id']}\" class=\"btn btn-danger btn-xs\" title=\"Delete\" data-toggle=\"tooltip\">";
              echo "<span class=\"glyphicon glyphicon-trash\"></span>";
              echo "</a>";
              echo "</div>";
              echo "</td>";
              echo "</tr>";
            }
            echo "</tbody>";
            echo "</table>";
          } else {
            echo "<p>No products found in {$category_name}</p>";
          }
        } else {
          echo "<p>Select a category to view products.</p>";
        }
        ?>
      </div>
    </div>
  </div>
</div>

<?php include_once('layouts/footer.php'); ?>
