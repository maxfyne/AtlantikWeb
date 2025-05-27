<?php

namespace App\Controllers;
use App\Models\ModeleClient; //donne accès à la classe ModeleClient
use App\Models\ModeleLiaisonSecteur;
use App\Models\ModeleTarifLiaison;
use App\Models\ModeleSecteur;
use App\Models\ModeleTraversee;

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

    public function voirCommandesProduits()
    {
    
      $modeleLiaisonSecteur = new ModeleLiaisonSecteur(); //instanciation du modèle
      $data['lesLiaisons'] = $modeleLiaisonSecteur->getAllLiaisonSecteur();
      
      //var_dump($data['lesLiaisons']);
      //die();  

      $data['TitreDeLaPage'] = "Liste des Secteurs avec leurs liaisons";
  
      return view('Templates/Header')
      . view('Visiteur/vue_VoirLiaisonSecteur', $data)
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

    public function voirTarifLiaison()
    {

      $modeleTarifLiaison = new ModeleTarifLiaison(); //instanciation du modèle
      $recherche = $this->request->getGet('recherche');
      $data['lesTarifs'] = $modeleTarifLiaison->getAllTarifLiaison($recherche);

      
      //var_dump($data['lesLiaisons']);
      //die();

      $data['TitreDeLaPage'] = "Liste des Secteurs avec leurs liaisons";
  
      return view('Templates/Header')
      . view('Visiteur/vue_VoirTarif', $data)
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

    public function voirhorairesSecteurs($noSecteur = null)
    {
        helper('form');
    
        $modSecteur = new ModeleSecteur();
        $modTraversee = new ModeleTraversee();
    
        // Chargement de tous les secteurs pour affichage dans la vue
        $data['lesSecteurs'] = $modSecteur->findAll();
        $data['lesTraversees'] = [];
    
        if ($noSecteur !== null) {
            $data['lesLiaisons'] = $modSecteur->getAllLiaisonSecteur($noSecteur);
            $data['noSecteur'] = $noSecteur;
        } else {
            $data['lesLiaisons'] = [];
            $data['noSecteur'] = null;
        }
    
        // Si ce n'est PAS une requête POST, on affiche uniquement les liaisons
        if (!$this->request->is('post')) {
            $data['TitreDeLaPage'] = 'Voir les horaires';
            return view('Templates/Header')
                . view('Visiteur/vue_VoirHorairesSecteurs', $data)
                . view('Templates/Footer');
        }
    
        // Si on est en POST, traitement de la demande de traversées
        $noLiaison = $this->request->getPost('liaison');
        $date = $this->request->getPost('date');
    
        // Appel au modèle pour récupérer les traversées correspondantes
        $data['lesTraversees'] = $modTraversee->getAllhorairesLiaison($noLiaison, $date);
    
        $data['TitreDeLaPage'] = 'Voir les horaires';
    
        return view('Templates/Header')
            . view('Visiteur/vue_VoirHorairesSecteurs', $data)
            . view('Templates/Footer');
    }
    



}