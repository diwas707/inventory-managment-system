<?php
  $page_title = 'Add User';
  require_once('includes/load.php');
  page_require_level(1);

  $all_groups = find_all('user_groups');

  $groups = array_filter($all_groups, function($group) {
    return in_array(strtolower($group['group_name']), ['admin', 'user']);
  });

  if(isset($_POST['add_user'])){

    $req_fields = array('full-name','username','password','level');
    validate_fields($req_fields);

    if(empty($errors)){
      $name = remove_junk($db->escape($_POST['full-name']));
      $username = remove_junk($db->escape($_POST['username']));
      $password = remove_junk($db->escape($_POST['password']));
      $user_level = (int)$db->escape($_POST['level']);
      $password = sha1($password);
      $address = isset($_POST['address']) ? remove_junk($db->escape($_POST['address'])) : '';
      $contact_number = isset($_POST['contact-number']) ? remove_junk($db->escape($_POST['contact-number'])) : '';
      $document = '';

      if(isset($_FILES['document']) && $_FILES['document']['error'] == 0) {
        $document = 'uploads/' . basename($_FILES['document']['name']);
        move_uploaded_file($_FILES['document']['tmp_name'], $document);
      }

      // Check if username already exists
      $user_exists_query = "SELECT id FROM users WHERE username = '{$username}' LIMIT 1";
      $user_exists_result = $db->query($user_exists_query);

      if($db->num_rows($user_exists_result) > 0) {
        $session->msg('d', 'Sorry, username already exists!');
        redirect('add_user.php', false);
      } else {
        $query = "INSERT INTO users (name, username, password, user_level, status, address, contact_number, document) 
                  VALUES ('{$name}', '{$username}', '{$password}', '{$user_level}', '1', '{$address}', '{$contact_number}', '{$document}')";
        if($db->query($query)){
          $session->msg('s', "User account has been created!");
          redirect('add_user.php', false);
        } else {
          $session->msg('d', 'Sorry, failed to create account!');
          redirect('add_user.php', false);
        }
      }
    } else {
      $session->msg("d", $errors);
      redirect('add_user.php', false);
    }
  }
?>
<?php include_once('layouts/header.php'); ?>
<?php echo display_msg($msg); ?>
<div class="row">
  <div class="panel panel-default">
    <div class="panel-heading">
      <strong>
        <span class="glyphicon glyphicon-th"></span>
        <span>Add New User</span>
      </strong>
    </div>
    <div class="panel-body">
      <div class="col-md-6">
        <form method="post" action="add_user.php" enctype="multipart/form-data">
          <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" name="full-name" placeholder="Full Name" pattern="[A-Za-z\s]+$" title="Name cannot contain numbers">
          </div>
          <div class="form-group">
            <label for="username">Username</label>
            <input type="text" class="form-control" name="username" placeholder="Username" autocomplete="off">
          </div>
          <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" name="password" placeholder="Password">
          </div>
          <div class="form-group">
            <label for="level">User Role</label>
            <select class="form-control" name="level" id="user-role">
              <?php foreach ($groups as $group ): ?>
                <option value="<?php echo $group['group_level']; ?>"><?php echo ucwords($group['group_name']); ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="form-group" id="user-fields" style="display:none;">
            <div class="form-group">
              <label for="address">Address</label>
              <input type="text" class="form-control" name="address" placeholder="Address">
            </div>
            <div class="form-group">
              <label for="contact-number">Contact Number</label>
              <input type="text" class="form-control" name="contact-number" placeholder="Contact Number" pattern="^(98|97)\d{8}$" title="invalid contact number">
            </div>
            <div class="form-group">
              <label for="document">Document</label>
              <input type="file" class="form-control" name="document">
            </div>
          </div>
          <div class="form-group clearfix">
            <button type="submit" name="add_user" class="btn btn-primary">Add User</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
  document.getElementById('user-role').addEventListener('change', function() {
    var userFields = document.getElementById('user-fields');
    if (this.options[this.selectedIndex].text.toLowerCase() === 'user') {
      userFields.style.display = 'block';
    } else {
      userFields.style.display = 'none';
    }
  });
</script>

<?php include_once('layouts/footer.php'); ?>
