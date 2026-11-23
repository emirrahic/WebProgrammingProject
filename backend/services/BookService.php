<?php
require_once __DIR__ . '/BaseService.php';
require_once __DIR__ . '/../dao/BookDao.php';
require_once __DIR__ . '/../dao/AuthorDao.php';
require_once __DIR__ . '/../dao/CategoryDao.php';

class BookService extends BaseService {
    private $authorDao;
    private $categoryDao;

    public function __construct() {
        parent::__construct(new BookDao());
        $this->authorDao = new AuthorDao();
        $this->categoryDao = new CategoryDao();
    }

    protected function validate($data) {
        $this->requireText($data, "title", 200);
        $this->optionalText($data, "isbn", 20);

        $copies = filter_var($data["copies"] ?? null, FILTER_VALIDATE_INT);
        if ($copies === false || $copies < 0) {
            $this->fail("Field 'copies' must be a whole number, 0 or more");
        }
        if (!isset($data["author_id"]) || !$this->authorDao->getById($data["author_id"])) {
            $this->fail("Author does not exist");
        }
        if (!isset($data["category_id"]) || !$this->categoryDao->getById($data["category_id"])) {
            $this->fail("Category does not exist");
        }
    }
}
