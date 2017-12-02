<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

error_reporting(E_ALL ^ E_WARNING);





// Get all appt_emp entries
$app->get('/api/appt_emps', function(Request $request, Response $response) {
    $sql = "SELECT * FROM appt_emp";
    
    try {
        // Get DB Object
        $db = new Database();
        
        // Connect
        $db = $db->connect();

        $stmt = $db->query($sql);
        $appt_emps = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($appt_emps);

    } catch(PDOException $e) {
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

// Get Single appt_emp
$app->get('/api/appt_emp/{id}', function(Request $request, Response $response) {

    $id = $request->getAttribute('id');

    $sql = "SELECT * FROM appt_emp WHERE ApptId = {$id}";
    
    try {
        // Get DB Object
        $db = new Database();
        
        // Connect
        $db = $db->connect();

        $stmt = $db->query($sql);
        $appt_emp = $stmt->fetch(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($appt_emp);

    } catch(PDOException $e) {
        echo '{"error": {"text": '.$e->getMessage().'}';
    }

});

// Add appt_emp
$app->post('/api/appt_emp/add', function(Request $request, Response $response) {
    
        $appt_id =          $request->getParam('appt_id');
        $emp_num =          $request->getParam('emp_num');

    
        $sql = "INSERT INTO appt_emp (ApptID, EmpNum)
                VALUES (:appt_id, :emp_num)";
        
        try {
            // Get DB Object
            $db = new Database();
            
            // Connect
            $db = $db->connect();
    
            $stmt = $db->prepare($sql);
            
            $stmt->bindParam(':appt_id',        $appt_id);
            $stmt->bindParam(':emp_num',        $emp_num);


            $stmt->execute();

            echo '{"notice": {"text": "appt_emp Entry Added"}';
    
        } catch(PDOException $e) {
            echo '{"error": {"text": '.$e->getMessage().'}';
        }
    
    });

// // Update appt_emp
// $app->put('/api/appt_emp/update/{id}', function(Request $request, Response $response) {

//         $id =               $request->getAttribute('id');
//         $appt_date =        $request->getParam('appt_date');
//         $appt_time =        $request->getParam('appt_time');
//         $tx_name =          $request->getParam('tx_name');
//         $pt_num =           $request->getParam('pt_num');
    
//         $sql = "UPDATE appt_emp SET
//                     ApptDate      = :appt_date,
//                     ApptTime      = :appt_time,
//                     TxName        = :tx_name,
//                     PtNum         = :pt_num
//                 WHERE ApptID = {$id}";
        
//         try {
//             // Get DB Object
//             $db = new Database();
            
//             // Connect
//             $db = $db->connect();
    
//             $stmt = $db->prepare($sql);

//             $stmt->bindParam(':appt_date',        $appt_date);
//             $stmt->bindParam(':appt_time',        $appt_time);
//             $stmt->bindParam(':tx_name',          $tx_name);
//             $stmt->bindParam(':pt_num',           $pt_num);

//             $stmt->execute();

//             echo '{"notice": {"text": "appt_emp Updated"}';
    
//         } catch(PDOException $e) {
//             echo '{"error": {"text": '.$e->getMessage().'}';
//         }
    
//     });

// // Delete appt_emp
// $app->delete('/api/appt_emp/delete/{id}', function(Request $request, Response $response) {
    
//         $id = $request->getAttribute('id');
    
//         $sql = "DELETE FROM appt_emp WHERE ApptID = {$id}";
        
//         try {
//             // Get DB Object
//             $db = new Database();
            
//             // Connect
//             $db = $db->connect();
    
//             $stmt = $db->prepare($sql);
//             $stmt->execute();
//             $db = null;
            
//             echo '{"notice": {"text": appt_emp Deleted}';
    
//         } catch(PDOException $e) {
//             echo '{"error": {"text": '.$e->getMessage().'}';
//         }
    
//     });