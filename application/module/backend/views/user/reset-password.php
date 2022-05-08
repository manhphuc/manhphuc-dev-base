<?php
$id             = $this->item['id'];
$username       = $this->item['username'];
$email          = $this->item['email'];
$fullname       = $this->item['fullname'];
$newPassword    = Helper::randomString( 12 );
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
                    <form action="" method="post">
                        <div class="card card-default yivicCard">
                            <div class="card-header"></div>
                            <div class="card-body">
                                <div class="form-group row align-items-center">
                                    <label class="col-sm-2 col-form-label text-sm-right">ID</label>
                                    <div class="col-sm-8">
                                        <p class="form-control form-control-sm bg-light mb-0"><?= $id ?></p>
                                    </div>
                                </div>
                                <div class="form-group row align-items-center">
                                    <label class="col-sm-2 col-form-label text-sm-right">Username</label>
                                    <div class="col-sm-8">
                                        <p class="form-control form-control-sm bg-light mb-0"><?= $username ?></p>
                                    </div>
                                </div>
                                <div class="form-group row align-items-center">
                                    <label class="col-sm-2 col-form-label text-sm-right">Email</label>
                                    <div class="col-sm-8">
                                        <p class="form-control form-control-sm bg-light mb-0"><?= $email ?></p>
                                    </div>
                                </div>
                                <div class="form-group row align-items-center">
                                    <label class="col-sm-2 col-form-label text-sm-right">Fullname</label>
                                    <div class="col-sm-8">
                                        <p class="form-control form-control-sm bg-light mb-0"><?= $fullname ?></p>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label text-sm-right">New Password</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control form-control-sm mb-0" name="new-password" readonly value="<?= $newPassword ?>">
                                        <button type="submit" class="btn btn-sm btn-success mt-2">Save</button>
                                        <a href="" class="btn btn-sm btn-info mt-2"><i class="fas fa-sync-alt"></i> Generate Password</a>
                                    </div>
                                </div>
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