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
    public function recherche_post($recherche)
    {
        $pdo = $this->conn;
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $queryPost = 'SELECT * FROM posts';

        $params = [];

        if ($recherche !== null) {
            $queryPost .= ' WHERE titre_post LIKE :recherche OR message_post LIKE :recherche';
            $params[':recherche'] = '%' . $recherche . '%';
        }

        $stmt = $pdo->prepare($queryPost);
        $stmt->execute($params);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function recherche_categorie($recherche)
    {
        $pdo = $this->conn;
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $queryCat = 'SELECT libelle_cat, id_cat FROM categorie';
        $params = [];

        if ($recherche !== null) {
            $queryCat .= ' WHERE libelle_cat LIKE :libellecat';
            $params[':libellecat'] = '%' . $recherche . '%';
        }

        $stmt = $pdo->prepare($queryCat);
        $stmt->execute($params);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function recherche_user($recherche)
    {
        $pdo = $this->conn;
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $queryUser = 'SELECT * FROM user';

        $params = [];

        if ($recherche !== null) {
            $queryUser .= ' WHERE user.username LIKE :recherche';
            $params[':recherche'] = '%' . $recherche . '%';
        }

        $stmt = $pdo->prepare($queryUser);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
        public function recherche_post_comments($idpost) {
            $query = "SELECT * FROM posts WHERE id_post = :idpost";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':idpost', $idpost, PDO::PARAM_INT);
            $stmt->execute();
            $pdo = null;
            return $stmt->fetch(PDO::FETCH_ASSOC);

        }

    }