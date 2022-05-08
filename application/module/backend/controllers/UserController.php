<?php
class UserController extends AdminController {
    // ACTION: LIST
    public function indexAction() {
        $this->_view->_title = ucfirst($this->_controllerName) . ' Manager :: List';
        $totalItems = $this->_model->countItems( $this->_arrParam, ['task' => 'admin-count-items'] );
        $configPagination = [
            'totalItemsPerPage'     => 4,
            'pageRange'             => 2,
        ];
        $this->setPagination( $configPagination );
        $this->_view->pagination        = new Pagination( $totalItems, $this->_pagination );
        $this->_view->itemsStatusCount  = $this->_model->countItems( $this->_arrParam, ['task' => 'admin-count-items-group-by-status'] );
        $this->_view->slbGroup          = $this->_model->itemInSelectBox( $this->_arrParam );
        $this->_view->slbFilterGroup    = $this->_model->itemInSelectBox( $this->_arrParam, 'add-default' );
        $this->_view->Items             = $this->_model->listItems( $this->_arrParam );
        $this->_view->render( $this->_controllerName . '/index' );
    }

    // ACTION: AJAX CHANGE GROUP
    public function ajaxChangeGroupAction() {
        $result = $this->_model->changeGroup( $this->_arrParam );
        echo json_encode( $result );
    }

    // ACTION: ADD & EDIT USER
    public function formAction() {
        if ( ( $this->_arrParam['id'] ?? '' ) == Session::get('user')['info']['id'] ) URL::redirect( $this->_arrParam['module'], $this->_controllerName, 'index' );
        $this->_view->_title = ucfirst( $this->_controllerName ) . ' Manager :: Add';
        if ( isset( $this->_arrParam['id'] ) && !isset( $this->_arrParam['form']['token'] ) ) {
            $this->_view->_title = ucfirst($this->_controllerName) . ' Manager :: Edit';
            $this->_arrParam['form'] = $this->_model->getItem( $this->_arrParam );
            if ( empty( $this->_arrParam['form'] ) ) URL::redirect( $this->_arrParam['module'], $this->_controllerName, 'index' );
            if ( $this->_arrParam['form']['group_id'] < Session::get('user')['info']['group_id'] ) URL::redirect( $this->_arrParam['module'], $this->_controllerName, 'index' );
        }
        if ( isset( $this->_arrParam['form']['token'] ) ) {
            $this->_validate->validate( $this->_model );
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
        $this->_view->slbGroup = $this->_model->itemInSelectBox($this->_arrParam, 'add-default');
        $this->_view->render( "{$this->_controllerName}/form" );
    }

    public function resetPasswordAction() {
        $this->_view->_title = ucfirst( $this->_controllerName ) . ' Manager :: Reset Password';
        if ( isset( $this->_arrParam['new-password'] ) ) {
            $this->_model->resetPassword( $this->_arrParam );
            URL::redirect( $this->_arrParam['module'], $this->_controllerName, 'index' );
        }
        $this->_view->item = $this->_model->getItem( $this->_arrParam );
        $this->_view->render( "{$this->_controllerName}/reset-password" );
    }

    public function checkPasswordAction() {
        $result = $this->_model->checkPassword( $this->_arrParam );
        echo $result;
    }
}
