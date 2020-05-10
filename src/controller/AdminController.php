<?php

namespace Occazou\Src\Controller;

class AdminController extends Controller
{
    public $userModel;
    public $user;
    public $announceModel;
    public $announce;

    public function __construct()
    {
        $this->userModel = new \Occazou\Src\Model\UserModel();
        $this->user = new \Occazou\Src\Model\User();
        $this->announceModel = new \Occazou\Src\Model\AnnounceModel();
        $this->announce = new \Occazou\Src\Model\Announce();
        Controller::__construct();
    }

    public function checkIfAdmin()
    {
        return (isset($_SESSION['username']) && $_SESSION['username'] == 'admin')? true : false;
    }

    public function getAdmin()
    {
        if(isset($_SESSION['username']) && $_SESSION['username'] == 'admin'):
            $usersData = $this->userModel->getUsers();
            $announcesData = $this->announceModel->getAnnounces();
            $view = new \Occazou\Src\View\View('admin');
            $view->generate(['usersData'=>$usersData, 'announcesData'=>$announcesData]);
        else:
            throw new \Exception('Vous n\'êtes pas autorisé à voir cette page !');
        endif;
    }

    public function removeAnnounce($announceId)
    {
        if(!empty($announceId)):
            $this->announce->hydrate($this->announceModel->getAnnounce($announceId));
            if($this->announce->getId()):
                if($this->announceModel->deleteAnnounce($announceId)):
                    unlink(UPLOADS_DIR.$this->announce->getPictureName());
                    header('Location:/admin');
                else:
                    throw new \Exception("Une erreur s'est produite, l'annonce n'a pas été supprimée");
                endif;
            else:
                throw new \Exception("L'annonce n'existe pas !");
                
            endif;
        else:
            throw new \Exception("Il manque une donnée");
        endif;
    }

    public function deleteUser($username)
    {
        if(!empty($username)):
            if($this->userModel->isNotFree($username)):
                if($this->userModel->deleteUser($username)):
                    header('Location:/admin');
                else:
                    throw new \Exception("Une erreur s'est produite, l'utilisateur n'a pas été supprimé");
                endif;
            else:
                throw new \Exception("Le nom d'utilisateur ".$username." n'existe pas.");
            endif;
        else:
            throw new \Exception("Il manque une donnée");
        endif;
    }

    public function manageUser($username)
    {
        if(!empty($username)):
            if($this->user->hydrate($this->userModel->getUser($username))):
                $view = new \Occazou\Src\View\View('userAccount');
                $view->generate(['user'=>$this->user]);
            else:
                throw new \Exception("Le nom d'utilisateur ".$username." n'existe pas.");
            endif;
        else:
            throw new \Exception("Il manque une donnée");
        endif;
    }

    public function modifyUser($username)
    {
        if(!empty($_POST['username']) && !empty($_POST['email']) && !empty($_POST['city_name'])):
            $this->user->hydrate($this->userModel->getUser($_POST['username']));
            $this->user->hydrate($_POST);
            $cityModel = new \Occazou\Src\Model\CityModel();
            $this->user->getcity()->setId($cityModel->getCityId($this->user->getcity()));
            echo ($this->userModel->updateUser($this->user))? true : 'Une erreur s\'est produite, veuillez réessayer';
        else:
            echo 'Veuillez remplir tous les champs nécessaires !';
        endif;
    }
}