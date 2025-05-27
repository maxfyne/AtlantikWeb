<h2><?php echo $TitreDeLaPage ?></h2>

<form method="post">
<input type="text" name="txtNom" value="<?= esc($client->NOM) ?>"><br>
<input type="text" name="txtPrenom" value="<?= esc($client->PRENOM) ?>"><br>
<input type="text" name="txtAdresse" value="<?= esc($client->ADRESSE) ?>"><br>
<input type="text" name="txtCodePostal" value="<?= esc($client->CODEPOSTAL) ?>"><br>
<input type="text" name="txtVille" value="<?= esc($client->VILLE) ?>"><br>
<input type="text" name="txtTelephoneFixe" value="<?= esc($client->TELEPHONEFIXE) ?>"><br>
<input type="text" name="txtTelephoneMobile" value="<?= esc($client->TELEPHONEMOBILE) ?>"><br>
<input type="email" name="txtMel" value="<?= esc($client->MEL) ?>"><br>
<input type="password" name="txtMotDePasse" value="<?= esc($client->MOTDEPASSE) ?>"><br>


    <input type="submit" value="Enregistrer les modifications">
</form>