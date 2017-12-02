<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

error_reporting(E_ALL ^ E_WARNING);





// Get all Appointments
$app->get('/api/appointments', function(Request $request, Response $response) {
    $sql = "SELECT * FROM appointment";
    
    try {
        // Get DB Object
        $db = new Database();
        
        // Connect
        $db = $db->connect();

        $stmt = $db->query($sql);
        $appointments = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($appointments);

    } catch(PDOException $e) {
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

// Get Single Appointment
$app->get('/api/appointment/{id}', function(Request $request, Response $response) {

    $id = $request->getAttribute('id');

    $sql = "SELECT * FROM appointment WHERE ApptId = {$id}";
    
    try {
        // Get DB Object
        $db = new Database();
        
        // Connect
        $db = $db->connect();

        $stmt = $db->query($sql);
        $appointment = $stmt->fetch(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($appointment);

    } catch(PDOException $e) {
        echo '{"error": {"text": '.$e->getMessage().'}';
    }

});

// Add Appointment
$app->post('/api/appointment/add', function(Request $request, Response $response) {
    
        $appt_date =        $request->getParam('appt_date');
        $appt_time =        $request->getParam('appt_time');
        $tx_name =          $request->getParam('tx_name');
        $pt_num =           $request->getParam('pt_num');

    
        $sql = "INSERT INTO appointment (ApptDate, ApptTime, TxName, PtNum)
                VALUES (:appt_date, :appt_time, :tx_name, :pt_num)";
        
        try {
            // Get DB Object
            $db = new Database();
            
            // Connect
            $db = $db->connect();
    
            $stmt = $db->prepare($sql);
            
            $stmt->bindParam(':appt_date',        $appt_date);
            $stmt->bindParam(':appt_time',        $appt_time);
            $stmt->bindParam(':tx_name',          $tx_name);
            $stmt->bindParam(':pt_num',           $pt_num);


            $stmt->execute();

            echo '{"notice": {"text": "Appointment Added"}';
    
        } catch(PDOException $e) {
            echo '{"error": {"text": '.$e->getMessage().'}';
        }
    
    });

// Update appointment
$app->put('/api/appointment/update/{id}', function(Request $request, Response $response) {

        $id =               $request->getAttribute('id');
        $appt_date =        $request->getParam('appt_date');
        $appt_time =        $request->getParam('appt_time');
        $tx_name =          $request->getParam('tx_name');
        $pt_num =           $request->getParam('pt_num');
    
        $sql = "UPDATE appointment SET
                    ApptDate      = :appt_date,
                    ApptTime      = :appt_time,
                    TxName        = :tx_name,
                    PtNum         = :pt_num
                WHERE ApptID = {$id}";
        
        try {
            // Get DB Object
            $db = new Database();
            
            // Connect
            $db = $db->connect();
    
            $stmt = $db->prepare($sql);

            $stmt->bindParam(':appt_date',        $appt_date);
            $stmt->bindParam(':appt_time',        $appt_time);
            $stmt->bindParam(':tx_name',          $tx_name);
            $stmt->bindParam(':pt_num',           $pt_num);

            $stmt->execute();

            echo '{"notice": {"text": "Appointment Updated"}';
    
        } catch(PDOException $e) {
            echo '{"error": {"text": '.$e->getMessage().'}';
        }
    
    });

// // Delete appointment
// $app->delete('/api/appointment/delete/{id}', function(Request $request, Response $response) {
    
//         $id = $request->getAttribute('id');
    
//         $sql = "DELETE FROM appointment WHERE PtNum = {$id}";
        
//         try {
//             // Get DB Object
//             $db = new Database();
            
//             // Connect
//             $db = $db->connect();
    
//             $stmt = $db->prepare($sql);
//             $stmt->execute();
//             $db = null;
            
//             echo '{"notice": {"text": appointment Deleted}';
    
//         } catch(PDOException $e) {
//             echo '{"error": {"text": '.$e->getMessage().'}';
//         }
    
//     });