<?php
namespace controllers\crud\viewers;

use Ajax\semantic\widgets\dataform\DataForm;
use Ajax\semantic\widgets\datatable\DataTable;
use Ubiquity\controllers\crud\viewers\ModelViewer;
 /**
  * Class CrudUsersViewer
  */

 //gère l'affichage du controller
class CrudUsersViewer extends ModelViewer{
    protected function getDataTableRowButtons(): array
    {
        return ['edit','delete','display'];
    }

    public function getModelDataTable($instances, $model, $totalCount, $page = 1): DataTable
    {
        $dt = parent::getModelDataTable($instances, $model, $totalCount, $page);
        //index est le nom du champs qu'on veut modifier
        //icon indique l'icone qu'on veut mettre devant
        $dt->fieldAsLabel('firstname','mail');
        $dt->fieldAsHidden('id');
        return $dt;
    }

    public function setFormFieldsComponent(DataForm $form,$fieldTypes,$attributes = [ ]){
        $form->fieldAsHidden('id');
}


}
