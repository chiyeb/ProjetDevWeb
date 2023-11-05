<?php

namespace control;
use models\admin_models;
require_once '../models/admin_models.php';

class admin_controller
{
    //gère l'ajout d'une catégorie
    public function ajouter_cat(){
        $nomCategorie = $_POST['nom_cat'];
        $descriptionCategorie = $_POST['description'];
        $admin_models = new admin_models();
        $admin_models->ajouter_cat($nomCategorie,$descriptionCategorie);
    }
    //gère le ban d'un utilisateur
    public function ban_user(){
        $iduser = $_POST['id_user'];
        $admin_models = new admin_models();
        $admin_models->supr_utilisateur($iduser);
    }
}
//gère le cas où on veut ajouter une catégorie
if (isset($_POST['creer_cat'])) {
    $admin_controller = new admin_controller();
    $admin_controller->ajouter_cat();
}
//gère le cas où on veut ban un utilisateur
if (isset($_POST['ban'])){
    $admin_controller = new admin_controller();
    $admin_controller->ban_user();
}