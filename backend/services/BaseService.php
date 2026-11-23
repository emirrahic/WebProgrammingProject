<?php
class BaseService {
    protected $dao;

    public function __construct($dao) {
        $this->dao = $dao;
    }

    public function getAll() {
        return $this->dao->getAll();
    }

    public function getById($id) {
        $row = $this->dao->getById($id);
        if (!$row) {
            throw new Exception("Record not found", 404);
        }
        return $row;
    }

    public function create($data) {
        $data = $this->prepare($data, null);
        $id = $this->dao->insert($data);
        return $this->getById($id);
    }

    public function update($id, $data) {
        $this->getById($id);
        $data = $this->prepare($data, $id);
        $this->dao->update($id, $data);
        return $this->getById($id);
    }

    public function delete($id) {
        $this->getById($id);
        $this->dao->delete($id);
    }

    protected function prepare($data, $id) {
        $this->validate($data);
        return $data;
    }

    protected function validate($data) {
    }

    protected function fail($message) {
        throw new Exception($message, 400);
    }

    protected function requireText($data, $field, $max) {
        if (!isset($data[$field]) || !is_string($data[$field]) || trim($data[$field]) === "") {
            $this->fail("Field '" . $field . "' is required");
        }
        if (strlen($data[$field]) > $max) {
            $this->fail("Field '" . $field . "' is too long (maximum " . $max . " characters)");
        }
    }

    protected function optionalText($data, $field, $max) {
        if (isset($data[$field]) && (!is_string($data[$field]) || strlen($data[$field]) > $max)) {
            $this->fail("Field '" . $field . "' must be text with at most " . $max . " characters");
        }
    }
}
