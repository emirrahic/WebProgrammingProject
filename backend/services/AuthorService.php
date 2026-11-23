<?php
require_once __DIR__ . '/BaseService.php';
require_once __DIR__ . '/../dao/AuthorDao.php';

class AuthorService extends BaseService {
    public function __construct() {
        parent::__construct(new AuthorDao());
    }

    protected function validate($data) {
        $this->requireText($data, "name", 100);
        $this->optionalText($data, "country", 100);
    }
}
