<?php

require_once 'tools/_db.php'; 

if(isset($_GET['category_id']) ){ //si une catégorie est demandée via un id en URL


    $query2 = $db ->prepare('SELECT c.*, a.* 
                                      FROM category c
                                      JOIN article a
                                      ON c.id = a.category_id
                                      WHERE c.id = ? AND a.is_published = 1
                                      ORDER BY a.created_at DESC');

    $query2 -> execute([
        $_GET['category_id']
    ]);

    $articles = $query2 -> fetchAll();
	
	if(!$articles){ //Si la catégorie demandé existe bien
        header('location:index.php');
        exit;
	}
}
else{ //si PAS de catégorie demandée via un id en URL

	//séléction de tous les articles publiés
	$query = $db->query('SELECT c.*, a.* 
                                      FROM category c
                                      JOIN article a
                                      ON c.id = a.category_id
                                      WHERE a.is_published = 1
                                      ORDER BY a.created_at DESC');
	$articles = $query->fetchAll();
	var_dump($articles);
}

?>

<!DOCTYPE html>
<html>
 <head>
	<!-- si on affiche une catégorie, affichage de son nom, sinon affichage de "tous les articles" -->
	<title><?php if(isset($articles[0]['name'])): ?><?php echo $articles[0]['name']; ?><?php else : ?>Tous les articles<?php endif; ?> - Mon premier blog !</title>
   
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
						<!-- si on affiche une catégorie, affichage de son nom, sinon affichage de "tous les articles" -->
						<h1 class="mb-4"><?php if(isset($articles[0]['name'])): ?><?php echo $articles[0]['name']; ?><?php else : ?>Tous les articles<?php endif; ?> :</h1>
					</header>
					
					<!-- si on affiche une catégorie, affichage d'une div contenant sa description -->
					<?php if(isset($articles[0]['description'])): ?>
					<div class="category-description mb-4">
						<?php echo $articles[0]['description']; ?>
					</div>
					<?php endif; ?>
					
					<!-- s'il y a des articles à afficher -->
					<?php if(!empty($articles)): ?>
					
						<?php foreach($articles as $key => $article): ?>
						<article class="mb-4">
							<h2><?php echo $article['title']; ?></h2>

                            <?php $bool=false; ?>

							<!-- Si nous n'affichons pas une catégorie en particulier, je souhaite que le nom de la catégorie de chaque article apparaisse à côté de la date -->
							<?php for ($i = 0; $i < sizeof($articles)-2; $i++ ): ?>
                            <?php if(($articles[$i]['name']) != $articles[$i+1]['name']): ?>
							<?php $bool = true; ?>
                            <?php else: ?>
                            <?php $bool = false;?>
							<?php endif; ?>
							<?php endfor; ?>

                            <?php if($bool == true): ?>
                            <b class="article-category">[<?php echo $articles[$key]['name']; ?>]</b>
                            <?php endif; ?>
							<!-- affichage des infos de chaque article de la boucle -->
							<span class="article-date">Créé le <?php echo $article['created_at']; ?></span>
							<div class="article-summary">
								<?php echo $article['summary']; ?>
							</div>
							<a href="article.php?article_id=<?php echo $article['id']; ?>">> Lire l'article</a>
						</article>
						<?php endforeach; ?>
						
					<?php else: ?>
						<!-- s'il n'y a pas d'articles à afficher (catégorie vide ou aucun article publié) -->
						Aucun article dans cette catégorie...
					<?php endif; ?>
				</section>
			</main>
			
		</div>
		
		<?php require 'partials/footer.php'; ?>
		
	</div>
 </body>
</html>