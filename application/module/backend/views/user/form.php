<?php
// Input
$dataFrom       = $this->params['form'] ?? null;
$statusValues   = ['inactive' => TEMPLATE_STATUS['inactive']['name'], 'active' => TEMPLATE_STATUS['active']['name']];
$groupACPValues = ['0' => 'No', '1' => 'Yes'];
$inputToken     = Form::hidden( "form[token]", time() );

require_once MODULE_PATH . 'backend/views/define-form-button.php';

$labelClass         = 'col-sm-2 col-form-label text-sm-right';
$formControlClass   = 'form-control form-control-sm';
$customSelectClass  = 'custom-select custom-select-sm';
$userNameAttributes = isset( $this->params['id'] ) ? ['class' => $formControlClass, 'readonly' => true] : ['class' => $formControlClass];
// List element
$elements = [
    [
        'label'     => Form::label('form[username]', 'Username', ['class' =>  "$labelClass required"]),
        'element'   => Form::text('form[username]', $dataFrom['username'] ?? '', $userNameAttributes)
    ],
    [
        'label'     => Form::label('form[email]', 'Email', ['class' =>  "$labelClass required"]),
        'element'   => Form::text('form[email]', $dataFrom['email'] ?? '', ['class' => $formControlClass])
    ],
    [
        'label'     => Form::label('form[fullname]', 'Fullname', ['class' =>  "$labelClass"]),
        'element'   => Form::text('form[fullname]', $dataFrom['fullname'] ?? '', ['class' => $formControlClass])
    ],
    [
        'label'     => Form::label('status', 'Status', ['class' =>  "$labelClass"]),
        'element'   => Form::select('form[status]', $statusValues, $dataFrom['status'] ?? '', ['class' => $customSelectClass])
    ],
    [
        'label'     => Form::label('group_id', 'Group', ['class' =>  "$labelClass required"]),
        'element'   => Form::select('form[group_id]', $this->slbGroup, $dataFrom['group_id'] ?? '', ['class' => $customSelectClass])
    ]
];
if ( isset( $this->params['id'] ) ) {
    array_unshift( $elements, [
        'label'     => Form::label( 'form[id]', 'ID', ['class' =>  "$labelClass"] ),
        'element'   => Form::text( 'form[id]', $dataFrom['id'] ?? '', ['class' => $formControlClass, 'readonly' => true] )
    ] );
} else {
    array_splice( $elements, 1, 0, [[
        'label'     => Form::label( 'form[password]', 'Password', ['class' =>  "$labelClass required"] ),
        'element'   => Form::text( 'form[password]', $dataFrom['password'] ?? '', ['class' => $formControlClass] )
    ]] );
} ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <?php require_once ''.TEMPLATE_PATH . 'admin/yivic-admin-theme/html/page-header.php'; ?>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <?= $this->errors ?? '' ?>
                    <div class="card card-default yivicCard">
                        <div class="card-body">
                            <form action="" method="post" class="mb-0" id="admin-form">
                                <?= Form::showForm($elements); ?>
                                <?= $inputToken ?>
                            </form>
                        </div>
                        <div class="card-footer" style="padding-left: 0; padding-right: 0; background: #f4f6f9">
                            <?= BTN_SAVE . BTN_SAVE_CLOSE . BTN_SAVE_NEW . BTN_CANCEL ?>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- /.container-fluid -->
    </div> <!-- /.content -->
</div>