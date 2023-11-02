<?php

namespace control;
use models\suggestion_models;

require_once "../models/suggestion_models.php";
class suggestion_controller
{
    public function recupererSuggestion(){
        $suggestmodel = new suggestion_models();
        return $suggestmodel->recupSuggest();
    }
}