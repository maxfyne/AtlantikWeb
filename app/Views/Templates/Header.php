<?php
  echo '<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">';
  echo '<nav class="navbar navbar-expand-sm bg-light">
  <div class="container-fluid">
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" href="/accueil">Accueil</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="/compte">CréationCompte</a>
    </li>

    <li class="nav-item">
      <a class="nav-link" href="/connexion">Connexion</a>
    </li>

    <li class="nav-item">
      <a class="nav-link" href="/liaison">LiaisonParSecteur</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="/tarifs">TarifParLiaison</a>
    </li>

    <li class="nav-item">
      <a class="nav-link" href="/horaires">Horaires</a>
    </li>

    <li class="nav-item">
      <a class="nav-link" href="/modifier">ModifierCompte</a>
    </li>
    

  </ul>';
  $session = session();
  if ($session->get('prenom'))
  {
      echo 'Connecté en tant que '. $session->get('prenom');
  }
  echo'
  </div>
  </nav> ';
