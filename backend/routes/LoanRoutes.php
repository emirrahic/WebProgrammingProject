<?php
require_once __DIR__ . '/../services/LoanService.php';

Flight::route('GET /loans', function () {
    $service = new LoanService();
    Flight::json($service->getAll());
});

Flight::route('GET /loans/@id', function ($id) {
    $service = new LoanService();
    Flight::json($service->getById($id));
});

Flight::route('POST /loans', function () {
    $service = new LoanService();
    Flight::json($service->create(getJsonBody()), 201);
});

Flight::route('PUT /loans/@id', function ($id) {
    $service = new LoanService();
    Flight::json($service->update($id, getJsonBody()));
});

Flight::route('DELETE /loans/@id', function ($id) {
    $service = new LoanService();
    $service->delete($id);
    Flight::json(["message" => "Deleted"]);
});
