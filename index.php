<?php
$localhost = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "th2";
$conn = new mysqli($localhost, $username, $password, $dbname);
if ($conn->connect_error) {
     echo "Falha na conexao";
}
echo "Conexao bem sucedida";

$conn->close();

?>