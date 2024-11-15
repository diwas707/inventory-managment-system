<?php
  $page_title = 'Employee List';
  require_once('includes/load.php');
  // Check what level user has permission to view this page
  page_require_level(1);

  // Fetch data from the users table
  $users = find_all('users');
  $user_groups = find_all('user_groups');

  // Get the user level for "user" role
  $user_level = array_filter($user_groups, function($group) {
    return strtolower($group['group_name']) === 'user';
  });
  $user_level = reset($user_level)['group_level'];

  // Filter users to only include those with the "user" role
  $users = array_filter($users, function($user) use ($user_level) {
    return $user['user_level'] == $user_level;
  });
?>
<?php include_once('layouts/header.php'); ?>


<div class="row">
  <div class="col-md-6"></div>
    <?php echo display_msg($msg); ?>
  </div>

  <div class="row">
    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-heading clearfix">
          <strong>
            <span class="glyphicon glyphicon-th"></span>
            <span>User Details</span>
          </strong>
        </div>
        <div class="panel-body">
          <table class="table table-bordered table-striped">
            <thead>
              <tr>
                <th class="text-center" style="width: 10%;">Name</th>
                <th class="text-center" style="width: 10%;">Username</th>
                <th class="text-center" style="width: 15%;">User Role</th>
                <th class="text-center" style="width: 20%;">Address</th>
                <th class="text-center" style="width: 10%;">Contact Number</th>
                <th class="text-center" style="width: 20%;">Document</th>
                <th class="text-center" style="width: 5%;">Action</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($users as $user): ?>
                <tr>
                  <td class="text-center"><?php echo $user['name']; ?></td>
                  <td class="text-center"><?php echo $user['username']; ?></td>
                  <td class="text-center"><?php echo ucwords(find_by_id('user_groups', $user['user_level'])['group_name']); ?></td>
                  <td class="text-center"><?php echo $user['address']; ?></td>
                  <td class="text-center"><?php echo $user['contact_number']; ?></td>
                  <td class="text-center">
                    <?php if($user['document']): ?>
                      <a href="#" class="btn btn-info btn-xs view-document" data-document="<?php echo $user['document']; ?>" data-toggle="modal" data-target="#documentModal">View Document</a>
                    <?php else: ?>
                      No Document
                    <?php endif; ?>
                  </td>
                  <td class="text-center">
                    <a href="delete_employee.php?id=<?php echo (int)$user['id'];?>" class="btn btn-danger btn-xs" title="Delete" data-toggle="tooltip">
                      <span class="glyphicon glyphicon-trash"></span>
                    </a>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Bootstrap Modal -->
<div id="documentModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="documentModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="documentModalLabel">Document Viewer</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <iframe id="documentFrame" src="" style="width: 100%; height: 500px;" frameborder="0"></iframe>
      </div>
    </div>
  </div>
</div>

<script>
  document.querySelectorAll('.view-document').forEach(function(element) {
    element.addEventListener('click', function() {
      var documentUrl = this.getAttribute('data-document');
      document.getElementById('documentFrame').src = documentUrl;
    });
  });

  // Clear the iframe when the modal is closed
  $('#documentModal').on('hidden.bs.modal', function () {
    document.getElementById('documentFrame').src = '';
  });
</script>

<?php include_once('layouts/footer.php'); ?>
