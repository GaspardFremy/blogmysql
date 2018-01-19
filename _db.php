<?php

//inclure ici la connexion à la base de données
try {
  $db = new PDO('mysql:host=localhost;dbname=blog;charset=utf8', 'root', 'root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
} catch (Exception $e) {
    die('error :' . $e->getMessage());
}


?>
