<?php
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
  page_require_level(1);

  $user_id = (int)$_GET['id'];

  if ($user_id === 21) {
    $session->msg("d", "Cannot delete the primary admin.");
    redirect('users.php', false);
  } else {
    $delete_id = delete_by_id('users', $user_id);
    if ($delete_id) {
      $session->msg("s", "User deleted.");
      redirect('users.php');
    } else {
      $session->msg("d", "User deletion failed or Missing Prm.");
      redirect('users.php');
    }
  }
?>
