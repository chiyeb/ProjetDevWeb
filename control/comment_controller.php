<?php

use models\comment_models;
use models\post_model;

require_once "../models/comment_models.php";
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
// comment_controller.php

if (isset($_POST['submit_comment'])) {
    $postId = $_POST['post_id'];
    $commentText = $_POST['commentaire'];
    $user = $_SESSION['id'];
    $comment_control = new comment_controller();
    $comment_control->commenter($postId, $user, $commentText);
}

class comment_controller
{
    public function commenter($postId, $user, $commentText){
        $commentmodels = new \models\comment_models();
        $commentmodels->addComment($postId, $user, $commentText);
        header("Location: ../view/commentaire.php?post_id=". $postId);
    }
    public function getCommentsForPost($id){
        $comment_models = new comment_models();
        return $comment_models->getCommentsForPost($id);
    }

}
