<?php

namespace control;
require_once $_SERVER['DOCUMENT_ROOT'] . '/models/recherche_models.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/control/post_controller.php';

use control\post_controller;
use models\recherche_models;

class recherche_controller
{
    //gère la recherche d'un post
    public function rechercher_post($cat){
        if (isset($_POST['recherche_post'])) {
            $recherche = $_POST['recherche_post'];
            $recherche_models = new recherche_models();
            $resultats = $recherche_models->recherche_post($recherche);
            //si aucun posts n'as été trouvé à partir de la recherche de l'utilisateur
            if (count($resultats) > 0) {
                $post_controller = new post_controller();
                $post_controller->afficher_post_recherche($resultats);
                return $post_controller->afficher_post_recherche($resultats);
            }
        }
        //si aucune recherche de l'utilisateur
        else{
            $post_controller = new post_controller();
            return $post_controller->afficher_post($cat);
        }
    }
    //gère la recherche d'une catégorie
    public function rechercher_cat(){
        //si l'utilisateur à cherché une catégorie
        if (isset($_POST['recherche_cat'])){
            $recherche = $_POST['recherche_cat'];
            $recherche_models = new recherche_models();
            return $recherche_models->recherche_categorie($recherche);
        }
        //si l'utilisateur à cherché aucune catégorie
        $recherche = null;
        $recherche_models = new recherche_models();
        return $recherche_models->recherche_categorie($recherche);
    }
    //gère la recherche d'utilisateur
    public function rechercher_user($recherche){
        //si l'utilisateur à cherché un utilisateur
        if (isset($recherche)){
            $recherche_models = new recherche_models();
            return $recherche_models->recherche_user($recherche);
        }
        else{
            //si l'utilisateur à cherché aucun utilisateur
            $recherche = null;
            $recherche_models = new recherche_models();
            return $recherche_models->recherche_user(null);
        }
    }
    //récupère tout les utilisateur de la base de donnée
    public function recupAllUsers(){
        $recherchemodel = new recherche_models();
        $recherchemodel->AllUsers();
    }
    //gère la récupération d'un post pour la page commentaire.php
    public function rechercher_post_for_comments($idpost){
        $recherche_models = new recherche_models();
        $resultats = $recherche_models->recherche_post_comments($idpost);
        $post_controller = new post_controller();
        return $post_controller->afficher_post_recherche_comment($resultats);
    }
}
//gère le cas où l'utilisateur cherche un post
if (isset($_POST['rechercher_post'])) {
    $recherche_controller = new recherche_controller();
    $recherche_controller->rechercher_post(null);
}

