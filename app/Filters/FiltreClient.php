<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class FiltreClient implements FilterInterface
{

    /**
    * Effectuer le traitement requis par ce filtre.
    * Par défaut, il ne devrait rien renvoyer lors d'une exécution normale. 
    * Cependant, lorsqu'un état anormal est détecté, il devrait renvoyer une instance de CodeIgniter\HTTP\Response. 
    * Si tel est le cas, l'exécution du script s'arrêtera et cette réponse sera renvoyée au client, 
    * autorisant ainsi les pages d'erreur, les redirections, etc.
    * @param RequestInterface $request
    * @param array|null       $arguments
    *
    * @return mixed
    */

    public function before(RequestInterface $request, $arguments = null)
    {
        if(!(session()->get('prenom')))
        {
            return redirect()->to(base_url('connexion'));
        }
    }

 

    /**
    * Permet aux filtres After d'inspecter et de modifier l'objet de réponse selon les besoins. 
    * Cette méthode ne permet en aucun cas d'arrêter l'exécution d'autres filtres After, 
    * sauf en générant une exception ou une erreur.
    * @param RequestInterface  $request
    * @param ResponseInterface $response
    * @param array|null        $arguments
    *
    * @return mixed
    */

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        /* LES METHODES before() et after() doivent être présentent dans notre classe filtre
        mais il n'est pas nécessaire qu'elles soient 'codées' */
    }
}