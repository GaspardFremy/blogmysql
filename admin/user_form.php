<?php require_once '../tools/_db.php' ?>

<?php if (isset($_POST['button'])): ?>

    <?php $query = $db->prepare('INSERT INTO user (first_name, last_name, email, password, is_admin) VALUES (?,?,?,?,?)');
    $request = $query->execute(array($_POST['firstname'], $_POST['lastname'], $_POST['email'], $_POST['password'], $_POST['is_admin']));  ?>

    <?php if($request) {
      echo 'c\'est doux ça passe.';
    }else{
      echo 'c\'est pas doux ça passe pas.';
    } ?>
  <?php endif; ?>


<!DOCTYPE html>


<html>
  <head>
    <meta charset="utf-8">
    <title>Admin category</title>
  </head>
  <body>

  <form class="" action="user_form.php" method="post">
      <label for="first">Firstname</label><input class="first" type="text" name="firstname" value=""/><br>
      <label for="last">Lastname</label><input class "last" type="text" name="lastname" value=""/><br>
      <label for="mail">email</label><input class="mail" type="text" name="email" value=""/><br>
      <label for="pass">Password</label><input class="pass" type="password" name="password" value=""/><br>
      <label for="bio">Bio</label><textarea class="bio" name="name" rows="8" cols="10"></textarea><br>
      <label for="isadmin">Admin ?</label>
      <select class="isadmin" name="is_admin">
        <option value="0">non</option>
        <option value="1">oui</option>
      </select><br>
      <button type="submit" name="button">Submit</button>
  </form>
</body>
</html>
