<?php
require_once __DIR__ . '/../services/UserService.php';

Flight::route('GET /users', function () {
    $service = new UserService();
    Flight::json($service->getAll());
});

Flight::route('GET /users/@id', function ($id) {
    $service = new UserService();
    Flight::json($service->getById($id));
});

Flight::route('POST /users', function () {
    $service = new UserService();
    Flight::json($service->create(getJsonBody()), 201);
});

Flight::route('PUT /users/@id', function ($id) {
    $service = new UserService();
    Flight::json($service->update($id, getJsonBody()));
});

Flight::route('DELETE /users/@id', function ($id) {
    $service = new UserService();
    $service->delete($id);
    Flight::json(["message" => "Deleted"]);
});
