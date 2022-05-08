<?php
class UserModel extends AdminModel {

    protected $_columns = ['id', 'username', 'email', 'fullname', 'password', 'created', 'created_by', 'modified', 'modified_by', 'status', 'ordering', 'group_id'];
    protected $fieldSearchAccepted = ['id', 'username', 'email', 'fullname'];
    private $userInfo;

    public function __construct() {
        parent::__construct();
        $this->setTable( TBL_USER );
        $this->userInfo = Session::get('user')['info'] ?? [];
    }

    /*
     * Get item
     * @param $params
     * @param $options
     * @return array
     * */
    public function getItem( $params, $options = [] ) {
        $query[] = "SELECT `id`, `username`, `email`, `fullname`, `status`, `ordering`, `group_id`";
        $query[] = "FROM `$this->table`";
        $query[] = "WHERE `id` = {$params['id']}";

        $query = implode( ' ', $query );
        return $this->fetchRow( $query );
    }

    /*
     * List Items
     * @param $params
     * @param $options
     * @return array
     * */
    public function listItems( $params, $options = null ): array {
        //$currentUserID = $this->userInfo['id'];
        $query[] = "SELECT `id`, `username`, `email`, `fullname`, `created`, `created_by`, `modified`, `modified_by`, `status`, `ordering`, `group_id`";
        $query[] = "FROM `$this->table`";
        $query[] = "WHERE `id` <> 0";
        // Filter: keyword
        $flagWhere      = false;
        if ( isset( $params['search_value'] ) && $params['search_value'] != '' ) {
            $query[] = "AND";
            if ( $params['search_field'] == 'all' ) {
                $query[] = "(";
                foreach ( $this->fieldSearchAccepted as $field ) {
                    $query[] = "`$field` LIKE '%{$params['search_value']}%'";
                    $query[] = "OR";
                }
                array_pop($query);
                $query[] = ")";
            } elseif ( in_array( $params['search_field'], $this->fieldSearchAccepted ) ) {
                $query[] = "`{$params['search_field']}` LIKE '%{$params['search_value']}%'";
            }
        }

        // Filter: Status
        if( isset( $params['filter_status'] ) && $params['filter_status'] != 'all' ) {

            if( $flagWhere == false ){
                $filterStatus 	= "AND `status` =  '".$params['filter_status'] . "'";
                $query[] 	    = $filterStatus ;
                $flagWhere	    = true;
            } else {
                $filterStatus 	= "WHERE `status` =  '".$params['filter_status'] . "'";
                $query[] 	    = $filterStatus ;
            }
        }

        // Filter: Gr ACP
        if ( isset( $params['filter_group'] ) && $params['filter_group'] != 'default') $query[] = "AND `group_id` = '{$params['filter_group']}'";

        // Sort
        $paramsField 		= ( !empty( $_GET['field'] ) )      ? $_GET['field']   : 'id';
        $paramsType 		= ( !empty( $_GET['type'] ) )       ? $_GET['type']    : 'desc';

        if( !empty( $paramsField ) && !empty( $paramsType ) ) {
            $column     = $paramsField;
            $columnDir  = $paramsType;
            $query[]    = "ORDER BY `$column` $columnDir";
        } else {
            $query[]    = "ORDER BY `name` ASC";
        }

        // Pagination
        $pagination         = $params['pagination'];

        // Pagination
        $totalItemsPerPage  = $pagination['totalItemsPerPage'];
        if( $totalItemsPerPage > 1 ) {
            $position = ( $pagination['currentPage'] - 1 ) * $totalItemsPerPage ;
            $query[] = "LIMIT $position, $totalItemsPerPage";
        }

        $query      = implode( " ", $query );
        return $this->fetchAll( $query );
    }


    /*
     * Change Group
     * @param $params
     * @return array
     * */
    public function changeGroup( $params ): array {
        $id = $params['id'];
        $groupId = $params['group_id'];
        $modified = date(DB_DATETIME_FORMAT);
        $modifiedBy = $this->getHistoryBy();
        $query = "UPDATE `$this->table` SET `group_id` = $groupId, `modified` = '$modified', `modified_by` = '$modifiedBy' WHERE `id` = $id";
        $this->execute( $query );
        return [
            'id' => $id,
            'modified' => HTML::showItemHistory(json_decode($modifiedBy)->username, $modified)
        ];
    }

    /*
     * Item In SelectBox
     * @param $arrParam
     * @param $options
     * @return array
     * */
    public function itemInSelectBox( $arrParam, $options = null ): array {
        $query      = "SELECT `id`, `name` FROM `" . TBL_GROUP . "`";
        $result     = $this->fetchPairs( $query );
        if ( $options == 'add-default' ) {
            $result['default'] = "Select Group";
            ksort( $result );
        }
        return $result;
    }

    /*
     * Check Password
     * @param $params
     * @param $options
     * @return array
     * */
    public function checkPassword( $params, $options = null ) {
        $result = 0;
        if ( $options == null ) {
            $password   = md5( $params['password'] );
            $query      = "SELECT `id` FROM `$this->table` WHERE `id` = {$this->userInfo['id']} AND `password` = '$password'";
            $result     = $this->isExist( $query );
            // $result = $query;
        }
        return $result;
    }

    /*
     * Reset Password
     * @param $params
     * @param $options
     * @return array
     * */
    public function resetPassword( $params, $options = [] ) {
        $id             = $params['id'];
        $newPassword    = md5($params['new-password']);
        $query          = "UPDATE `$this->table` SET `password` = '$newPassword' WHERE `id` = '$id'";
        $exc            = $this->execute( $query );
        $result         = $exc->rowCount();
        if ( $result ) {
            Session::set( 'notify', Helper::createNotify( 'success', SUCCESS_CHANGE ) );
        } else {
            Session::set( 'notify', Helper::createNotify( 'warning', FAIL_ACTION ) );
        }
    }

    /*
     * Save item
     * @param $arrParam
     * @param $option
     * @return id
     * */
    public function saveItem( $params, $options = [] ) {
        if ( $options['task'] == 'add' ) {
            $params['form']['created'] = date( DB_DATETIME_FORMAT );
            $params['form']['created_by'] = $this->getHistoryBy();
            $params['form']['password'] = md5( $params['form']['password'] );
            $data = array_intersect_key( $params['form'], array_flip( $this->_columns ) );
            $result = $this->insert( $data );
            if ( $result ) {
                Session::set('notify', Helper::createNotify( 'success', SUCCESS_ADD ) );
            } else {
                Session::set('notify', Helper::createNotify( 'warning', FAIL_ACTION ) );
            }
            return $result;
        }

        if ( $options['task'] == 'edit' ) {
            unset( $params['form']['username'] );
            $params['form']['modified'] = date( DB_DATETIME_FORMAT );
            $params['form']['modified_by'] = $this->getHistoryBy();
            $data = array_intersect_key( $params['form'], array_flip( $this->_columns ) );
            $result = $this->update( $data, [['id', $params['form']['id']]] );
            if ( $result ) {
                Session::set( 'notify', Helper::createNotify( 'success', SUCCESS_EDIT ) );
            } else {
                Session::set( 'notify', Helper::createNotify( 'warning', FAIL_ACTION ) );
            }
            return $params['form']['id'];
        }
    }

}
