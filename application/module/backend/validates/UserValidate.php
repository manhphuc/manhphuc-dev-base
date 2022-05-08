<?php
class UserValidate extends Validate {
    public function __construct( $params )  {
        $dataForm = $params['form'] ?? [];
        parent::__construct( $dataForm );
    }

    public function validate( $model ) {
        $queryUsername  = "SELECT `id` FROM " . TBL_USER . " WHERE `username` = '{$this->source['username']}'";
        $queryEmail     = "SELECT `id` FROM " . TBL_USER . " WHERE `email` = '{$this->source['email']}'";
        if ( isset( $this->source['id'] ) ) {
            $queryUsername  .= " AND `id` <> '{$this->source['id']}'";
            $queryEmail     .= " AND `id` <> '{$this->source['id']}'";
        }
        $this->addRule( 'username', 'string-existRecord', ['database' => $model, 'query' => $queryUsername, 'min' => 3, 'max' => 50] )
            ->addRule( 'email', 'email-existRecord', ['database' => $model, 'query' => $queryEmail] )
            ->addRule( 'group_id', 'status', ['deny' => ['default']] );
        if ( !isset( $this->source['id'] ) ) $this->addRule( 'password', 'string', ['min' => 8, 'max' => 32] );
        $this->run();
    }
}