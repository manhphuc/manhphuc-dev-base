<?php
/**
 * Created by PhpStorm.
 * User: manhphucofficial@gmail.com
 * Date: 07/13/2021
 * Time: 9:59 PM
 */

class GroupController extends Controller {

    /*
     * Construct init
     * */
    public function __construct( $arrParams ){
        parent::__construct( $arrParams );
        $this->_templateObj->setFolderTemplate( 'admin/yivic-admin-theme/' );
        $this->_templateObj->setFileTemplate( 'index-template.php' );
        $this->_templateObj->setFileConfig( 'template.ini' );
        $this->_templateObj->load();
    }

    /*
     * Display group list items
     * */
    public function indexAction(){
        $this->_view->_title    = 'User Manager: User Groups';
        $totalItems = $this->_model->countItem( $this->_arrParam, null );

        $configPagination = [
            'totalItemsPerPage'     => 4,
            'pageRange'             => 2,
        ];

        $this->setPagination( $configPagination );
        $this->_view->pagination = new Pagination( $totalItems, $this->_pagination );

        $this->_view->Items     = $this->_model->listItem( $this->_arrParam, null );
        $this->_view->render( 'group/index' );

    }

    /*
     * Add group
     * */
    /* comment */
    public function formAction(){
        $this->_view->_title = 'User Groups : Add';
        if( isset( $this->_arrParam['id'] ) ){
            $this->_view->_title = 'User Groups : Edit';
            $this->_arrParam[ 'form' ] = $this->_model->infoItem( $this->_arrParam );
            if( empty( $this->_arrParam['form'] ) ) URL::redirect( 'backend', 'group', 'index' );
        }

        if( isset( $this->_arrParam['form']['token'] ) > 0 ){
            $validate = new Validate( $this->_arrParam['form'] );
            $validate->addRule( 'name', 'string', [ 'min' => 3, 'max' => 255 ] )
                ->addRule( 'ordering', 'int', [ 'min' => 1, 'max' => 100 ] )
                ->addRule( 'status', 'status', [ 'deny' => [ 'default' ] ] )
                ->addRule( 'group_acp', 'status', [ 'deny' => [ 'default' ] ] );
            $validate->run();
            $this->_arrParam['form'] = $validate->getResult();
            if( $validate->isValid() == false ){
                $this->_view->errors = $validate->showErrors();
            } else {
                $task	= ( isset( $this->_arrParam['form']['id'] ) ) ? 'edit' : 'add';
                $id	= $this->_model->saveItem( $this->_arrParam, [ 'task' => $task ] );
                if ( $this->_arrParam['type'] == 'save-close' ) URL::redirect( 'backend', 'group', 'index' );
                if ( $this->_arrParam['type'] == 'save-new' ) URL::redirect( 'backend', 'group', 'form' );
                if ( $this->_arrParam['type'] == 'save' ) URL::redirect( 'backend', 'group', 'form', [ 'id' => $id ] );
            }
        }

        $this->_view->arrParam = $this->_arrParam;
        $this->_view->render( 'group/form' );
    }

    /*
     * Action: Ajax status (*)
     * */
    public function ajaxStatusAction(){
        $result = $this->_model->changeStatus( $this->_arrParam, [ 'task' => 'change-ajax-status' ] );
        echo json_encode( $result );
    }

    /*
     * Action: Ajax Group ACP (*)
     * */
    public function ajaxACPAction(){
        $result = $this->_model->changeStatus( $this->_arrParam, [ 'task' => 'change-ajax-group-acp' ] );
        echo json_encode( $result );
    }

    /*
     * Action: Status (*)
     * */
    public function statusAction(){
        $result = $this->_model->changeStatus( $this->_arrParam, [ 'task' => 'change-status' ] );
        URL::redirect( 'backend', 'group', 'index' );
    }

    /*
     * Action: Trash (*)
     * */
    /* comment */
    public function trashAction(){
        $this->_arrParam['id'] 		= $_GET['id'];
        $result = $this->_model->deleteItem( $this->_arrParam );
        URL::redirect( 'backend', 'group', 'index' );
    }

    /*
     * ACTION: Ordering (*)
     * */
    public function orderingAction(){
        $this->_model->ordering( $this->_arrParam );
        URL::redirect( 'backend', 'group', 'index' );
    }


    //
    public function changeAjaxAction(){
        $_arrParam['value'] = $_GET['valueOrdering'];
        $_arrParam['id']	= $_GET['id'];
        $result = $this->_model->changeAjax( $_arrParam, $_GET['typeOrdering'] );
        echo json_encode($result);
    }

}