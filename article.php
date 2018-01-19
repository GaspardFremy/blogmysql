<?php require_once '_db.php'; ?>
<?php
$query2 = $db->prepare('SELECT * FROM article WHERE is_published = 1 AND id = ?');
$query2->execute(array($_GET['article_id']));
// data 2 and query 2 because data and query are used in the partial nav.php
$data2 = $query2 -> fetch();
//si article_id n'est pas défini OU si l'article ayant cet ID n'existe pas
if(!isset($_GET['article_id']) || !isset($data2[$_GET['article_id']]) ){
	header('location:index.php');
	exit;
}

?>

<!DOCTYPE html>
<html>
 <head>

	<title><?php echo $data2['title']; ?> - Mon premier blog !</title>

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
            <h1><?php echo $data2['title']; ?></h1>
					<span class="article-date">Créé le <?php echo $data2['created_at']; ?></span>
					<div class="article-content">
						<?php echo $data2['content']; ?>
					</div>
				</article>
			</main>

		</div>

		<?php require 'partials/footer.php'; ?>
    <?php $query2 -> closeCursor(); ?>
	</div>
 </body>
</html>
