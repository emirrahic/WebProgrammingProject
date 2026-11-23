<?php
class OpenLibraryService {
    private $baseUrl;
    private $timeout;

    public function __construct() {
        $config = require __DIR__ . '/../config/config.php';
        $this->baseUrl = $config['open_library_url'] ?? 'https://openlibrary.org';
        $this->timeout = $config['api_timeout'] ?? 5;
    }

    public function searchBooks($query) {
        $query = trim($query);
        if ($query === "") {
            throw new Exception("Search text is required", 400);
        }
        if (strlen($query) > 100) {
            throw new Exception("Search text is too long (maximum 100 characters)", 400);
        }

        $url = $this->baseUrl . "/search.json?limit=5&fields=title,author_name,first_publish_year,isbn,cover_i&q=" . urlencode($query);
        $context = stream_context_create([
            "http" => [
                "timeout" => $this->timeout,
                "header" => "User-Agent: LibraryBookManagement/1.0\r\n"
            ]
        ]);

        $response = @file_get_contents($url, false, $context);
        if ($response === false) {
            writeErrorLog("Open Library request failed: " . $url);
            throw new Exception("Book search is not available right now. Please try again later.", 503);
        }

        $data = json_decode($response, true);
        if (!isset($data["docs"])) {
            writeErrorLog("Open Library returned an unexpected response for: " . $url);
            throw new Exception("Book search is not available right now. Please try again later.", 503);
        }

        $books = [];
        foreach ($data["docs"] as $doc) {
            $books[] = [
                "title" => $doc["title"] ?? "",
                "author" => isset($doc["author_name"]) ? $doc["author_name"][0] : "",
                "first_publish_year" => $doc["first_publish_year"] ?? null,
                "isbn" => isset($doc["isbn"]) ? $doc["isbn"][0] : "",
                "cover_url" => isset($doc["cover_i"]) ? "https://covers.openlibrary.org/b/id/" . $doc["cover_i"] . "-M.jpg" : ""
            ];
        }
        return $books;
    }
}
