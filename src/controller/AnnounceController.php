<?php

namespace Occazou\Src\Controller;

use Exception;

/**
 * Class Controller
 */
class AnnounceController
{
    private $announceModel;
    private $announce;

    public function __construct()
    {
        $this->announceModel = new \Occazou\Src\Model\AnnounceModel();
        $this->announce = new \Occazou\Src\Model\Announce();
    }

    public function new($userData)
    {
        if(!empty($_POST['title']) && !empty($_POST['text']) && !empty($_POST['price'])):
            if(isset($_FILES['picture']) && $_FILES['picture']['error'] == 0):
                // enregistre 
                $this->savePicture($_FILES['picture']);
            endif;

            // enregistres l'annonce dans la db
            $this->announce->hydrate($_POST);
            $this->announce->hydrate($userData);

            if($this->announceModel->addAnnounce($this->announce)):
                header('Location:/');
            else:
                throw new Exception('Une erreur s\'est produite');
            endif;
        endif;
    }

    public function savePicture(array $picture)
    {
        $fileName = $this->setPictureFileName($picture);
        if($fileName):
            $this->announce->setPictureName($fileName);
            $this->announceModel->savePicture($picture['tmp_name'], $fileName);
        else:
            throw new \Exception('Veuillez saisir une image au format JPG ou JPEG ou GIF ou PNG');
        endif;
    }

    public function setPictureFileName(array $picture)
    {
        $extensions = ['jpg', 'jpeg', 'gif', 'png'];
        $picture = [
            'name' => pathinfo($picture['name'])['filename'],
            'tempName' => pathinfo($picture['tmp_name'])['filename'],
            'extension' => pathinfo($picture['name'])['extension']
        ];

        $fileName = (in_array($picture['extension'], $extensions))? md5($picture['tempName'].$picture['name']).'.'.$picture['extension'] : false;


        return $fileName;
    }
}