<?php require_once '../tools/_db.php';

if(isset($_GET['logout'])){
    session_destroy();
}

if(isset($_POST['login'])) {

    if(empty($_POST['email'])||empty($_POST['password'])){
            $message = 'les champs ne sont pas remplis correctement';
    }else {

        $query = $db->prepare('SELECT * FROM user WHERE email = ? AND password = ?');
        $query->execute([
            $_POST['email'],
            $_POST['password']
        ]);

        $admin = $query->fetch();

        if($admin['is_admin'] == 1){
            $_SESSION['is_admin'] = 1;
            $_SESSION['user'] = $admin['first_name'];
            header('Location: index.php');
        }else{
            $_SESSION['is_admin'] = 0;
            $message = 'vous n\'etes pas administrateur ou vos identifiants sont incorrects';
        }
    }
}


        ?>



<!DOCTYPE html>
<html>
<head>

    <title>Administration - Mon premier blog !</title>

    <?php require 'partials/head_assets.php'; ?>

</head>
<body class="index-body">
<div class="container-fluid">
    <?php require 'partials/header.php'; ?>
    <div class="row my-3 index-content">


        <main class="col-9">
            <section>
                <div class="tab-content">
                    <div class="tab-pane container-fluid <?php if(isset($_POST['login']) || !isset($_POST['register'])): ?>active<?php endif; ?>" id="login" role="tabpanel">

                        <form action="login-register.php" method="post" class="p-4 row flex-column">

                            <h4 class="pb-4 col-sm-8 offset-sm-2">Connexion</h4>

                            <?php if(isset($message)): ?>
                                <?php echo $message; ?>
                            <?php endif; ?>

                            <div class="form-group col-sm-8 offset-sm-2">
                                <label for="email">Email</label>
                                <input class="form-control" value="" type="email" placeholder="Email" name="email" id="email" />
                            </div>

                            <div class="form-group col-sm-8 offset-sm-2">
                                <label for="password">Mot de passe</label>
                                <input class="form-control" value="" type="password" placeholder="Mot de passe" name="password" id="password" />
                            </div>

                            <div class="text-right col-sm-8 offset-sm-2">
                                <input class="btn btn-success" type="submit" name="login" value="Valider" />
                            </div>

                        </form>

                    </div>
            </section>
        </main>
    </div>

</div>
</body>
</html>