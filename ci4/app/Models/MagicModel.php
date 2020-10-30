<?php namespace App\Models;

//if (!defined('BASEPATH')) exit('No direct script access allowed');

use CodeIgniter\Model;

class MagicModel extends Model
{

    public function startTab()
    {
        $session = session();
        $TableauVariables = array("MagiqueN" => random_int(1, 100), "Min" => 0, "Max" => 101, "Tentatives" => 0);
        if (!is_null($session->MagicTab))
        {
            $TableauVariables = $session->MagicTab;
        }
        return $TableauVariables;
    }

    public function newTab()
    {
        return array("MagiqueN" => random_int(1, 100), "Min" => 0, "Max" => 101, "Tentatives" => 0);
    }

    public function saveTab($TableauVariables)
    {
        $session = session();
        $session->set("MagicTab", $TableauVariables);
    }

    public function deleteTab()
    {
        $session = session();
        //$_SESSION = array();
        $session->remove("MagicTab");
        $session->destroy();
    }
}