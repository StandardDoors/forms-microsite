<?php

$lang = 'en';
$pageTitle = 'Service Request';
$pagePath = '/service/';
include 'partials/header.php';

?>
        <h1><?php echo $t['service.heading']; ?></h1>
        <p><?php echo $t['service.description']; ?></p>

<?php include 'partials/tally-embed.php'; ?>

<?php include 'partials/footer.php'; ?>
