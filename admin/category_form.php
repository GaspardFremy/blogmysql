<?php require_once '../tools/_db.php' ?>

<?php if(isset($_POST['button'])): ?>
  <?php $request = $db -> prepare('INSERT INTO category(name,description) VALUES (?,?)'); ?>
  <?php $request -> execute(array($_POST['name'], $_POST['description'])); ?>

<?php endif; ?>



<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <form class="" action="category_form.php" method="post">
        <label for="name">NAME</label><input class="name" type="text" name="name" value="">
        <label for="description">DESC</label><input class="description" type="text" name="description" value="">
        <button type="submit" name="button">Submit</button>
    </form>
  </body>
</html>
