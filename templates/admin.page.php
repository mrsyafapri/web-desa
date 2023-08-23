<?php
global $app, $content;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <meta name="description" content="Web Desa Teluk Jira">
    <meta name="author" content="KKN UIN SUSKA Riau 2023">

    <title>Admin - <?= $app->siteName; ?>
    </title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= $app->siteUrl; ?>/public/plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="<?= $app->siteUrl; ?>/public/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="<?= $app->siteUrl; ?>/public/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- JQVMap -->
    <link rel="stylesheet" href="<?= $app->siteUrl; ?>/public/plugins/jqvmap/jqvmap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= $app->siteUrl; ?>/public/css/adminlte.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="<?= $app->siteUrl; ?>/public/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="<?= $app->siteUrl; ?>/public/plugins/daterangepicker/daterangepicker.css">
    <!-- summernote -->
    <link rel="stylesheet" href="<?= $app->siteUrl; ?>/public/plugins/summernote/summernote-bs4.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="<?= $app->siteUrl; ?>/public/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="<?= $app->siteUrl; ?>/public/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="<?= $app->siteUrl; ?>/public/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">

    <!-- jQuery -->
    <script src="<?= $app->siteUrl; ?>/public/plugins/jquery/jquery.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="<?= $app->siteUrl; ?>/public/plugins/jquery-ui/jquery-ui.min.js"></script>

    <!-- Favicon -->
    <link rel="shortcut icon" href="<?= $app->siteUrl; ?>/public/img/logo.png" type="image/x-icon">
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <!-- Modal -->
    <div class="modal fade" id="loginModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Apakah Anda yakin ingin logout?</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-footer justify-content-right">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak</button>
                    <a type="button" href="<?php echo $app->siteUrl; ?>/admin/Beranda/logout" class="btn btn-danger">Logout</a>
                </div>
            </div>
        </div>
    </div>
    <div class="wrapper">
        <!-- Preloader -->
        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="<?= $app->siteUrl; ?>/public/img/logo.png" alt="logo" width="80">
        </div>

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="<?php echo $app->siteUrl; ?>" class="nav-link">Home</a>
                </li>
            </ul>
        </nav>

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="<?php echo $app->siteUrl; ?>/admin.php" class="brand-link">
                <img src="<?= $app->siteUrl; ?>/public/img/logo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">Desa Teluk Jira</span>
            </a>
            <!-- Sidebar -->
            <div class="sidebar">
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="<?= $app->siteUrl; ?>/public/img/avatar.png" class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info">
                        <a href="#" class="d-block">
                            <?= $app->getUser()->username; ?>
                        </a>
                    </div>
                </div>
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <li class="nav-item">
                            <a href="<?php echo $app->siteUrl; ?>/admin.php" class="nav-link">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    Dashboard
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo $app->siteUrl; ?>/admin/pengguna" class="nav-link">
                                <i class="nav-icon fas fa-users"></i>
                                <p>Pengguna</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo $app->siteUrl; ?>/admin/perangkat" class="nav-link">
                                <i class="nav-icon fas fa-user-tie"></i>
                                <p>Perangkat Desa</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo $app->siteUrl; ?>/admin/bpd" class="nav-link">
                                <i class="nav-icon fas fa-user-tie"></i>
                                <p>BPD</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo $app->siteUrl; ?>/admin/kegiatan" class="nav-link">
                                <i class="nav-icon fas fa-calendar-alt"></i>
                                <p>Kegiatan</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link" data-toggle="modal" data-target="#loginModal">
                                <i class="nav-icon fas fa-sign-out-alt"></i>
                                <p>Logout</p>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>

        <!-- START: Content -->
        <div class="content-wrapper">
            <?= $content; ?>
        </div>
        <!-- END: Content -->

        <!-- START: Footer -->
        <footer class="main-footer">
            <strong>Copyright &copy;
                <?= date('Y'); ?> <a href="<?= $app->siteUrl; ?>">Desa Teluk Jira</a>.
            </strong> All rights reserved.
        </footer>
        <!-- END: Footer -->
    </div>

    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>
    <!-- Bootstrap 4 -->
    <script src="<?= $app->siteUrl; ?>/public/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- ChartJS -->
    <script src="<?= $app->siteUrl; ?>/public/plugins/chart.js/Chart.min.js"></script>
    <!-- Sparkline -->
    <script src="<?= $app->siteUrl; ?>/public/plugins/sparklines/sparkline.js"></script>
    <!-- JQVMap -->
    <script src="<?= $app->siteUrl; ?>/public/plugins/jqvmap/jquery.vmap.min.js"></script>
    <script src="<?= $app->siteUrl; ?>/public/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
    <!-- jQuery Knob Chart -->
    <script src="<?= $app->siteUrl; ?>/public/plugins/jquery-knob/jquery.knob.min.js"></script>
    <!-- daterangepicker -->
    <script src="<?= $app->siteUrl; ?>/public/plugins/moment/moment.min.js"></script>
    <script src="<?= $app->siteUrl; ?>/public/plugins/daterangepicker/daterangepicker.js"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="<?= $app->siteUrl; ?>/public/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
    <!-- Summernote -->
    <script src="<?= $app->siteUrl; ?>/public/plugins/summernote/summernote-bs4.min.js"></script>
    <!-- overlayScrollbars -->
    <script src="<?= $app->siteUrl; ?>/public/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
    <!-- AdminLTE App -->
    <script src="<?= $app->siteUrl; ?>/public/js/adminlte.js"></script>
    <!-- DataTables  & Plugins -->
    <script src="<?= $app->siteUrl; ?>/public/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="<?= $app->siteUrl; ?>/public/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="<?= $app->siteUrl; ?>/public/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="<?= $app->siteUrl; ?>/public/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="<?= $app->siteUrl; ?>/public/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="<?= $app->siteUrl; ?>/public/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="<?= $app->siteUrl; ?>/public/plugins/jszip/jszip.min.js"></script>
    <script src="<?= $app->siteUrl; ?>/public/plugins/pdfmake/pdfmake.min.js"></script>
    <script src="<?= $app->siteUrl; ?>/public/plugins/pdfmake/vfs_fonts.js"></script>
    <script src="<?= $app->siteUrl; ?>/public/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="<?= $app->siteUrl; ?>/public/plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="<?= $app->siteUrl; ?>/public/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
</body>

</html>