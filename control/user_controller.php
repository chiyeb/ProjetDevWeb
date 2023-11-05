<?php

namespace control;
require_once "../models/user_model.php";
require_once "../control/image_controller.php";
use models\user_model;
use PDO;

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
//si l'utilisateur ajoute une image de profil
if (isset($_FILES['image'])){
    $usecontrol = new user_controller();
    $usecontrol->addImageProfil();
    header("Location: ../view/AfficherProfil.php");
}class user_controller
{
    public function login($email, $pass)
    {
        // Gère la connexion d'un utilisateur en vérifiant les informations d'identification
        $user_model = new user_model();
        $user_model->check_account($email, $pass);
    }

    public function getImage($user)
    {
        // Récupère l'image de profil d'un utilisateur
        $usermodel = new user_model();
        return $usermodel->getImage($user);
    }

    public function addImageProfil()
    {
        // Gère le téléchargement et l'ajout d'une image de profil pour l utilisateur
        $imagecontrol = new image_controller();
        $image = $imagecontrol->uploadImg();

        if ($image !== false) {
            $usermodel = new user_model();
            $usermodel->insertImageProfil($_SESSION['id'], $image);
        }
    }

    public function supprimerPost($id)
    {
        // Supprime un post spécifique
        $usermodel = new user_model();
        $usermodel->suprPost($id);
        exit();
    }
    //gère la récupération de l'email à partir de l'id de l'utilisateur
    public function getEmail($id){
        $usermodel = new user_model();
        return $usermodel->getEmail($id);
    }
    //gère la récupération du pseudo de l'utilisateur
    public function getUsername($id){
        $usermodel = new user_model();
        return $usermodel->getUsername($id);
    }

    public function logout()
    {
        // Déconnecte l'utilisateur en détruisant la session
        session_destroy();
        header("Location: ../index.php");
        exit;
    }

    public function changerMdp()
    {
        // Gère la modification du mot de passe de l'utilisateur
        $user_model = new user_model();
        $user_model->changerMdp();
    }

    public function changerMail()
    {
        // Gère la modification de l'adresse e-mail de l'utilisateur
        $usermodel = new user_model();
        $usermodel->changerMail();
    }

    public function envoyerMail()
    {
        // Envoie un e-mail
        $usermodel = new user_model();
        if ($usermodel->checkEmail($_POST['nouvel_email'])){
            // Le mail existe déjà, affiche un message d'erreur
            header("Location: ../view/changer_email.php?error= Le mail existe déjà. Choisissez-en un autre.");
        }
        else{
            $usermodel->sendMail(null, null);
        }
        $email = $_POST['nouvel_email'];
        header("Location: ../view/verife_new_mail.php?success=Un code vous a été envoyé par mail !&email=$email");
    }

    public function inscription($username, $pass, $mail, $user_data)
    {
        // Gère le processus d'inscription d'un nouvel utilisateur.
        $usermodel = new user_model();
        $usermodel->inscription($username, $pass, $mail, $user_data);
    }

    public function confirmMail($token, $email)
    {
        // Gère la confirmation de l'e-mail de l'utilisateur
        $usermodel = new user_model();
        $usermodel->confirmMail($token, $email);
    }

    public function mdpOublier($email)
    {
        // Gère la demande de réinitialisation de mot de passe en envoyant un e-mail de réinitialisation
        $usermodel = new user_model();
        $usermodel->mdpOublier($email);
    }

    public function changerMdpOublier($code, $nvmdp){
        // Gère la modification du mot de passe suite à une demande de réinitialisation
        $usermodel = new user_model();
        $usermodel->changerMdpOublier($code, $nvmdp);
    }
    //gère le changement de pseudo
    public function changerUsername($username){
        $usermodel = new user_model();
        $usermodel->changerUsername($username);
    }
    //renvoyer le code de vérification par mail
    public function renvoyerMail($email){
        $usermodel = new user_model();
        $usermodel->renvoyerMail($email);
        exit();
    }
}
//gère le cas où l'utilisateur à oublié son mot de passe
if (isset($_POST['emailMdpOublier'])){
    if (empty($_POST['emailMdpOublier'])){
        header("Location: ../view/mot_de_passe_oublie.php?error=Entrez un e-mail valide.");
    }
    $email = $_POST['emailMdpOublier'];
    $usercontroller = new user_controller();
    $usercontroller->mdpOublier($email);
}
// Gère le cas où un utilisateur souhaite supprimer un post spécifique.
if (isset($_GET['suprId']))
{
    $postID = $_GET['suprId'];
    $usercontrol = new user_controller();
    $usercontrol->supprimerPost($postID);
    header("Location: ../view/accueil.php");
}
//déconnecte un utilisateur
if (isset($_GET['logout']) && $_GET['logout'] == 1) {
    $user_controller = new user_controller();
    $user_controller->logout();
}
//gère le cas où l'utilisateur veut changer d'e-mail
if (isset($_POST['changermail'])) {
    $usercontrol = new user_controller();
    $usercontrol->envoyerMail();
}
//gère le cas où l'utilisateur à confirmé sa nouvelle adresse e-mail
if (isset($_POST['confirmerMail'])) {
    $usercontrol = new user_controller();
    $usercontrol->changerMail();
}
//gère le cas où l'utilisateur veut changer de mot de passe
if (isset($_POST['changermdp'])) {
    $usercontroller = new user_controller();
    $usercontroller->changerMdp();
}
//gère le cas où l'utilisateur veut se connecter
if (isset($_POST['email']) && isset($_POST['password'])) {

    $email = $_POST['email'];
    $pass = $_POST['password'];
    $usercontroller = new user_controller();
    $usercontroller->login($email, $pass);
}
//gère le cas où l'utilisateur confirme son adresse mail
if (isset($_POST['emailConfirmMail']) && isset($_POST['tokenConfirmMail'])) {
    $usercontroller = new user_controller();
    $usercontroller->confirmMail($_POST['tokenConfirmMail'], $_POST['emailConfirmMail']);
}
//gère le cas où l'utilisateur confirme le changement de son mot de passe après l'avoir oublié
if (isset($_POST['tokenConfirmMdpOublier'])){
    $usercontroller = new user_controller();
    $usercontroller->changerMdpOublier($_POST['tokenConfirmMdpOublier'], $_POST['mdpConfirmMdpOublier']);
}
//gère le cas où l'utilisateur s'inscrit
if (isset($_POST['emailInscr']) && isset($_POST['passwordInscr']) && isset($_POST['usernameInscr'])) {
    $password = $_POST['passwordInscr'];
    $email = $_POST['emailInscr'];
    //si le mot de passe ne respecte pas : minimum 8 caractères, 1 majuscule, 1 chiffre et 1 caractère spécial
    if (strlen($password) < 8 || !preg_match("/[0-9]/", $password) || !preg_match("/[A-Z]/", $password) || !preg_match("/[!?;.,@#$%^&*]/", $password)) {
        header("Location: ../view/Inscription.php?error=Le mot de passe doit contenir minimum 8 caractères, 1 majuscule, 1 chiffre et 1 caractère spécial.");
        exit();
    }
    //crypte le mot de passe
    $pass = password_hash($_POST['passwordInscr'], PASSWORD_ARGON2ID);
    $name = $_POST['usernameInscr'];

    $user_data = 'email=' . $email . '&username=' . $name;
    // si l'e-mail est vide
    if (empty($email)) {
        header("Location: ../view/Inscription.php?error=E-mail requis&$user_data");
        exit();
    }
    // si le mot de passe est vide
    else if (empty($pass)) {
        header("Location: ../view/Inscription.php?error=Mot de passe requis&$user_data");
        exit();
    }
    // si l'username est vide
    else if (empty($name)) {
        header("Location: ../view/Inscription.php?error=Nom requis&$user_data");
        exit();
    } else {
        $usercontroller = new user_controller();
        $usercontroller->inscription($name, $pass, $email, $user_data);
    }
}
//gère le cas où l'utilisateur veut changer de pseudo
if (isset($_POST['nouveauUsername'])){
    $usercontroller = new user_controller();
    $usercontroller->changerUsername($_POST['nouveauUsername']);
}
//renvoyer le code de confirmation par mail
if(isset($_POST['renvoyerCodeMailConfirm'])){
    echo "test";
    var_dump(($_POST['RenvoyeremailConfirmMail']));
    if (isset($_POST['RenvoyeremailConfirmMail'])){
        echo "test";
        $user_controller = new user_controller();
        $user_controller->renvoyerMail($_POST['RenvoyeremailConfirmMail']);
        header("Location: ../view/verifemail.php?success=Code renvoyé avec succès !");
    }
    else{
        header("Location: ../view/verifemail.php?error=Pour renvoyer le code, veuillez entrer votre e-mail.");
    }
}