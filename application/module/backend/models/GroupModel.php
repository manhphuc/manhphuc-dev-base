<?php
class GroupModel extends Model{

    private $_columns = [ 'id', 'name', 'group_acp', 'created', 'created_by', 'modified', 'modified_by', 'status', 'ordering', 'privilege_id', 'picture' ];
    private $_userInfo;
    protected $fieldSearchAccepted = ['id', 'name'];

    public function __construct() {
        parent::__construct();
        $this->setTable( TBL_GROUP );

        $userObj 			= Session::get( 'user' );
        @$this->_userInfo 	= $userObj['info'];

    }

    public function countItems( $params = [], $options = [] ) {
        //$currentUserID = $this->_userInfo['id'];
        $result = null;
        if ( $options['task'] == 'admin-count-items-group-by-status' ) {
            $query[] = "SELECT `status`, COUNT(`id`) AS `count` FROM `$this->table` WHERE `id` <> 0";
            if ( isset( $params['filter_group'] ) && $params['filter_group'] != 'default' ) $query[] = "AND `group_id` = '{$params['filter_group']}'";
            if ( isset( $params['search_value'] ) && $params['search_value'] != '' ) {
                $query[] = "AND";
                if ( $params['search_field'] == 'all' ) {
                    $query[] = "(";
                    foreach ( $this->fieldSearchAccepted as $field ) {
                        $query[] = "`$field` LIKE '%{$params['search_value']}%'";
                        $query[] = "OR";
                    }
                    array_pop( $query );
                    $query[] = ")";
                } elseif ( in_array( $params['search_field'], $this->fieldSearchAccepted ) ) {
                    $query[] = "`{$params['search_field']}` LIKE '%{$params['search_value']}%'";
                }
            }
            $query[] .= " GROUP BY `status`";
            $query = implode(' ', $query);
            $result = $this->fetchAll($query);
        }

        if ( $options['task'] == 'admin-count-items' ) {
            $query[] = "SELECT COUNT(`id`) AS `count` FROM `$this->table` WHERE `id` > 0";

            if ( isset( $params['filter_status'] ) && $params['filter_status'] != 'all' ) $query[] = "AND `status` = '{$params['filter_status']}'";

            if ( isset( $params['filter_group'] ) && $params['filter_group'] != 'default' ) $query[] = "AND `group_id` = '{$params['filter_group']}'";

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
            $query = implode(' ', $query);
            $result = $this->fetchRow($query)['count'];
        }

        return $result;
    }

    public function listItem( $arrParam, $option = null ): array {
        $currentUserID = $this->_userInfo['id'];
        $query[]    = "SELECT `id`, `name`, `group_acp`, `status`, `ordering`, `created`, `created_by`, `modified`, `modified_by` ";
        $query[]    = "FROM `$this->table`";
        $query[] = "WHERE `id` <> 0";
        // Filter: keyword
        $flagWhere      = false;
        if ( isset( $arrParam['search_value'] ) && $arrParam['search_value'] != '' ) {
            $query[] = "AND";
            if ( $arrParam['search_field'] == 'all' ) {
                $query[] = "(";
                foreach ( $this->fieldSearchAccepted as $field ) {
                    $query[] = "`$field` LIKE '%{$arrParam['search_value']}%'";
                    $query[] = "OR";
                }
                array_pop($query);
                $query[] = ")";
            } elseif ( in_array( $arrParam['search_field'], $this->fieldSearchAccepted ) ) {
                $query[] = "`{$arrParam['search_field']}` LIKE '%{$arrParam['search_value']}%'";
            }
        }

        // Filter: Status
        if( isset( $arrParam['filter_status'] ) && $arrParam['filter_status'] != 'all' ) {

            if( $flagWhere == false ){
                $filterStatus 	= "AND `status` =  '".$arrParam['filter_status'] . "'";
                $query[] 	    = $filterStatus ;
                $flagWhere	    = true;
            } else {
                $filterStatus 	= "WHERE `status` =  '".$arrParam['filter_status'] . "'";
                $query[] 	    = $filterStatus ;
            }
        }

        // Filter: Gr ACP
        if( isset( $arrParam['filter_group_acp'] ) && $arrParam['filter_group_acp'] != 'default' ) {
            if( $flagWhere == true ){
                $query[]	= "AND `group_acp` = '" . $arrParam['filter_group_acp']. "'";
            } else {
                $query[]	= "WHERE `group_acp` = '" . $arrParam['filter_group_acp'] . "'";
                $flagWhere	= true;
            }
        }

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
        $pagination         = $arrParam['pagination'];

        // Pagination
        $totalItemsPerPage  = $pagination['totalItemsPerPage'];
        if( $totalItemsPerPage > 1 ) {
            $position = ( $pagination['currentPage'] - 1 ) * $totalItemsPerPage ;
            $query[] = "LIMIT $position, $totalItemsPerPage";
        }

        $query      = implode( " ", $query );

        return $this->fetchAll( $query );
    }

    public function changeStatus( $arrParam, $option = null ): array {
        if ( $option['task'] == 'change-ajax-status' ) {
            $status         = ( $arrParam['status'] == 'inactive' ) ? 'active' : 'inactive';
            $modified_by    = $this->_userInfo['username'];
            $modified		= date('Y-m-d', time());
            $id             = $arrParam['id'];
            $query	        = "UPDATE `$this->table` SET `status` = '$status', `modified` = '$modified', `modified_by` = '$modified_by'  WHERE `id` = '" . $id . "'";

            $this->execute($query);
            Session::set( 'message', [ 'class' => 'alert-success', 'content' => 'Phần tử đã được thay đổi trạng thái!' ] );
            return [
                'id'        => $id,
                'status'    => $status,
                'link'      => URL::createLink( 'backend', 'group', 'ajaxStatus', [ 'id' => $id, 'status' => $status ] ),
                'title'     => 'Cập nhật thành công',
                'class'     => 'success'
            ];
        }
        if ( $option['task'] == 'change-ajax-group-acp' ) {
            $group_acp      = ( $arrParam['group_acp'] == 0 ) ? 1 : 0;
            $modified_by	= $this->_userInfo['username'];
            $modified		= date('Y-m-d', time());
            $id             = $arrParam['id'];
            $query		= "UPDATE `$this->table` SET `group_acp` = $group_acp, `modified` = '$modified', `modified_by` = '$modified_by'  WHERE `id` = '" . $id . "'";
            $this->execute($query);
            Session::set( 'message', [ 'class' => 'alert-success', 'content' => 'Phần tử đã được thay đổi group ACP!' ] );
            return [
                'id'        => $id,
                'group_acp' => $group_acp,
                'link'      => URL::createLink( 'backend', 'group', 'ajaxACP', [ 'id' => $id, 'group_acp' => $group_acp ] ),
                'title'     => 'Cập nhật thành công',
                'class'     => 'success'
            ];
        }
        if ( $option['task'] == 'change-status' ) {
            $status         = $arrParam['type'];
            $modified_by	= $this->_userInfo['username'];
            $modified		= date('Y-m-d', time());
            if( !empty( $arrParam['cid'] ) ) {
                $ids        = $this->createWhereDeleteSQL( $arrParam['cid'] );
                $query		= "UPDATE `$this->table` SET `status` = $status, `modified` = '$modified', `modified_by` = '$modified_by'  WHERE `id` IN ($ids)";
                $this->execute( $query );
                Session::set( 'message', [ 'class' => 'alert-success', 'content' => 'Có <strong class="class="alert-link"">' . $this->affectedRows() . '</strong> phần tử được thay đổi trạng thái thành công!' ] );
            } else {
                Session::set( 'message', [ 'class' => 'alert-danger', 'content' => 'Vui lòng chọn vào phần tử muốn thay đổi!' ] );
            }
        }
        if ( $option['task'] == 'changeOrderingField' ) {
            $value  = $arrParam['value'];
            $id     = $arrParam['id'];
            $modified_by    = $this->_userInfo['username'];
            $modified		= date('Y-m-d', time());
            $query	        = "UPDATE `$this->table` SET `ordering` = '$value', `modified` = '$modified', `modified_by` = '$modified_by'  WHERE `id` = '" . $id . "'";
            $this->execute( $query );
            return ['title' => 'Cập nhật thành công', 'class' => 'success'];
        }

    }

    public function deleteItem( $arrParam, $option = null ) {
        if( $option == null ) {
            if( !empty( $arrParam['cid'] ) ) {
                $ids    = $this->createWhereDeleteSQL( $arrParam['cid'] );
                $query  = "DELETE FROM `$this->table` WHERE `id` IN ( $ids )";
                $this->query( $query );
                Session::set( 'message', [ 'class' => 'alert-success', 'content' => 'Có <strong class="class="alert-link"">' . $this->affectedRows() . '</strong> phần tử được xóa thành công!' ] );
            } elseif ( !empty( $arrParam['id'] ) ) {
                $id         = $arrParam['id'];
                $exc = $this->delete( [$id] );
                Session::set( 'message', [ 'class' => 'alert-success', 'content' => 'Có ' .$exc->rowCount(). ' phần tử được xóa!' ] );
            } else {
                Session::set( 'message', [ 'class' => 'alert-danger', 'content' => 'Vui lòng chọn vào phần tử muốn xóa!' ] );
            }
        }
    }

    public function itemInSelectBox( $arrParam, $options = null ): array {
        $query      = "SELECT `id`, `name` FROM `$this->table`";
        $result     = $this->fetchAll( $query );
        if ( $options == 'add-default' ) {
            $result['default'] = "- Select Group -";
            ksort( $result );
        }
        return $result;
    }

    public function getItem($params, $options = []) {
        $query[] = "SELECT `id`, `name`, `group_acp`, `status`, `ordering`";
        $query[] = "FROM `$this->table`";
        $query[] = "WHERE `id` = {$params['id']}";

        $query = implode( ' ', $query );
        return $this->fetchRow( $query );
    }

    /*
     * Info item
     * @param $arrParam
     * @param $option
     * @return id
     * */
    public function infoItem( $arrParam, $option = null ){
        if( $option == null ){
            $query[]	= "SELECT `id`, `name`, `group_acp`, `status`, `ordering`";
            $query[]	= "FROM `$this->table`";
            $query[]	= "WHERE `id` = '" . $arrParam['id'] . "'";
            $query		= implode( " ", $query );
            return $this->fetchRow( $query );
        }
    }

    /*
     * Save item
     * @param $arrParam
     * @param $option
     * @return id
     * */
    public function saveItem( $arrParam, $options = [] ) {
        if ( $options['task'] == 'add' ) {
            $arrParam['form']['created'] = date( DB_DATETIME_FORMAT );
            $arrParam['form']['created_by'] = $this->getHistoryBy();
            $arrParam['form']['privilege_id']	= 1;
            $arrParam['form']['picture']	    = 'img1.png';
            $data = array_intersect_key($arrParam['form'], array_flip( $this->_columns ) );
            $result = $this->insert( $data );
            if ( $result ) {
                Session::set('notify', Helper::createNotify( 'success', SUCCESS_ADD ) );
            } else {
                Session::set('notify', Helper::createNotify( 'warning', FAIL_ACTION ) );
            }
            return $result;
        }

        if ( $options['task'] == 'edit' ) {
            $arrParam['form']['modified'] = date( DB_DATETIME_FORMAT );
            $arrParam['form']['modified_by'] = $this->getHistoryBy();
            $arrParam['form']['privilege_id']	= 1;
            $arrParam['form']['picture']	    = 'img1.png';
            $data = array_intersect_key( $arrParam['form'], array_flip( $this->_columns ) );
            $result = $this->update( $data, [ ['id', $arrParam['form']['id']] ] );
            if ( $result ) {
                Session::set( 'notify', Helper::createNotify( 'success', SUCCESS_EDIT ) );
            } else {
                Session::set( 'notify', Helper::createNotify( 'warning', FAIL_ACTION ) );
            }
            return $arrParam['form']['id'];
        }
    }


    /*
     * Ordering
     * @param $arrParam
     * @param $option
     * @return id
     * */
    public function ordering( $arrParam, $option = null ){
        if( $option == null ){
            if( !empty( $arrParam['order'] ) ){
                $i = 0;
                $modified_by	= $this->_userInfo['username'];
                $modified		= date( 'Y-m-d', time() );
                foreach( $arrParam['order'] as $id => $ordering ){
                    $i++;
                    $query	= "UPDATE `$this->table` SET `ordering` = $ordering, `modified` = '$modified', `modified_by` = '$modified_by'  WHERE `id` = '" . $id . "'";
                    $this->query( $query );
                }
                Session::set( 'message', [ 'class' => 'alert-success', 'content' => 'Có ' .$i. ' phần tử được thay đổi  ordering!' ] );
            }
        }
    }

    /*
     * Total Filter Items
     * @return array
     * */
    public function totalFilterItem(): array {
        $totalItemFilter                    = [];
        $totalItemFilter['totalActive'] 	= $this->fetchRow("SELECT COUNT(`id`) AS `total` FROM `$this->table` WHERE `status` = 'active'")['total'];
        $totalItemFilter['totalInactive'] 	= $this->fetchRow("SELECT COUNT(`id`) AS `total` FROM `$this->table` WHERE `status` = 'inactive'")['total'];
        $totalItemFilter['totalAll']		= $this->fetchRow("SELECT COUNT(`id`) AS `total` FROM `$this->table`")['total'];
        return $totalItemFilter;
    }

    /*
     * Change Bulk
     * @param $arrParam
     * @param $option
     * @return Void
     * */
    public function changeBulk( $arrParam, $option = null ) {
        if( !empty ( $_POST['action_choose'] ) && !empty( $_POST['cid'] ) ) {
            $queryAction = '';
            $where       = $this->createWhereDeleteSQL( $_POST['cid'] );
            switch ( $_POST['action_choose'] ) {
                case 'active':
                    $queryAction    = "UPDATE `$this->table` SET `status` = 'active' WHERE `id` IN ($where)";
                    $exc            = $this->execute( $queryAction );
                    Session::set('alert', 'There are '.$exc->rowCount().' items that have changed status');
                    break;
                case 'inactive':
                    $queryAction    = "UPDATE `$this->table` SET `status` = 'inactive' WHERE `id` IN ($where)";
                    $exc            = $this->execute( $queryAction );
                    Session::set('alert', 'There are '.$exc->rowCount().' items that have changed status');
                    break;
                case 'ordering':
                    $i = 0;
                    foreach ( $_POST['ordering'] as $key => $value ) {
                        $queryAction = "UPDATE `$this->table` SET `ordering` = $value WHERE `id` = $key ";
                        $this->execute( $queryAction );
                        $i++;
                    }
                    Session::set('alert', 'There are '.$i.' items that have changed ordering');
                    break;
                case 'delete':
                    $queryAction    = "DELETE FROM `$this->table` WHERE `id` IN ($where)";
                    $exc            = $this->execute( $queryAction );
                    Session::set('alert', 'There are delete '.$exc->rowCount().' items');
                    break;
            }
        }
    }
}