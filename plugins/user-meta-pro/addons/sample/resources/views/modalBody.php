<?php namespace UserMeta\Sample;?>
<?php 
// Expecting: $someVariable from the caller.
?>

<h3>Hello from <?= $someVariable ?></h3>

<?= Base::view('fooView') ?>