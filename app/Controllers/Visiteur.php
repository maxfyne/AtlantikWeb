<?php

namespace App\Controllers;
use App\Models\ModeleClient; //donne accès à la classe ModeleClient

class Visiteur extends BaseController
{
    public function accueil(): string
    {
        helper('assets');
        return view('Templates/Header')
        . view('Visiteur/vue_Accueil')
        . view('Templates/Footer');
    }

    public function compte(): string
    {
        return view('Templates/Header')
        . view('Visiteur/vue_Compte')
        . view('Templates/Footer');
    }

    //////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////
    
    
    public function creerCompte()
    {

        helper('form');
        $data['TitreDeLaPage'] = 'Créer son compte';

        /* TEST SI FORMULAIRE POSTE OU SI APPEL DIRECT (EN GET) */
        if (!$this->request->is('post')) 
        {
            /* le formulaire n'a pas été posté, on retourne le formulaire */
            return view('Templates/Header')
            . view('Visiteur/vue_CreerCompte', $data)
            . view('Templates/Footer');
        }

        /* SI FORMULAIRE NON POSTE, LE CODE QUI SUIT N'EST PAS EXECUTE */
        /* VALIDATION DU FORMULAIRE */


        $reglesValidation = [

            'txtNom' => 'required|string|max_length[60]',
            // obligatoire, chaîne de carac. <= 60 carac.

            'txtPrenom' => 'required|string|max_length[60]',
            // obligatoire, chaîne de carac. <= 60 carac.

            'txtAdresse' => 'required|string|max_length[128]',
            // obligatoire, chaîne de carac. <= 128 carac.

            'txtCodePostal' => 'required|integer',
            // integer

            'txtVille' => 'required|string|max_length[80]',
            // obligatoire, chaîne de carac. <= 80 carac.

            'txtTelephoneFixe' => 'permit_empty|string|max_length[16]',
            // obligatoire, chaîne de carac. <= 16 carac.

            'txtTelephoneMobile' => 'permit_empty|string|max_length[16]',
            // obligatoire, chaîne de carac. <= 16 carac.

            'txtMel' => 'required|string|max_length[80]',
            // obligatoire, chaîne de carac. <= 80 carac.

            'txtMotDePasse' => 'required|string|max_length[80]',
            // obligatoire, chaîne de carac. <= 80 carac.

        ];

        if (!$this->validate($reglesValidation)) 
        {
            /* formulaire non validé, on renvoie le formulaire */

            $data['TitreDeLaPage'] = "Saisie compte incorrecte";

            return view('Templates/Header')
            . view('Visiteur/vue_CreerCompte', $data)
            . view('Templates/Footer');
        }

        /* SI FORMULAIRE NON VALIDE, LE CODE QUI SUIT N'EST PAS EXECUTE */
        /* INSERTION Client SAISI DANS BDD */

        $donneesAInserer = array(
            'Nom' => $this->request->getPost('txtNom'),
            'Prenom' => $this->request->getPost('txtPrenom'),
            'Adresse' => $this->request->getPost('txtAdresse'),
            'CodePostal' => $this->request->getPost('txtCodePostal'),
            'Ville' => $this->request->getPost('txtVille'),
            'TelephoneFixe' => $this->request->getPost('txtTelephoneFixe'),
            'TelephoneMobile' => $this->request->getPost('txtTelephoneMobile'),
            'Mel' => $this->request->getPost('txtMel'),
            'MotDePasse' => $this->request->getPost('txtMotDePasse')
        ); //   champs de la table 'Client'

        $modelClient = new ModeleClient(); //instanciation du modèle
        $data['Client'] = $modelClient->insert($donneesAInserer);
        // provoque insert into sur la table mappée (produit, ici), retourne la clé générée


        return view('Templates/Header')
            .view('Visiteur/vue_RapportCreerCompte', $data)
            .view('Templates/Footer');

    } // creerCompte

    //////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////

    public function seConnecter()
    {
        helper(['form']);
        $session = session();
        $data['TitreDeLaPage'] = 'Se connecter';

        /* TEST SI FORMULAIRE POSTE OU SI APPEL DIRECT (EN GET) */
        if (!$this->request->is('post'))
        {
            return view('Templates/Header', $data)
            . view('Visiteur/vue_SeConnecter')
            . view('Templates/Footer');
        }

        /* SI FORMULAIRE NON POSTE, LE CODE QUI SUIT N'EST PAS EXECUTE */
        /* VALIDATION DU FORMULAIRE */

        $reglesValidation = [ // Régles de validation

            'txtMel' => 'required',
            'txtMotDePasse' => 'required',
        ];

        if (!$this->validate($reglesValidation)) 
        {
            /* formulaire non validé */
            $data['TitreDeLaPage'] = "Saisie incorrecte";
            return view('Templates/Header', $data)
            . view('Visiteur/vue_SeConnecter') // Renvoi formulaire de connexion
            . view('Templates/Footer');
        }

        /* SI FORMULAIRE NON VALIDE, LE CODE QUI SUIT N'EST PAS EXECUTE */
        /* RECHERCHE Client DANS BDD */

        $Mel = $this->request->getPost('txtMel');
        $MdP = $this->request->getPost('txtMotDePasse');

 
        /* on va chercher dans la BDD le client correspondant aux id et mot de passe saisis */
        $modClient = new ModeleClient(); // instanciation modèle
        $condition = ['Mel'=>$Mel,'motdepasse'=>$MdP];
        $ClientRetourne = $modClient->where($condition)->first();

        /* where : méthode, QueryBuilder, héritée de Model (), retourne,
        ici sous forme d'un objet, le résultat de la requête :

        SELECT * FROM Client  WHERE identifiant='$pId' and motdepasse='$MotdePasse

        ClientRetourne = objet utilisateur ($returnType = 'object')
        */

 

        if ($ClientRetourne != null) 
        {
            /* noclient et mot de passe OK : noclient et profil sont stockés en session */
            $session->set('noclient', $ClientRetourne->NOCLIENT);
            $session->set('nom', $ClientRetourne->NOM);
            $session->set('prenom', $ClientRetourne->PRENOM);

            $data['noclient'] = $noclient;
            echo view('Templates/Header', $data);
            echo view('Visiteur/vue_ConnexionReussie');
            echo view('Templates/Footer');
        }

        else 
        {
            /* identifiant et/ou mot de passe OK : on renvoie le formulaire  */
            $data['TitreDeLaPage'] = "Identifiant ou/et Mot de passe inconnu(s)";
            return view('Templates/Header', $data)
            . view('Visiteur/vue_SeConnecter')
            . view('Templates/Footer');

        }
    } // seConnecter

    //////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////

    SELECT s.NOM, l.NOLIAISON, l.DISTANCE, pd.NOM, pa.NOM FROM secteur s inner join liaison l on (s.NOSECTEUR = l.NOSECTEUR) inner join port pd on (l.NOPORT_DEPART = pd.NOPORT) inner join port pa on (l.NOPORT_ARRIVEE = pa.NOPORT); 

}