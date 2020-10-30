<?php
// application/models/ProduitsModel.php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class MagicModel extends CI_Model
{

    public function start()
    {
        $TableauVariables = array("MagiqueN" => random_int(1, 100), "Min" => 0, "Max" => 101, "Tentatives" => 0);
        if (!is_null($this->session->userdata("MagicTab")))
        {
            $TableauVariables = $this->session->MagicTab;
        }
        return $TableauVariables;
    }

    public function new()
    {
        return array("MagiqueN" => random_int(1, 100), "Min" => 0, "Max" => 101, "Tentatives" => 0);
    }

    public function save($TableauVariables)
    {
        $this->session->set_userdata("MagicTab", $TableauVariables);
    }

    public function delete()
    {
        //$_SESSION = array();
        $this->session->unset_userdata("MagicTab");
        //$this->session->sess_destroy();
    }
}