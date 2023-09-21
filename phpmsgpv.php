<?php
session_start();

if (isset($_SESSION['id'])) {
    $user_id = $_SESSION['id'];
} else {
    header("Location: login.php"); // Remplacez "login.php" par la page de connexion
    exit();
}

// Informations de connexion à la base de données
$servername = 'mysql-ysite.alwaysdata.net'; // Adresse du serveur de base de données
$username = 'ysite_tymeo'; // Nom d'utilisateur de la base de données
$password = 'tymeoysite'; // Mot de passe de la base de données
$dbname = 'ysite_allbd'; // Nom de la base de données que vous avez créée
function lastId($pdo) {
    $stmt = $pdo->prepare("SELECT MAX(id_message) FROM messages");
    $stmt->execute();
    $lastId = $stmt->fetchColumn();

    // Incrémente le dernier ID de 1
    $nextId = $lastId + 1;

    return $nextId;
}
try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $receiver_id = $_POST["receiver_id"];
        $message = $_POST["message"];
        $id_message = lastId($pdo);;

        // Préparation de la requête SQL avec PDO
        $stmt = $pdo->prepare("INSERT INTO messages (id_message,sender_id, receiver_id, message) VALUES (:id_message,:sender_id, :receiver_id, :message)");
        $stmt->bindParam(':id_message', $id_message);
        $stmt->bindParam(':sender_id', $user_id);
        $stmt->bindParam(':receiver_id', $receiver_id);
        $stmt->bindParam(':message', $message);

        if ($stmt->execute()) {
            echo "Message envoyé avec succès !";
        } else {
            echo "Erreur : " . $stmt->errorInfo()[2];
        }
    }

    // Afficher les messages
    $stmt = $pdo->prepare("SELECT * FROM messages WHERE sender_id = :user_id OR receiver_id = :user_id ORDER BY timestamp DESC");
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();

    $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($messages) > 0) {
        echo "<h2>Vos messages :</h2>";
        foreach ($messages as $row) {
            $sender_id = $row["sender_id"];
            $receiver_id = $row["receiver_id"];
            $message = $row["message"];

            echo "<p><strong>De :</strong> $sender_id<br>";
            echo "<strong>À :</strong> $receiver_id<br>";
            echo "<strong>Message :</strong> $message</p>";
        }
    } else {
        echo "<p>Aucun message trouvé.</p>";
    }
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}
?>
