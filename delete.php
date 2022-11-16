<?php
// Inicialize a sessão
session_start();

// Verifique se o usuário está logado, se não, redirecione-o para uma página de login
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: index.php");
    exit;
}
require_once "connecta.php";

$cadastro_id = $_GET['id'];

$sql2 = mysqli_query($link, "UPDATE cadastro SET cadastro_ativo = 0 WHERE id = $cadastro_id");
mysqli_query($link, $sql2);


        mysqli_close($link);
        
      
       
        header('Location: ./resultado_busca.php');

      
    

    ?>

    