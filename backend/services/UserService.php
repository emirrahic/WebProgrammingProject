<?php
require_once __DIR__ . '/BaseService.php';
require_once __DIR__ . '/../dao/UserDao.php';

class UserService extends BaseService {
    public function __construct() {
        parent::__construct(new UserDao());
    }

    public function getAll() {
        $users = $this->dao->getAll();
        foreach ($users as $i => $user) {
            unset($users[$i]["password_hash"]);
        }
        return $users;
    }

    public function getById($id) {
        $user = parent::getById($id);
        unset($user["password_hash"]);
        return $user;
    }

    protected function prepare($data, $id) {
        $this->validate($data);
        unset($data["password_hash"]);
        if ($id === null && !isset($data["password"])) {
            $this->fail("Field 'password' is required");
        }
        if (isset($data["password"])) {
            $data["password_hash"] = password_hash($data["password"], PASSWORD_DEFAULT);
        }
        return $data;
    }

    protected function validate($data) {
        $this->requireText($data, "name", 100);
        $this->requireText($data, "email", 150);
        if (!filter_var($data["email"], FILTER_VALIDATE_EMAIL)) {
            $this->fail("Email is not valid");
        }
        if (!isset($data["role"]) || !in_array($data["role"], ["admin", "member"], true)) {
            $this->fail("Role must be admin or member");
        }
        if (isset($data["password"]) && (!is_string($data["password"]) || strlen($data["password"]) < 6)) {
            $this->fail("Password must have at least 6 characters");
        }
    }
}
