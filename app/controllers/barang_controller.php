<?php
// app/controllers/barang_controller.php

require_once '../app/models/barang_model.php';

class BarangController {
    private $model;

    public function __construct($db_connection) {
        $this->model = new BarangModel($db_connection);
    }

    // 1. Halaman Depan Publik (Katalog)
    public function index() {
        $barang_list = $this->model->getAll();
        require_once '../app/views/home.php';
    }

    // 2. Halaman Admin: Daftar Inventaris
    public function adminIndex() {
        if (!isset($_SESSION['user_id'])) { header("Location: index.php?action=login"); exit(); }
        $barang_list = $this->model->getAll();
        require_once '../app/views/barang/index.php';
    }

    // 3. Halaman Admin: Tambah Data
    public function create() {
        if (!isset($_SESSION['user_id'])) { header("Location: index.php?action=login"); exit(); }
        $error_msg = "";

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $nama_barang = trim($_POST['nama_barang']);
            $kategori = $_POST['kategori'];
            $harga = $_POST['harga'];
            $jumlah = $_POST['jumlah'];
            $deskripsi = trim($_POST['deskripsi']);

            if (empty($nama_barang)) {
                $error_msg = "Nama model tidak boleh kosong.";
            } elseif (!is_numeric($harga) || $harga < 0) {
                $error_msg = "Harga harus berupa angka valid dan tidak boleh negatif.";
            } elseif (!is_numeric($jumlah) || $jumlah < 0) {
                $error_msg = "Jumlah stok harus berupa angka valid dan tidak boleh negatif.";
            } else {
                $gambar_path_db = NULL;
                // Logika Upload Gambar (Berjalan di folder public/)
                if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === UPLOAD_ERR_OK) {
                    $file_ext = strtolower(pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION));
                    $allowed_ext = ['jpg', 'jpeg', 'png'];

                    if (!in_array($file_ext, $allowed_ext)) {
                        $error_msg = "Gagal: Hanya format JPG, JPEG, PNG.";
                    } elseif ($_FILES['gambar']['size'] > 2097152) {
                        $error_msg = "Gagal: Ukuran gambar maksimal 2MB.";
                    } else {
                        $nama_unik = uniqid() . '_' . basename($_FILES['gambar']['name']);
                        $lokasi_simpan = 'uploads/' . $nama_unik; 
                        $gambar_path_db = 'uploads/' . $nama_unik;

                        if (!move_uploaded_file($_FILES['gambar']['tmp_name'], $lokasi_simpan)) {
                            $error_msg = "Gagal memindahkan file ke server.";
                        }
                    }
                }

                if (empty($error_msg)) {
                    $data = [
                        'nama_barang' => $nama_barang, 'kategori' => $kategori,
                        'harga' => $harga, 'jumlah' => $jumlah,
                        'deskripsi' => $deskripsi, 'gambar' => $gambar_path_db
                    ];
                    $this->model->save($data);
                    header("Location: index.php?action=barang");
                    exit();
                }
            }
        }
        require_once '../app/views/barang/create.php';
    }

    // 4. Halaman Admin: Edit Data
    public function edit() {
        if (!isset($_SESSION['user_id'])) { header("Location: index.php?action=login"); exit(); }
        $id = $_GET['id'];
        $data_barang = $this->model->getById($id);
        $error_msg = "";

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $nama_barang = trim($_POST['nama_barang']);
            $kategori = $_POST['kategori'];
            $harga = $_POST['harga'];
            $jumlah = $_POST['jumlah'];
            $deskripsi = trim($_POST['deskripsi']);

            if (empty($nama_barang) || !is_numeric($harga) || !is_numeric($jumlah) || $harga < 0 || $jumlah < 0) {
                $error_msg = "Validasi gagal. Periksa kembali input Anda.";
            } else {
                $gambar_path_db = $data_barang['gambar'];

                if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === UPLOAD_ERR_OK) {
                    $file_ext = strtolower(pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION));
                    if (in_array($file_ext, ['jpg', 'jpeg', 'png']) && $_FILES['gambar']['size'] <= 2097152) {
                        // Hapus file lama jika ada
                        if (!empty($data_barang['gambar']) && file_exists($data_barang['gambar'])) {
                            unlink($data_barang['gambar']);
                        }
                        $nama_unik = uniqid() . '_' . basename($_FILES['gambar']['name']);
                        $gambar_path_db = 'uploads/' . $nama_unik;
                        move_uploaded_file($_FILES['gambar']['tmp_name'], $gambar_path_db);
                    } else {
                        $error_msg = "Format/ukuran gambar tidak valid.";
                    }
                }

                if (empty($error_msg)) {
                    $data = [
                        'nama_barang' => $nama_barang, 'kategori' => $kategori,
                        'harga' => $harga, 'jumlah' => $jumlah,
                        'deskripsi' => $deskripsi, 'gambar' => $gambar_path_db
                    ];
                    $this->model->update($id, $data);
                    header("Location: index.php?action=barang");
                    exit();
                }
            }
        }
        require_once '../app/views/barang/edit.php';
    }

    // 5. Halaman Admin: Hapus Data
    public function destroy() {
        if (!isset($_SESSION['user_id'])) { header("Location: index.php?action=login"); exit(); }
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $data_barang = $this->model->getById($id);

            // Hapus fisik gambar
            if($data_barang && !empty($data_barang['gambar']) && file_exists($data_barang['gambar'])) {
                unlink($data_barang['gambar']);
            }
            $this->model->delete($id);
        }
        header("Location: index.php?action=barang");
        exit();
    }
}
?>