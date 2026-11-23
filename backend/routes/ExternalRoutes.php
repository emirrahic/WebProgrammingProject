<?php
require_once __DIR__ . '/../services/OpenLibraryService.php';

Flight::route('GET /external/books', function () {
    $service = new OpenLibraryService();
    Flight::json($service->searchBooks($_GET['q'] ?? ""));
});
