<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

error_reporting(E_ALL ^ E_WARNING);
$app = new \Slim\App;


$app->options('/{routes:.+}', function ($request, $response, $args) {
    return $response;
});

$app->add(function ($req, $res, $next) {
    $response = $next($req, $res);
    return $response
                ->withHeader('Access-Control-Allow-Origin', '*')
                ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With,
                              Content-Type, Accept, Origin, Authorization')
                ->withHeader('Access-Control-Allow-Methods', 
                             'GET, POST, PUT, DELETE, OPTIONS')
                ->withHeader('Content-type', 'application/json');
});

// Get all customers
$app->get('/api/patients', function(Request $request, Response $response) {
    $sql = "SELECT * FROM patient";
    
    try {
        // Get DB Object
        $db = new Database();
        
        // Connect
        $db = $db->connect();

        $stmt = $db->query($sql);
        $patients = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($patients);

    } catch(PDOException $e) {
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

// Get Single Customer
$app->get('/api/patient/{id}', function(Request $request, Response $response) {

    $id = $request->getAttribute('id');

    $sql = "SELECT * FROM patient WHERE PtNum = {$id}";
    
    try {
        // Get DB Object
        $db = new Database();
        
        // Connect
        $db = $db->connect();

        $stmt = $db->query($sql);
        $patient = $stmt->fetch(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($patient);

    } catch(PDOException $e) {
        echo '{"error": {"text": '.$e->getMessage().'}';
    }

});

// Add Customer
$app->post('/api/patient/add', function(Request $request, Response $response) {
    
        $first_name =       $request->getParam('first_name');
        $last_name =        $request->getParam('last_name');
        $preferred_name =   $request->getParam('preferred_name');
        $address =          $request->getParam('address');
        $city =             $request->getParam('city');
        $state =            $request->getParam('state');
        $zip =              $request->getParam('zip');
        $prim_phone =       $request->getParam('prim_phone');
        $sec_phone =        $request->getParam('sec_phone');
        $email =            $request->getParam('email');
        $allergies =        $request->getParam('allergies');
        $ins_name =         $request->getParam('ins_name');
        $ins_number =       $request->getParam('ins_number');

    
        $sql = "INSERT INTO patient (FirstName, LastName, PreferredName, Address, City, State, Zip, PrimPhone, 
                                    SecPhone, Email, Allergies, InsName, InsNumber)
                VALUES (:first_name,:last_name, :preferred_name, :address, :city, :state, 
                        :zip, :prim_phone, :sec_phone, :email, :allergies, :ins_name, :ins_number)";
        
        try {
            // Get DB Object
            $db = new Database();
            
            // Connect
            $db = $db->connect();
    
            $stmt = $db->prepare($sql);
            
            $stmt->bindParam(':first_name',      $first_name);
            $stmt->bindParam(':last_name',       $last_name);
            $stmt->bindParam(':preferred_name',  $preferred_name);
            $stmt->bindParam(':address',         $address);
            $stmt->bindParam(':city',            $city);
            $stmt->bindParam(':state',           $state);
            $stmt->bindParam(':zip',             $zip);
            $stmt->bindParam(':prim_phone',      $prim_phone);
            $stmt->bindParam(':sec_phone',       $sec_phone);
            $stmt->bindParam(':email',           $email);
            $stmt->bindParam(':allergies',       $allergies);
            $stmt->bindParam(':ins_name',        $ins_name);
            $stmt->bindParam(':ins_number',      $ins_number);

            $stmt->execute();

            echo '{"notice": {"text": "Patient Added"}';
    
        } catch(PDOException $e) {
            echo '{"error": {"text": '.$e->getMessage().'}';
        }
    
    });

// Update Customer
$app->put('/api/patient/update/{id}', function(Request $request, Response $response) {

        $id =               $request->getAttribute('id');
        $first_name =       $request->getParam('first_name');
        $last_name =        $request->getParam('last_name');
        $preferred_name =   $request->getParam('preferred_name');
        $address =          $request->getParam('address');
        $city =             $request->getParam('city');
        $state =            $request->getParam('state');
        $zip =              $request->getParam('zip');
        $prim_phone =       $request->getParam('prim_phone');
        $sec_phone =        $request->getParam('sec_phone');
        $email =            $request->getParam('email');
        $allergies =        $request->getParam('allergies');
        $ins_name =         $request->getParam('ins_name');
        $ins_number =       $request->getParam('ins_number');
    
        $sql = "UPDATE patient SET
                    FirstName     = :first_name,
                    LastName      = :last_name,
                    PreferredName = :preferred_name,
                    Address       = :address,
                    City          = :city,
                    State         = :state,
                    Zip           = :zip,
                    PrimPhone     = :prim_phone,
                    SecPhone      = :sec_phone,
                    Email         = :email,
                    Allergies     = :allergies,
                    InsName       = :ins_name,
                    InsNumber     = :ins_number
                WHERE PtNum = {$id}";
        
        try {
            // Get DB Object
            $db = new Database();
            
            // Connect
            $db = $db->connect();
    
            $stmt = $db->prepare($sql);

            $stmt->bindParam(':first_name',      $first_name);
            $stmt->bindParam(':last_name',       $last_name);
            $stmt->bindParam(':preferred_name',  $preferred_name);
            $stmt->bindParam(':address',         $address);
            $stmt->bindParam(':city',            $city);
            $stmt->bindParam(':state',           $state);
            $stmt->bindParam(':zip',             $zip);
            $stmt->bindParam(':prim_phone',      $prim_phone);
            $stmt->bindParam(':sec_phone',       $sec_phone);
            $stmt->bindParam(':email',           $email);
            $stmt->bindParam(':allergies',       $allergies);
            $stmt->bindParam(':ins_name',        $ins_name);
            $stmt->bindParam(':ins_number',      $ins_number);

            $stmt->execute();

            echo '{"notice": {"text": "Patient Updated"}';
    
        } catch(PDOException $e) {
            echo '{"error": {"text": '.$e->getMessage().'}';
        }
    
    });

// Delete Customer
$app->delete('/api/customer/delete/{id}', function(Request $request, Response $response) {
    
        $id = $request->getAttribute('id');
    
        $sql = "DELETE FROM customers WHERE id = {$id}";
        
        try {
            // Get DB Object
            $db = new Database();
            
            // Connect
            $db = $db->connect();
    
            $stmt = $db->prepare($sql);
            $stmt->execute();
            $db = null;
            
            echo '{"notice": {"text": Customer Deleted}';
    
        } catch(PDOException $e) {
            echo '{"error": {"text": '.$e->getMessage().'}';
        }
    
    });