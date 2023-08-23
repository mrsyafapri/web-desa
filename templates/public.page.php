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

    <title><?= $app->siteName; ?></title>

    <link rel="shortcut icon" type="image/png" href="<?= $app->siteUrl; ?>/public/img/logo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="<?= $app->siteUrl ?>/public/css/style.css">
</head>

<body>
    <!-- START: Header -->
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark my-bg-primary fixed-top">
            <div class="container">
                <img src="<?= $app->siteUrl ?>/public/img/logo.png" alt="logo" height="25" class="me-2">
                <a class="navbar-brand text-bold" href="<?= $app->siteUrl ?>">Desa Teluk Jira</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link text-white" aria-current="page" href="<?= $app->siteUrl ?>">Beranda</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="<?= $app->siteUrl ?>/perangkat/list">Perangkat
                                Desa</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="<?= $app->siteUrl ?>/bpd/list">Badan Permusyawaratan
                                Desa</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="<?= $app->siteUrl ?>/kegiatan/list">Kegiatan</a>
                        </li>
                        <?php if ($app->getUser()->id == 0) { ?>
                            <li class="nav-item">
                                <a class="nav-link text-white" href="<?= $app->siteUrl ?>/login.php">
                                    <i class="fas fa-sign-in-alt"></i>
                                </a>
                            </li>
                        <?php } else {
                        ?>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-user"></i>
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <li><a class="dropdown-item" href="<?= $app->siteUrl ?>/admin.php">Admin</a></li>
                                    <li><a class="dropdown-item" href="<?php echo $app->siteUrl; ?>/admin/Beranda/logout">Logout</a>
                                    </li>
                                </ul>
                            </li>
                        <?php
                        } ?>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <!-- END: Header -->

    <!-- START: Content area -->
    <main>
        <?= $content; ?>
    </main>
    <!-- END: Content area -->

    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
        <path fill="#7A9D54" fill-opacity="1" d="M0,96L20,122.7C40,149,80,203,120,229.3C160,256,200,256,240,240C280,224,320,192,360,186.7C400,181,440,203,480,186.7C520,171,560,117,600,90.7C640,64,680,64,720,69.3C760,75,800,85,840,122.7C880,160,920,224,960,250.7C1000,277,1040,267,1080,229.3C1120,192,1160,128,1200,122.7C1240,117,1280,171,1320,186.7C1360,203,1400,181,1420,170.7L1440,160L1440,320L1420,320C1400,320,1360,320,1320,320C1280,320,1240,320,1200,320C1160,320,1120,320,1080,320C1040,320,1000,320,960,320C920,320,880,320,840,320C800,320,760,320,720,320C680,320,640,320,600,320C560,320,520,320,480,320C440,320,400,320,360,320C320,320,280,320,240,320C200,320,160,320,120,320C80,320,40,320,20,320L0,320Z">
        </path>
    </svg>
    <!-- START: Footer -->
    <footer class="my-bg-secondary text-white">
        <div class="container p-4">
            <div class="row">
                <!-- START: Info Desa -->
                <div class="col-xl-4 col-lg-3 col-md-12 mb-4 mb-md-0">
                    <h6 class="text-uppercase fw-bold mb-3">Desa Teluk Jira</h6>
                    <p>Teluk Jira merupakan salah satu desa yang ada di kecamatan Tempuling, Kabupaten Indragiri Hilir,
                        provinsi Riau, Indonesia.</p>
                </div>
                <!-- END: Info Desa -->
                <!-- START: Lokasi -->
                <div class="col-xl-5 col-lg-6 col-md-12 mb-4 mb-md-0">
                    <h6 class="text-uppercase fw-bold mb-3">Lokasi</h6>
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d127671.46244883817!2d102.8941459!3d-0.37426105!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e284c032e9c9a85%3A0xa68c5bce1128dfac!2sTlk.%20Jira%2C%20Kec.%20Tempuling%2C%20Kabupaten%20Indragiri%20Hilir%2C%20Riau!5e0!3m2!1sid!2sid!4v1692426341541!5m2!1sid!2sid" width="400" height="300" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
                <!-- END: Lokasi -->
                <!-- START: Kontak -->
                <div class="col-xl-3 col-lg-3 col-md-12 mb-4 mb-md-0">
                    <h6 class="text-uppercase fw-bold mb-3">Kontak</h6>
                    <p><i class="fas fa-home me-3"></i> Jl. Propinsi, Teluk Jira, Tempuling, Kabupaten Indragiri
                        Hilir, Riau 29261</p>
                    <p>
                        <i class="fas fa-envelope me-3"></i>
                        <a href="mailto:telukjira@gmail.com" class="text-white">telukjira@gmail.com</a>
                    </p>
                    <p><i class="fas fa-phone me-3"></i> +62 852-6383-0000</p>
                </div>
                <!-- END: Kontak -->
            </div>
        </div>
        <!-- START: Copyright -->
        <div class="text-center p-3 my-bg-primary">
            Copyright &copy;
            <?= date('Y'); ?> -
            <?= $app->siteName; ?>
        </div>
        <!-- END: Copyright -->
    </footer>
    <!-- END: Footer -->

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.min.js" integrity="sha384-Rx+T1VzGupg4BHQYs2gCW9It+akI2MM/mndMCy36UVfodzcJcF0GGLxZIzObiEfa" crossorigin="anonymous"></script>
</body>

</html>