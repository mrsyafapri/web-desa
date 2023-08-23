<?php
class PenggunaController
{
    public function index()
    {
        $model = new PenggunaModel();
        $view = new PenggunaView();
        $view->index($model->selectAll(), "");
    }

    public function add()
    {
        $model = new PenggunaModel();
        $view = new PenggunaView();
        $view->edit($model->select(0));
    }

    public function edit()
    {
        global $app;

        $model = new PenggunaModel();
        $view = new PenggunaView();
        $view->edit($model->select($app->id));
    }

    public function save()
    {
        $model = new PenggunaModel();
        $model->save();
    }

    public function delete()
    {
        global $app;

        $model = new PenggunaModel();
        $model->delete($app->id);
    }
}

class PenggunaModel
{
    public $id = 0;
    public $username = "";
    public $password = "";

    public function selectAll()
    {
        global $app;

        $sql = "SELECT *
                FROM pengguna
                ORDER BY username";
        $result = $app->queryArrayOfObjects($sql);

        return $result;
    }

    public function select($id)
    {
        global $app;

        $sql = "SELECT *
                FROM pengguna
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
        $username = isset($_REQUEST["username"]) ? trim($_REQUEST["username"]) : "";
        $password = isset($_REQUEST["password"]) ? trim($_REQUEST["password"]) : "";

        if ($id == 0) {
            //data tidak ditemukan maka insert
            $sql = "INSERT INTO pengguna (username, password)
                    VALUES (:username, :password)";
            $params = array(
                ":username" => $username,
                ":password" => md5($password),
            );
            $app->query($sql, $params);
        } else {
            //data ditemukan maka update
            $sql = "UPDATE pengguna
                    SET username=:username, password=:password
                    WHERE id=:id";
            $params = array(
                ":id" => $id,
                ":username" => $username,
                ":password" => md5($password),
            );
            $app->query($sql, $params);
        }

        $view = new PenggunaView();
        $view->index($this->selectAll(), "Data pengguna berhasil disimpan");
    }

    public function delete($id)
    {
        global $app;

        $sql = "DELETE FROM pengguna
                WHERE id=:id";
        $params = array(
            ":id" => $id
        );
        $app->query($sql, $params);

        $view = new PenggunaView();
        $view->index($this->selectAll(), "Data pengguna berhasil dihapus", true);
    }
}

class PenggunaView
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
                        <h1 class="m-0">Pengguna</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="<?= $app->siteUrl ?>">Home</a></li>
                            <li class="breadcrumb-item active">Pengguna</li>
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
                                <h3 class="card-title">Entri Pengguna</h3>
                            </div>
                            <form action="<?= $app->siteUrl; ?>/admin/<?= $app->component; ?>/save" method="post">
                                <input type="hidden" name="id" value="<?= $result->id; ?>">
                                <div class=" card-body">
                                    <div class="form-group">
                                        <label for="username" class="form-label">Username:</label>
                                        <input type="text" class="form-control" id="username" name="username" placeholder="Masukkan username" value="<?= $result->username; ?>" required autofocus>
                                    </div>
                                    <div class="form-group">
                                        <label for="password" class="form-label">Password:</label>
                                        <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan password" value="<?= $result->password; ?>" required>
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
                        <h1 class="m-0">Pengguna</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="<?= $app->siteUrl; ?>">Home</a></li>
                            <li class=" breadcrumb-item active">Pengguna</li>
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
                                <div class="card-title">Data Pengguna</div>
                                <div class="card-tools">
                                    <a href="<?php echo $app->siteUrl; ?>/admin/<?php echo $app->component; ?>/add" class="btn btn-primary">Tambah</a>
                                </div>
                            </div>
                            <div class="card-body">
                                <table id="example2" class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Username</th>
                                            <th>Password</th>
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
                                                        <?= $obj->id; ?>
                                                    </td>
                                                    <td>
                                                        <?= $obj->username; ?>
                                                    </td>
                                                    <td>
                                                        <?= str_repeat("*", strlen($obj->password)); ?>
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
}
?>