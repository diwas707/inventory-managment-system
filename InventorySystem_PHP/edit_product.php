<?php
  $page_title = 'Edit product';
  require_once('includes/load.php');
  // Checking what level user has permission to view this page
  page_require_level(3);
?>
<?php
$product = find_by_id('products', (int)$_GET['id']);
$all_categories = find_all('categories');
$all_photo = find_all('media');

if (!$product) {
  $session->msg("d", "Missing product id.");
  redirect('product.php');
}
?>
<?php
if (isset($_POST['product'])) {
  $req_fields = array('product-title', 'product-categorie', 'product-quantity', 'buying-price', 'saleing-price');
  validate_fields($req_fields);

  if (empty($errors)) {
    $p_name  = remove_junk($db->escape($_POST['product-title']));
    $p_cat   = (int)$_POST['product-categorie'];
    $p_qty   = remove_junk($db->escape($_POST['product-quantity']));
    $p_buy   = remove_junk($db->escape($_POST['buying-price']));
    $p_sale  = remove_junk($db->escape($_POST['saleing-price']));
    $media_id = is_null($_POST['product-photo']) || $_POST['product-photo'] === "" ? '0' : remove_junk($db->escape($_POST['product-photo']));

    // Calculate new total quantity
    $add_qty = isset($_POST['add-quantity']) ? (int)$_POST['add-quantity'] : 0;
    $remove_qty = isset($_POST['remove-quantity']) ? (int)$_POST['remove-quantity'] : 0;
    $new_total_qty = $product['quantity'] + $add_qty - $remove_qty;

    $query  = "UPDATE products SET";
    $query .= " name = '{$p_name}', quantity = '{$new_total_qty}',";
    $query .= " buy_price = '{$p_buy}', sale_price = '{$p_sale}', categorie_id = '{$p_cat}', media_id = '{$media_id}'";
    $query .= " WHERE id = '{$product['id']}'";
    
    if ($db->query($query) && $db->affected_rows() === 1) {
      $session->msg('s', "Product updated");
      redirect('product.php', false);
    } else {
      $session->msg('d', ' Sorry, failed to update!');
      redirect('edit_product.php?id=' . $product['id'], false);
    }
  } else {
    $session->msg("d", $errors);
    redirect('edit_product.php?id=' . $product['id'], false);
  }
}
?>
<?php include_once('layouts/header.php'); ?>
<div class="row">
  <div class="col-md-12">
    <?php echo display_msg($msg); ?>
  </div>
</div>
<div class="row">
  <div class="panel panel-default">
    <div class="panel-heading">
      <strong>
        <span class="glyphicon glyphicon-th"></span>
        <span>Edit Product</span>
      </strong>
    </div>
    <div class="panel-body">
      <div class="col-md-7">
        <form method="post" action="edit_product.php?id=<?php echo (int)$product['id'] ?>">
          <div class="form-group">
            <div class="input-group">
              <span class="input-group-addon">
                <i class="glyphicon glyphicon-th-large"></i>
              </span>
              <input type="text" class="form-control" name="product-title" value="<?php echo remove_junk($product['name']); ?>">
            </div>
          </div>
          <div class="form-group">
            <div class="row">
              <div class="col-md-6">
                <select class="form-control" name="product-categorie">
                  <option value="">Select a category</option>
                  <?php foreach ($all_categories as $cat): ?>
                    <option value="<?php echo (int)$cat['id']; ?>" <?php if ($product['categorie_id'] === $cat['id']) echo "selected"; ?>>
                      <?php echo remove_junk($cat['name']); ?>
                    </option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="col-md-6">
                <select class="form-control" name="product-photo">
                  <option value="">No image</option>
                  <?php foreach ($all_photo as $photo): ?>
                    <option value="<?php echo (int)$photo['id']; ?>" <?php if ($product['media_id'] === $photo['id']) echo "selected"; ?>>
                      <?php echo $photo['file_name']; ?>
                    </option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label for="qty">Current Quantity</label>
                  <input type="text" class="form-control" name="product-quantity" value="<?php echo remove_junk($product['quantity']); ?>" readonly>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="add-quantity">Add Quantity</label>
                  <input type="number" class="form-control" name="add-quantity" value="0">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="remove-quantity">Remove Quantity</label>
                  <input type="number" class="form-control" name="remove-quantity" value="0">
                </div>
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="buying-price">Buying Price</label>
                  <div class="input-group">
                    <span class="input-group-addon">
                    <i class="glyphicon">&#x0930;&#x0942;</i>
                    </span>
                    <input type="number" class="form-control" name="buying-price" value="<?php echo remove_junk($product['buy_price']); ?>">
                    <span class="input-group-addon">.00</span>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="saleing-price">Selling Price</label>
                  <div class="input-group">
                    <span class="input-group-addon">
                    <i class="glyphicon">&#x0930;&#x0942;</i>
                      </span>
                    <input type="number" class="form-control" name="saleing-price" value="<?php echo remove_junk($product['sale_price']); ?>">
                    <span class="input-group-addon">.00</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <button type="submit" name="product" class="btn btn-primary">Update</button>
        </form>
      </div>
    </div>
  </div>
</div>
<?php include_once('layouts/footer.php'); ?>

