<?php
// Input
$dataFrom = $this->params['form'] ?? null;
$statusValues = ['inactive' => TEMPLATE_STATUS['inactive']['name'], 'active' => TEMPLATE_STATUS['active']['name']];
$groupACPValues = ['0' => 'No', '1' => 'Yes'];
$inputToken = Form::hidden( "form[token]", time() );

// Save
$linkSave = URL::createLink( $this->arrParam['module'], $this->arrParam['controller'], 'form', ['type' => 'save'] );
$btnSave = HTML::createActionButton( "javascript:submitForm('$linkSave')", 'btn-success mr-1', 'Save' );

// Save & Close
$linkSaveClose = URL::createLink( $this->arrParam['module'], $this->arrParam['controller'], 'form', ['type' => 'save-close'] );
$btnSaveClose = HTML::createActionButton( "javascript:submitForm('$linkSaveClose')", 'btn-success mr-1', 'Save & Close' );

// Save & New
$linkSaveNew = URL::createLink( $this->arrParam['module'], $this->arrParam['controller'], 'form', ['type' => 'save-new'] );
$btnSaveNew = HTML::createActionButton( "javascript:submitForm('$linkSaveNew')", 'btn-success mr-1', 'Save & New' );

// Cancel
$linkCancel = URL::createLink( $this->arrParam['module'], $this->arrParam['controller'], 'index' );
$btnCancel = HTML::createActionButton( $linkCancel, 'btn-danger mr-1', 'Cancel' );

// List element
$elements = [
    [
        'label'     => Form::label( 'name', 'Name', ['class' => 'col-sm-2 col-form-label text-sm-right required'] ),
        'element'   => Form::text( 'form[name]', $dataFrom['name'] ?? '', ['class' => 'form-control'] )
    ],
    [
        'label'     => Form::label( 'ordering', 'Ordering', ['class' =>  'col-sm-2 col-form-label text-sm-right'] ),
        'element'   => Form::number( 'form[ordering]', $dataFrom['ordering'] ?? '', ['class' => 'form-control'] )
    ],
    [
        'label'     => Form::label( 'status', 'Status', ['class' =>  'col-sm-2 col-form-label text-sm-right'] ),
        'element'   => Form::select('form[status]', $statusValues, $dataFrom['status'] ?? '', ['class' => 'custom-select'])
    ],
    [
        'label'     => Form::label( 'group_acp', 'Group ACP', ['class' =>  'col-sm-2 col-form-label text-sm-right'] ),
        'element'   => Form::select( 'form[group_acp]', $groupACPValues, $dataFrom['group_acp'] ?? '0', ['class' => 'custom-select'] )
    ],
];
if ( isset( $this->params['id'] ) ) {
    array_unshift($elements, [
        'label'     => Form::label( 'id', 'ID', ['class' =>  'col-sm-2 col-form-label text-sm-right'] ),
        'element'   => Form::text( 'form[id]', $dataFrom['id'] ?? '', ['class' => 'form-control', 'readonly' => true] )
    ]);
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
                            <?= $btnSave . $btnSaveClose . $btnSaveNew . $btnCancel ?>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- /.container-fluid -->
    </div> <!-- /.content -->
</div>