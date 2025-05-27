<?php

namespace App\Controllers;
use App\Models\ModeleClient;

class Client extends BaseController
{
    public function modifierClient($noClient = null)
{
    helper('form');
    $modClient = new ModeleClient();
    $data['TitreDeLaPage'] = 'Modifier son compte';

    // Vérifie que l'ID est fourni
    if ($noClient == null) 
    {
        throw new \CodeIgniter\Exceptions\PageNotFoundException('Client non trouvé');
    }

    // Récupère le client existant
    $client = $modClient->find($noClient);
    if (!$client) 
    {
        throw new \CodeIgniter\Exceptions\PageNotFoundException("Client avec ID $noClient non trouvé.");
    }

    // Si le formulaire n'est pas posté, afficher le formulaire pré-rempli
    if (!$this->request->is('post')) {
        $data['Client'] = $client;
        return view('Templates/Header')
            . view('Visiteur/vue_ModifierCompte', $data)
            . view('Templates/Footer');
    }

    // Validation des données
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

    if (!$this->validate($reglesValidation)) {
        $data['Client'] = $client;
        $data['TitreDeLaPage'] = "Modification incorrecte";
        return view('Templates/Header')
            . view('Visiteur/vue_ModifierCompte', $data)
            . view('Templates/Footer');
    }
    
    ////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////
    //////////////SI CA BUG METTRE EN MAJUSCULE/////////////
    ////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////
    
    // Données validées -> mise à jour
    $donneesModifiees = [
        'Nom' => $this->request->getPost('txtNom'),
        'Prenom' => $this->request->getPost('txtPrenom'),
        'Adresse' => $this->request->getPost('txtAdresse'),
        'CodePostal' => $this->request->getPost('txtCodePostal'),
        'Ville' => $this->request->getPost('txtVille'),
        'TelephoneFixe' => $this->request->getPost('txtTelephoneFixe'),
        'TelephoneMobile' => $this->request->getPost('txtTelephoneMobile'),
        'Mel' => $this->request->getPost('txtMel'),
        'MotDePasse' => $this->request->getPost('txtMotDePasse')
    ];

    $modClient->update($noClient, $donneesModifiees);

    $data['TitreDeLaPage'] = "Modification réussie";
    $data['Client'] = $modClient->find($noClient);

    return view('Templates/Header')
        . view('Visiteur/vue_RapportModifierCompte', $data)
        . view('Templates/Footer');
}

}