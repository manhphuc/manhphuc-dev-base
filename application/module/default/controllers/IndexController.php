<?php
class IndexController extends FrontendController {

    /*
     * Index Action
     * */
    public function indexAction(){
        $this->_view->_title	= 'Trang chủ';
        $this->_view->render( $this->_controllerName . '/index' );
    }

    /*
     * Login Action
     * @param null
     * @return view_template
     * */
    public function loginAction() {
        $this->_view->_title	= 'Đăng nhập';

//        echo '<pre>';
//        print_r($this);
//        echo '</pre>';

        $userInfo = Session::get( 'user' );

        if ( ( $userInfo['login'] ?? false ) == true && $userInfo['time'] + TIME_LOGIN >= time() ) {
            URL::redirect( 'default', 'user', 'index', [], 'tai-khoan.html' );
        }

        if ( isset( $this->_arrParam['form']['token'] ) ) {
            $this->_validate->validateLogin( $this->_model );
            if ( $this->_validate->isValid() ) {
                $infoUser = $this->_model->infoItem( $this->_arrParam );
                $arrSession = [
                    'login'     => true,
                    'info'      => $infoUser,
                    'time'      => time(),
                    'group_acp' => $infoUser['group_acp']
                ];
                Session::set( 'user', $arrSession );
                header( 'location: ' . $_SERVER['HTTP_REFERER'] );
            } else {
                $this->_view->errors = 'Thông tin đăng nhập không chính xác!';
            }
        }
        $this->_view->render('index/login');
    }
}