<?php
class GroupModel extends AdminModel {

    protected $_columns = [ 'id', 'name', 'group_acp', 'created', 'created_by', 'modified', 'modified_by', 'status', 'ordering', 'privilege_id', 'picture' ];
    protected $fieldSearchAccepted = ['id', 'name'];

    public function __construct() {
        parent::__construct();
        $this->setTable( TBL_GROUP );
    }

    /*
     * Get item
     * @param $params
     * @param $options
     * @return array
     * */
    public function getItem( $params, $options = [] ) {
        $query[] = "SELECT `id`, `name`, `group_acp`, `status`, `ordering`";
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
        $query[]    = "SELECT `id`, `name`, `group_acp`, `status`, `ordering`, `created`, `created_by`, `modified`, `modified_by` ";
        $query[]    = "FROM `$this->table`";
        $query[]    = "WHERE `id` <> 0";
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
        if( isset( $params['filter_group_acp'] ) && $params['filter_group_acp'] != 'default' ) {
            if( $flagWhere == true ){
                $query[]	= "AND `group_acp` = '" . $params['filter_group_acp']. "'";
            } else {
                $query[]	= "WHERE `group_acp` = '" . $params['filter_group_acp'] . "'";
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
            $data = array_intersect_key( $arrParam['form'], array_flip( $this->_columns ) );
            $result = $this->insert( $data );
            if ( $result ) {
                Session::set( 'notify', Helper::createNotify( 'success', SUCCESS_ADD ) );
            } else {
                Session::set( 'notify', Helper::createNotify( 'warning', FAIL_ACTION ) );
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

}