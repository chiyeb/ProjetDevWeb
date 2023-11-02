<?php

namespace control;
use models\admin_models;
require_once '../models/admin_models.php';
if (isset($_POST['creer_cat'])) {
    $admin_controller = new admin_controller();
    $admin_controller->ajouter_cat();
}
if (isset($_POST['ban'])){
    $admin_controller = new admin_controller();
    $admin_controller->ban_user();
}
class admin_controller
{
    public function ajouter_cat(){
        $nomCategorie = $_POST['nom_cat'];
        $descriptionCategorie = $_POST['description'];
        $admin_models = new admin_models();
        $admin_models->aouter_cat($nomCategorie,$descriptionCategorie);
    }
    public function ban_user(){
        $iduser = $_POST['id_user'];
        $admin_models = new admin_models();
        $admin_models->supr_utilisateur($iduser);
    }
}