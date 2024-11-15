<?php
  $page_title = 'Edit User';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
  page_require_level(1);
?>
<?php
  $e_user = find_by_id('users', (int)$_GET['id']);
  $groups = find_all('user_groups');
  if (!$e_user) {
    $session->msg("d", "Missing user id.");
    redirect('users.php');
  }
?>

<?php
// Update User basic info
if (isset($_POST['update'])) {
  $req_fields = array('name', 'username', 'level');
  validate_fields($req_fields);
  if (empty($errors)) {
    $id = (int)$e_user['id'];
    $name = remove_junk($db->escape($_POST['name']));
    $username = remove_junk($db->escape($_POST['username']));
    $level = (int)$db->escape($_POST['level']);
    $status = remove_junk($db->escape($_POST['status']));
    $address = isset($_POST['address']) ? remove_junk($db->escape($_POST['address'])) : '';
    $contact_number = isset($_POST['contact-number']) ? remove_junk($db->escape($_POST['contact-number'])) : '';
    $document = $e_user['document'];

    if (isset($_FILES['document']) && $_FILES['document']['error'] == 0) {
      $document = 'uploads/' . basename($_FILES['document']['name']);
      move_uploaded_file($_FILES['document']['tmp_name'], $document);
    }

    $sql = "UPDATE users SET name='{$name}', username='{$username}', user_level='{$level}', status='{$status}', address='{$address}', contact_number='{$contact_number}', document='{$document}' WHERE id='{$db->escape($id)}'";
    $result = $db->query($sql);
    if ($result && $db->affected_rows() === 1) {
      $session->msg('s', "Account Updated ");
      redirect('edit_user.php?id=' . (int)$e_user['id'], false);
    } else {
      $session->msg('d', 'Sorry, failed to update!');
      redirect('edit_user.php?id=' . (int)$e_user['id'], false);
    }
  } else {
    $session->msg("d", $errors);
    redirect('edit_user.php?id=' . (int)$e_user['id'], false);
  }
}
?>

<?php include_once('layouts/header.php'); ?>
<div class="row">
  <div class="col-md-12"> <?php echo display_msg($msg); ?> </div>
  <div class="col-md-6">
    <div class="panel panel-default">
      <div class="panel-heading">
        <strong>
          <span class="glyphicon glyphicon-th"></span>
          Update <?php echo remove_junk(ucwords($e_user['name'])); ?> Account
        </strong>
      </div>
      <div class="panel-body">
        <form method="post" action="edit_user.php?id=<?php echo (int)$e_user['id']; ?>" class="clearfix" enctype="multipart/form-data">
        <div class="form-group">
    <label for="name" class="control-label">Name</label>
    <input type="text" class="form-control" name="name" value="<?php echo remove_junk($e_user['name']); ?>" pattern="^[A-Za-z\s]+$" title="Name cannot contain numbers">
</div>
          <div class="form-group">
            <label for="username" class="control-label">Username</label>
            <input type="text" class="form-control" name="username" value="<?php echo remove_junk($e_user['username']); ?>">
          </div>
          <div class="form-group">
  <label for="level">User Role</label>
  <select class="form-control" name="level" id="user-role">
    <?php foreach ($groups as $group): ?>
      <?php if ($group['group_name'] !== 'special'): ?>
        <option <?php if ($group['group_level'] === $e_user['user_level']) echo 'selected="selected"'; ?> value="<?php echo $group['group_level']; ?>"><?php echo ucwords($group['group_name']); ?></option>
      <?php endif; ?>
    <?php endforeach; ?>
  </select>
</div>

          <div class="form-group" id="user-fields" style="display: none;">
            <div class="form-group">
              <label for="address">Address</label>
              <input type="text" class="form-control" name="address" value="<?php echo remove_junk($e_user['address']); ?>" placeholder="Address">
            </div>
            <div class="form-group">
        <label for="contact-number">Contact Number</label>
        <input type="text" class="form-control" name="contact-number" value="<?php echo remove_junk($e_user['contact_number']); ?>" pattern="^(98|97)\d{8}$" title="Contact number must start with 98 or 97 and should be 10 digits" placeholder="Contact Number">
    </div>
            <div class="form-group">
              <label for="document">Document</label>
              <input type="file" class="form-control" name="document">
              <?php if ($e_user['document']): ?>
                <p>Current document: <a href="<?php echo $e_user['document']; ?>" target="_blank">View</a></p>
              <?php endif; ?>
            </div>
          </div>
          <div class="form-group clearfix">
            <button type="submit" name="update" class="btn btn-info">Update</button>
          </div>
        </form>
      </div>
    </div>
  </div>


<script>
  document.addEventListener('DOMContentLoaded', function() {
    var userRoleSelect = document.getElementById('user-role');
    var userFields = document.getElementById('user-fields');

    function toggleUserFields() {
      if (userRoleSelect.options[userRoleSelect.selectedIndex].text.toLowerCase() === 'user') {
        userFields.style.display = 'block';
      } else {
        userFields.style.display = 'none';
      }
    }

    userRoleSelect.addEventListener('change', toggleUserFields);
    toggleUserFields();  // Initial call to set the correct state on page load
  });
</script>

<?php include_once('layouts/footer.php'); ?>
