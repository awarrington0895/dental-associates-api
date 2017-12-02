<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

error_reporting(E_ALL ^ E_WARNING);





// Get all Treatmnents
$app->get('/api/treatments', function(Request $request, Response $response) {
    $sql = "SELECT * FROM treatment";
    
    try {
        // Get DB Object
        $db = new Database();
        
        // Connect
        $db = $db->connect();

        $stmt = $db->query($sql);
        $treatments = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($treatments);

    } catch(PDOException $e) {
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});


