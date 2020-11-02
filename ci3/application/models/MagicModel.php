<?php
// application/models/ProduitsModel.php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class MagicModel extends CI_Model
{

    public function start()
    {
        //création d'un tableau associatif avec les variables dont le jeu à besoin (dont le nombre à trouver)
        $TableauVariables = array("MagiqueN" => random_int(1, 100), "Min" => 0, "Max" => 101, "Tentatives" => 0);
        //vérification si une session a déjà été initialisée (donc si une partie est déjà commencée)
        if (!is_null($this->session->userdata("MagicTab")))
        {
            //mettre les variables de la session existante dans la tableau, pour les traiter dans le reste de la page
            $TableauVariables = $this->session->MagicTab;
        }
        //renvoie du tableau associatif au controller
        return $TableauVariables;
    }

    public function new()
    {
        //création d'un nouveau tableau associatif pour la nouvelle partie, qu'on renvoie au controller
        return array("MagiqueN" => random_int(1, 100), "Min" => 0, "Max" => 101, "Tentatives" => 0);
    }

    public function save($TableauVariables)
    {
        //on enregistre les nouvelles variables dans la session
        $this->session->set_userdata("MagicTab", $TableauVariables);
    }

    public function delete()
    {
        //on vide les variables de la session
        // $this->session->unset_userdata("MagicTab");
        $_SESSION = array();
        //on détruit la session
        $this->session->sess_destroy();
    }
}