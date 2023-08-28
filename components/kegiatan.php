<?php
class KegiatanController
{
    public function index()
    {
        $model = new KegiatanModel();
        $view = new KegiatanView();
        $view->index($model->selectAll(), "");
    }

    public function add()
    {
        $model = new KegiatanModel();
        $view = new KegiatanView();
        $view->edit($model->select(0));
    }

    public function edit()
    {
        global $app;

        $model = new KegiatanModel();
        $view = new KegiatanView();
        $view->edit($model->select($app->id));
    }

    public function save()
    {
        $model = new KegiatanModel();
        $model->save();
    }

    public function delete()
    {
        global $app;

        $model = new KegiatanModel();
        $model->delete($app->id);
    }

    public function list()
    {
        $model = new KegiatanModel();
        $view = new KegiatanView();
        $view->list($model->selectAllPublikasi());
    }

    public function detail()
    {
        global $app;

        $model = new KegiatanModel();
        $view = new KegiatanView();
        $view->detail($model->select($app->id));
    }
}

class KegiatanModel
{
    public $id = 0;
    public $nama = "";
    public $waktu = "";
    public $lokasi = "";
    public $deskripsi = "";
    public $foto = "";
    public $video = "";
    public $publikasi = 0;

    public function selectAllPublikasi()
    {
        global $app;

        $sql = "SELECT *
                FROM kegiatan
                WHERE publikasi=1
                ORDER BY id DESC";
        $result = $app->queryArrayOfObjects($sql);

        return $result;
    }

    public function selectAll()
    {
        global $app;

        $sql = "SELECT *
                FROM kegiatan
                ORDER BY id DESC";
        $result = $app->queryArrayOfObjects($sql);

        return $result;
    }

    public function select($id)
    {
        global $app;

        $sql = "SELECT *
                FROM kegiatan
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
        $nama = isset($_REQUEST["nama"]) ? trim($_REQUEST["nama"]) : "";
        $waktu = isset($_REQUEST["waktu"]) ? trim($_REQUEST["waktu"]) : "";
        $lokasi = isset($_REQUEST["lokasi"]) ? trim($_REQUEST["lokasi"]) : "";
        $deskripsi = isset($_REQUEST["deskripsi"]) ? trim($_REQUEST["deskripsi"]) : "";
        $video = isset($_REQUEST["video"]) ? trim($_REQUEST["video"]) : "";
        $publikasi = isset($_REQUEST["publikasi"]) ? intval($_REQUEST["publikasi"]) : 0;

        // File Upload Handling
        $foto = "";
        if (isset($_FILES["foto"]) && $_FILES["foto"]["error"] === UPLOAD_ERR_OK) {
            // Set the destination folder where the uploaded file will be stored
            $uploadDir = "./uploads/kegiatan/";

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
            $sql = "INSERT INTO kegiatan (nama, waktu, lokasi, deskripsi, foto, video, publikasi)
                    VALUES (:nama, :waktu, :lokasi, :deskripsi, :foto, :video, :publikasi)";
            $params = array(
                ":nama" => $nama,
                ":waktu" => $waktu,
                ":lokasi" => $lokasi,
                ":deskripsi" => $deskripsi,
                ":foto" => $foto,
                ":video" => $video,
                ":publikasi" => $publikasi,
            );
            $app->query($sql, $params);
        } else {
            // data ditemukan maka update
            if ($foto == "") {
                // foto tidak diubah
                $sql = "UPDATE kegiatan
                    SET nama=:nama, waktu=:waktu, lokasi=:lokasi, deskripsi=:deskripsi, video=:video, publikasi=:publikasi
                    WHERE id=:id";
                $params = array(
                    ":id" => $id,
                    ":nama" => $nama,
                    ":waktu" => $waktu,
                    ":lokasi" => $lokasi,
                    ":deskripsi" => $deskripsi,
                    ":video" => $video,
                    ":publikasi" => $publikasi,
                );
                $app->query($sql, $params);
            } else {
                // foto diubah
                $sql = "UPDATE kegiatan
                    SET nama=:nama, waktu=:waktu, lokasi=:lokasi, deskripsi=:deskripsi, foto=:foto, video=:video, publikasi=:publikasi
                    WHERE id=:id";
                $params = array(
                    ":id" => $id,
                    ":nama" => $nama,
                    ":waktu" => $waktu,
                    ":lokasi" => $lokasi,
                    ":deskripsi" => $deskripsi,
                    ":foto" => $foto,
                    ":video" => $video,
                    ":publikasi" => $publikasi,
                );
                $app->query($sql, $params);
            }
        }

        $view = new KegiatanView();
        $view->index($this->selectAll(), "Data kegiatan berhasil disimpan");
    }

    public function delete($id)
    {
        global $app;

        $sql = "DELETE FROM kegiatan
                WHERE id=:id";
        $params = array(
            ":id" => $id
        );
        $app->query($sql, $params);

        $view = new KegiatanView();
        $view->index($this->selectAll(), "Data kegiatan berhasil dihapus", true);
    }

    public function detail($id)
    {
        global $app;

        $sql = "SELECT *
                FROM kegiatan
                WHERE id=:id";
        $params = array(
            ":id" => $id
        );
        $result = $app->queryObject($sql, $params);

        return $result;
    }
}

class KegiatanView
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
                        <h1 class="m-0">Kegiatan</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="<?= $app->siteUrl; ?>">Home</a></li>
                            <li class="breadcrumb-item active">Kegiatan</li>
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
                                <h3 class="card-title">Entri Kegiatan</h3>
                            </div>
                            <form action="<?= $app->siteUrl; ?>/admin/<?= $app->component; ?>/save" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="id" value="<?= $result->id; ?>">
                                <div class=" card-body">
                                    <div class="form-group">
                                        <label for="nama" class="form-label">Nama Kegiatan: <i class="text-danger">*</i></label>
                                        <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukkan nama kegiatan" value="<?= $result->nama; ?>" required autofocus>
                                    </div>
                                    <div class="form-group">
                                        <label for="waktu" class="form-label">Tanggal Kegiatan: <i class="text-danger">*</i></label>
                                        <input type="datetime-local" class="form-control" id="waktu" name="waktu" placeholder="Masukkan waktu kegiatan" value="<?= $result->waktu; ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="lokasi" class="form-label">Lokasi Kegiatan: <i class="text-danger">*</i></label>
                                        <input type="text" class="form-control" id="lokasi" name="lokasi" placeholder="Masukkan lokasi kegiatan" value="<?= $result->lokasi; ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="deskripsi" class="form-label">Deskripsi Kegiatan: <i class="text-danger">*</i></label>
                                        <textarea id="deskripsi" name="deskripsi" class="form-control" rows="5" placeholder="Masukkan deskripsi kegiatan" required><?= $result->deskripsi; ?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="foto" class="form-label">Foto Kegiatan: <i class="text-danger">*</i></label>
                                        <input type="file" name="foto" id="foto" class="form-control" accept="image/*" <?= $result->id == 0 ? "required" : ""; ?>>
                                    </div>
                                    <div class="form-group">
                                        <label for="video" class="form-label">Video Kegiatan:</label>
                                        <input type="text" class="form-control" id="video" name="video" placeholder="Masukkan link video kegiatan" value="<?= $result->video; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="publikasi" class="form-label">Publikasi: <i class="text-danger">*</i></label>
                                        <input type="checkbox" id="publikasi" class="form-control" name="publikasi" value="1" <?php echo $result->publikasi == 1 ? "checked" : ""; ?> required>
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
        </section>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                $("#publikasi").change(function() {
                    if ($(this).is(":checked")) {
                        $(this).val(1);
                    } else {
                        $(this).val(0);
                    }
                });
            });
        </script>
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
                        <h1 class="m-0">Kegiatan</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="<?= $app->siteUrl; ?>">Home</a></li>
                            <li class=" breadcrumb-item active">Kegiatan</li>
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
                                <div class="card-title">Data Kegiatan</div>
                                <div class="card-tools">
                                    <a href="<?php echo $app->siteUrl; ?>/admin/<?php echo $app->component; ?>/add" class="btn btn-primary">Tambah</a>
                                </div>
                            </div>
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Nama Kegiatan</th>
                                            <th>Tanggal Kegiatan</th>
                                            <th>Lokasi Kegiatan</th>
                                            <th>Publikasi</th>
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
                                                        <?= $obj->waktu; ?>
                                                    </td>
                                                    <td>
                                                        <?= $obj->lokasi; ?>
                                                    </td>
                                                    <td>
                                                        <?= $obj->publikasi == 1 ? "Ya" : "Tidak"; ?>
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
                                                <td colspan="4" class="text-center">Tidak ada data</td>
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
                $("#example1").DataTable({
                    "responsive": true,
                    "lengthChange": false,
                    "autoWidth": false,
                    "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
                }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
            });

            function confirmDelete(id) {
                if (confirm("Apakah Anda yakin ingin menghapus kegiatan ini?")) {
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
            <div class="p-5 text-center rounded-4" style="background: linear-gradient(rgba(0, 0, 0, 0.60), rgba(0, 0, 0, 0.60)), url('<?= $app->siteUrl; ?>/public/img/bg-kegiatan.jpeg'); background-repeat:no-repeat;background-size:cover; height: 680px;">
                <div class="mask">
                    <div class="d-flex justify-content-center align-items-center h-100" style="margin-top: 250px;">
                        <div class="text-white">
                            <h1 class="mb-3 fw-bold">Kegiatan</h1>
                            <h4 class="mb-3">Kegiatan yang dilakukan oleh Desa Teluk Jira</h4>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section id="kegiatan">
            <div class="container">
                <div class="row justify-content-center">
                    <?php
                    if (count($result) > 0) {
                        foreach ($result as $obj) {
                    ?>
                            <div class="col-lg-3 col-sm-6 col-12">
                                <!-- START: Card Kegiatan -->
                                <a href="<?= $app->siteUrl; ?>/kegiatan/detail/<?= $obj->id; ?>">
                                    <div class="card card-cascade my-bg-primary text-white">
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
                                        <div class="card-footer text-white text-center">
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
        </section>
    <?php
    }

    public function detail($result)
    {
        global $app;
    ?>
        <div class="container" style="margin-top: 70px;">
            <div class="row">
                <div class="col-5">
                    <img src="<?= $app->siteUrl; ?>/uploads/kegiatan/<?= $result->foto; ?>" class="img-fluid rounded" alt="Foto Kegiatan">
                    <!-- video url -->
                    <?php
                    if ($result->video != "") {
                    ?>
                        <a href="<?= $result->video; ?>" class="btn btn-primary mt-3" target="_blank">
                            <i class="fab fa-youtube"></i>
                            Lihat Video Kegiatan
                        </a>
                    <?php } ?>
                </div>
                <div class="col-7">
                    <h1 class="fw-bold">
                        <?= $result->nama; ?>
                    </h1>
                    <span class="badge bg-primary">
                        <i class="far fa-calendar-alt"></i>
                        <?= date("d M Y", strtotime($result->waktu)); ?>
                    </span>
                    <span class="badge bg-success">
                        <i class="fas fa-clock ml-2"></i>
                        <?= date("H:i", strtotime($result->waktu)) . " WIB"; ?>
                    </span>
                    <span class="badge bg-secondary">
                        <i class="fas fa-map-marker-alt"></i>
                        <?= $result->lokasi; ?>
                    </span>
                    <p class="mt-3">
                        <?= $result->deskripsi; ?>
                    </p>
                </div>
            </div>
        </div>
<?php
    }
}
?>