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
 use Ubiquity\utils\http\USession;

 #[Route(path: '/')]
 class StoreController extends \controllers\ControllerBase{
   private $count = 0;



    public function initialize() {
        parent::initialize();

    }

    #[Route(path:'_default', name: 'home')]
    public function index(){
        $sections = DAO::getAll(Section::class);
        $this->loadView('StoreController/index.html',['sections'=>$sections] );
		
	}

    #[Get (path : "section/{id}",name: 'store.section')]
    public function getSection(int $id){
        $section = DAO::getById(Section::class,$id);
        $num = DAO::count(Product::class);
        $this->loadView('StoreController/getSection.html',['section'=>$section, 'cart' => USession::get('cart',["nb"=>0,"montant"=>0]),'count'=>$num]);
    }

    #[Route (path: 'allProducts', name: 'store.allProducts')]
public function getAllProduct()
    {
        $products = DAO::getAll(Product::class);
        $this->loadView('StoreController/getAllProduct.html');


    }

    #[Get (path: 'addToCart/{id}/{count}', name: 'store.addToCart')]
    public function addToCart (int $id, int $count){
        $montant = DAO::getById(Product::class,$id);
        $cart = USession::get('cart',["nb"=>0,"montant"=>0]);
        $cart[]=[$id, $count];
        $cart["nb"] ++;
        $cart["montant"] = $cart["montant"] + $montant->getPrice();
        USession::set('cart',$cart);
        $this->count ++;


    }


}
