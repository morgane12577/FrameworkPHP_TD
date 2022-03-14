<?php
namespace controllers;
use Ubiquity\orm\DAO;
use Ubiquity\utils\flash\FlashMessage;
use Ubiquity\utils\http\UResponse;
use Ubiquity\utils\http\USession;
use Ubiquity\utils\http\URequest;
use Ubiquity\attributes\items\router\Route;

#[Route(path: "/login",inherited: true,automated: true)]
class MyAuth extends \Ubiquity\controllers\auth\AuthController{


    public function getActiveUser()
    {
        return USession::get("user");
    }

    protected function onConnect($connected) {
        $urlParts=$this->getOriginalURL();
        USession::set($this->_getUserSessionKey(), $connected);
        if(isset($urlParts)){
            $this->_forward(implode("/",$urlParts));
        }else{
            UResponse::header('Location','/');
        }
	}

    public function _displayInfoAsString(): bool
    {
        return true;
    }


    protected function _connect() {
        if(URequest::isPost()){
            $email=URequest::post($this->_getLoginInputName());
            $password=URequest::post($this->_getPasswordInputName());
            $user=DAO::getOne(User::class,'email= ?',false,[$email]);
            if($user!=null){
                //USession::set("user",$user);
                USession::set('idOrga',$user->getOrganization());
                if(URequest::password_verify('password',$user->getPassword())){
                    return $user;
                }
                return $user;
            }
        }
        return;
    }

	
	/**
	 * {@inheritDoc}
	 * @see \Ubiquity\controllers\auth\AuthController::isValidUser()
	 */
	public function _isValidUser($action=null): bool {
		return USession::exists($this->_getUserSessionKey());
	}

	public function _getBaseRoute(): string {
		return '/login';
	}

    protected function noAccessMessage(FlashMessage $fMessage){
        $fMessage->setTitle('Accès interdit');
        $fMessage->setContent("Vous n'avez pas l'autorisation d'accéder à cette page !");
    }

    protected function terminateMessage(FlashMessage $fMessage)
    {
        $fMessage->setTitle("Fermeture");
        $fMessage->setContent("Vous avez été correctement déconnecté de l'application");
    }


}
