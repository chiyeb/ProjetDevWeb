<?php

namespace control;
require_once $_SERVER['DOCUMENT_ROOT'] . '/models/recherche_models.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/control/post_controller.php';

use control\post_controller;
use models\recherche_models;

if (isset($_POST['rechercher_post'])) {
    $recherche_controller = new recherche_controller();
    $recherche_controller->rechercher_post(null);
}

class recherche_controller
{
    public function rechercher_post($cat){
        if (isset($_POST['recherche_post'])) {
            $recherche = $_POST['recherche_post'];
            $recherche_models = new recherche_models();
            $resultats = $recherche_models->recherche_post($recherche);
            if (count($resultats) > 0) {
                $post_controller = new post_controller();
                $post_controller->afficher_post_recherche($resultats);
                return $post_controller->afficher_post_recherche($resultats);
            }
        }
        else{
            $post_controller = new post_controller();
            return $post_controller->afficher_post($cat);
        }
    }
    public function rechercher_cat(){
        if (isset($_POST['recherche_cat'])){
            $recherche = $_POST['recherche_cat'];
            $recherche_models = new recherche_models();
            return $recherche_models->recherche_categorie($recherche);
        }
        $recherche = null;
        $recherche_models = new recherche_models();
        return $recherche_models->recherche_categorie($recherche);
    }
    public function rechercher_user(){
        if (isset($_POST['recherche_user'])){
            $recherche = $_POST['recherche_user'];
            $recherche_models = new recherche_models();
            return $recherche_models->recherche_user($recherche);
        }
        $recherche = null;
        $recherche_models = new recherche_models();
        return $recherche_models->recherche_categorie($recherche);
    }
    public function rechercher_post_for_comments($idpost){
        $recherche_models = new recherche_models();
        $resultats = $recherche_models->recherche_post_comments($idpost);
        $post_controller = new post_controller();
        return $post_controller->afficher_post_recherche($resultats);
}
}
