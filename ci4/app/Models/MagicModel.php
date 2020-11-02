<?php namespace App\Models;

//if (!defined('BASEPATH')) exit('No direct script access allowed');

use CodeIgniter\Model;

class MagicModel extends Model
{

    public function startTab()
    {
        //récupération des données sessions
        $session = session();
        //création d'un tableau associatif avec les variables dont le jeu à besoin (dont le nombre à trouver)
        $TableauVariables = array("MagiqueN" => random_int(1, 100), "Min" => 0, "Max" => 101, "Tentatives" => 0);
        //vérification si une session a déjà été initialisée (donc si une partie est déjà commencée)
        if (!is_null($session->MagicTab))
        {
            //mettre les variables de la session existante dans la tableau, pour les traiter dans le reste de la page
            $TableauVariables = $session->MagicTab;
        }
        //renvoie du tableau associatif au controller
        return $TableauVariables;
    }

    public function newTab()
    {
        //création d'un nouveau tableau associatif pour la nouvelle partie, qu'on renvoie au controller
        return array("MagiqueN" => random_int(1, 100), "Min" => 0, "Max" => 101, "Tentatives" => 0);
    }

    public function saveTab($TableauVariables)
    {
        //récupération des données sessions
        $session = session();
        //on enregistre les nouvelles variables dans la session
        $session->set("MagicTab", $TableauVariables);
    }

    public function deleteTab()
    {
        //récupération des données sessions
        $session = session();
        //on vide les variables de la session
        // $session->remove("MagicTab");
        $_SESSION = array();
        //on détruit la session
        $session->destroy();
    }
}