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

// Add Patient
$app->post('/api/appointment/add', function(Request $request, Response $response) {
    
        $appt_id =          $request->getParam('appt_id');
        $appt_date =        $request->getParam('appt_date');
        $appt_time =        $request->getParam('appt_time');
        $tx_name =          $request->getParam('tx_name');
        $pt_num =           $request->getParam('pt_num');

    
        $sql = "INSERT INTO appointment (ApptId, ApptDate, ApptTime, TxName, PtNum)
                VALUES (:appt_id, :appt_date, :appt_time, :tx_name, :pt_num)";
        
        try {
            // Get DB Object
            $db = new Database();
            
            // Connect
            $db = $db->connect();
    
            $stmt = $db->prepare($sql);
            
            $stmt->bindParam(':appt_id',          $appt_id);
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

// // Update Patient
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

// // Delete Patient
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