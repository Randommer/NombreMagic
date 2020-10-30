<?php
// application/controllers/Produits.php

defined('BASEPATH') OR exit('No direct script access allowed');

class Magic extends CI_Controller 
{

    public function index()
    {
        //$this->load->library(['session']);
        $this->load->model("MagicModel");

        $TableauVariables = $this->MagicModel->start();

        $gagne = false;
        if ($this->input->post())
        {
            if ($this->input->post("again") == "letsgo")
            {
                $TableauVariables = $this->MagicModel->new();
            }
            else
            {
                $TableauVariables["Tentatives"]++;
                if ($this->input->post("essai") == $TableauVariables["MagiqueN"])
                {
                    //Winning
                    $gagne = true;
                }
                else
                {
                    if ($this->input->post("essai") > $TableauVariables["MagiqueN"])
                    {
                        $TableauVariables["Max"] = $this->input->post("essai");
                    }
                    else
                    {
                        $TableauVariables["Min"] = $this->input->post("essai");
                    }
                }
            }
        }

        $this->MagicModel->save($TableauVariables);

        if($gagne)
        {
            $this->load->view('header');
            $aView = ["TableauVariables" => $TableauVariables];
            $this->load->view('win', $aView);
            $this->load->view('footer');
            // $this->load->view('header-st');
            // $this->load->view('win-st', $aView);
            // $this->load->view('footer-st');

            $this->MagicModel->delete();
        }
        else
        {
            $ExReg = "(";
            for ($i = $TableauVariables["Min"] + 1; $i <= $TableauVariables["Max"] - 1; $i++)
            {
                $ExReg = $ExReg.$i."|";
            }
            $ExReg = $ExReg."code)";

            // $this->load->view('header');
            $aView = ["TableauVariables" => $TableauVariables, "ExReg" => $ExReg];
            // $this->load->view('play', $aView);
            // $this->load->view('footer');
            $this->load->view('header-st');
            $this->load->view('play-st', $aView);
            $this->load->view('footer-st');
        }
    }
}