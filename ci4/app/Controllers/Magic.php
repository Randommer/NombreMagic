<?php namespace App\Controllers;

//defined('BASEPATH') OR exit('No direct script access allowed');

use App\Models\MagicModel;
use CodeIgniter\Controller;

class Magic extends Controller 
{

    public function index()
    {
        //$this->load->library(['session']);
        //$this->load->model("MagicModel");
        $MagicMod = new MagicModel();
        $request = \Config\Services::request();

        $TableauVariables = $MagicMod->startTab();

        $gagne = false;
        if ($request->getPost())
        {
            if ($request->getPost("again") == "letsgo")
            {
                $TableauVariables = $MagicMod->newTab();
            }
            else
            {
                $TableauVariables["Tentatives"]++;
                if ($request->getPost("essai") == $TableauVariables["MagiqueN"])
                {
                    //Winning
                    $gagne = true;
                }
                else
                {
                    if ($request->getPost("essai") > $TableauVariables["MagiqueN"])
                    {
                        $TableauVariables["Max"] = $request->getPost("essai");
                    }
                    else
                    {
                        $TableauVariables["Min"] = $request->getPost("essai");
                    }
                }
            }
        }

        $MagicMod->saveTab($TableauVariables);

        if($gagne)
        {
            echo view('header');
            $aView = ["TableauVariables" => $TableauVariables];
            echo view('win', $aView);
            echo view('footer');

            $MagicMod->deleteTab();
        }
        else
        {
            $ExReg = "(";
            for ($i = $TableauVariables["Min"] + 1; $i <= $TableauVariables["Max"] - 1; $i++)
            {
                $ExReg = $ExReg.$i."|";
            }
            $ExReg = $ExReg."code)";

            echo view('header');
            $aView = ["TableauVariables" => $TableauVariables, "ExReg" => $ExReg];
            echo view('play', $aView);
            echo view('footer');
        }
    }
}