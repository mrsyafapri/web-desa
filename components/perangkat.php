<?php
class PerangkatController
{
    public function index()
    {
        $model = new PerangkatModel();
        $view = new PerangkatView();
        $view->index($model->selectAll(), "");
    }

    public function add()
    {
        $model = new PerangkatModel();
        $view = new PerangkatView();
        $view->edit($model->select(0));
    }

    public function edit()
    {
        global $app;

        $model = new PerangkatModel();
        $view = new PerangkatView();
        $view->edit($model->select($app->id));
    }

    public function save()
    {
        $model = new PerangkatModel();
        $model->save();
    }

    public function delete()
    {
        global $app;

        $model = new PerangkatModel();
        $model->delete($app->id);
    }

    public function list()
    {
        $model = new PerangkatModel();
        $view = new PerangkatView();
        $view->list($model->selectAll());
    }
}

class PerangkatModel
{
    public $id = 0;
    public $nama = "";
    public $tempat_lahir = "";
    public $tanggal_lahir = "";
    public $jabatan = "";
    public $alamat = "";
    public $foto = "";
    public $periode_awal = "";
    public $periode_akhir = "";

    public function selectAll()
    {
        global $app;

        $sql = "SELECT *
                FROM perangkat_desa
                ORDER BY nama";
        $result = $app->queryArrayOfObjects($sql);

        return $result;
    }

    public function select($id)
    {
        global $app;

        $sql = "SELECT *
                FROM perangkat_desa
                WHERE id=:id";
        $params = array(
            ":id" => $id
        );
        $result = $app->queryObject($sql, $params);
        if (!$result) {
            // Data baru
            $result = $this;
        }

        return $result;
    }

    public function save()
    {
        global $app;

        $id = isset($_REQUEST["id"]) ? intval($_REQUEST["id"]) : 0;
        $nama = isset($_REQUEST["nama"]) ? $_REQUEST["nama"] : "";
        $tempat_lahir = isset($_REQUEST["tempat_lahir"]) ? $_REQUEST["tempat_lahir"] : "";
        $tanggal_lahir = isset($_REQUEST["tanggal_lahir"]) ? $_REQUEST["tanggal_lahir"] : "";
        $jabatan = isset($_REQUEST["jabatan"]) ? $_REQUEST["jabatan"] : "";
        $alamat = isset($_REQUEST["alamat"]) ? $_REQUEST["alamat"] : "";
        $periode_awal = isset($_REQUEST["periode_awal"]) ? $_REQUEST["periode_awal"] : "";
        $periode_akhir = isset($_REQUEST["periode_akhir"]) ? $_REQUEST["periode_akhir"] : "";

        // File Upload Handling
        $foto = "";
        if (isset($_FILES["foto"]) && $_FILES["foto"]["error"] === UPLOAD_ERR_OK) {
            // Set the destination folder where the uploaded file will be stored
            $uploadDir = "./uploads/perangkat/";

            // Generate a unique filename to prevent overwriting existing files
            $filename = uniqid() . "-" . basename($_FILES["foto"]["name"]);

            // Set the final path of the uploaded file
            $targetPath = $uploadDir . $filename;

            // Move the uploaded file from temporary directory to the target path
            if (move_uploaded_file($_FILES["foto"]["tmp_name"], $targetPath)) {
                $foto = $filename; // Save the filename to the database
            } else {
                // Handle the case when file upload fails
                // You can redirect or display an error message here
                die("File upload failed.");
            }
        }

        if ($id == 0) {
            // data tidak ditemukan maka insert
            $sql = "INSERT INTO perangkat_desa(nama, tempat_lahir, tanggal_lahir, jabatan, alamat, foto, periode_awal, periode_akhir)
                    VALUES(:nama, :tempat_lahir, :tanggal_lahir, :jabatan, :alamat, :foto, :periode_awal, :periode_akhir)";
            $params = array(
                ":nama" => $nama,
                ":tempat_lahir" => $tempat_lahir,
                ":tanggal_lahir" => $tanggal_lahir,
                ":jabatan" => $jabatan,
                ":alamat" => $alamat,
                ":foto" => $foto,
                ":periode_awal" => $periode_awal,
                ":periode_akhir" => $periode_akhir,
            );
            $app->query($sql, $params);
        } else {
            // data ditemukan maka update
            $sql = "UPDATE perangkat_desa
                    SET nama=:nama, tempat_lahir=:tempat_lahir, tanggal_lahir=:tanggal_lahir, jabatan=:jabatan, alamat=:alamat, foto=:foto, periode_awal=:periode_awal, periode_akhir=:periode_akhir
                    WHERE id=:id";
            $params = array(
                ":id" => $id,
                ":nama" => $nama,
                ":tempat_lahir" => $tempat_lahir,
                ":tanggal_lahir" => $tanggal_lahir,
                ":jabatan" => $jabatan,
                ":alamat" => $alamat,
                ":foto" => $foto,
                ":periode_awal" => $periode_awal,
                ":periode_akhir" => $periode_akhir,
            );
            $app->query($sql, $params);
        }

        $view = new PerangkatView();
        $view->index($this->selectAll(), "Data perangkat desa berhasil disimpan.");
    }

    public function delete($id)
    {
        global $app;

        $sql = "DELETE FROM perangkat_desa
                WHERE id=:id";
        $params = array(
            ":id" => $id
        );
        $app->query($sql, $params);

        $view = new PerangkatView();
        $view->index($this->selectAll(), "Data perangkat desa berhasil dihapus.", true);
    }
}

class PerangkatView
{
    public function edit($result)
    {
        global $app;

        if ($app->getUser()->id == 0) {
            header("Location:" . $app->siteUrl);
        }
?>
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Perangkat Desa</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="<?= $app->siteUrl ?>">Home</a></li>
                            <li class=" breadcrumb-item active">Perangkat Desa</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Entri Perangkat Desa</h3>
                            </div>
                            <form action="<?= $app->siteUrl; ?>/admin/<?= $app->component; ?>/save" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="id" value="<?= $result->id; ?>">
                                <div class=" card-body">
                                    <div class="form-group">
                                        <label for="nama" class="form-label">Nama:</label>
                                        <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukkan nama" value="<?= $result->nama; ?>" required autofocus>
                                    </div>
                                    <div class=" form-group">
                                        <label for="tempat_lahir" class="form-label">Tempat Lahir:</label>
                                        <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir" placeholder="Masukkan tempat lahir" value="<?= $result->tempat_lahir; ?>">
                                    </div>
                                    <div class=" form-group">
                                        <label for="tanggal_lahir" class="form-label">Tanggal Lahir:</label>
                                        <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" value="<?= $result->tanggal_lahir; ?>">
                                    </div>
                                    <div class=" form-group">
                                        <label for="jabatan" class="form-label">Jabatan:</label>
                                        <input type="text" class="form-control" id="jabatan" name="jabatan" placeholder="Masukkan jabatan" value="<?= $result->jabatan; ?>" required>
                                    </div>
                                    <div class=" form-group">
                                        <label for="alamat" class="form-label">Alamat:</label>
                                        <textarea class="form-control" id="alamat" name="alamat" placeholder="Masukkan alamat" required><?= $result->alamat; ?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="foto" class="form-label">Foto Profil:</label>
                                        <input type="file" name="foto" id="foto" class="form-control" accept="image/*">
                                    </div>
                                    <div class="form-group">
                                        <label for="periode_awal" class="form-label">Periode Awal Masa Jabatan:</label>
                                        <input type="number" min="0000" max="2099" class="form-control" id="periode_awal" name="periode_awal" placeholder="Masukkan periode awal" value="<?= $result->periode_awal; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="periode_akhir" class="form-label">Periode Akhir Masa Jabatan:</label>
                                        <input type="number" min="0000" max="2099" class="form-control" id="periode_akhir" name="periode_akhir" placeholder="Masukkan periode akhir" value="<?= $result->periode_akhir; ?>">
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                    <a href="<?= $app->siteUrl; ?>/admin/<?= $app->component; ?>" class="btn btn-secondary">Batal</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    <?php
    }

    public function index($result, $message, $isDeleted = false)
    {
        global $app;

        if ($app->getUser()->id == 0) {
            header("Location:" . $app->siteUrl);
        }
    ?>
        <div class="content-header">
            <div class="container-fluid">
                <?php if ($message != "") { ?>
                    <div class="alert <?= $isDeleted ? "alert-danger" : "alert-success"; ?> alert-dismissible fade show" role="alert">
                        <?= $message; ?>
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    </div>
                <?php } ?>
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Perangkat Desa</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item">
                                <a href="<?= $app->siteUrl; ?>">Home</a>
                            </li>
                            <li class=" breadcrumb-item active">Perangkat Desa</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="card-title">Data Perangkat Desa</div>
                                <div class="card-tools">
                                    <a href="<?php echo $app->siteUrl; ?>/admin/<?php echo $app->component; ?>/add" class="btn btn-primary">Tambah</a>
                                </div>
                            </div>
                            <div class="card-body">
                                <table id="example2" class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>Nama</th>
                                            <th>Tempat, Tanggal Lahir</th>
                                            <th>Jabatan</th>
                                            <th>Alamat</th>
                                            <th>Periode Masa Jabatan</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (count($result) > 0) {
                                            foreach ($result as $obj) {
                                        ?>
                                                <tr>
                                                    <td>
                                                        <?= $obj->nama; ?>
                                                    </td>
                                                    <td>
                                                        <?php if ($obj->tempat_lahir != "" && $obj->tanggal_lahir != "") { ?>
                                                            <?= $obj->tempat_lahir; ?>,
                                                            <?= date("d M Y", strtotime($obj->tanggal_lahir)); ?>
                                                        <?php } ?>
                                                    <td>
                                                        <?= $obj->jabatan; ?>
                                                    </td>
                                                    <td>
                                                        <?= $obj->alamat; ?>
                                                    </td>
                                                    <td>
                                                        <?php if ($obj->periode_awal != 0 && $obj->periode_akhir != 0) { ?>
                                                            <?= $obj->periode_awal; ?> -
                                                            <?= $obj->periode_akhir; ?>
                                                        <?php } ?>
                                                    </td>
                                                    <td>
                                                        <a href="<?= $app->siteUrl; ?>/admin/<?= $app->component; ?>/edit/<?= $obj->id; ?>" class="badge btn-info">
                                                            <i class="fas fa-edit"></i> Edit
                                                        </a>
                                                        <a href="javascript:confirmDelete(<?= $obj->id ?>)" class="badge btn-danger tombol-hapus">
                                                            <i class="fas fa-trash"></i> Hapus
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php
                                            }
                                        } else {
                                            ?>
                                            <tr>
                                                <td colspan="6" class="text-center">Tidak ada</td>
                                            </tr>
                                        <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Page specific script -->
        <script>
            $(function() {
                $('#example2').DataTable({
                    "paging": true,
                    "lengthChange": false,
                    "searching": false,
                    "ordering": true,
                    "info": true,
                    "autoWidth": false,
                    "responsive": true,
                });
            });

            function confirmDelete(id) {
                if (confirm("Apakah anda yakin ingin menghapus pengguna ini?")) {
                    window.open("<?= $app->siteUrl; ?>/admin/<?= $app->component; ?>/delete/" + id, '_self');
                }
            }
        </script>
    <?php
    }

    public function list($result)
    {
        global $app;
    ?>
        <section id="jumbotron">
            <div class="p-5 text-center rounded-4" style="background: linear-gradient(rgba(0, 0, 0, 0.60), rgba(0, 0, 0, 0.60)), url('<?= $app->siteUrl; ?>/public/img/bg-perangkat.jpg'); background-repeat:no-repeat;background-size:cover; height: 680px;">
                <div class="mask">
                    <div class="d-flex justify-content-center align-items-center h-100" style="margin-top: 250px;">
                        <div class="text-white">
                            <h1 class="mb-3 fw-bold">Perangkat Desa</h1>
                            <h4 class="mb-3">Berikut adalah perangkat desa yang ada di Desa Teluk Jira</h4>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section id="perangkat">
            <div class="container">
                <div class="row justify-content-center">
                    <?php
                    if (count($result) > 0) {
                        foreach ($result as $obj) {
                    ?>
                            <div class="col-lg-3 col-sm-6 col-12">
                                <!-- START: Card Perangkat -->
                                <div class="card card-cascade my-bg-primary text-white">
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
        </section>
<?php
    }
}
?>