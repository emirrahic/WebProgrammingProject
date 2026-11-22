<?php
require_once __DIR__ . '/BaseService.php';
require_once __DIR__ . '/../dao/CategoryDao.php';

class CategoryService extends BaseService {
    public function __construct() {
        parent::__construct(new CategoryDao());
    }

    protected function validate($data) {
        $this->requireText($data, "name", 100);
        $this->optionalText($data, "description", 255);
    }
}
