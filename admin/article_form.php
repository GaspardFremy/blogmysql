<?php require_once '../tools/_db.php' ?>

<?php if (isset($_POST['button'])): ?>

    <?php $insert = $db->prepare('INSERT INTO article (category_id, title, created_at, content, summary, is_published) VALUES (?,?,NOW(),?,?,?)');
    $request = $insert->execute(array($_POST['cat_id'], $_POST['title'], $_POST['content'], $_POST['summary'], $_POST['ip']));  ?>

    <?php $insert ->closeCursor(); ?>

<?php endif; ?>


<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Article form</title>
  </head>
  <body>
    <form class="" action="article_form.php" method="post">
        <input type="text" name="title" value="" placeholder="title"></br>
        <label for="ca">category</label>
        <select class="ca" name="cat_id">
          <?php $categoriesId = []; ?>
          <?php $categoriesName = []; ?>
          <?php $query = $db -> query('SELECT id,name FROM category'); ?>
          <?php while ($cat = $query -> fetch()) : ?>
              <?php array_push($categoriesName, $cat['name']) ?>
              <?php array_push($categoriesId, $cat['id']) ?>
          <?php endwhile; ?>
          <?php $query->closeCursor() ?>
          <?php for ($i=0; $i < sizeof($categoriesId) ; $i++) :?>
            <option value="<?php echo $categoriesId[$i]; ?>"><?php echo $categoriesName[$i]; ?></option> 
          <?php endfor; ?>
        </select></br>
        <label for="content">Content</label>
        <textarea class="content" name="content" rows="8" cols="80"></textarea></br>
        <label for="summary">Summary</label>
        <textarea class="summary" name="summary" rows="8" cols="80"></textarea></br>
          <label for="ip">Is published ?</label>
        <select class="ip" name="ip">
          <option value="0">isn't published</option>
          <option value="1">is published</option>
        </select>
          <button type="submit" name="button">Submit</button>
    </form>
  </body>
</html>
