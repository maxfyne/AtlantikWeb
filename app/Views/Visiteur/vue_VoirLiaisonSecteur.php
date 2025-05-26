<h2><?php echo $TitreDeLaPage ?></h2>

<!--
$TitreDeLaPage : variable récupérée depuis le contrôleur
$lesCommandes : les commandes, avec leurs produits
 -->

<?php
$attributsTableau = ["table_open" => "<table class='table table-striped'>",]; // classe Bootstrap
$table = new \CodeIgniter\View\Table($attributsTableau);
$table->setHeading(['Secteur', 'NOLIAISON', 'DISTANCE', 'PortDepart', 'PortArrivee']); // entête tableau
echo $table->generate($lesLiaisons);
?>