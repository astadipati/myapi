<?php
 
require_once 'include/DB_Functions.php';
$db = new DB_Functions();
 
// json response array
$response = array("error" => FALSE);
 
if (isset($_POST['nama']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['IDperkara'])) {
 
    // menerima parameter POST ( nama, email, password , idperkara)
    
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $idperkara = $_POST['IDperkara'];

    // Cek jika user ada dengan email yang sama
    if ($db->isUserExisted($email)) {
        // user telah ada
        $response["error"] = TRUE;
        $response["error_msg"] = "User telah ada dengan email " . $email;
        echo json_encode($response);
    } else {
        // buat user baru
        $user = $db->simpanUser($nama, $email, $password, $idperkara);
        if ($user) {
            // simpan user berhasil
            $response["error"] = FALSE;
            $response["uid"] = $user["unique_id"];
            
            $response["user"]["nama"] = $user["nama"];
            $response["user"]["email"] = $user["email"];
            $response["user"]["IDperkara"] = $user["IDperkara"];
            echo json_encode($response);
        } else {
            // gagal menyimpan user
            $response["error"] = TRUE;
            $response["error_msg"] = "Terjadi kesalahan saat melakukan registrasi";
            echo json_encode($response);
        }
    }
} else {
    $response["error"] = TRUE;
    $response["error_msg"] = "Terjadi kesalahan nama, email, atau password";
    echo json_encode($response);
}
?>