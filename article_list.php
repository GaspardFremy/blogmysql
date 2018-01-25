<?php require_once 'tools/_db.php';

if (isset($_GET['id'])){
$query = $db->prepare('SELECT * FROM category WHERE id = ?');
$query->execute(array($_GET['id']));

$category = $query -> fetch();

$query -> closeCursor();
}

//si l'ID de catégorie n'est pas défini OU si la catégorie ayant cet ID n'existe pas
if(isset($_GET['id']) && empty($category) ){
	header('location:index.php');
	exit;
}
?>

<!DOCTYPE html>
<html>
 <head>

	<title><?php if(isset($_GET['id'])): ?><?php echo $category['name']; ?><?php else: ?>Tous les articles<?php endif; ?> - Mon premier blog !</title>

   <?php require 'partials/head_assets.php'; ?>

 </head>
 <body class="article-list-body">
	<div class="container-fluid">

		<?php require 'partials/header.php'; ?>

		<div class="row my-3 article-list-content">

			<?php require('partials/nav.php'); ?>

			<main class="col-9">
				<section class="all_aricles">
					<header>
						<?php if(isset($_GET['id'])): ?>
						<h1 class="mb-4"><?php echo $category['name']; ?></h1>
						<?php else: ?>
						<h1 class="mb-4">Tous les articles :</h1>
						<?php endif; ?>
					</header>

					<?php if(isset($_GET['id'])): ?>
					<div class="category-description mb-4">
					<?php echo $category['description']; ?>
					</div>
					<?php endif; ?>

					<?php if( isset($_GET['id']) AND $category['id'] == $_GET['id'] ) : ?>

						<?php $query = $db -> prepare('SELECT * FROM article WHERE category_id = ? AND is_published = 1');
						$query -> execute(array($category['id'])); ?>

						<?php while($article = $query -> fetch()): ?>
					<article class="mb-4">
						<h2><?php echo $article['title']; ?></h2>
						<span class="article-date"><?php echo $article['created_at']; ?></span>
						<div class="article-content">
							<?php echo $article['summary']; ?>
						</div>
						<a href="article.php?article_id=<?php echo $article['id']; ?>">> Lire l'article</a>
					</article>

				<?php endwhile; ?>

			<?php elseif (!isset($_GET['id'])): ?>
				<?php $query = $db -> prepare('SELECT * FROM article WHERE is_published = 1');
				$query -> execute(); ?>

				<?php while($article = $query -> fetch()): ?>
						<article class="mb-4">
							<h2><?php echo $article['title']; ?></h2>
							<span class="article-date"><?php echo $article['created_at']; ?></span>
							<div class="article-content">
								<?php echo $article['summary']; ?>
							</div>
							<a href="article.php?article_id=<?php echo $article['id']; ?>">> Lire l'article</a>
						</article>

				<?php endwhile; ?>
			<?php endif; ?>

				</section>
			</main>
				<?php $query -> closeCursor(); ?>
		</div>

		<?php require 'partials/footer.php'; ?>

	</div>
 </body>
</html>
