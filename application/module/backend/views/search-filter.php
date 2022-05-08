<?php
use Yivic\ManhPhucDevBase\Application\Module\Backend\Views\BEViewConfigs\BEViewConfigs;
$xhtmlFilter        = '';
$classCustomSelect  = "custom-select custom-select-sm mr-1";
$styleAttr          = "width: unset";
switch ( BEViewConfigs::controller_mame() ) {
    case 'user':
        $xhtmlFilter .= '<div class="row justify-content-start align-items-end yivic-selectBox-row">';
        $xhtmlFilter .= '    <div class="form-group input-group-sm">';
        $xhtmlFilter .=         Form::select( 'filter_group', $this->slbFilterGroup, $this->params['filter_group'] ?? 'default', ['class' => $classCustomSelect, 'style' => $styleAttr] );
        $xhtmlFilter .= '    </div>';
        $xhtmlFilter .= '</div>';
        break;
} ?>
<div class="card card-default yivicCard">
    <div class="card-header">
        <h3 class="card-title">Search & Filter</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
            </button>
        </div>
    </div>
    <div class="card-body">
        <div class="container-fluid">
            <div class="row justify-content-between align-items-center">
                <div class="area-filter-status mb-2">
                    <?php $currentFilterStatus    = $this->arrParam['filter_status'] ?? 'all'; ?>
                    <?php echo $xhtmlButtonFilter = HTML::showButtonFilter( $this->arrParam['module'], $this->arrParam['controller'], $this->itemsStatusCount, $currentFilterStatus, BEViewConfigs::search_field(), BEViewConfigs::search_value() ); ?>
                </div>
                <div class="area-search mb-2">
                    <form action="" method="GET">
                        <div class="input-group">
                            <?php $xhtmlSearchArea  = HTML::showAreaSearch( $this->arrParam['controller'], BEViewConfigs::search_field(), BEViewConfigs::search_value(), BEViewConfigs::reload_link() ); ?>
                            <?php echo $xhtmlSearchArea; ?>
                        </div>
                    </form>
                </div>
            </div>
            <?= $xhtmlFilter; ?>
        </div>
    </div>
    <!-- /.card-body -->
</div>