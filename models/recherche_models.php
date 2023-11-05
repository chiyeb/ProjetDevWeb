<?php

namespace models;

use control\connectbd_controller;
use PDO;
use PDOException;
require_once '../control/connectbd_controller.php';
class recherche_models
{
    public $conn;

    public function __construct() {
        $this->conn = (new connectbd_controller())->connectbd1();
    }
    //fonction pour rechercher les posts à partir d'un mot
    public function recherche_post($recherche)
    {
        $pdo = $this->conn;
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        //requête SQL sous forme de String
        $queryPost = 'SELECT * FROM posts';

        $params = [];
        //si la recherche n'est pas nul, donc l'utilisateur à recherché quelque chose
        if ($recherche !== null) {
            //on ajoute à la requête sous forme de String le reste de la requête SQL (la clause where filtrer par le message et le titre)
            $queryPost .= ' WHERE titre_post LIKE :recherche OR message_post LIKE :recherche';
            //on ajoute les paramètres
            $params[':recherche'] = '%' . $recherche . '%';
        }

        $stmt = $pdo->prepare($queryPost);
        $stmt->execute($params);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    //fonction pour rechercher une catégories
    public function recherche_categorie($recherche)
    {
        $pdo = $this->conn;
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        //requête SQL sous forme de String
        $queryCat = 'SELECT libelle_cat, id_cat FROM categorie';
        //si la recherche n'est pas nul, donc l'utilisateur à recherché quelque chose
        if ($recherche !== null) {
            //on ajoute à la requête sous forme de String le reste de la requête SQL (la clause where filtrer par le libelle de la catégorie)
            $queryCat .= ' WHERE libelle_cat LIKE :libellecat';
            //on ajoute les paramètres
            $params = [':libellecat' => '%' . $recherche . '%'];
        } else {
            $params = [];
        }
        //on ajoute le random à la requête SQL pour avoir 13 catégories aléatoires qui s'affichent dans l'accueil
        $queryCat .= ' ORDER BY RAND() LIMIT 10';

        $stmt = $pdo->prepare($queryCat);
        $stmt->execute($params);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    //fonction pour rechercher un utilisateur
    public function recherche_user($recherche)
    {
        $pdo = $this->conn;
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        //requête SQL sous forme de String
        $queryUser = 'SELECT username, image_profil FROM user';

        $params = [];
        //si la recherche n'est pas nul, donc l'utilisateur à recherché quelque chose
        if ($recherche !== null) {
            //on ajoute à la requête sous forme de String le reste de la requête SQL (la clause where filtrer par le username)
            $queryUser .= ' WHERE user.username LIKE :recherche';
            //on ajoute les paramètres
            $params[':recherche'] = '%' . $recherche . '%';
        }
        $stmt = $pdo->prepare($queryUser);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
        //fonction pour rechercher le post à partir du paramètre "$idpost" pour l'afficher dans la page "commentaire.php"
        public function recherche_post_comments($idpost) {
            //requête SQL pour récupérer tout les posts contenant l'id du post "$idost"
            $query = "SELECT * FROM posts WHERE id_post = :idpost";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':idpost', $idpost, PDO::PARAM_INT);
            $stmt->execute();
            $pdo = null;
            return $stmt->fetch(PDO::FETCH_ASSOC);

        }

    }