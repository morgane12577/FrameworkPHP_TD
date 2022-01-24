<?php
namespace controllers;
 use Ubiquity\attributes\items\router\Get;
 use Ubiquity\attributes\items\router\Post;
 use Ubiquity\attributes\items\router\Route;

 /**
  * Controller TodosController
  */
 #[Route('todos')]
class TodosController extends \controllers\ControllerBase{

     #[Route('_default')]
	public function index(){
		
	}

    #[Post('add')]
    public function addElement(){

    }

    #[Get('delete/{index}')]
    public function deleteElement($index){

    }

    #[Post('edit/{index}')]
    public function editElement ($index){
    }

    #[Get('loadlist/{uniqid}')]
    public function loadList($uniqid){

    }

     #[Get('loadlist')]
     public function loadListFromForm(){

     }

     #[Get('new/{force}')]
     public function newlist($force){

     }

     #[Get('saveList')]
     public function saveList(){

     }


}
