<?php
session_start();

// Configuration de la connexion à la base de données
$servername = "localhost";
$dbname = "projet web"; // Correction du nom de la base de données
$username = "toumi";
$password = "Toumi123";

// Connexion à la base de données
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérification de la connexion
if ($conn->connect_error) {
    die("Erreur de connexion: " . $conn->connect_error);
}

if (isset($_POST['signin'])) {
    $email = $_POST['mail'];
    $password = $_POST['pass'];

    // Préparation de l'instruction SQL pour récupérer l'email et le mot de passe
    $stmt = $conn->prepare("SELECT email, password, role FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Vérification des résultats
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Vérification du mot de passe
        if (password_verify($password, $row['password'])) {
            $_SESSION['email'] = $email;
            $_SESSION['role'] = $row['role'];

            // Correction des conditions pour vérifier le rôle
            $role = $row['role'];
            if ($role === 'admin') {
                header("location:/DSWEB1/pages/admin.php");
                exit;
            } else if ($role === 'Docteur') {
                header("location:/DSWEB1/pages/doctor.php");
                exit;
            } else if ($role === 'patient') {
                header("location:/DSWEB1/pages/patient.php");
                exit;
            } else if ($role === 'infermier') {
                header("location:/DSWEB1/pages/infermier.php");
                exit;
            }
        } else {
            // Mot de passe incorrect
            echo "Mot de passe incorrect.";
        }
    } else {
        // Aucun compte trouvé
        echo "Aucun compte trouvé avec cet email.";
    }

    // Fermer la déclaration
    $stmt->close();
}

// Fermer la connexion
$conn->close();
?>
