<?php
require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/helpers.php';

Flight::map('error', function (Throwable $e) {
    $code = $e->getCode();
    if (in_array($code, [400, 404, 503], true)) {
        sendError($e->getMessage(), $code);
    } elseif ($e instanceof PDOException && $code === "23000") {
        sendError("This record conflicts with other data, for example a duplicate email or a record that is still in use", 400);
    } else {
        writeErrorLog(get_class($e) . ": " . $e->getMessage());
        sendError("Server error", 500);
    }
});

Flight::map('notFound', function () {
    sendError("Route not found", 404);
});

require __DIR__ . '/routes/AuthorRoutes.php';
require __DIR__ . '/routes/CategoryRoutes.php';
require __DIR__ . '/routes/UserRoutes.php';
require __DIR__ . '/routes/BookRoutes.php';
require __DIR__ . '/routes/LoanRoutes.php';
require __DIR__ . '/routes/ExternalRoutes.php';

Flight::start();
