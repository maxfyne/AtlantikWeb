<h2><?php echo $TitreDeLaPage ?></h2>

<?php

  if ($TitreDeLaPage=='Saisie incorrecte')
    echo service('validation')->listErrors();

  /* set_value : en cas de non validation, les données déjà saisies sont réinjectées dans le formulaire */
  
  echo form_open('compte');
  echo csrf_field();

  echo form_label('Nom','txtNom');
  echo form_input('txtNom', set_value('txtNom'));

  echo'
  <br>
  <br>';

  echo form_label('Prenom','txtPrenom');
  echo form_password('txtPrenom', set_value('txtPrenom'));   

  echo'
  <br>
  <br>';

  echo form_label('Adresse','txtAdresse');
  echo form_input('txtAdresse', set_value('txtAdresse'));    

  echo'
  <br>
  <br>';

  echo form_label('CodePostal','txtCodePostal');
  echo form_password('txtCodePostal', set_value('txtCodePostal'));  
  
  echo'
  <br>
  <br>';

  echo form_label('Ville','txtVille');
  echo form_password('txtVille', set_value('txtVille'));   

  echo'
  <br>
  <br>';

  echo form_label('Telephone Fixe','txtTelephoneFixe');
  echo form_input('txtTelephoneFixe', set_value('txtTelephoneFixe'));    

  echo'
  <br>
  <br>';

  echo form_label('Telephone Mobile','txtTelephoneMobile');
  echo form_input('txtTelephoneMobile', set_value('txtTelephoneMobile'));    

  echo'
  <br>
  <br>';

  echo form_label('Mel','txtMel');
  echo form_password('txtMel', set_value('txtMel'));    

  echo'
  <br>
  <br>';

  echo form_label('Mot de passe','txtMotDePasse');
  echo form_password('txtMotDePasse', set_value('txtMotDePasse'));    

  echo'
  <br>
  <br>';
 

  echo form_submit('submit', 'Créer');
  echo form_close();

?>