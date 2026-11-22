<?php
require_once __DIR__ . '/BaseService.php';
require_once __DIR__ . '/../dao/LoanDao.php';
require_once __DIR__ . '/../dao/UserDao.php';
require_once __DIR__ . '/../dao/BookDao.php';

class LoanService extends BaseService {
    private $userDao;
    private $bookDao;

    public function __construct() {
        parent::__construct(new LoanDao());
        $this->userDao = new UserDao();
        $this->bookDao = new BookDao();
    }

    protected function prepare($data, $id) {
        if (!isset($data["status"])) {
            $data["status"] = "borrowed";
        }
        $this->validate($data);

        if ($data["status"] === "borrowed") {
            $this->checkAvailable($data["book_id"], $id);
            $data["return_date"] = null;
        } elseif (empty($data["return_date"])) {
            $data["return_date"] = date("Y-m-d");
        }
        return $data;
    }

    protected function validate($data) {
        if (!isset($data["user_id"]) || !$this->userDao->getById($data["user_id"])) {
            $this->fail("User does not exist");
        }
        if (!isset($data["book_id"]) || !$this->bookDao->getById($data["book_id"])) {
            $this->fail("Book does not exist");
        }
        $this->checkDate($data, "loan_date");
        $this->checkDate($data, "due_date");
        if ($data["due_date"] < $data["loan_date"]) {
            $this->fail("Due date cannot be before the loan date");
        }
        if (!empty($data["return_date"])) {
            $this->checkDate($data, "return_date");
        }
        if (!in_array($data["status"], ["borrowed", "returned"], true)) {
            $this->fail("Status must be borrowed or returned");
        }
    }

    private function checkDate($data, $field) {
        if (!isset($data[$field]) || !is_string($data[$field])) {
            $this->fail("Field '" . $field . "' is required");
        }
        $date = DateTime::createFromFormat("Y-m-d", $data[$field]);
        if (!$date || $date->format("Y-m-d") !== $data[$field]) {
            $this->fail("Field '" . $field . "' must be a date like 2026-11-20");
        }
    }

    private function checkAvailable($bookId, $loanId) {
        $book = $this->bookDao->getById($bookId);
        $borrowed = 0;
        foreach ($this->dao->getAll() as $loan) {
            if ($loan["book_id"] == $bookId && $loan["status"] === "borrowed" && $loan["id"] != $loanId) {
                $borrowed++;
            }
        }
        if ($borrowed >= $book["copies"]) {
            $this->fail("No copies of this book are available");
        }
    }
}
