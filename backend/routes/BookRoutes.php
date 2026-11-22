<?php
require_once __DIR__ . '/../services/BookService.php';

Flight::route('GET /books', function () {
    $service = new BookService();
    Flight::json($service->getAll());
});

Flight::route('GET /books/@id', function ($id) {
    $service = new BookService();
    Flight::json($service->getById($id));
});

Flight::route('POST /books', function () {
    $service = new BookService();
    Flight::json($service->create(getJsonBody()), 201);
});

Flight::route('PUT /books/@id', function ($id) {
    $service = new BookService();
    Flight::json($service->update($id, getJsonBody()));
});

Flight::route('DELETE /books/@id', function ($id) {
    $service = new BookService();
    $service->delete($id);
    Flight::json(["message" => "Deleted"]);
});
