<?php
/**
 * Created by PhpStorm.
 * User: manhphucofficial@gmail.com
 * Date: 07/13/2021
 * Time: 9:59 PM
 */

class GroupController extends AdminController {

    /*
     * Display group list items
     * */
    public function indexAction(){
        $this->_view->_title    = 'User Manager: User Groups';
        $totalItems = $this->_model->countItems($this->_arrParam, ['task' => 'admin-count-items']);

        $configPagination = [
            'totalItemsPerPage'     => 3,
            'pageRange'             => 2,
        ];
        $this->setPagination( $configPagination );
        $this->_view->pagination        = new Pagination( $totalItems, $this->_pagination );
        $this->_view->itemsStatusCount  = $this->_model->countItems( $this->_arrParam, ['task' => 'admin-count-items-group-by-status'] );
        $this->_view->Items             = $this->_model->listItems( $this->_arrParam, null );
        $this->_view->countItem         = $this->_model->totalFilterItem();
        $this->_view->render( 'group/index' );
    }

    /*
     * Add group
     * */
    public function formAction() {
        if ( ( $this->_arrParam['id'] ?? '' ) == Session::get( 'user')['info']['id'] ) URL::redirect( $this->_arrParam['module'], $this->_controllerName, 'index' );
        $this->_view->_title = ucfirst( $this->_controllerName ) . ' Manager :: Add';

        if ( isset( $this->_arrParam['id'] ) && !isset( $this->_arrParam['form']['token'] ) ) {
            $this->_view->_title = ucfirst( $this->_controllerName ) . ' Manager :: Edit';
            $this->_arrParam['form'] = $this->_model->getItem( $this->_arrParam );
            if ( empty( $this->_arrParam['form'] ) ) URL::redirect( $this->_arrParam['module'], $this->_controllerName, 'index');
        }

        if ( isset( $this->_arrParam['form']['token'] ) ) {
            $this->_validate->validate();
            $this->_arrParam['form'] = $this->_validate->getResults();
            if ( !$this->_validate->isValid() ) {
                $this->_view->errors = $this->_validate->showErrors();
            } else {
                $task = isset( $this->_arrParam['form']['id'] ) ? 'edit' : 'add';
                $id = $this->_model->saveItem( $this->_arrParam, ['task' => $task] );
                $this->redirectAfterSave( $this->_arrParam, ['id' => $id] );
            }
        }

        $this->_view->params = $this->_arrParam;
        $this->_view->render("{$this->_controllerName}/form");
    }

}