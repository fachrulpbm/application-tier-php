<?php
class Mahasiswa extends Model {
    
    public $id;
    public $nim;
    public $nama;
    public $jurusan;

    public function __construct($db) {
        parent::__construct($db);
        $this->table = "mahasiswas";
    }

    public function getAll() {
        $query = "SELECT * FROM {$this->table} ORDER BY id ASC";
        return $this->executeQuery($query);
    }

    public function getById() {
        $query = "SELECT * FROM {$this->table} WHERE id = :id LIMIT 1";
        $stmt = $this->executeQuery($query, [':id' => $this->id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $this->nim = $row['nim'];
            $this->nama = $row['nama'];
            $this->jurusan = $row['jurusan'];
            return $row;
        }

        return false;
    }

    public function create() {
        $query = "INSERT INTO {$this->table} 
                  (nim, nama, jurusan) 
                  VALUES (:nim, :nama, :jurusan)";

        $params = [
            ':nim' => $this->nim,
            ':nama' => $this->nama,
            ':jurusan' => $this->jurusan
        ];

        $stmt = $this->executeQuery($query, $params);

        if ($stmt) {
            $this->id = $this->conn->lastInsertId();
            return true;
        }

        return false;
    }

    public function update() {
        $query = "UPDATE {$this->table} 
                  SET nim = :nim, 
                      nama = :nama, 
                      jurusan = :jurusan
                  WHERE id = :id";

        $params = [
            ':id' => $this->id,
            ':nim' => $this->nim,
            ':nama' => $this->nama,
            ':jurusan' => $this->jurusan
        ];

        $stmt = $this->executeQuery($query, $params);
        return $stmt->rowCount() > 0;
    }

    public function delete() {
        $query = "DELETE FROM {$this->table} WHERE id = :id";
        $stmt = $this->executeQuery($query, [':id' => $this->id]);
        return $stmt->rowCount() > 0;
    }
}
