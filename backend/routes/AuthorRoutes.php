<?php
require_once __DIR__ . '/../services/AuthorService.php';

Flight::route('GET /authors', function () {
    $service = new AuthorService();
    Flight::json($service->getAll());
});

Flight::route('GET /authors/@id', function ($id) {
    $service = new AuthorService();
    Flight::json($service->getById($id));
});

Flight::route('POST /authors', function () {
    $service = new AuthorService();
    Flight::json($service->create(getJsonBody()), 201);
});

Flight::route('PUT /authors/@id', function ($id) {
    $service = new AuthorService();
    Flight::json($service->update($id, getJsonBody()));
});

Flight::route('DELETE /authors/@id', function ($id) {
    $service = new AuthorService();
    $service->delete($id);
    Flight::json(["message" => "Deleted"]);
});
