<?php
class MahasiswaController extends Controller {
    private $mahasiswa;

    public function __construct() {
        $db = (new Database())->getConnection();
        $this->mahasiswa = new Mahasiswa($db);
    }

    public function index() {
        try {
            $stmt = $this->mahasiswa->getAll();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $this->success($result, 'Data mahasiswa berhasil diambil');
        } catch (Exception $e) {
            $this->error('Gagal mengambil data: ' . $e->getMessage(), 500);
        }
    }

    public function show($id) {
        try {
            $this->mahasiswa->id = (int)$id;
            $result = $this->mahasiswa->getById();
            if ($result) {
                $this->success($result, 'Data mahasiswa ditemukan');
            } else {
                $this->error('Data mahasiswa tidak ditemukan', 404);
            }
        } catch (Exception $e) {
            $this->error('Gagal mengambil data: ' . $e->getMessage(), 500);
        }
    }

    public function create() {
        $input = $this->getJsonInput();
        if (!$input) {
            $this->error('Data JSON tidak valid', 400);
        }
        $this->validateRequired($input, ['nim', 'nama']);
        $input = $this->sanitize($input);
        $this->mahasiswa->nim = $input['nim'];
        $this->mahasiswa->nama = $input['nama'];
        $this->mahasiswa->jurusan = $input['jurusan'] ?? null;
        try {
            if ($this->mahasiswa->create()) {
                $this->success([
                    'id' => $this->mahasiswa->id,
                    'nim' => $this->mahasiswa->nim,
                    'nama' => $this->mahasiswa->nama,
                    'jurusan' => $this->mahasiswa->jurusan
                ], 'Mahasiswa berhasil ditambahkan', 201);
            } else {
                $this->error('Gagal menambahkan mahasiswa', 500);
            }
        } catch (Exception $e) {
            $this->error('Error: ' . $e->getMessage(), 500);
        }
    }

    public function update($id) {
        if (!$id || !is_numeric($id)) {
            $this->error('ID tidak valid', 400);
        }
        $input = $this->getJsonInput();
        if (!$input) {
            $this->error('Data JSON tidak valid', 400);
        }
        $this->validateRequired($input, ['nim', 'nama']);
        $input = $this->sanitize($input);
        $this->mahasiswa->id = (int)$id;
        $this->mahasiswa->nim = $input['nim'];
        $this->mahasiswa->nama = $input['nama'];
        $this->mahasiswa->jurusan = $input['jurusan'] ?? null;
        try {
            if ($this->mahasiswa->update()) {
                $this->success(null, 'Data mahasiswa berhasil diperbarui');
            } else {
                $this->error('Gagal memperbarui data atau data tidak ditemukan', 404);
            }
        } catch (Exception $e) {
            $this->error('Error: ' . $e->getMessage(), 500);
        }
    }

    public function delete($id) {
        if (!$id || !is_numeric($id)) {
            $this->error('ID tidak valid', 400);
        }
        $this->mahasiswa->id = (int)$id;
        try {
            if ($this->mahasiswa->delete()) {
                $this->success(null, 'Mahasiswa berhasil dihapus');
            } else {
                $this->error('Gagal menghapus data atau data tidak ditemukan', 404);
            }
        } catch (Exception $e) {
            $this->error('Error: ' . $e->getMessage(), 500);
        }
    }
}
