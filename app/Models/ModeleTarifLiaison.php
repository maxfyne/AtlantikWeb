<?php

namespace App\Models;
use CodeIgniter\Model;

class ModeleTarifLiaison extends Model

{
  protected $table = 'liaison l'; // alias s sur la table liaison
  protected $primaryKey = 'noliaison';
  protected $useAutoIncrement = true;
  protected $returnType = 'object'; // résultats retournés sous forme d'objet(s)
  protected $allowedFields = ['NOPORT_DEPART', 'NOSECTEUR', 'NOPORT_ARRIVEE', 'DISTANCE'];


  public function getAllTarifLiaison($recherche = null)
  {

    if($recherche)
    {
      $noliaison = $recherche;
    }
    else
    {
      $noliaison = 1;
    }



    $condition = ['l.noliaison' => $noliaison];
    /*
    SELECT c.LETTRECATEGORIE, c.LIBELLE, ty.NOTYPE, ty.LIBELLE, p.DATEDEBUT, p.DATEFIN, t.TARIF from liaison l 
    inner join tarifer t on (l.NOLIAISON = t.NOLIAISON) 
    inner join periode p on (t.NOPERIODE = p.NOPERIODE) 
    inner join type ty on (t.LETTRECATEGORIE = ty.LETTRECATEGORIE) 
    inner join categorie c on (ty.LETTRECATEGORIE = c.LETTRECATEGORIE) 
    LIMIT 15; 
    */

    $res = $this->join('tarifer t', 'l.NOLIAISON = t.NOLIAISON', 'inner')
    ->join('periode p', 't.NOPERIODE = p.NOPERIODE',  'inner')
    ->join('type ty', 't.LETTRECATEGORIE = ty.LETTRECATEGORIE',  'inner')
    ->join('categorie c', 'ty.LETTRECATEGORIE = c.LETTRECATEGORIE',  'inner')
    ->where($condition)
    ->select('c.LETTRECATEGORIE, c.LIBELLE as "Libelle_categorie", ty.NOTYPE, ty.LIBELLE as "Libelle_type", p.DATEDEBUT as "DateDebut", p.DATEFIN as "DateFin", t.TARIF')
    ->limit(15)
    ->get();

    //var_dump($res);
    //die();
    return $res;

    // ->get() : pour générer le tableau automatiquement,
    // si non : ->get()->getResult();  (voir vue associée)
  }

}