<?php

require_once '../tools/_db.php';
if($_SESSION['is_admin'] != 1){
    header('location: login-register.php');
}

//supprimer l'utilisateur dont l'ID est envoyé en paramètre URL
if(isset($_GET['user_id']) && isset($_GET['action']) && $_GET['action'] == 'delete'){

	$query = $db->prepare('DELETE FROM user WHERE id = ?');
	$result = $query->execute(
		[
			$_GET['user_id']
		]
	);
	//générer un message à afficher plus bas pour l'administrateur
	if($result){
		$message = "Suppression efféctuée.";
	}
	else{
		$message = "Impossible de supprimer la séléction.";
	}
}

//séléctionner tous les utilisateurs pour affichage de la liste
$query = $db->query('SELECT * FROM user');
$users = $query->fetchall();
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
					<header class="pb-4 d-flex justify-content-between">
						<h4>Liste des utilisateurs</h4>
						<a class="btn btn-primary" href="user-form.php">Ajouter un utilisateur</a>
					</header>

					<?php if(isset($message)): //si un message a été généré plus haut, l'afficher ?>
					<div class="bg-success text-white p-2 mb-4">
						<?php echo $message; ?>
					</div>
					<?php endif; ?>

					<table class="table table-striped">
						<thead>
							<tr>
								<th>#</th>
								<th>First Name</th>
								<th>Last Name</th>
								<th>Email</th>
								<th>Admin</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>

							<?php if($users): ?>
							<?php foreach($users as $user): ?>

							<tr>
								<!-- htmlentities sert à écrire les balises html sans les interpréter -->
								<th><?php echo htmlentities($user['id']); ?></th>
								<td><?php echo htmlentities($user['first_name']); ?></td>
								<td><?php echo htmlentities($user['last_name']); ?></td>
								<td><?php echo htmlentities($user['email']); ?></td>
								<td><?php echo htmlentities($user['is_admin']); ?></td>
								<td>
									<a href="user-form.php?user_id=<?php echo $user['id']; ?>&action=edit" class="btn btn-warning">Modifier</a>
									<a onclick="return confirm('Are you sure?')" href="user-list.php?user_id=<?php echo $user['id']; ?>&action=delete" class="btn btn-danger">Supprimer</a>
								</td>
							</tr>

							<?php endforeach; ?>
							<?php else: ?>
								Aucun utilisateur enregistré.
							<?php endif; ?>

						</tbody>
					</table>

				</section>

			</div>

		</div>
	</body>
</html>
