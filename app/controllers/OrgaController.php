<?php
namespace controllers;
 use models\Organization;
 use Ubiquity\attributes\items\router\Get;
 use Ubiquity\attributes\items\router\Route;
 use Ubiquity\orm\DAO;

 /**
  * Controller OrgaController
  */

 #[Route('orga')]
class OrgaController extends \controllers\ControllerBase{

     #[Get(name: 'orga.index')]
	public function index(){
        $orgas = DAO::getAll(Organization::class);
		$this->loadView("OrgaController/index.html", compact('orgas'));
	}

    #[Route(path: "getOne/{idOrga}" , name : "orga.getOne")]
    public function getOne($idOrga){
         $orga = DAO::getById(Organization::class,$idOrga, ['users.groupes, groupes']);
         $this->loadView("OrgaController/getOne.html", compact('orga'));

    }
}
