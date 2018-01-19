<?php require('_db.php'); ?>
<nav class="col-3 py-2 categories-nav">
	<b>Catégories :</b>
	<ul>
		<li><a href="article_list.php">Tous les articles</a></li>
		<!-- liste des catégories -->

	 <?php $query = $db -> query('SELECT id,name FROM category') ?>

<?php while($data = $query -> fetch()){
		echo '<li><a href="article_list.php?id=' . $data['id'] . '">' . $data['name'] . '</a></li>';
} ?>
		<?php $query->closeCursor(); ?>
	</ul>
</nav>
