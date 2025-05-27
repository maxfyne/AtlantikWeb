<?php

namespace App\Models;
use CodeIgniter\Model;

class ModeleTraversee extends Model
{
    protected $table = 'traversee t';
    protected $primaryKey = 'NOTRAVERSEE';
    protected $useAutoIncrement = true;
    protected $returnType = 'object';
    protected $allowedFields = ['NOLIAISON', 'NOBATEAU', 'DATEHEUREDEPART', 'DATEHEUREARRIVEE', 'CLOTUREEMBARQUEMENT'];

    public function getAllhorairesLiaison($noLiaison = null, $date = null)
    {
        $builder = $this->join('liaison l', 't.NOLIAISON = l.NOLIAISON', 'inner')
            ->join('bateau b', 't.NOBATEAU = b.NOBATEAU',  'inner')
            ->join('contenir c', 't.NOBATEAU = c.NOBATEAU',  'inner')
            ->join('type ty', 'c.LETTRECATEGORIE = ty.LETTRECATEGORIE',  'inner')
            ->join('enregistrer e', 'ty.LETTRECATEGORIE = e.LETTRECATEGORIE and ty.NOTYPE = e.NOTYPE',  'inner')
            ->select('t.NOTRAVERSEE, t.DATEHEUREDEPART, b.NOM AS NOM_BATEAU, ty.LETTRECATEGORIE, ty.NOTYPE, (c.CAPACITEMAX - e.QUANTITERESERVEE) AS PLACES_DISPO');

        if ($noLiaison !== null) {
            $builder->where('t.NOLIAISON', $noLiaison);
        }

        if ($date !== null) {
            $builder->where('DATE(t.DATEHEUREDEPART)', $date);
        }

        return $builder->get()->getResult();
    }
}
