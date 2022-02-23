<?php
namespace controllers;
 use Ajax\JsUtils;
 use Ubiquity\attributes\items\router\Get;
 use Ubiquity\attributes\items\router\Post;
 use Ubiquity\attributes\items\router\Route;
 use Ubiquity\cache\CacheManager;
 use Ubiquity\controllers\auth\AuthController;
 use Ubiquity\controllers\auth\WithAuthTrait;
 use Ubiquity\utils\http\URequest;
 use Ubiquity\utils\http\USession;

 /**
  * Controller TodosController
  * @property JsUtils $jquery
  */
 //#[Route('todos')]
class TodosController extends \controllers\ControllerBase{

    //POur avoir l'authentification
    use WithAuthTrait;


    const CACHE_KEY = 'datas/lists/';
    const EMPTY_LIST_ID='not saved';
    const LIST_SESSION_KEY='list';
    const ACTIVE_LIST_SESSION_KEY='active-list';


     #[Route('_default', name : 'home')]
	public function index(){
		$list = USession::get(self::LIST_SESSION_KEY,[]);
        $this->loadView('TodosController/index.html');
        $this->displayList($list);

	}

    public function testJquery(){
         $this->jquery->click('button',"$('.elm').toggle();");
         $this->jquery->renderDefaultView();
    }

    #[Post('todos/add', name : 'todos.add')]
    public function addElement(){
         $val = URequest::post('elm');
         $list = USession::get(self::LIST_SESSION_KEY,[]);
         $list[] = $val;
        USession::set(self::LIST_SESSION_KEY, $list);
        $this->displayList($list);

    }

    #[Get('todos/delete/{index}', name : 'todos.delete')]
    public function deleteElement($index){
        $list = USession::get(self::LIST_SESSION_KEY,[]);
        unset($list[$index]);
        USession::set(self::LIST_SESSION_KEY, \array_values($list));
        $this->displayList($list);


    }

    #[Post('todos/edit/{index}', name : 'todos.edit')]
    public function editElement ($index){
        $val = URequest::post('elm');
        $list = USession::get(self::LIST_SESSION_KEY,[]);
        $list[$index] = $val;
        USession::set(self::LIST_SESSION_KEY, $list);
        $this->displayList($list);
    }

    #[Get('todos/loadlist/{id}', name: 'todos.loadList')]
    public function loadList($id){
       if (CacheManager::$cache->exists(self::CACHE_KEY . $id)) {
            $list = CacheManager::$cache->fetch(self::CACHE_KEY . $id);
            $this->displayList($list);
        }
        else{
            $this->showMessage('',"la liste n'existe pas");
        }

    }

     #[Post('todos/loadlist', name : 'todos.loadListPost')]
     public function loadListFromForm(){

     }

     #[Get('todos/new/{force}', name : 'todos.new')]
     public function newlist($force){
            if ($force == false){
                $this->showMessage('',"la liste existe déjà et pas vide");
            }
            else{

            }
     }

     #[Get('todos/saveList', name : 'todos.save')]
     public function saveList(){
         $list = USession::get(self::LIST_SESSION_KEY,[]);
         $id=uniqid('',true);
         CacheManager::$cache->store(self::CACHE_KEY . $id, $list);
         $this->jquery->semantic()->htmlInput(value: $id, identifier: 'elmText');
         $this->showMessage(header:'',message:"Liste Sauvegardée avec l'id =" .$id, buttons: [$this->jquery->semantic()->htmlButton(identifier: 'bt',value: 'Copier')]);
         $this->createCopyButton('bt','elmText');
         $this->showMessage('',"Acceder à la liste avec le lien http://127.0.0.1:8090/todos/loadlist/". $id);
         $this->displayList($list);
     }

    private function createCopyButton(string $bt,string $elmText){
        $this->jquery->click($bt,'
                    let tmp = $("<input>");
                    $("body").append(tmp);
                    tmp.val($("'.$elmText.'").text()).select();
                    document.execCommand("copy");
                    tmp.remove();
                    $("'.$bt.'").popup({content: "Idenfifiant copié !"}).popup("show");
    ');
    }

    private function showMessage(string $header, string $message, string $type = '', string $icon = 'info circle',array $buttons=[]) {
        $this->loadView('main/message.html', compact('header', 'type', 'icon', 'message','buttons'));
    }

    private function displayList(array $list) {
         $this->loadView( 'TodosController/displayList.html',['list'=> $list]);
    }


    protected function getAuthController(): AuthController
    {
        return new MyAuth($this);
    }
}
