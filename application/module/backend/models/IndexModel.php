<?php
class IndexModel extends Model{

    public function __construct() {
        parent::__construct();
    }

    public function infoItem( $arrParam, $option = NULL ) {
        if ( $option == NULL ) {
            $username = $arrParam['form']['username'];
            $password = md5( $arrParam['form']['password'] );
            $query[] = "SELECT `u`.`id`, `u`.`fullname`, `u`.`username`, `u`.`email`, `u`.`group_id`, `g`.`group_acp`, `g`.`privilege_id`";
            $query[] = "FROM `user` AS `u` LEFT JOIN `group` AS g ON `u`.`group_id` = `g`.`id`";
            $query[] = "WHERE `username` = '$username' AND `password` = '$password'";
            $query = implode(  ' ', $query );
            $result = $this->fetchRow( $query );
            if( $result['group_acp'] == 1 ) {
                $arrPrivilege = explode( ',', $result['privilege_id'] );
                $strPrivilegeID = '';
                foreach ( $arrPrivilege as $privilegeID ) $strPrivilegeID .= "'$privilegeID', ";
                $queryPrivilege[] = "SELECT `id`, CONCAT( `module`, '-' , `controller`, '-', `action` ) AS `name`";
                $queryPrivilege[] = "FROM `".TBL_PRIVILEGE."` AS privilege";
                $queryPrivilege[] = "WHERE id IN ( $strPrivilegeID'0' )";

                $queryPrivilege = implode( " ", $queryPrivilege );
                $result['privilege'] = $this->fetchAll( $queryPrivilege );
            }
            return $result;
        }
    }
}