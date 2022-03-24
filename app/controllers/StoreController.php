<?php
namespace controllers;
 /**
  * Controller StoreController
  */

 use models\Product;
 use models\Section;
 use Ubiquity\attributes\items\router\Route;
 use Ubiquity\controllers\Router;
 use Ubiquity\attributes\items\router\Get;
 use Ubiquity\orm\DAO;
 use Ubiquity\orm\repositories\ViewRepository;

class StoreController extends \controllers\ControllerBase{
    private ViewRepository $repo;

    public function initialize() {
        parent::initialize();

    }

    #[Route('_default', name: 'home')]
    public function index(){
        $sections = DAO::getAll(Section::class);
        $this->loadView('StoreController/index.html',['sections'=>$sections] );
		
	}

    #[Get (path : "section/{id}",name: 'store.section')]
    public function getSection(int $id){
        $section = DAO::getById(Section::class,$id);
        $this->loadView('StoreController/getSection.html',['section'=>$section]);
    }

    #[Route (path: 'allProducts', name: 'store.allProducts')]
public function getAllProduct()
    {
        $products = DAO::getAll(Product::class);
        $this->loadView('StoreController/getAllProduct.html');


    }


}
