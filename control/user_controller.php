<?php

namespace control;
require_once "../models/user_model.php";
require_once "../control/image_controller.php";
use models\user_model;
use PDO;

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (isset($_FILES['image'])){
    $usecontrol = new user_controller();
    $usecontrol->addImageProfil();
    header("Location: ../view/AfficherProfil.php");
}
class user_controller
{
    public function login($email, $pass)
    {
        $user_model = new user_model();
        $user_model->check_account($email, $pass);

    }

    public function getImage($user)
    {
        $usermodel = new user_model();
        return $usermodel->getImage($user);
    }

    public function addImageProfil()
    {
        $imagecontrol = new image_controller();
        $image = $imagecontrol->uploadImg();

        // Assurez-vous que le téléchargement s'est bien passé
        if ($image !== false) {
            $usermodel = new user_model();
            $usermodel->insertImageProfil($_SESSION['id'], $image);
        }
    }

    public function supprimerPost($id)
    {
        $usermodel = new user_model();
        $usermodel->suprPost($id);
        exit();
    }

    public function logout()
    {
        session_destroy();
        header("Location: ../index.php");
        exit;
    }

    public function changerMdp()
    {
        $user_model = new user_model();
        $user_model->changerMdp();
    }

    public function changerMail()
    {
        $usermodel = new user_model();
        $usermodel->changerMail();
    }

    public function envoyerMail()
    {
        $usermodel = new user_model();
        $usermodel->sendMail(null, null);
    }

    public function inscription($username, $pass, $mail, $user_data)
    {
        $usermodel = new user_model();
        $usermodel->inscription($username, $pass, $mail, $user_data);
    }

    public function confirmMail($token, $email)
    {
        $usermodel = new user_model();
        $usermodel->confirmMail($token, $email);
    }

    public function mdpOublier($email)
    {
        $usermodel = new user_model();
        $usermodel->mdpOublier($email);
    }
    public function changerMdpOublier($code, $nvmdp){
        $usermodel = new user_model();
        $usermodel->changerMdpOublier($code, $nvmdp);
    }
}


if (isset($_POST['emailMdpOublier'])){
    if (empty($_POST['emailMdpOublier'])){
        header("Location: ../view/mot_de_passe_oublie.php?error=Entrez un e-mail valide.");
    }
    $email = $_POST['emailMdpOublier'];
    $usercontroller = new user_controller();
    $usercontroller->mdpOublier($email);
}
// Récupérer l'ID du post à supprimer depuis la requête GET
if (isset($_GET['suprId']))
{
    $postID = $_GET['suprId'];
    $usercontrol = new user_controller();
    $usercontrol->supprimerPost($postID);
    header("Location: ../view/accueil.php");
    exit();
}

if (isset($_GET['logout']) && $_GET['logout'] == 1) {
    // Créez une instance de votre user_controller et appelez la fonction logout
    $user_controller = new user_controller();
    $user_controller->logout();
}

if (isset($_POST['changermail'])) {
    $usercontrol = new user_controller();
    $usercontrol->envoyerMail();
}
if (isset($_POST['confirmerMail'])) {
    echo "test";
    $usercontrol = new user_controller();
    $usercontrol->changerMail();
}
if (isset($_POST['changermdp'])) {
    $usercontroller = new user_controller();
    $usercontroller->changerMdp();
}
//Login
if (isset($_POST['email']) && isset($_POST['password'])) {

    $email = $_POST['email'];
    $pass = $_POST['password'];
    $usercontroller = new user_controller();
    $usercontroller->login($email, $pass);
}
if (isset($_POST['emailConfirmMail']) && isset($_POST['tokenConfirmMail'])) {
    $usercontroller = new user_controller();
    $usercontroller->confirmMail($_POST['tokenConfirmMail'], $_POST['emailConfirmMail']);
}
if (isset($_POST['tokenConfirmMdpOublier'])){
    var_dump($_POST['tokenConfirmMdpOublier']);
    $usercontroller = new user_controller();
    $usercontroller->changerMdpOublier($_POST['tokenConfirmMdpOublier'], $_POST['mdpConfirmMdpOublier']);
}
//inscription
if (isset($_POST['emailInscr']) && isset($_POST['passwordInscr']) && isset($_POST['usernameInscr'])) {

    $email = $_POST['emailInscr'];
    $pass = password_hash($_POST['passwordInscr'], PASSWORD_ARGON2ID);
    $name = $_POST['usernameInscr'];

    $user_data = 'email=' . $email . '&username=' . $name;

    if (empty($email)) {
        header("Location: ../view/Inscription.php?error=E-mail requis&$user_data");
        exit();
    } else if (empty($pass)) {
        header("Location: ../view/Inscription.php?error=Mot de passe requis&$user_data");
        exit();
    } else if (empty($name)) {
        header("Location: ../view/Inscription.php?error=Nom requis&$user_data");
        exit();
    } else {
        $usercontroller = new user_controller();
        $usercontroller->inscription($name, $pass, $email, $user_data);
    }
}