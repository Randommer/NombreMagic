<?php namespace App\Controllers;

//defined('BASEPATH') OR exit('No direct script access allowed');

use App\Models\MagicModel;
use CodeIgniter\Controller;

class Magic extends Controller 
{

    public function index()
    {
        //chargement du modèle MagicModel, équivalent de '$this->load->model("MagicModel");' en ci3
        $MagicMod = new MagicModel();
        //variable qui récupère les données POST envoyées au controller
        $request = \Config\Services::request();

        //recupération du tableau associatif, la fonction startTab en crée un ou en récupère un enregistré dans la session
        $TableauVariables = $MagicMod->startTab();

        //on initialise une variable à faux, on la changera si la tentative correspond au nombre à trouver
        $gagne = false;
        //série de tests à effectuer si un post à effectuer pour arriver sur cette page
        if ($request->getPost())
        {
            //vérifie si une variable "again" est passé dans le post (donc le joueur a cliqué sur Nouvelle Partie)
            if ($request->getPost("again") == "letsgo")
            {
                //récupération d'un nouveau tableau associatif crée par la fonction newTab
                $TableauVariables = $MagicMod->newTab();
            }
            else //si il n'y a pas de variable "again" dans le post (le joueur a donc effectué une tentative)
            {
                //on incrémente de 1 le nombre de tentatives que le joueur a testé
                $TableauVariables["Tentatives"]++;
                //on vérifie si la variable "essai" (qu'a rentré le joueur) est le nombre à trouver
                if ($request->getPost("essai") == $TableauVariables["MagiqueN"])
                {
                    //C'est gagné !!
                    //on change la variable à vrai qui servira à afficher l'écran de victoire
                    $gagne = true;
                }
                else //si l'essai pas n'est pas le nombre à trouver
                {
                    //on test si l'essai est plus grand que le nombre à trouver
                    if ($request->getPost("essai") > $TableauVariables["MagiqueN"])
                    {
                        //on change la valeur limite haute de la plage où se trouve le nombre à trouver
                        $TableauVariables["Max"] = $request->getPost("essai");
                    }
                    else //si l'essai n'est pas plus grand, donc il est plus petit
                    {
                        //on change la valeur limite basse de la plage où se trouve le nombre à trouver
                        $TableauVariables["Min"] = $request->getPost("essai");
                    }
                }
            }
        }

        //on enregistre les nouvelles variables dans la session à l'aide de la fonction saveTab
        $MagicMod->saveTab($TableauVariables);

        //views à afficher si la partie est gagnée
        if($gagne)
        {
            //chargement de la view header.php
            echo view('header');
            //chargement de la view win.php avec le tableau associatif
            $aView = ["TableauVariables" => $TableauVariables];
            echo view('win', $aView);
            //chargement de la view footer.php
            echo view('footer');

            //on nettoie la session car la partie est gagnée
            $MagicMod->deleteTab();
        }
        else //views à afficher à quand une partie commence ou est en cours
        {
            //création d'une chaîne de caractères qui servira d'expression régulière pour que le joueur ne puisse entrer que les nombres dans la plage du nombre à trouver
            //on ouvre la chaîne avec une ouverture de parenthèse puis le premier nombre de la plage du nombre à trouver
            $ExReg = "(".($TableauVariables["Min"] + 1);
            //on fait tourner une boucle pour chaque nombre dans la plage du nombre à trouver
            for ($i = $TableauVariables["Min"] + 2; $i <= $TableauVariables["Max"] - 1; $i++)
            {
                //on concatène la chaîne existante avec le caractère |, suivi du nombre du tour de boucle
                $ExReg = $ExReg."|".$i;
            }
            //on concatène la chaîne existante avec une fermeture de parenthèse
            $ExReg = $ExReg.")";

            //chargement de la view header.php
            echo view('header');
            //chargement de la view play.php avec le tableau associatif
            $aView = ["TableauVariables" => $TableauVariables, "ExReg" => $ExReg];
            echo view('play', $aView);
            //chargement de la view footer.php
            echo view('footer');
        }
    }
}