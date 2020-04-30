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
    private $userModel;
    private $user;

    public function __construct()
    {
        $this->announceModel = new \Occazou\Src\Model\AnnounceModel();
        $this->announce = new \Occazou\Src\Model\Announce();
        $this->userModel = new \Occazou\Src\Model\UserModel();
        $this->user = new \Occazou\Src\Model\User();
    }

    public function new()
    {
        if(!empty($_SESSION['username'])&&!empty($_SESSION['id'])):
            $this->user->hydrate($this->userModel->getUser($_SESSION['username']));
            if(!empty($_POST['title']) && !empty($_POST['text']) && !empty($_POST['price'])):
                if(isset($_FILES['picture']) && $_FILES['picture']['error'] == 0):
                    if(!$this->savePicture($_FILES['picture'])):
                        throw new Exception('Une erreur s\'est produite, veuillez réessayer.');
                    endif;
                endif;
                $this->announce->hydrate($_POST);
                $this->announce->hydrate(['author_id'=>$this->user->getId()]);

                if(!$this->announceModel->addAnnounce($this->announce)):
                    unlink(UPLOADS_DIR.$this->announce->getPictureName());
                    throw new Exception('Une erreur s\'est produite, veuillez réessayer.');
                endif;
                header('Location:/user-announces');
            else:
                throw new Exception('Veuillez remplir tous les champs nécessaires.');
            endif;
        else:
            throw new Exception('Veuillez vous connecter.');
        endif;
    }

    public function savePicture(array $picture)
    {
        $fileName = $this->setPictureFileName($picture);
        if($fileName):
            $this->announce->setPictureName($fileName);
            return move_uploaded_file($picture['tmp_name'], UPLOADS_DIR.$fileName);
        else:
            throw new \Exception('Veuillez saisir une image au format JPG ou JPEG ou GIF ou PNG');
        endif;
    }

    public function setPictureFileName(array $picture)
    {
        $picture = [
            'name' => pathinfo($picture['name'])['filename'],
            'tempName' => pathinfo($picture['tmp_name'])['filename'],
            'extension' => pathinfo($picture['name'])['extension']
        ];

        $fileName = (in_array($picture['extension'], IMG_EXTENSIONS))? $_SESSION['id'].md5($picture['tempName'].$picture['name']).'.'.$picture['extension'] : false;

        return $fileName;
    }
}