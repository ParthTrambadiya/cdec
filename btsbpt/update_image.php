<?php 

session_start();

$dbObj = new DBConfig();

$pdo = $dbObj->getPdo();
$conn = $dbObj->getConn();

$uploadDir = 'assets/images/avatars/';
$response = [ 
    'status' => 0, 
    'message' => 'Form submission failed, please try again.' 
];

    $uploadStatus = 1; 
        
    // Upload file 
    $uploadedFile = ''; 
    if(!empty($_FILES["file"]["name"])){ 
            
        // File path config 
        $fileName = basename($_FILES["file"]["name"]);
        $targetFilePath = $uploadDir . $fileName;
        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION); 
            
        // Allow certain file formats 
        $allowTypes = array('jpg', 'png', 'jpeg');
        $restrictExt = ['php', 'pht', 'phpt', 'phtml', 'php3', 'php4', 'php5', 'php6', '%00', 'xss', 'ecs'];
        if(in_array($fileType, $allowTypes)){
            foreach($restrictExt as $restricted) {
                if(strpos(strtolower($fileName), $restricted) !== false) {
                    $uploadStatus = 0; 
                    $response['message'] = 'Sorry, only JPG, JPEG, & PNG files are allowed to upload.';
                    break;
                }
            }
            if($uploadStatus == 1) {
                // Upload file to the server 
                if(move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath)){ 
                    $uploadedFile = $today . $fileName; 
                }else{ 
                    $uploadStatus = 0; 
                    $response['message'] = 'Sorry, there was an error uploading your image.'; 
                }
            }
        } else{ 
            $uploadStatus = 0; 
            $response['message'] = 'Sorry, only JPG, JPEG, & PNG files are allowed to upload.'; 
        } 
    } 
        
    if($uploadStatus == 1){ 
        // Include the database config file 
        include_once 'db-config.php'; 
            
        // Insert form data in the database 
        $update = "UPDATE admin SET img = '".$uploadedFile."' WHERE id='ADMIN'"; 
            
        if(mysqli_query($conn, $update)){ 
            $_SESSION['img'] = $uploadedFile;
            $response['status'] = 1; 
            $response['message'] = 'Profile image changed successfully!'; 
        } 
    }
     
echo json_encode($response);

?>