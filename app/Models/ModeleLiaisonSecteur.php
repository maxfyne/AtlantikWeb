<?php

namespace App\Models;
use CodeIgniter\Model; 

class ModeleLiaisonSecteur extends Model

{
  protected $table = 'secteur s'; // alias s sur la table secteur
  protected $primaryKey = 'nosecteur';
  protected $useAutoIncrement = true;
  protected $returnType = 'object'; // résultats retournés sous forme d'objet(s)
  protected $allowedFields = ['nom'];


  public function getAllLiaisonSecteur()
  {
    /* REQUETE SQL
    SELECT s.NOM, l.NOLIAISON, l.DISTANCE, pd.NOM, pa.NOM FROM secteur s 
    inner join liaison l on (s.NOSECTEUR = l.NOSECTEUR) 
    inner join port pd on (l.NOPORT_DEPART = pd.NOPORT)
    inner join port pa on (l.NOPORT_ARRIVEE = pa.NOPORT); */
   
    
    $res = $this->join('liaison l', 's.NOSECTEUR = l.NOSECTEUR', 'inner')
    ->join('port pde', 'l.NOPORT_DEPART = pde.NOPORT',  'inner')
    ->join('port pae', 'l.NOPORT_ARRIVEE = pae.NOPORT',  'inner')
    ->select('s.NOM, l.NOLIAISON, l.DISTANCE, pde.NOM as "PortDepart", pae.NOM as "PortArrivee"')
    ->get();

    //var_dump($res);
    //die();
    return $res;

    // ->get() : pour générer le tableau automatiquement,
    // si non : ->get()->getResult();  (voir vue associée)
  }
}