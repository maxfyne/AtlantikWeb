<?php

namespace App\Models;

use CodeIgniter\Model;

 

class ModeleClient extends Model

{
  protected $table = 'Client';
  
  protected $primaryKey = 'noclient';

  protected $useAutoIncrement = true;

  protected $returnType = 'object'; // résultats retournés sous forme d'objet(s)

 

  protected $allowedFields = ['Nom', 'Prenom', 'Adresse', 'CodePostal', 'Ville', 'TelephoneFixe', 'TelephoneMobile', 'Mel', 'MotDePasse'];

 /////////////////////////////////////////////////////////////////////////////////////////////
}