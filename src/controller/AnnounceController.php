<?php

namespace Occazou\Src\Controller;

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
                        throw new \Exception('Une erreur s\'est produite, veuillez réessayer.');
                    endif;
                endif;
                $this->announce->hydrate($_POST);
                $this->announce->hydrate(['author_id'=>$this->user->getId()]);

                if(!$this->announceModel->addAnnounce($this->announce)):
                    unlink(UPLOADS_DIR.$this->announce->getPictureName());
                    throw new \Exception('Une erreur s\'est produite, veuillez réessayer.');
                endif;
                header('Location:/user-announces');
            else:
                throw new \Exception('Veuillez remplir tous les champs nécessaires.');
            endif;
        else:
            throw new \Exception('Veuillez vous connecter.');
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

    public function getUserAnnounces()
    {
        if(isset($_SESSION['id'])):
            $announcesData = $this->announceModel->getUserAnnounces($_SESSION['id']);
            $view = new \Occazou\Src\View\View('userAnnounces');
            $view->generate($announcesData);
        else:
            throw new \Exception("Veuillez vous connecter.");
            
        endif;
    }

    public function getAnnounce()
    {
        if(!empty($_GET['req']) && intval($_GET['req'])):
            $this->announce->hydrate($this->announceModel->getAnnounce($_GET['req']));
            $view = new \Occazou\Src\View\View('announce');
            $view->generate(['announce'=>$this->announce]);
        else:
            throw new \Exception("Oups ! Un erreur s'est produite ...");
        endif;
    }

    public function deleteAnnounce()
    {
        if(!empty($_GET['req']) && intval($_GET['req'])):
            $this->announce->hydrate($this->announceModel->getAnnounce($_GET['req']));
            if(!empty($_SESSION['id']) && $_SESSION['id']==$this->announce->getAuthor()->getId()):
                $this->announceModel->deleteAnnounce($_GET['req']);
                header('Location:/user-announces');
            else:
                throw new \Exception("Vous n'êtes pas autorisé à effectuer cette requête.");
            endif;
        else:
            throw new \Exception("Il manque une donnée");
        endif;
    }

    public function getAnnounces()
    {
        if(!empty($_GET['req'])):
            $userRequest = $this->formatReq();
            if(!empty($userRequest['location']) && !empty($userRequest['subject'])):
                $announcesData = $this->announceModel->getAnnouncesByCity($userRequest['location'], $userRequest['subject']);
                echo $this->json_encode($announcesData);
            else:
                $announcesData = $this->announceModel->getAnnouncesByRegion($userRequest['location']);
                $view = new \Occazou\Src\View\View('search');
                $view->generate(['announcesData'=>$announcesData, 'location'=>$userRequest['location']]);
            endif;
        else:
            header('Location:/');
        endif;
    }

    private function json_encode($data)
    {
        $announcesJSON = [];
        foreach ($data as $key => $value):
            $this->announce->hydrate($value);
            if($img = $this->announce->getPictureName()):
                $this->announce->setPictureName(UPLOADS_DIR.$img);
            else:
                $this->announce->setPictureName(UPLOADS_DIR.IMG_DEFAULT);
            endif;
            array_push($announcesJSON,[
                'id'=>$this->announce->getId(),
                'title'=>$this->announce->getTitle(),
                'city'=>$this->announce->getAuthor()->getCity()->getName(),
                'price'=>(string) $this->announce->getPrice(),
                'text'=>$this->announce->getText(),
                'date'=>$this->announce->getCreationDate(),
                'picture'=>$this->announce->getPictureName()
            ]);
        endforeach;
        return json_encode($announcesJSON);
    }

    private function formatReq()
    {
        $userRequest = explode('--', $_GET['req']);
        $request['location'] = $userRequest[0];
        $request['subject'] = (!empty($userRequest[1]))? $userRequest[1] : null;
        return $request;
    }
}