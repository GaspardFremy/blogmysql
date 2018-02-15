<?php
require_once '../tools/_db.php';

//Si $_POST['save'] existe, cela signifie que c'est un ajout d'utilisateur
if(isset($_POST['save'])){
    $query = $db->prepare('INSERT INTO article (title, category_id, summary, content, is_published, created_at) VALUES (?, ?, ?, ?, ?, NOW())');
    $newArticle = $query->execute(
        [
            $_POST['title'],
            $_POST['category_id'],
            $_POST['summary'],
            $_POST['content'],
            $_POST['is_published'],
        ]
    );
    //redirection après enregistrement
    //si $newUser alors l'enregistrement a fonctionné
    if($newArticle){
        header('location:article-list.php');
        exit;
    }
    else{ //si pas $newUser => enregistrement échoué => générer un message pour l'administrateur à afficher plus bas
        $message = "Impossible d'enregistrer le nouvel utilisateur...";
    }
}

//Si $_POST['update'] existe, cela signifie que c'est une mise à jour d'utilisateur
if(isset($_POST['update'])){

    $query = $db->prepare('UPDATE article SET
		title = :title,
		category_id = :category_id,
		summary = :summary,
		created_at = NOW(),
		content = :content,
		is_published = :is_published
		WHERE id = :id'
    );

    //données du formulaire
    $result = $query->execute(
        [
            'title' => $_POST['title'],
            'category_id' => $_POST['category_id'],
            'summary' => $_POST['summary'],
            'content' => $_POST['content'],
            'is_published' => $_POST['is_published'],
            'id' => $_POST['id'],
        ]
    );

    if($result){
        header('location:article-list.php');
        exit;
    }
    else{
        $message = 'Erreur.';
    }
}

//si on modifie un utilisateur, on doit séléctionner l'utilisateur en question (id envoyé dans URL) pour pré-remplir le formulaire plus bas
if(isset($_GET['article_id']) && isset($_GET['action']) && $_GET['action'] == 'edit'){

    $query = $db->prepare('SELECT * FROM article WHERE id = ?');
    $query->execute(array($_GET['article_id']));
    //$user contiendra les informations de l'utilisateur dont l'id a été envoyé en paramètre d'URL
    $article = $query->fetch();
}

?>
<!DOCTYPE html>
<html>
<head>

    <title>Administration des utilisateurs - Mon premier blog !</title>

    <?php require 'partials/head_assets.php'; ?>

</head>
<body class="index-body">
<div class="container-fluid">

    <?php require 'partials/header.php'; ?>

    <div class="row my-3 index-content">

        <?php require 'partials/nav.php'; ?>

        <section class="col-9">
            <header class="pb-3">
                <!-- Si $user existe, on affiche "Modifier" SINON on affiche "Ajouter" -->
                <h4><?php if(isset($article)): ?>Modifier<?php else: ?>Ajouter<?php endif; ?> un Article</h4>
            </header>

            <?php if(isset($message)): //si un message a été généré plus haut, l'afficher ?>
                <div class="bg-danger text-white">
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>

            <!-- Si $user existe, chaque champ du formulaire sera pré-remplit avec les informations de l'utilisateur -->

            <form action="article-form.php" method="post">
                <div class="form-group">
                    <label for="title">Title :</label>
                    <input class="form-control" <?php if(isset($article)): ?>value="<?php echo $article['title']?>"<?php endif; ?> type="text" placeholder="Prénom" name="title" id="title" />
                </div>
                <div class="form-group">
                    <label for="is_admin">Catégorie :</label>
                    <select class="form-control" name="category_id" id="category_id">
                        <?php $queryCat = $db ->query('SELECT name,id FROM category'); ?>
                        <?php while($cat = $queryCat ->fetch()): ?>
                            <option value="<?php echo $cat['id']; ?>"><?php echo $cat['name']; ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="content">Content :</label>
                    <textarea class="form-control" name="content" id="content" placeholder="Contenu..."><?php if(isset($article)): ?><?php echo $article['content']?><?php endif; ?></textarea>
                </div>
                <div class="form-group">
                    <label for="summary">Summary :</label>
                    <textarea class="form-control" name="summary" id="summary" placeholder="Résumé..."><?php if(isset($article)): ?><?php echo $article['content']?><?php endif; ?></textarea>
                </div>
                <div class="form-group">
                    <label for="is_published">Published ?</label>
                    <select class="form-control" name="is_published" id="is_published">
                        <option value="0" <?php if(isset($article) && $article['is_published'] == 0): ?>selected<?php endif; ?>>Non</option>
                        <option value="1" <?php if(isset($article) && $article['is_published'] == 1): ?>selected<?php endif; ?>>Oui</option>
                    </select>
                </div>

                <div class="text-right">
                    <!-- Si $user existe, on affiche un lien de mise à jour -->
                    <?php if(isset($article)): ?>
                        <input class="btn btn-success" type="submit" name="update" value="Mettre à jour" />
                        <!-- Sinon on afficher un lien d'enregistrement d'un nouvel utilisateur -->
                    <?php else: ?>
                        <input class="btn btn-success" type="submit" name="save" value="Enregistrer" />
                    <?php endif; ?>
                </div>

                <!-- Si $user existe, on ajoute un champ caché contenant l'id de l'utilisateur à modifier pour la requête UPDATE -->
                <?php if(isset($article)): ?>
                    <input type="hidden" name="id" value="<?php echo $article['id']?>" />
                <?php endif; ?>

            </form>
        </section>
    </div>

</div>
</body>
</html>
