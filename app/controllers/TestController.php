<?php
namespace controllers;
use Ubiquity\attributes\items\router\Route;
 use Ajax\JsUtils;


 /**
  * Controller TestController
  * @property JsUtils $jquery
  */

class TestController extends \controllers\ControllerBase{

	public function index(){
        $this->jquery->getHref(element: 'a', parameters: ['hasLoader'=>false, 'historize'=> false]);
        $this->jquery->click(element: '#bt-toggle',js: '$("#reponse").toggle();');
        $bt = $this->jquery->semantic()->htmlButton(identifier: 'bt-compo', value:'test compo' );

        $bt->addIcon(icon: 'users');
        $bt->onClick(jsCode: '$("#reponse").html("Click sur le bouton");');

        //avec jquery ne pas utiliser le loadView mais le renderView
        $this->jquery->renderView(viewName: 'TestController/index.html');

	}

	#[Route( "/test",name: "test")]
	public function test(){

		echo'<h1> Réponse Ajax</h1>';
	}

}
