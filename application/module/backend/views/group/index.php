<?php
use Yivic\ManhPhucDevBase\Application\Module\Backend\Views\BEViewConfigs\BEViewConfigs;
require_once MODULE_PATH . 'backend/views/config.php';
$userInfo = Session::get('user')['info'];

$controller     = @$this->arrParam['controller'];
$module         = @$this->arrParam['module'];
$action         = @$this->arrParam['action'];
$paramsStatus   = !empty( @$this->arrParam['filter_status'] ) ? @$this->arrParam['filter_status'] : 'all';
$columnPost     = ( !empty( $_GET['field'] ) ) ? $_GET['field']   : 'id';
$orderPost 		= ( !empty( $_GET['type'] ) ) ? $_GET['type']    : 'desc';
$paginationHTML = $this->pagination->showPagination( URL::createLink( 'backend', $controller, 'index' ) ); ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <?php require_once ''.TEMPLATE_PATH . 'admin/yivic-admin-theme/html/page-header.php'; ?>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <?php $bulkAction     = URL::createLink( $this->arrParam['module'], $this->arrParam['controller'], 'bulk' ); ?>
                    <form class="content" action="<?php echo $bulkAction; ?>" method="post" name="adminForm" id="adminForm">
                        <div class="yivic-allBlockForm" >
                            <!-- Search & Filter -->
                            <?php require_once MODULE_PATH . 'backend/views/search-filter.php'; ?>

                            <!-- List -->
                            <div class="card card-default yivicCard">
                                <div class="card-header">
                                    <h3 class="card-title">List</h3>
                                    <div class="card-tools">
                                        <a href="<?= BEViewConfigs::reload_link() ?>" class="btn btn-tool" data-card-widget="refresh"">
                                            <i class="fas fa-sync-alt"></i>
                                        </a>
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="container-fluid">
                                        <div class="row align-items-center justify-content-between mb-2">
                                            <div>
                                                <div class="input-group input-group-sm">

                                                    <select class="form-control custom-select" name="action_choose">
                                                        <option value="default">Bulk Action</option>
                                                        <option value="active">Active</option>
                                                        <option value="inactive">InActive</option>
                                                        <option value="ordering">Change Ordering</option>
                                                        <option value="delete">Delete</option>
                                                    </select>

                                                    <span class="input-group-append">
                                                        <button type="submit" name="apply" id="apply" class="btn btn-info">Apply</button>
                                                    </span>

                                                </div>
                                            </div>
                                            <div>
                                                <a href="<?php echo BEViewConfigs::add_new_link(); ?>" class="btn btn-sm btn-info"><i class="fas fa-plus"></i> Add New</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="table-responsive">
                                        <div id="yivicTableAjax_wrapper" class="dataTables_wrapper">

                                            <table id="yivicTableAjax-ordering" class="table table-bordered table-striped" >
                                                <thead>
                                                    <tr>
                                                        <th data-priority="1" class="text-center yivic-adminCol" width="30px"><input type="checkbox" class="pointer yivic-adminCheckbox" id="checkAll" name="checkAll"></th>
                                                        <?php echo $tHeadID          = Helper::cmsLinkSort( 'ID', 'id', $columnPost, $orderPost, ['class' => 'text-center'] ); ?>
                                                        <?php echo $tHeadName        = Helper::cmsLinkSort( 'Name', 'name', $columnPost, $orderPost, ['class' => 'text-left td-content', 'priority' => 2] ); ?>
                                                        <?php echo $tHeadGrACP       = Helper::cmsLinkSort( 'Group ACP', 'group_acp', $columnPost, $orderPost, ['style'=> 'width: 110', 'class' => 'text-center'] ); ?>
                                                        <?php echo $tHeadStatus      = Helper::cmsLinkSort( 'Status', 'status', $columnPost, $orderPost, ['style'=> 'width: 100', 'class' => 'text-center'] ); ?>
                                                        <?php echo $tHeadOrdering    = Helper::cmsLinkSort( 'Ordering', 'ordering', $columnPost, $orderPost, ['style'=> 'width: 100', 'class' => 'text-center'] ); ?>
                                                        <?php echo $tHeadCreated     = Helper::cmsLinkSort( 'Created', 'created', $columnPost, $orderPost, ['class' => 'text-center'] ); ?>
                                                        <?php echo $tHeadModified    = Helper::cmsLinkSort( 'Modified', 'modified', $columnPost, $orderPost, ['class' => 'text-center'] ); ?>
                                                        <th class="text-center" width="30px">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="text-center">
                                                    <?php $str_output = '';
                                                    if ( !empty( $this->Items ) ) {
                                                        foreach ( $this->Items as $key => $value ) {
                                                            $id             = Helper::highlight( $value['id'], BEViewConfigs::search_field(), BEViewConfigs::search_value(), 'id' );
                                                            $title          = Helper::highlight( $value['name'], BEViewConfigs::search_field(), BEViewConfigs::search_value(), 'name' );
                                                            $status         = Helper::cmsStatus( $value['status'], URL::createLink( 'backend', 'group', 'ajaxStatus', [ 'id' => $id, 'status' =>  $value['status'] ] ), $id );
                                                            $gr_acp         = Helper::cmsGroupACP( $value['group_acp'], URL::createLink( 'backend', 'group', 'ajaxACP', [ 'id' => $id, 'group_acp' => $value['group_acp'] ] ), $id );
                                                            $ordering       = '<input id="'.$id.'" type="text" name="order['.$id.']" size="5" value="'.$value['ordering'].'" class="orderingField text-center form-control form-control-alt form-control-sm">';
                                                            $created_by     = json_decode( $value['created_by'] );
                                                            $createdBy      = HTML::showItemHistory( $created_by->username ?? '', $value['created'] );
                                                            $modified_by    = json_decode( $value['modified_by'] );
                                                            $modifiedBy     = HTML::showItemHistory( $modified_by->username ?? '', $value['modified'] );
                                                            $actionButton   = HTML::showActionButton( BEViewConfigs::module_name(), BEViewConfigs::controller_mame() , $value['id'] );

                                                            $str_output .= '<tr>';
                                                            $str_output .= '    <!-- Checkbox -->';
                                                            $str_output .= '    <td class="yivic-adminCol"><input class="yivic-adminCheckbox" type="checkbox" name="cid[]" value="'.$id.'" ></td> <!-- End Checkbox -->';

                                                            $str_output .= '    <!-- ID -->';
                                                            $str_output .= '    <td class="">'.$id.'</td> <!-- End ID -->';

                                                            $str_output .= '    <!-- Title -->';
                                                            $str_output .= '    <td class="text-left td-content">';
                                                            $str_output .= '        <a class="" href="">'.$title.'</a>';
                                                            $str_output .= '    </td> <!-- End Title -->';

                                                            $str_output .= '    <!-- ACP Group -->';
                                                            $str_output .= '    <td>'.$gr_acp.'</td> <!-- End ACP Group -->';

                                                            $str_output .= '    <!-- Status -->';
                                                            $str_output .= '    <td>'.$status.'</td> <!-- End Status -->';

                                                            $str_output .= '    <!-- Ordering -->';
                                                            $str_output .= '    <td class="position-relative">';
                                                            $str_output .= '        '.$ordering.'';
                                                            $str_output .= '    </td> <!-- End Ordering -->';

                                                            $str_output .= '    <!-- Created -->';
                                                            $str_output .= '    <td>'.$createdBy.'</td><!-- End Created -->';

                                                            $str_output .= '     <!-- Modified -->';
                                                            $str_output .= '    <td>'.$modifiedBy.'</td> <!-- End Modified -->';

                                                            $str_output .= '    <!-- Action -->';
                                                            $str_output .= '    <td>'.$actionButton.'</td> <!-- End Action -->';
                                                            $str_output .= '</tr>';
                                                        }
                                                        echo $str_output;
                                                    } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer clearfix">
                                    <div class="row">
                                        <div class="col-sm-12 col-md-12">
                                            <?php echo $paginationHTML ?>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div>
                                <input type="hidden" name="filter_column" value="name" />
                                <input type="hidden" name="filter_page" value="1" />
                                <input type="hidden" name="filter_column_dir" value="desc" />
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>