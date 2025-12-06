<?php

class MahasiswaService {
    private $mahasiswa; // DAO/Repository

    public function __construct(Mahasiswa $mahasiswa) {
        $this->mahasiswa = $mahasiswa;
    }

    public function getAll() {
        $stmt = $this->mahasiswa->getAll();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById(int $id) {
        $this->mahasiswa->id = $id;
        return $this->mahasiswa->getById();
    }

    public function create(array $input) {
        $this->validateRequired($input, ['nim', 'nama']);
        $input = $this->sanitize($input);
        $this->mahasiswa->nim = $input['nim'];
        $this->mahasiswa->nama = $input['nama'];
        $this->mahasiswa->jurusan = $input['jurusan'] ?? null;
        if ($this->mahasiswa->create()) {
            return [
                'id' => $this->mahasiswa->id,
                'nim' => $this->mahasiswa->nim,
                'nama' => $this->mahasiswa->nama,
                'jurusan' => $this->mahasiswa->jurusan
            ];
        }
        throw new Exception('Gagal menambahkan mahasiswa');
    }

    public function update(int $id, array $input) {
        $this->validateRequired($input, ['nim', 'nama']);
        $input = $this->sanitize($input);
        $this->mahasiswa->id = $id;
        $this->mahasiswa->nim = $input['nim'];
        $this->mahasiswa->nama = $input['nama'];
        $this->mahasiswa->jurusan = $input['jurusan'] ?? null;
        if (!$this->mahasiswa->update()) {
            throw new Exception('Gagal memperbarui data atau data tidak ditemukan');
        }
    }

    public function delete(int $id) {
        $this->mahasiswa->id = $id;
        if (!$this->mahasiswa->delete()) {
            throw new Exception('Gagal menghapus data atau data tidak ditemukan');
        }
    }

    private function validateRequired(array $input, array $requiredFields): void {
        $missing = [];
        foreach ($requiredFields as $field) {
            if (!isset($input[$field]) || empty(trim($input[$field]))) {
                $missing[] = $field;
            }
        }
        if (!empty($missing)) {
            throw new Exception('Field wajib: ' . implode(', ', $missing));
        }
    }

    private function sanitize($data) {
        if (is_array($data)) {
            return array_map([$this, 'sanitize'], $data);
        }
        return htmlspecialchars(strip_tags(trim($data)), ENT_QUOTES, 'UTF-8');
    }
}