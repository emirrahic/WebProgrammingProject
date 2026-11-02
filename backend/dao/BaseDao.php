<?php
class BaseDao {
    protected $connection;
    protected $table;
    protected $columns;

    public function __construct($table, $columns) {
        $config = require __DIR__ . '/../config/config.php';
        $this->table = $table;
        $this->columns = $columns;
        $this->connection = new PDO(
            "mysql:host=" . $config['db_host'] . ";dbname=" . $config['db_name'] . ";charset=utf8mb4",
            $config['db_user'],
            $config['db_pass'],
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]
        );
    }

    public function getAll() {
        $stmt = $this->connection->prepare("SELECT * FROM " . $this->table);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getById($id) {
        $stmt = $this->connection->prepare("SELECT * FROM " . $this->table . " WHERE id = :id");
        $stmt->execute(["id" => $id]);
        return $stmt->fetch();
    }

    public function insert($data) {
        $data = $this->filterData($data);
        $names = array_keys($data);
        $sql = "INSERT INTO " . $this->table . " (" . implode(", ", $names) . ") VALUES (:" . implode(", :", $names) . ")";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute($data);
        return $this->connection->lastInsertId();
    }

    public function update($id, $data) {
        $data = $this->filterData($data);
        $parts = [];
        foreach (array_keys($data) as $name) {
            $parts[] = $name . " = :" . $name;
        }
        $data["id"] = $id;
        $sql = "UPDATE " . $this->table . " SET " . implode(", ", $parts) . " WHERE id = :id";
        $stmt = $this->connection->prepare($sql);
        return $stmt->execute($data);
    }

    public function delete($id) {
        $stmt = $this->connection->prepare("DELETE FROM " . $this->table . " WHERE id = :id");
        return $stmt->execute(["id" => $id]);
    }

    protected function filterData($data) {
        $clean = [];
        foreach ($this->columns as $column) {
            if (array_key_exists($column, $data)) {
                $clean[$column] = $data[$column];
            }
        }
        return $clean;
    }
}
