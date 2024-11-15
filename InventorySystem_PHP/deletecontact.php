<?php
require_once('includes/load.php');

// Check the user's permission level
page_require_level(3);

// Find the contact by ID
$contact = find_by_id('contacts', (int)$_GET['id']);

// Check if the contact exists
if (!$contact) {
    $session->msg("d", "Missing inquery ID.");
    redirect('mail.php');
}

// Attempt to delete the contact
$delete_id = delete_by_id('contacts', (int)$contact['id']);

// Check if the deletion was successful
if ($delete_id) {
    $session->msg("s", "inquery deleted.");
    redirect('inquires.php');
} else {
    $session->msg("d", "inquery deletion failed.");
    redirect('inquires.php');
}
?>
