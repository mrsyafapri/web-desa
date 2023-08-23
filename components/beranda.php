<?php
class BerandaController
{
    public function index()
    {
        global $app;

        $view = new BerandaView();
        $model = new BerandaModel();

        $scriptName = basename($_SERVER['SCRIPT_FILENAME']);
        if ($scriptName == "admin.php") {
            $jumlahPengguna = $model->jumlahPengguna();
            $jumlahPerangkat = $model->jumlahPerangkat();
            $jumlahBPD = $model->jumlahBPD();
            $jumlahKegiatan = $model->jumlahKegiatan();
            $view->dashboard($jumlahPengguna, $jumlahPerangkat, $jumlahBPD, $jumlahKegiatan);
        } else {
            $perangkat = $model->getPerangkat();
            $bpd = $model->getBPD();
            $kegiatan = $model->getKegiatan();
            $view->index($perangkat, $bpd, $kegiatan);
        }
    }

    public function logout()
    {
        $model = new BerandaModel();
        $model->logout();
    }
}

class BerandaModel
{
    public function jumlahPengguna()
    {
        global $app;

        $sql = "SELECT COUNT(*) AS jumlah
                FROM pengguna";
        $result = $app->queryObject($sql);
        return $result->jumlah;
    }

    public function jumlahPerangkat()
    {
        global $app;

        $sql = "SELECT COUNT(*) AS jumlah
                FROM perangkat_desa";
        $result = $app->queryObject($sql);
        return $result->jumlah;
    }

    public function jumlahBPD()
    {
        global $app;

        $sql = "SELECT COUNT(*) AS jumlah
                FROM bpd";
        $result = $app->queryObject($sql);
        return $result->jumlah;
    }

    public function jumlahKegiatan()
    {
        global $app;

        $sql = "SELECT COUNT(*) AS jumlah
                FROM kegiatan";
        $result = $app->queryObject($sql);
        return $result->jumlah;
    }

    public function logout()
    {
        global $app;

        $_SESSION = array();
        $_SESSION['user'] = new UserAccount();

        header("Location:" . $app->siteUrl);
    }

    public function getPerangkat()
    {
        global $app;

        $sql = "SELECT *
                FROM perangkat_desa
                ORDER BY nama";
        $result = $app->queryArrayOfObjects($sql);
        return $result;
    }

    public function getBPD()
    {
        global $app;

        $sql = "SELECT *
                FROM bpd
                ORDER BY nama";
        $result = $app->queryArrayOfObjects($sql);
        return $result;
    }

    public function getKegiatan()
    {
        global $app;

        $sql = "SELECT *
                FROM kegiatan
                WHERE publikasi=1
                ORDER BY id DESC";
        $result = $app->queryArrayOfObjects($sql);
        return $result;
    }
}

class BerandaView
{
    public function dashboard($pengguna, $perangkat, $bpd, $kegiatan)
    {
        global $app;
?>
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Selamat Datang
                                <span class="text-bold">
                                    <?= $_SESSION['user']->username; ?>
                                </span>
                            </h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>
                                <?= $pengguna; ?>
                            </h3>
                            <p>Pengguna</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <a href="<?= $app->siteUrl; ?>/admin/pengguna" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>
                                <?= $perangkat; ?>
                            </h3>
                            <p>Perangkat Desa</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-building"></i>
                        </div>
                        <a href="<?= $app->siteUrl; ?>/admin/perangkat" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>
                                <?= $bpd; ?>
                            </h3>
                            <p>Badan Permusyawaratan Desa</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-user-tie"></i>
                        </div>
                        <a href="<?= $app->siteUrl; ?>/admin/bpd" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-pink">
                        <div class="inner">
                            <h3>
                                <?= $kegiatan; ?>
                            </h3>
                            <p>Kegiatan</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-calendar"></i>
                        </div>
                        <a href="<?= $app->siteUrl; ?>/admin/kegiatan" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    <?php
    }

    public function index($perangkat, $bpd, $kegiatan)
    {
        global $app;
    ?>
        <!-- START: Jumbotron -->
        <section id="jumbotron">
            <div class="p-5 text-center rounded-4" style="background: linear-gradient(rgba(0, 0, 0, 0.60), rgba(0, 0, 0, 0.60)), url('<?= $app->siteUrl; ?>/public/img/kantor.jpg'); background-repeat:no-repeat;background-size:cover; height: 680px;">
                <div class="mask">
                    <div class="d-flex justify-content-center align-items-center h-100" style="margin-top: 250px;">
                        <div class="text-white">
                            <h1 class="mb-3 fw-bold">Selamat Datang di Web Desa Teluk Jira</h1>
                            <h4 class="mb-3">Kecamatan Tempuling Kabupaten Indragiri Hilir</h4>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- END: Jumbotron -->
        <!-- START: Profil Desa -->
        <section id="profil">
            <div class="container text-center">
                <div class="row my-3">
                    <div class="col">
                        <h2 class="fw-bold">Profil Desa</h2>
                    </div>
                </div>
                <div class="row justify-content-center mb-5">
                    <div class="col-lg-3 col-sm-6 col-12">
                        <div class="card">
                            <i class="fas fa-water fa-5x my-3"></i>
                            <div class="card-body">
                                <h5 class="card-title">6.600 Ha/M2</h5>
                                <p class="card-text">Luas Desa</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 col-12">
                        <div class="card">
                            <i class="fas fa-calendar fa-5x my-3"></i>
                            <div class="card-body">
                                <h5 class="card-title">1984</h5>
                                <p class="card-text">Tahun Pembentukan</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 col-12">
                        <div class="card">
                            <i class="fas fa-users fa-5x my-3"></i>
                            <div class="card-body">
                                <h5 class="card-title">3218 Jiwa</h5>
                                <p class="card-text">Jumlah Penduduk</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 col-12">
                        <div class="card">
                            <i class="fas fa-house-user fa-5x my-3"></i>
                            <div class="card-body">
                                <h5 class="card-title">864 KK</h5>
                                <p class="card-text">Jumlah Kepala Keluarga</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
                <path fill="#7A9D54" fill-opacity="1" d="M0,32L14.1,64C28.2,96,56,160,85,176C112.9,192,141,160,169,128C197.6,96,226,64,254,58.7C282.4,53,311,75,339,112C367.1,149,395,203,424,229.3C451.8,256,480,256,508,218.7C536.5,181,565,107,593,106.7C621.2,107,649,181,678,176C705.9,171,734,85,762,64C790.6,43,819,85,847,112C875.3,139,904,149,932,133.3C960,117,988,75,1016,96C1044.7,117,1073,203,1101,197.3C1129.4,192,1158,96,1186,69.3C1214.1,43,1242,85,1271,106.7C1298.8,128,1327,128,1355,117.3C1383.5,107,1412,85,1426,74.7L1440,64L1440,320L1425.9,320C1411.8,320,1384,320,1355,320C1327.1,320,1299,320,1271,320C1242.4,320,1214,320,1186,320C1157.6,320,1129,320,1101,320C1072.9,320,1045,320,1016,320C988.2,320,960,320,932,320C903.5,320,875,320,847,320C818.8,320,791,320,762,320C734.1,320,706,320,678,320C649.4,320,621,320,593,320C564.7,320,536,320,508,320C480,320,452,320,424,320C395.3,320,367,320,339,320C310.6,320,282,320,254,320C225.9,320,198,320,169,320C141.2,320,113,320,85,320C56.5,320,28,320,14,320L0,320Z">
                </path>
            </svg>
        </section>
        <!-- END: Profil Desa -->
        <!-- START: List Kegiatan -->
        <section id="perangkat" class="my-bg-secondary">
            <div class="container">
                <div class="row text-center mb-3">
                    <div class="col">
                        <h2 class="fw-bold text-white">Perangkat Desa</h2>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <?php
                    if (count($perangkat) > 0) {
                        foreach ($perangkat as $obj) {
                    ?>
                            <div class="col-lg-3 col-sm-6 col-12">
                                <!-- START: Card Perangkat -->
                                <div class="card card-cascade">
                                    <!-- Card image -->
                                    <div class="view view-cascade overlay">
                                        <img class="card-img-top card-profile-img" src="<?= $app->siteUrl; ?>/uploads/perangkat/<?= $obj->foto; ?>" alt="Card image cap">
                                        <a>
                                            <div class="mask rgba-white-slight"></div>
                                        </a>
                                    </div>
                                    <!-- Card content -->
                                    <div class="card-body card-body-cascade text-center">
                                        <!-- Title -->
                                        <h4 class="card-title fw-bold">
                                            <?= $obj->nama; ?>
                                        </h4>
                                        <!-- Subtitle -->
                                        <h6 class="font-weight-bold indigo-text py-2">
                                            <?= $obj->jabatan; ?>
                                        </h6>
                                    </div>
                                </div>
                                <!-- END: Card Perangkat -->
                            </div>
                    <?php }
                    } ?>
                </div>
            </div>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
                <path fill="#ffffff" fill-opacity="1" d="M0,32L14.1,64C28.2,96,56,160,85,176C112.9,192,141,160,169,128C197.6,96,226,64,254,58.7C282.4,53,311,75,339,112C367.1,149,395,203,424,229.3C451.8,256,480,256,508,218.7C536.5,181,565,107,593,106.7C621.2,107,649,181,678,176C705.9,171,734,85,762,64C790.6,43,819,85,847,112C875.3,139,904,149,932,133.3C960,117,988,75,1016,96C1044.7,117,1073,203,1101,197.3C1129.4,192,1158,96,1186,69.3C1214.1,43,1242,85,1271,106.7C1298.8,128,1327,128,1355,117.3C1383.5,107,1412,85,1426,74.7L1440,64L1440,320L1425.9,320C1411.8,320,1384,320,1355,320C1327.1,320,1299,320,1271,320C1242.4,320,1214,320,1186,320C1157.6,320,1129,320,1101,320C1072.9,320,1045,320,1016,320C988.2,320,960,320,932,320C903.5,320,875,320,847,320C818.8,320,791,320,762,320C734.1,320,706,320,678,320C649.4,320,621,320,593,320C564.7,320,536,320,508,320C480,320,452,320,424,320C395.3,320,367,320,339,320C310.6,320,282,320,254,320C225.9,320,198,320,169,320C141.2,320,113,320,85,320C56.5,320,28,320,14,320L0,320Z">
                </path>
            </svg>
        </section>
        <!-- END: List Kegiatan -->
        <!-- START: List BPD -->
        <section id="bpd">
            <div class="container">
                <div class="row text-center mb-3">
                    <div class="col">
                        <h2 class="fw-bold">Badan Permusyawaratan Desa</h2>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <?php
                    if (count($bpd) > 0) {
                        foreach ($bpd as $obj) {
                    ?>
                            <div class="col-lg-3 col-sm-6 col-12">
                                <!-- START: Card Perangkat -->
                                <div class="card card-cascade my-bg-secondary text-white">
                                    <!-- Card image -->
                                    <div class="view view-cascade overlay">
                                        <img class="card-img-top card-profile-img" src="<?= $app->siteUrl; ?>/uploads/bpd/<?= $obj->foto; ?>" alt="Card image cap">
                                        <a>
                                            <div class="mask rgba-white-slight"></div>
                                        </a>
                                    </div>
                                    <!-- Card content -->
                                    <div class="card-body card-body-cascade text-center">
                                        <!-- Title -->
                                        <h4 class="card-title fw-bold">
                                            <?= $obj->nama; ?>
                                        </h4>
                                        <!-- Subtitle -->
                                        <h6 class="font-weight-bold indigo-text py-2">
                                            <?= $obj->jabatan; ?>
                                        </h6>
                                    </div>
                                </div>
                                <!-- END: Card Perangkat -->
                            </div>
                    <?php }
                    } ?>
                </div>
            </div>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
                <path fill="#7A9D54" fill-opacity="1" d="M0,32L14.1,64C28.2,96,56,160,85,176C112.9,192,141,160,169,128C197.6,96,226,64,254,58.7C282.4,53,311,75,339,112C367.1,149,395,203,424,229.3C451.8,256,480,256,508,218.7C536.5,181,565,107,593,106.7C621.2,107,649,181,678,176C705.9,171,734,85,762,64C790.6,43,819,85,847,112C875.3,139,904,149,932,133.3C960,117,988,75,1016,96C1044.7,117,1073,203,1101,197.3C1129.4,192,1158,96,1186,69.3C1214.1,43,1242,85,1271,106.7C1298.8,128,1327,128,1355,117.3C1383.5,107,1412,85,1426,74.7L1440,64L1440,320L1425.9,320C1411.8,320,1384,320,1355,320C1327.1,320,1299,320,1271,320C1242.4,320,1214,320,1186,320C1157.6,320,1129,320,1101,320C1072.9,320,1045,320,1016,320C988.2,320,960,320,932,320C903.5,320,875,320,847,320C818.8,320,791,320,762,320C734.1,320,706,320,678,320C649.4,320,621,320,593,320C564.7,320,536,320,508,320C480,320,452,320,424,320C395.3,320,367,320,339,320C310.6,320,282,320,254,320C225.9,320,198,320,169,320C141.2,320,113,320,85,320C56.5,320,28,320,14,320L0,320Z">
                </path>
            </svg>
        </section>
        <!-- END: List BPD -->
        <!-- START: List Kegiatan -->
        <section id="kegiatan" class="my-bg-secondary">
            <div class="container">
                <div class="row text-center mb-3">
                    <div class="col">
                        <h2 class="fw-bold text-white">Kegiatan</h2>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <?php
                    if (count($kegiatan) > 0) {
                        foreach ($kegiatan as $obj) {
                    ?>
                            <div class="col-md-3 mb-5">
                                <!-- START: Card Kegiatan -->
                                <a href="<?= $app->siteUrl; ?>/kegiatan/detail/<?= $obj->id; ?>">
                                    <div class="card card-cascade">
                                        <!-- Card image -->
                                        <div class="view view-cascade overlay">
                                            <img class="card-img-top" src="<?= $app->siteUrl; ?>/uploads/kegiatan/<?= $obj->foto; ?>" alt="Card image cap">
                                            <a>
                                                <div class="mask rgba-white-slight"></div>
                                            </a>
                                        </div>
                                        <!-- Card content -->
                                        <div class="card-body card-body-cascade text-center">
                                            <!-- Title -->
                                            <h4 class="card-title fw-bold">
                                                <?= $obj->nama; ?>
                                            </h4>
                                            <!-- Subtitle -->
                                            <h6 class="font-weight-bold indigo-text pt-2">
                                                <i class="fas fa-map-marker-alt"></i>
                                                <?= $obj->lokasi; ?>
                                            </h6>
                                        </div>
                                        <!-- Card footer -->
                                        <div class="card-footer text-muted text-center">
                                            <i class="far fa-calendar-alt"></i>
                                            <?= date("d M Y", strtotime($obj->waktu)); ?>
                                            <br>
                                            <i class="fas fa-clock ml-2"></i>
                                            <?= date("H:i", strtotime($obj->waktu)) . " WIB"; ?>
                                        </div>
                                    </div>
                                </a>
                                <!-- END: Card Kegiatan -->
                            </div>
                    <?php }
                    } ?>
                </div>
            </div>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
                <path fill="#ffffff" fill-opacity="1" d="M0,32L14.1,64C28.2,96,56,160,85,176C112.9,192,141,160,169,128C197.6,96,226,64,254,58.7C282.4,53,311,75,339,112C367.1,149,395,203,424,229.3C451.8,256,480,256,508,218.7C536.5,181,565,107,593,106.7C621.2,107,649,181,678,176C705.9,171,734,85,762,64C790.6,43,819,85,847,112C875.3,139,904,149,932,133.3C960,117,988,75,1016,96C1044.7,117,1073,203,1101,197.3C1129.4,192,1158,96,1186,69.3C1214.1,43,1242,85,1271,106.7C1298.8,128,1327,128,1355,117.3C1383.5,107,1412,85,1426,74.7L1440,64L1440,320L1425.9,320C1411.8,320,1384,320,1355,320C1327.1,320,1299,320,1271,320C1242.4,320,1214,320,1186,320C1157.6,320,1129,320,1101,320C1072.9,320,1045,320,1016,320C988.2,320,960,320,932,320C903.5,320,875,320,847,320C818.8,320,791,320,762,320C734.1,320,706,320,678,320C649.4,320,621,320,593,320C564.7,320,536,320,508,320C480,320,452,320,424,320C395.3,320,367,320,339,320C310.6,320,282,320,254,320C225.9,320,198,320,169,320C141.2,320,113,320,85,320C56.5,320,28,320,14,320L0,320Z">
                </path>
            </svg>
        </section>
        <!-- END: List Kegiatan -->
        <!-- START: Lokasi Desa -->
        <section id="lokasi">
            <div class="container text-center">
                <div class="row my-3">
                    <div class="col">
                        <h2 class="fw-bold">Lokasi Desa</h2>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d255342.9248991319!2d102.894146!3d-0.374261!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e284c032e9c9a85%3A0xa68c5bce1128dfac!2sTlk.%20Jira%2C%20Kec.%20Tempuling%2C%20Kabupaten%20Indragiri%20Hilir%2C%20Riau!5e0!3m2!1sid!2sid!4v1692806184293!5m2!1sid!2sid" width="800" height="600" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
                <div class="row justify-content-center mb-5">
                    <div class="col-lg-3 col-sm-6 col-12">
                        <div class="card">
                            <img src="<?= $app->siteUrl; ?>/public/img/utara.png" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title">Gaung Anak Serka</h5>
                                <p class="card-text">Sebelah Utara</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 col-12">
                        <div class="card">
                            <img src="<?= $app->siteUrl; ?>/public/img/selatan.png" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title">Sungai Indragiri</h5>
                                <p class="card-text">Sebelah Selatan</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 col-12">
                        <div class="card">
                            <img src="<?= $app->siteUrl; ?>/public/img/timur.png" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title">Pangkalan Tujuh</h5>
                                <p class="card-text">Sebelah Timur</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 col-12">
                        <div class="card">
                            <img src="<?= $app->siteUrl; ?>/public/img/barat.png" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title">Mumpa</h5>
                                <p class="card-text">Sebelah Barat</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- END: Lokasi Desa -->
<?php
    }
}
?>