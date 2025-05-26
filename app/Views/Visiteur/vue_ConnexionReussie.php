<h2>Connexion réussie !</h2>

<?php 
    $session = session();

    echo '<p>Bienvenue '.$session->get('prenom') .' '.$session->get('nom'). '!</p>';
?>

<p><a href="<?php echo site_url('accueil') ?>">Retour à l'accueil</a><p>