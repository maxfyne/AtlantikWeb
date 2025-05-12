<br><br><br>

<?php

if ($Client) { // true (1) si ajout, false (0) sinon

    echo '<h3> Ajout Client effectué. </h3>';

} else {

    echo '<h3> Echec ajout du Client. </h3>';

}

?>

<br><br><br>

<p><a href="<?php echo site_url('compte') ?>">Retour au menu de creation de compte</a></p>