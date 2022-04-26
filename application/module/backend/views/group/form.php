<?php
// Input
@$controller    = @$this->arrParam['controller'];
@$dataForm      = $this->arrParam['form'];
$inputName      = Helper::cmsInput( 'text', 'form[name]', 'input-name', @$dataForm['name'], 'form-control', null, 'Enter a name...' );
$inputOrdering  = Helper::cmsInput( 'text', 'form[ordering]', 'input-ordering', @$dataForm['ordering'], 'form-control', null, 'Enter a Ordering...' );
$inputToken     = Helper::cmsInput( 'hidden', 'form[token]', 'token', time() );
$selectStt      = Helper::cmsSelectbox( 'form[status]', 'form-select', [ 'default' => '- Select status -', 1 => 'Publish', 0 => 'Unpublish' ], @$dataForm['status'], null );
$selectGrACP    = Helper::cmsSelectbox( 'form[group_acp]', 'form-select', [ 'default' => '- Select Group ACP -', 1 => 'Yes', 0 => 'No' ], @$dataForm['group_acp'], null );

// Row input
$rowInputName       = Helper::cmsRowInputForm( 'Name', 'mb-4', '', $inputName, true );
$rowInputOrdering   = Helper::cmsRowInputForm( 'Ordering', 'mb-4', '', $inputOrdering, true );
$rowStatus          = Helper::cmsRowInputForm( 'Status', 'mb-4', '', $selectStt, true );
$rowGrACP           = Helper::cmsRowInputForm( 'Group ACP', 'mb-4', '', $selectGrACP, true );

$inputID    = '';
$rowInputID = '';
if( isset( $this->arrParam['id'] ) ){
    $inputID    = Helper::cmsInput( 'text', 'form[id]', 'input-id', $dataForm['id'], 'form-control form-control-alt', null, null, true );
    $rowInputID = Helper::cmsRowInputForm( 'ID', 'mb-4', '', $inputID, false );
}
$message    = Session::get( 'message' );
Session::delete( 'message' );
$strMessage = Helper::cmsMessage( $message ); ?>
?>
<main id="main-container">
    <!-- Hero -->
    <div class="content">
        <div class="d-md-flex justify-content-md-between align-items-md-center py-3 pt-md-3 pb-md-0 text-center text-md-start">
            <div>
                <h1 class="h3 mb-1"><?php echo $this->_title ?></h1>
                <p class="fw-medium mb-0 text-muted">Welcome, admin! You have <a class="fw-medium" href="javascript:void(0)">0 new notifications</a>.</p>
            </div>
            <!-- Status Update -->
            <?php echo $strMessage ?> <!-- Status Update -->
            <?php echo @$this->errors ?>
        </div>
    </div>
    <!-- END Hero -->
    <!-- Page Content -->
    <form class="content" action="#" method="post" name="adminForm" id="adminForm">
        <!-- All Group -->
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title"><?php echo $this->_title ?></h3>
                <div class="block-options">
                    <div class="dropdown">
                        <button type="button" class="btn-block-option" data-toggle="block-option" data-action="state_toggle" data-action-mode="demo">
                            <i class="si si-refresh"></i>
                        </button>
                        <button type="button" class="btn-block-option" data-toggle="block-option" data-action="content_toggle"></button>
                        <button type="button" class="btn-block-option" data-toggle="block-option" data-action="fullscreen_toggle"></button>
                        <button type="button" class="btn btn-alt-secondary" id="dropdown-ecom-filters" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Filters <i class="fa fa-angle-down ms-1"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdown-ecom-filters">
                            <a class="dropdown-item d-flex align-items-center justify-content-between" href="javascript:void(0)">
                                Active
                                <span class="badge bg-success rounded-pill">260</span>
                            </a>
                            <a class="dropdown-item d-flex align-items-center justify-content-between" href="javascript:void(0)">
                                Inactive
                                <span class="badge bg-danger rounded-pill">63</span>
                            </a>
                            <a class="dropdown-item d-flex align-items-center justify-content-between" href="javascript:void(0)">
                                All
                                <span class="badge bg-black-50 rounded-pill">36k</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="block-content">
                <div class="row">
                    <div class="col-md-12 ms-auto text-end">
                        <?php
                        $linkToolBarSave            = URL::createLink( 'backend', $controller, 'form', [ 'type' => 'save' ] );
                        $btnToolBarSave             = Helper::phnCmsButton( 'Save', 'toolbar-save', $linkToolBarSave, 'btn-primary', '<i class="si si-check me-1"></i>', 'submit' );

                        $linkToolBarSaveAndClose    = URL::createLink( 'backend', $controller, 'form', [ 'type' => 'save-close' ] );
                        $btnToolBarSaveAndClose     = Helper::phnCmsButton( 'Save & Close', 'toolbar-save-close', $linkToolBarSaveAndClose, 'btn-info', '<i class="far me-1 fa-save"></i>', 'submit' );

                        $linkToolBarSaveAndNew      = URL::createLink( 'backend', $controller, 'form', [ 'type' => 'save-new' ] );
                        $btnToolBarSaveAndNew       = Helper::phnCmsButton( 'Save & New', 'toolbar-save-new', $linkToolBarSaveAndNew, 'btn-dark', '<i class="fa me-1 fa-save"></i>', 'submit' );

                        $linkToolBarCancel          = URL::createLink( 'backend', $controller, 'index' );
                        $btnToolBarCancel           = Helper::phnCmsButton( 'Cancel', 'toolbar-cancel', $linkToolBarCancel, 'btn-danger', '<i class="fa me-1 fa-times-circle"></i>' );
                        ?>
                        <div class="block block-rounded">
                            <?php echo $btnToolBarSave; ?>
                            <?php echo $btnToolBarSaveAndClose; ?>
                            <?php echo $btnToolBarSaveAndNew; ?>
                            <?php echo $btnToolBarCancel; ?>
                        </div>
                    </div>
                </div>

                <!-- Add Group -->
                <div class="block-content">
                    <!-- Advanced -->
                    <h2 class="content-heading">Advanced</h2>
                    <div class="row items-push">
                        <div class="col-lg-4">
                            <p class="text-muted">You can easily validate any kind of data you like either it is in a normal input, a textarea or a select box</p>
                        </div>
                        <div class="col-lg-8 col-xl-5">
                            <?php echo $rowInputName ?>
                            <?php echo $rowStatus ?>
                            <?php echo $rowGrACP ?>
                            <?php echo $rowInputOrdering ?>
                            <?php echo $rowInputID ?>
                        </div>
                    </div>
                    <!-- END Advanced -->
                    <div class="row items-push">
                        <div class="col-lg-7 offset-lg-4">
                            <?php echo $btnToolBarSave; ?>
                            <?php echo $btnToolBarCancel; ?>
                        </div>
                    </div>
                </div>
                <!-- End Add Group -->
            </div>
            <div><?php echo $inputToken ?></div>
        </div>
        <!-- END All Group -->
    </form>
    <!-- END Page Content -->
</main>