<?php
class IndexModel extends Model{
    public function __construct() {
        parent::__construct();
        $this->setTable( TBL_USER );
    }
}