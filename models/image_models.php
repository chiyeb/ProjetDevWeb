<?php

namespace models;
use control\connectbd_controller;
use PDO;

require_once "../control/connectbd_controller.php";
class image_models
{
    public $conn;

    public function __construct()
    {
        $this->conn = (new connectbd_controller())->connectbd1();
    }

    public function uploadImg()
    {
        $client_id = "3dbdff30ccea2f9";
        $uploadOk = 1;
        if (is_uploaded_file($_FILES ['image'] ['tmp_name'])) {
            $check = getimagesize($_FILES["image"]["tmp_name"]);
            if ($check !== false) {
                $uploadOk = 1;
            } else {
                header("Location: ../view/accueil.php?errorPost=Ce fichier n'est pas une image");
                $uploadOk = 0;
            }
            if ($_FILES["image"]["size"] > 9000000) {
                header("Location: ../view/accueil.php?errorPost=L'image est trop large");
                $uploadOk = 0;
            }
            if ($uploadOk == 0) {
                header("Location: ../view/accueil.php?errorPost=Une erreur inconnue s'est produite, Veuillez nous contacter.");
            } else {
                $image_source = file_get_contents($_FILES['image']['tmp_name']);

                $postFields = array('image' => base64_encode($image_source));

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, 'https://api.imgur.com/3/image');
                curl_setopt($ch, CURLOPT_POST, TRUE);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Client-ID ' . $client_id));
                curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
                $response = curl_exec($ch);
                curl_close($ch);
                $responseArr = json_decode($response);

                if (!empty($responseArr->data->link)) {
                    $imgurData = $responseArr;
                    if (!empty($imgurData)) {
                        return $imgurData->data->link;
                    }
                } else {
                    header("Location: ../view/accueil.php?errorPost=Une erreur inconnue s'est produite, Veuillez nous contacter.");
                }
            }
        } else {
            header("Location: ../view/accueil.php?errorPost=Ce fichier n'est pas une image");
            $imgLink = null;
        }
    }
}