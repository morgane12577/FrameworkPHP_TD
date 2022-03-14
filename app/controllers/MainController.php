<?php
namespace controllers;
 use services\dao\OrgaRepository;
 use Ubiquity\attributes\items\di\Autowired;
 use Ubiquity\attributes\items\router\Route;
 use Ubiquity\utils\http\USession;

 /**
  * Controller MainController
  */
class MainController extends \controllers\ControllerBase{

    #[Autowired]
    private OrgaRepository $repo;

    public function setRepo(OrgaRepository $repo): void {
        $this->repo = $repo;
    }

    /**
     * @throws \Exception
     */
    #[Route(path: "/_default" , name : "home")]
	public function index(){
        $user = $this->getAuthController()->getActiveUser();
        $this->loadView("MainController/index.html",['user'=>$user]);
        
		
	}

    private function getAuthController(): MyAuth
    {
        return $this->_auth ??= new MyAuth($this);
    }
}
