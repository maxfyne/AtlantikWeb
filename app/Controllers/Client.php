<?php

namespace App\Controllers;
use App\Models\ModeleClient;

class Client extends BaseController
{
    public function modifierCompte()
    {
        helper('form');

        $noclient = session()->get('noclient');
        if (!$noclient) 
        {
            return redirect()->to('/connexion')->with('error', 'Veuillez vous connecter pour modifier votre compte.');
        }

        $modelClient = new \App\Models\ModeleClient();

        $client = $modelClient->find($noclient);
        if (!$client) 
        {
            return redirect()->to('/connexion')->with('error', 'Compte non trouvé.');
        }

        $data['TitreDeLaPage'] = 'Modifier mes informations';
        $data['client'] = $client;

  
  
//var_dump($client);
//die();


        if (!$this->request->is('post')) 
        {
            return view('Templates/Header')
                . view('Client/vue_ModifierCompte', $data)
                . view('Templates/Footer');
        }

        // Déclaration des règles de validation pour chaque champ du formulaire.

        $reglesValidation = [
            'txtNom' => 'required|string|max_length[60]',
            'txtPrenom' => 'required|string|max_length[60]',
            'txtAdresse' => 'required|string|max_length[128]',
            'txtCodePostal' => 'required|integer',
            'txtVille' => 'required|string|max_length[80]',
            'txtTelephoneFixe' => 'permit_empty|string|max_length[16]',
            'txtTelephoneMobile' => 'permit_empty|string|max_length[16]',
            'txtMel' => 'required|string|max_length[80]',
            'txtMotDePasse' => 'required|string|max_length[80]',
        ];

        if (!$this->validate($reglesValidation)) 
        {
            $data['TitreDeLaPage'] = 'Modification incorrecte';
            return view('Templates/Header')
                . view('Client/vue_ModifierCompte', $data)
                . view('Templates/Footer');
        }


        // Création d’un tableau avec les nouvelles données extraites du formulaire POST.
        
        $donneesModifiees = [
            'Nom' => $this->request->getPost('txtNom'),
            'Prenom' => $this->request->getPost('txtPrenom'),
            'Adresse' => $this->request->getPost('txtAdresse'),
            'CodePostal' => $this->request->getPost('txtCodePostal'),
            'Ville' => $this->request->getPost('txtVille'),
            'TelephoneFixe' => $this->request->getPost('txtTelephoneFixe'),
            'TelephoneMobile' => $this->request->getPost('txtTelephoneMobile'),
            'Mel' => $this->request->getPost('txtMel'),
            'MotDePasse' => $this->request->getPost('txtMotDePasse'),
        ];

        $modelClient->update($noclient, $donneesModifiees);

        $data['message'] = 'Votre compte a bien été mis à jour.';

        return view('Templates/Header')
            . view('Client/vue_RapportModifierCompte', $data)
            . view('Templates/Footer');
    }

}