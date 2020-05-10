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
            $view = new \Occazou\Src\View\View('admin');
            $view->generate(['usersData'=>$usersData]);
        else:
            throw new \Exception('Vous n\'êtes pas autorisé à voir cette page !');
        endif;
    }
}