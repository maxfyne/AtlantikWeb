<h2><?php echo $TitreDeLaPage ?></h2>

<!--
$TitreDeLaPage : variable récupérée depuis le contrôleur
$lesTarifs : les tarifs des liaisons
 -->
 <form class="d-flex" method="get" action="<?= site_url('tarifs') ?>">
    <input class="form-control me-2" name="recherche" type="text" placeholder="Rechercher un numero de liaison">
    <button class="btn btn-primary" type="submit">Rechercher</button>
</form>


<?php

$attributsTableau = ["table_open" => "<table class='table table-striped'>",]; // classe Bootstrap
$table = new \CodeIgniter\View\Table($attributsTableau);
$table->setHeading(['LETTRECATEGORIE', 'LIBELLECATEGORIE', 'NOTYPE', 'LIBELLETYPE', 'DATEDEBUT', 'DATEFIN', 'TARIF']); // entête tableau
echo $table->generate($lesTarifs);
?>