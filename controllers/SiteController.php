<?php

class SiteController
{
    public function actionIndex()
    {
        require_once(ROOT . '/view/index.php');
        return true;
    }

    public function actionTghook(){
        require_once (ROOT.'/config/Tghook.php');
        return true;
    }

    public function actionGetAjax()
    {
        header("Content-Type: application/json");
        $data = json_decode(file_get_contents("php://input"));
        echo SiteAjax::getEvent();
        return true;
    }

    public function actionAddAjax()
    {
        header("Content-Type: application/json");
        $data = json_decode(file_get_contents("php://input"));
        echo "Я есть сервер " . $data->id . ' ' .$data->message . ' '.$data->status . ' '.$data->datetime . ' ';
        SiteAjax::addEvent($data->id, $data->message, $data->status, $data->datetime);
        return true;
    }

    public function actionDelAjax()
    {
        header("Content-Type: application/json");
        $data = json_decode(file_get_contents("php://input"));
        echo "Я есть сервер удалить" . $data->id ;
        SiteAjax::delEvent($data->id);
        return true;
    }

    public function actionUpdAjax()
    {
        header("Content-Type: application/json");
        $data = json_decode(file_get_contents("php://input"));
        echo "Я есть сервер Обносить" . $data->id ;
        SiteAjax::updEvent($data->id,$data->status);
        return true;
    }
}