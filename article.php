<?php require 'tools/_db.php'; ?>
<?php
$query = $db->prepare('SELECT * FROM article WHERE is_published = 1 AND id = ?');
$query->execute(array($_GET['article_id']));
// data 2 and query 2 because data and query are used in the partial nav.php
$article = $query -> fetch();
//si article_id n'est pas défini OU si l'article ayant cet ID n'existe pas
if(!isset($_GET['article_id']) || empty($article) ){
	header('location:index.php');
	exit;
}

?>

<!DOCTYPE html>
<html>
 <head>

	<title><?php echo $article['title']; ?> - Mon premier blog !</title>

   <?php require 'partials/head_assets.php'; ?>

 </head>
 <body class="article-body">
	<div class="container-fluid">

		<?php require 'partials/header.php'; ?>

		<div class="row my-3 article-content">

			<?php require 'partials/nav.php'; ?>


			<main class="col-9">
				<article>
            <!-- contenu de l'article -->
            <h1><?php echo $article['title']; ?></h1>
					<span class="article-date">Créé le <?php echo $article['created_at']; ?></span>
					<div class="article-content">
						<?php echo $article['content']; ?>
					</div>
				</article>
			</main>

		</div>

		<?php require 'partials/footer.php'; ?>
    <?php $query -> closeCursor(); ?>
	</div>
 </body>
</html>
