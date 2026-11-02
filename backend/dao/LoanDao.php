<?php
require_once __DIR__ . '/BaseDao.php';

class LoanDao extends BaseDao {
    public function __construct() {
        parent::__construct("loans", ["user_id", "book_id", "loan_date", "due_date", "return_date", "status"]);
    }
}
