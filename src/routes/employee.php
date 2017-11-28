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

// Update Employee
$app->put('/api/employee/update/{id}', function(Request $request, Response $response) {

        $id =               $request->getAttribute('id');
        $first_name =       $request->getParam('first_name');
        $last_name =        $request->getParam('last_name');
        $role =             $request->getParam('role');

    
        $sql = "UPDATE employee SET
                    FirstName     = :first_name,
                    LastName      = :last_name,
                    Role          = :role
                WHERE EmpNum = {$id}";
        
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

            echo '{"notice": {"text": "Employee Updated"}';
    
        } catch(PDOException $e) {
            echo '{"error": {"text": '.$e->getMessage().'}';
        }
    
    });

// Delete Employee
$app->delete('/api/employee/delete/{id}', function(Request $request, Response $response) {
    
        $id = $request->getAttribute('id');
    
        $sql = "DELETE FROM employee WHERE EmpNum = {$id}";
        
        try {
            // Get DB Object
            $db = new Database();
            
            // Connect
            $db = $db->connect();
    
            $stmt = $db->prepare($sql);
            $stmt->execute();
            $db = null;
            
            echo '{"notice": {"text": Employee Deleted}';
    
        } catch(PDOException $e) {
            echo '{"error": {"text": '.$e->getMessage().'}';
        }
    
    });