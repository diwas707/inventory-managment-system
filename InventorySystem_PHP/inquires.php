<?php
  $page_title = 'User Query';
  require_once('includes/load.php');
  // Checking what level user has permission to view this page
  page_require_level(3);

  // Fetch data from the contacts table
  $contacts = find_all('contacts');
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
      <span>Inquires</span>
          </strong>
          </div>
 
          <div class="panel-body">
          <table class="table table-bordered table-striped">
    <thead>
        <tr>
            
        <th class="text-center" style="width: 15%;">Name</th>
        <th class="text-center" style="width: 15%;">Email</th>
        <th class="text-center" style="width: 15%;">Contact</th>
        <th class="text-center" style="width: 2q5%;">Query</th>
        <th class="text-center" style="width: 5%;">Action</th> 
        </tr>
    </thead>
    <tbody>
        <?php foreach($contacts as $contact): ?>
        <tr>
        <td class="text-center"><?php echo $contact['name']; ?></td>
        <td class="text-center"><?php echo $contact['email']; ?></td>
        <td class="text-center"><?php echo $contact['contact']; ?></td>
        <td class="text-center"><?php echo $contact['inquiry']; ?></td>
        <td class="text-center">
            
            <a href="deletecontact.php?id=<?php echo (int)$contact['id'];?>" class="btn btn-danger btn-xs" title="Delete" data-toggle="tooltip">
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

<?php include_once('layouts/footer.php'); ?>
