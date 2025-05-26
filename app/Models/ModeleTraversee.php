<?php

namespace App\Models;
use CodeIgniter\Model;

 

class ModeleTraversee extends Model

{
  protected $table = 'traversee t';
  protected $primaryKey = 'NOTRAVERSEE';
  protected $useAutoIncrement = true;
  protected $returnType = 'object'; // résultats retournés sous forme d'objet(s)
  protected $allowedFields = ['NOLIAISON', 'NOBATEAU', 'DATEHEUREDEPART', 'DATEHEUREARRIVEE', 'CLOTUREEMBARQUEMENT'];

public function getAllhorairesLiaison($nosecteur, $noLiaison = null, $date = null)
 {
   /* select t.NOTRAVERSEE, t.DATEHEUREDEPART, b.NOM, ty.LETTRECATEGORIE, ty.NOTYPE, (c.CAPACITEMAX - e.QUANTITERESERVEE) from traversee t 
   inner join liaison l on (t.NOLIAISON = l.NOLIAISON) 
   inner join bateau b on (t.NOBATEAU = b.NOBATEAU) 
   inner join contenir c on (t.NOBATEAU = c.NOBATEAU) 
   inner join type ty on (c.LETTRECATEGORIE = ty.LETTRECATEGORIE) 
   inner join enregistrer e on ((ty.LETTRECATEGORIE = e.LETTRECATEGORIE) and (ty.NOTYPE = e.NOTYPE)) 

   ///////////////////////////////////////
   where l.NOPORT_DEPART = 1 and l.NOPORT_ARRIVEE = 2 and t.DATEHEUREDEPART > "2021-01-01"; */
   ///////////////////////////////////////
  
   
   $res = $this->join('liaison l', 't.NOLIAISON = l.NOLIAISON', 'inner')
   ->join('bateau b', 't.NOBATEAU = b.NOBATEAU',  'inner')
   ->join('contenir c', 't.NOBATEAU = c.NOBATEAU',  'inner')
   ->join('type ty', 'c.LETTRECATEGORIE = ty.LETTRECATEGORIE',  'inner')
   ->join('enregistrer e', 'ty.LETTRECATEGORIE = e.LETTRECATEGORIE and ty.NOTYPE = e.NOTYPE',  'inner')
   ->select('t.NOTRAVERSEE, t.DATEHEUREDEPART, b.NOM, ty.LETTRECATEGORIE, ty.NOTYPE, (c.CAPACITEMAX - e.QUANTITERESERVEE)');

   if ($noLiaison !== null) 
    {
        $res ->where('t.NOLIAISON', $noLiaison);
    }

    if ($date !== null) 
    {
        $res->where('DATE(t.DATEHEUREDEPART)', $date);
    }
   ////////////////////////////////////
   //->where('s.NOSECTEUR', $noSecteur)
   ////////////////////////////////////
   $res->getResult();

   //var_dump($res); OK
   //die();
   
   
   return $res;

   // ->get() : pour générer le tableau automatiquement,
   // si non : ->get()->getResult();  (voir vue associée)
 }
}