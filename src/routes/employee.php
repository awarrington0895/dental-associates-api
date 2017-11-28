<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

// Get all employees
$app->get('/api/employees', function(Request $request, Response $response) {
    $sql = "SELECT * FROM employee";
    
    try {
        // Get DB Object
        $db = new Database();
        
        // Connect
        $db = $db->connect();

        $stmt = $db->query($sql);
        $employees = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($employees);

    } catch(PDOException $e) {
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

// Get Single Employee
$app->get('/api/employee/{id}', function(Request $request, Response $response) {

    $id = $request->getAttribute('id');

    $sql = "SELECT * FROM employee WHERE EmpNum = {$id}";
    
    try {
        // Get DB Object
        $db = new Database();
        
        // Connect
        $db = $db->connect();

        $stmt = $db->query($sql);
        $employee = $stmt->fetch(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($employee);

    } catch(PDOException $e) {
        echo '{"error": {"text": '.$e->getMessage().'}';
    }

});

// Add Employee
$app->post('/api/employee/add', function(Request $request, Response $response) {
    
        $first_name =       $request->getParam('first_name');
        $last_name =        $request->getParam('last_name');
        $role =             $request->getParam('role');


    
        $sql = "INSERT INTO employee (FirstName, LastName, Role)
                VALUES (:first_name,:last_name, :role)";
        
        try {
            // Get DB Object
            $db = new Database();
            
            // Connect
            $db = $db->connect();
    
            $stmt = $db->prepare($sql);
            
            $stmt->bindParam(':first_name',      $first_name);
            $stmt->bindParam(':last_name',       $last_name);
            $stmt->bindParam(':role',            $role);


            $stmt->execute();

            echo '{"notice": {"text": "Employee Added"}';
    
        } catch(PDOException $e) {
            echo '{"error": {"text": '.$e->getMessage().'}';
        }
    
    });

// // Update Customer
// $app->put('/api/patient/update/{id}', function(Request $request, Response $response) {

//         $id =               $request->getAttribute('id');
//         $first_name =       $request->getParam('first_name');
//         $last_name =        $request->getParam('last_name');
//         $preferred_name =   $request->getParam('preferred_name');
//         $address =          $request->getParam('address');
//         $city =             $request->getParam('city');
//         $state =            $request->getParam('state');
//         $zip =              $request->getParam('zip');
//         $prim_phone =       $request->getParam('prim_phone');
//         $sec_phone =        $request->getParam('sec_phone');
//         $email =            $request->getParam('email');
//         $allergies =        $request->getParam('allergies');
//         $ins_name =         $request->getParam('ins_name');
//         $ins_number =       $request->getParam('ins_number');
    
//         $sql = "UPDATE patient SET
//                     FirstName     = :first_name,
//                     LastName      = :last_name,
//                     PreferredName = :preferred_name,
//                     Address       = :address,
//                     City          = :city,
//                     State         = :state,
//                     Zip           = :zip,
//                     PrimPhone     = :prim_phone,
//                     SecPhone      = :sec_phone,
//                     Email         = :email,
//                     Allergies     = :allergies,
//                     InsName       = :ins_name,
//                     InsNumber     = :ins_number
//                 WHERE PtNum = {$id}";
        
//         try {
//             // Get DB Object
//             $db = new Database();
            
//             // Connect
//             $db = $db->connect();
    
//             $stmt = $db->prepare($sql);

//             $stmt->bindParam(':first_name',      $first_name);
//             $stmt->bindParam(':last_name',       $last_name);
//             $stmt->bindParam(':preferred_name',  $preferred_name);
//             $stmt->bindParam(':address',         $address);
//             $stmt->bindParam(':city',            $city);
//             $stmt->bindParam(':state',           $state);
//             $stmt->bindParam(':zip',             $zip);
//             $stmt->bindParam(':prim_phone',      $prim_phone);
//             $stmt->bindParam(':sec_phone',       $sec_phone);
//             $stmt->bindParam(':email',           $email);
//             $stmt->bindParam(':allergies',       $allergies);
//             $stmt->bindParam(':ins_name',        $ins_name);
//             $stmt->bindParam(':ins_number',      $ins_number);

//             $stmt->execute();

//             echo '{"notice": {"text": "Patient Updated"}';
    
//         } catch(PDOException $e) {
//             echo '{"error": {"text": '.$e->getMessage().'}';
//         }
    
//     });

// // Delete Customer
// $app->delete('/api/patient/delete/{id}', function(Request $request, Response $response) {
    
//         $id = $request->getAttribute('id');
    
//         $sql = "DELETE FROM patient WHERE PtNum = {$id}";
        
//         try {
//             // Get DB Object
//             $db = new Database();
            
//             // Connect
//             $db = $db->connect();
    
//             $stmt = $db->prepare($sql);
//             $stmt->execute();
//             $db = null;
            
//             echo '{"notice": {"text": Patient Deleted}';
    
//         } catch(PDOException $e) {
//             echo '{"error": {"text": '.$e->getMessage().'}';
//         }
    
//     });