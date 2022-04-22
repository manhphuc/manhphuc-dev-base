<?php
class IndexController extends Controller {
	
	public function __construct( $arrParams ){
		parent::__construct( $arrParams );
	}

    public function indexAction() {
        $this->_templateObj->setFolderTemplate( 'admin/yivic-admin-theme/' );
        $this->_templateObj->setFileTemplate( 'index-template.php' );
        $this->_templateObj->setFileConfig( 'template.ini' );
        $this->_templateObj->load();
        $this->_view->_title    = 'Dashboard';
        $this->_view->render( 'index/index' );
    }

    public function loginAction(){
        $infoUser   = Session::get( 'user' );
        if( ( @$infoUser['login'] == TRUE && @$infoUser['time'] + TIME_LOGIN >= time() ) ) {
            URL::redirect( 'backend', 'index', 'index' );
        }
        $this->_templateObj->setFolderTemplate( 'admin/yivic-admin-theme/' );
        $this->_templateObj->setFileTemplate( 'login-template.php' );
        $this->_templateObj->setFileConfig( 'template.ini' );
        $this->_templateObj->load();
        $this->_view->_title    = 'Login';
        if( isset( $this->_arrParam['form']['token'] ) > 0 ) {
            $validate = new Validate( $this->_arrParam['form'] );
            $username = $this->_arrParam['form']['username'];
            $password = md5( $this->_arrParam['form']['password'] );
            $query = "SELECT `id` FROM `user` WHERE `username` = '$username' AND `password` = '$password'";
            $validate->addRule( 'username', 'existRecord', [ 'database' => $this->_model, 'query' => $query ] );
            $validate->run();
            if( $validate->isValid() == TRUE ) {
                $userInfo   = $this->_model->infoItem( $this->_arrParam );
                $arrSession = [
                    'login'     => TRUE,
                    'info'      => $userInfo,
                    'time'      => time(),
                    'group_acp' => $userInfo['group_acp']
                ];
                Session::set( 'user', $arrSession );
                URL::redirect( 'backend', 'index', 'index' );
            } else {
                $this->_view->errors = $validate->showErrors();
            }
        }
        $this->_view->render( 'index/login' );
        exit();
    }

    public function logoutAction(){
        Session::delete( 'user' );
        URL::redirect( 'backend', 'index', 'login' );
    }

}