<?php
$controller     = @$this->arrParam['controller'];
$module         = @$this->arrParam['module'];
$action         = @$this->arrParam['action'];
$paramsStatus   = !empty( @$this->arrParam['filter_status'] ) ? @$this->arrParam['filter_status'] : 'all';
$columnPost     = ( !empty( $_GET['field'] ) ) ? $_GET['field']   : 'id';
$orderPost 		= ( !empty( $_GET['type'] ) ) ? $_GET['type']    : 'desc';
$paginationHTML = $this->pagination->showPagination( URL::createLink( 'backend', $controller, 'index' ) );
?>
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
                                                <?php $linkInactive	= URL::createLink( $module, $controller, $action, ['filter_status' => 'inactive'] ); ?>
                                                <?php $linkActive	= URL::createLink( $module, $controller, $action, ['filter_status' => 'active'] ); ?>
                                                <?php $linkAll		= URL::createLink( $module, $controller, $action, ['filter_status' => 'all'] ); ?>
                                                <?php $arrFilterStatus= [
                                                    'all' => [
                                                        'name'  => 'All',
                                                        'class' => 'btn-default',
                                                        'link'  => $linkAll,
                                                        'total' => $this->countItem['totalAll']
                                                    ],
                                                    'active'  => [
                                                        'name'  => 'Active',
                                                        'class' => 'btn-default',
                                                        'link'  => $linkActive,
                                                        'total' => $this->countItem['totalActive']
                                                    ],
                                                    'inactive' => [
                                                        'name'  => 'InActive',
                                                        'class' => 'btn-default',
                                                        'link'  => $linkInactive,
                                                        'total' => $this->countItem['totalInactive']
                                                    ]
                                                ]; ?>
                                                <?php $arrFilterStatus[$paramsStatus]['class'] = 'btn-success'; ?>
                                                <?php echo Helper::showFilterStatus( $arrFilterStatus ); ?>
                                            </div>
                                            <div class="area-search mb-2">
                                                <form action="" method="GET">
                                                    <div class="input-group">
                                                        <?php $paramsSearch = !empty( $this->arrParam['search'] ) ? $this->arrParam['search'] : ''; ?>
                                                        <input type="text" class="form-control" name="search" placeholder="Search for" aria-label="search" value="<?php echo $paramsSearch; ?>">
                                                        <span class="input-group-append">
                                                            <button type="button" name="clear" class="btn btn-default">Clear</button>
                                                            <button type="button" name="search" class="btn btn-success">Search</button>
                                                        </span>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <?php
                                        // Select box status
                                        $arrSelectBoxStt = [
                                            'default'   => 'Select status',
                                            'inactive'  => 'Unpublish',
                                            'active'    => 'Publish'
                                        ];
                                        $selectBoxStt       = Helper::cmsSelectBox( 'filter_state', 'form-select', $arrSelectBoxStt, $this->arrParam['filter_state'] ?? '' );

                                        // Select box Group ACP
                                        $arrSelectGrACP     = [
                                            'default'   => 'Select Group ACP',
                                            1           => 'Yes',
                                            0           => 'No'
                                        ];
                                        $selectGrACP        = Helper::cmsSelectBox( 'filter_group_acp', 'form-select', $arrSelectGrACP, $this->arrParam['filter_group_acp'] ?? '' );
                                        ?>
                                        <div class="row justify-content-start align-items-end yivic-selectBox-row">
                                            <div class="form-group">
                                                <select class="form-control">
                                                    <option value="default">Select status</option>
                                                    <option value="0">Publish</option>
                                                    <option value="1">Unpublish</option>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <select class="form-control" disabled>
                                                    <option value="default">Select Group ACP</option>
                                                    <option value="1">Yes</option>
                                                    <option value="0">No</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card-body -->
                            </div>

                            <!-- List -->
                            <div class="card card-default yivicCard">
                                <div class="card-header">
                                    <h3 class="card-title">List</h3>
                                    <div class="card-tools">
                                        <a href="#" class="btn btn-tool" data-card-widget="refresh" onclick="javascript:refreshAll()">
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
                                                <div class="input-group">

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
                                                <a href="group-form.php" class="btn btn-info"><i class="fas fa-plus"></i> Add New</a>
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
                                                            $id             = $value['id'];
                                                            $status         = Helper::cmsStatus( $value['status'], URL::createLink( 'backend', 'group', 'ajaxStatus', [ 'id' => $id, 'status' =>  $value['status'] ] ), $id );
                                                            $gr_acp         = Helper::cmsGroupACP( $value['group_acp'], URL::createLink( 'backend', 'group', 'ajaxACP', [ 'id' => $id, 'group_acp' => $value['group_acp'] ] ), $id );
                                                            $ordering       = '<input id="'.$id.'" type="text" name="order['.$id.']" size="5" value="'.$value['ordering'].'" class="orderingField text-center form-control form-control-alt form-control-sm">';
                                                            $created        = Helper::formatDate( 'd-m-Y', $value['created'] );
                                                            $createdBy      = $value['created_by'];
                                                            $modified       = Helper::formatDate( 'd-m-Y', $value['modified'] );
                                                            $modifiedBy     = $value['modified_by'];
                                                            $linkEdit       = URL::createLink( 'backend', $controller, 'form', [ 'id' => $id ] );

                                                            $linkDelete     = URL::createLink( $this->arrParam['module'], $this->arrParam['controller'], 'trash', ['id' => $id] );
                                                            $buttonAction   = Helper::createButtonAction( array( 'delete' => "javascript:trashSingle('$linkDelete')" ) );

                                                            $str_output .= '<tr>';
                                                            $str_output .= '    <!-- Checkbox -->';
                                                            $str_output .= '    <td class="yivic-adminCol"><input class="yivic-adminCheckbox" type="checkbox" name="cid[]" value="'.$id.'" ></td> <!-- End Checkbox -->';

                                                            $str_output .= '    <!-- ID -->';
                                                            $str_output .= '    <td class="">'.$id.'</td> <!-- End ID -->';

                                                            $str_output .= '    <!-- Title -->';
                                                            $str_output .= '    <td class="text-left td-content">';
                                                            $str_output .= '        <a class="" href="">'.$value['name'].'</a>';
                                                            $str_output .= '    </td> <!-- End Title -->';

                                                            $str_output .= '    <!-- ACP Group -->';
                                                            $str_output .= '    <td>'.$gr_acp.'</td> <!-- End ACP Group -->';

                                                            $str_output .= '    <!-- Status -->';
                                                            $str_output .= '    <td>'.$status.'</td> <!-- End Status -->';

                                                            $str_output .= '    <!-- Ordering -->';
                                                            $str_output .= '    <td>';
                                                            $str_output .= '        '.$ordering.'';
                                                            $str_output .= '    </td> <!-- End Ordering -->';

                                                            $str_output .= '    <!-- Created -->';
                                                            $str_output .= '    <td>';
                                                            $str_output .= '        <p class="mb-0"><i class="far fa-user"></i> '.$createdBy.'</p>';
                                                            $str_output .= '        <p class="mb-0"><i class="far fa-clock"></i> '.$created.'</p>';
                                                            $str_output .= '    </td> <!-- End Created -->';

                                                            $str_output .= '     <!-- Modified -->';
                                                            $str_output .= '    <td>';
                                                            $str_output .= '        <p class="mb-0"><i class="far fa-user"></i> '.$modifiedBy.'</p>';
                                                            $str_output .= '        <p class="mb-0"><i class="far fa-clock"></i> '.$modified.'</p>';
                                                            $str_output .= '    </td> <!-- End Modified -->';

                                                            $str_output .= '    <!-- Action -->';
                                                            $str_output .= '    <td>';
                                                            $str_output .= '        <a href="'.$linkEdit.'" class="btn btn-info btn-sm rounded-circle yivic-btnSM"><i class="fas fa-pen"></i></a>';
                                                            $str_output .= '        '.$buttonAction.'';
                                                            $str_output .= '    </td> <!-- End Action -->';

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