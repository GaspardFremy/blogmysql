<?php
require_once '../tools/_db.php';
if($_SESSION['is_admin'] != 1){
    header('location: login-register.php');
}

//Si $_POST['save'] existe, cela signifie que c'est un ajout d'utilisateur
if(isset($_POST['save'])){
    $query = $db->prepare('INSERT INTO category (name, description) VALUES (?, ?)');
    $newCat = $query->execute(
        [
            $_POST['name'],
            $_POST['description'],
        ]
    );
    //redirection après enregistrement
    //si $newUser alors l'enregistrement a fonctionné
    if($newCat){
        header('location:category-list.php');
        exit;
    }
    else{ //si pas $newUser => enregistrement échoué => générer un message pour l'administrateur à afficher plus bas
        $message = "Impossible d'enregistrer le nouvel utilisateur...";
    }
}

//Si $_POST['update'] existe, cela signifie que c'est une mise à jour d'utilisateur
if(isset($_POST['update'])){

    $query = $db->prepare('UPDATE category SET
		name = :name,
		description = :description,
		WHERE id = :id'
    );

    //données du formulaire
    $result = $query->execute(
        [
            'name' => $_POST['name'],
            'description' => $_POST['description']
        ]
    );

    if($result){
        header('location:category-list.php');
        exit;
    }
    else{
        $message = 'Erreur.';
    }
}

//si on modifie un utilisateur, on doit séléctionner l'utilisateur en question (id envoyé dans URL) pour pré-remplir le formulaire plus bas
if(isset($_GET['category_id']) && isset($_GET['action']) && $_GET['action'] == 'edit'){

    $query = $db->prepare('SELECT * FROM category WHERE id = ?');
    $query->execute(array($_GET['category_id']));
    //$user contiendra les informations de l'utilisateur dont l'id a été envoyé en paramètre d'URL
    $category = $query->fetch();
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
                <h4><?php if(isset($category)): ?>Modifier<?php else: ?>Ajouter<?php endif; ?> un Article</h4>
            </header>

            <?php if(isset($message)): //si un message a été généré plus haut, l'afficher ?>
                <div class="bg-danger text-white">
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>

            <!-- Si $user existe, chaque champ du formulaire sera pré-remplit avec les informations de l'utilisateur -->

            <form action="category-form.php" method="post">
                <div class="form-group">
                    <label for="title">Name :</label>
                    <input class="form-control" <?php if(isset($category)): ?>value="<?php echo $category['name']?>"<?php endif; ?> type="text" placeholder="Prénom" name="title" id="title" />
                </div>
                <div class="form-group">
                    <label for="description">Description :</label>
                    <textarea class="form-control" name="description" id="description" placeholder="Contenu..."><?php if(isset($category)): ?><?php echo $category['description']?><?php endif; ?></textarea>
                </div>

                <div class="text-right">
                    <!-- Si $user existe, on affiche un lien de mise à jour -->
                    <?php if(isset($category)): ?>
                        <input class="btn btn-success" type="submit" name="update" value="Mettre à jour" />
                        <!-- Sinon on afficher un lien d'enregistrement d'un nouvel utilisateur -->
                    <?php else: ?>
                        <input class="btn btn-success" type="submit" name="save" value="Enregistrer" />
                    <?php endif; ?>
                </div>

                <!-- Si $user existe, on ajoute un champ caché contenant l'id de l'utilisateur à modifier pour la requête UPDATE -->
                <?php if(isset($category)): ?>
                    <input type="hidden" name="id" value="<?php echo $category['id']?>" />
                <?php endif; ?>

            </form>
        </section>
    </div>

</div>
</body>
</html>
