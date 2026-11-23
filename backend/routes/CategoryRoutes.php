<?php
require_once __DIR__ . '/../services/CategoryService.php';

Flight::route('GET /categories', function () {
    $service = new CategoryService();
    Flight::json($service->getAll());
});

Flight::route('GET /categories/@id', function ($id) {
    $service = new CategoryService();
    Flight::json($service->getById($id));
});

Flight::route('POST /categories', function () {
    $service = new CategoryService();
    Flight::json($service->create(getJsonBody()), 201);
});

Flight::route('PUT /categories/@id', function ($id) {
    $service = new CategoryService();
    Flight::json($service->update($id, getJsonBody()));
});

Flight::route('DELETE /categories/@id', function ($id) {
    $service = new CategoryService();
    $service->delete($id);
    Flight::json(["message" => "Deleted"]);
});
