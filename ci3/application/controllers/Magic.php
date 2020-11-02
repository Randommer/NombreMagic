<?php
// application/controllers/Produits.php

defined('BASEPATH') OR exit('No direct script access allowed');

class Magic extends CI_Controller 
{

    public function index()
    {
        //initialisation de la session (maintenant fait en autoload)
        //$this->load->library(['session']);

        //chargement du modèle associé
        $this->load->model("MagicModel");

        //recupération du tableau associatif, la fonction start en crée un ou en récupère un enregistré dans la session
        $TableauVariables = $this->MagicModel->start();

        //on initialise une variable à faux, on la changera si la tentative correspond au nombre à trouver
        $gagne = false;
        //série de tests à effectuer si un post à effectuer pour arriver sur cette page
        if ($this->input->post())
        {
            //vérifie si une variable "again" est passé dans le post (donc le joueur a cliqué sur Nouvelle Partie)
            if ($this->input->post("again") == "letsgo")
            {
                //récupération d'un nouveau tableau associatif crée par la fonction new
                $TableauVariables = $this->MagicModel->new();
            }
            else //si il n'y a pas de variable "again" dans le post (le joueur a donc effectué une tentative)
            {
                //on incrémente de 1 le nombre de tentatives que le joueur a testé
                $TableauVariables["Tentatives"]++;
                //on vérifie si la variable "essai" (qu'a rentré le joueur) est le nombre à trouver
                if ($this->input->post("essai") == $TableauVariables["MagiqueN"])
                {
                    //C'est gagné !!
                    //on change la variable à vrai qui servira à afficher l'écran de victoire
                    $gagne = true;
                }
                else //si l'essai pas n'est pas le nombre à trouver
                {
                    //on test si l'essai est plus grand que le nombre à trouver
                    if ($this->input->post("essai") > $TableauVariables["MagiqueN"])
                    {
                        //on change la valeur limite haute de la plage où se trouve le nombre à trouver
                        $TableauVariables["Max"] = $this->input->post("essai");
                    }
                    else //si l'essai n'est pas plus grand, donc il est plus petit
                    {
                        //on change la valeur limite basse de la plage où se trouve le nombre à trouver
                        $TableauVariables["Min"] = $this->input->post("essai");
                    }
                }
            }
        }

        //on enregistre les nouvelles variables dans la session à l'aide de la fonction save
        $this->MagicModel->save($TableauVariables);

        //views à afficher si la partie est gagnée
        if($gagne)
        {
            //chargement de la view header.php
            $this->load->view('header');
            //chargement de la view win.php avec le tableau associatif
            $aView = ["TableauVariables" => $TableauVariables];
            $this->load->view('win', $aView);
            //chargement de la view footer.php
            $this->load->view('footer');

            //on nettoie la session car la partie est gagnée
            $this->MagicModel->delete();
        }
        else //views à afficher à quand une partie commence ou est en cours
        {
            //création d'une chaîne de caractères qui servira d'expression régulière pour que le joueur ne puisse entrer que les nombres dans la plage du nombre à trouver
            //on ouvre la chaîne avec une ouverture de parenthèse
            $ExReg = "(";
            //on fait tourner une boucle pour chaque nombre dans la plage du nombre à trouver
            for ($i = $TableauVariables["Min"] + 1; $i <= $TableauVariables["Max"] - 1; $i++)
            {
                //on concatène la chaîne existante avec le nombre du tour de boucle, suivi du caractère |
                $ExReg = $ExReg.$i."|";
            }
            //on concatène la chaîne existante avec une chaîne impossible à rentrer par le joueur (le champ attend 3 caractères maximum et donc ici on rentre une chaîne de 4 de long), puis une ferme la chaîne avec une fermeture de parenthèse
            $ExReg = $ExReg."code)";

            //chargement de la view header.php
            $this->load->view('header');
            //chargement de la view play.php avec le tableau associatif
            $aView = ["TableauVariables" => $TableauVariables, "ExReg" => $ExReg];
            $this->load->view('play', $aView);
            //chargement de la view footer.php
            $this->load->view('footer');
        }
    }
}