<?php
class BPDController
{
    public function index()
    {
        $model = new BPDModel();
        $view = new BPDView();
        $view->index($model->selectAll(), "");
    }

    public function add()
    {
        $model = new BPDModel();
        $view = new BPDView();
        $view->edit($model->select(0));
    }

    public function edit()
    {
        global $app;

        $model = new BPDModel();
        $view = new BPDView();
        $view->edit($model->select($app->id));
    }

    public function save()
    {
        $model = new BPDModel();
        $model->save();
    }

    public function delete()
    {
        global $app;

        $model = new BPDModel();
        $model->delete($app->id);
    }

    public function list()
    {
        $model = new BPDModel();
        $view = new BPDView();
        $view->list($model->selectAll());
    }
}

class BPDModel
{
    public $id = 0;
    public $nama = "";
    public $jabatan = "";
    public $foto = "";
    public $awal_masa_bakti = "";
    public $akhir_masa_bakti = "";

    public function selectAll()
    {
        global $app;

        $sql = "SELECT *
                FROM bpd
                ORDER BY nama";
        $result = $app->queryArrayOfObjects($sql);

        return $result;
    }

    public function select($id)
    {
        global $app;

        $sql = "SELECT *
                FROM bpd
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
        $jabatan = isset($_REQUEST["jabatan"]) ? $_REQUEST["jabatan"] : "";
        $awal_masa_bakti = isset($_REQUEST["awal_masa_bakti"]) ? $_REQUEST["awal_masa_bakti"] : "";
        $akhir_masa_bakti = isset($_REQUEST["akhir_masa_bakti"]) ? $_REQUEST["akhir_masa_bakti"] : "";

        // File Upload Handling
        $foto = "";
        if (isset($_FILES["foto"]) && $_FILES["foto"]["error"] === UPLOAD_ERR_OK) {
            // Set the destination folder where the uploaded file will be stored
            $uploadDir = "./uploads/bpd/";

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
            $sql = "INSERT INTO bpd(nama, jabatan, foto, awal_masa_bakti, akhir_masa_bakti)
                    VALUES(:nama, :jabatan, :foto, :awal_masa_bakti, :akhir_masa_bakti)";
            $params = array(
                ":nama" => $nama,
                ":jabatan" => $jabatan,
                ":foto" => $foto,
                ":awal_masa_bakti" => $awal_masa_bakti,
                ":akhir_masa_bakti" => $akhir_masa_bakti,
            );
            $app->query($sql, $params);
        } else {
            // data ditemukan maka update
            $sql = "UPDATE bpd
                    SET nama=:nama, jabatan=:jabatan, foto=:foto, awal_masa_bakti=:awal_masa_bakti, akhir_masa_bakti=:akhir_masa_bakti
                    WHERE id=:id";
            $params = array(
                ":id" => $id,
                ":nama" => $nama,
                ":jabatan" => $jabatan,
                ":foto" => $foto,
                ":awal_masa_bakti" => $awal_masa_bakti,
                ":akhir_masa_bakti" => $akhir_masa_bakti,
            );
            $app->query($sql, $params);
        }

        $view = new BPDView();
        $view->index($this->selectAll(), "Data BPD berhasil disimpan.");
    }

    public function delete($id)
    {
        global $app;

        $sql = "DELETE FROM bpd
                WHERE id=:id";
        $params = array(
            ":id" => $id
        );
        $app->query($sql, $params);

        $view = new BPDView();
        $view->index($this->selectAll(), "Data BPD berhasil dihapus.", true);
    }
}

class BPDView
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
                        <h1 class="m-0">Badan Permusyawaratan Desa</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="<?= $app->siteUrl ?>">Home</a></li>
                            <li class=" breadcrumb-item active">Badan Permusyawaratan Desa</li>
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
                                <h3 class="card-title">Entri Badan Permusyawaratan Desa</h3>
                            </div>
                            <form action="<?= $app->siteUrl; ?>/admin/<?= $app->component; ?>/save" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="id" value="<?= $result->id; ?>">
                                <div class=" card-body">
                                    <div class="form-group">
                                        <label for="nama" class="form-label">Nama:</label>
                                        <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukkan nama" value="<?= $result->nama; ?>" required autofocus>
                                    </div>
                                    <div class=" form-group">
                                        <label for="jabatan" class="form-label">Jabatan:</label>
                                        <input type="text" class="form-control" id="jabatan" name="jabatan" placeholder="Masukkan jabatan" value="<?= $result->jabatan; ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="foto" class="form-label">Foto Profil:</label>
                                        <input type="file" name="foto" id="foto" class="form-control" accept="image/*">
                                    </div>
                                    <div class="form-group">
                                        <label for="awal_masa_bakti" class="form-label">Awal Masa Bakti:</label>
                                        <input type="number" min="0000" max="2099" class="form-control" id="awal_masa_bakti" name="awal_masa_bakti" placeholder="Masukkan awal masa bakti" value="<?= $result->awal_masa_bakti; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="akhir_masa_bakti" class="form-label">Akhir Masa Bakti:</label>
                                        <input type="number" min="0000" max="2099" class="form-control" id="akhir_masa_bakti" name="akhir_masa_bakti" placeholder="Masukkan akhir masa bakti" value="<?= $result->akhir_masa_bakti; ?>">
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
                        <h1 class="m-0">Badan Permusyawaratan Desa</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item">
                                <a href="<?= $app->siteUrl; ?>">Home</a>
                            </li>
                            <li class=" breadcrumb-item active">Badan Permusyawaratan Desa</li>
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
                                <div class="card-title">Data Badan Permusyawaratan Desa</div>
                                <div class="card-tools">
                                    <a href="<?php echo $app->siteUrl; ?>/admin/<?php echo $app->component; ?>/add" class="btn btn-primary">Tambah</a>
                                </div>
                            </div>
                            <div class="card-body">
                                <table id="example2" class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>Nama</th>
                                            <th>Jabatan</th>
                                            <th>Masa Bakti</th>
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
                                                        <?= $obj->jabatan; ?>
                                                    </td>
                                                    <td>
                                                        <?= $obj->awal_masa_bakti; ?> -
                                                        <?= $obj->akhir_masa_bakti; ?>
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
                                                <td colspan="4" class="text-center">Tidak ada</td>
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
            <div class="p-5 text-center" style="background: linear-gradient(rgba(0, 0, 0, 0.60), rgba(0, 0, 0, 0.60)), url('<?= $app->siteUrl; ?>/public/img/bg-bpd.png'); background-repeat:no-repeat;background-size:cover; height: 680px;">
                <div class="mask">
                    <div class="d-flex justify-content-center align-items-center h-100" style="margin-top: 250px;">
                        <div class="text-white">
                            <h1 class="mb-3 fw-bold">Badan Permusyawaratan Desa</h1>
                            <h4 class="mb-3">Berikut adalah anggota Badan Permusyawaratan Desa (BPD) Desa Teluk Jira.</h4>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section id="bpd">
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
        </section>
<?php
    }
}
?>