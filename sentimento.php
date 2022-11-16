<?php
// Inicialize a sessão
session_start();

// Incluir arquivo de configuração
require_once "config.php";

// Verifique se o usuário está logado, se não, redirecione-o para uma página de login
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
  header("location: login.php");
  exit;
}
require_once "connecta.php";

//CHECKING SUBMIT BUTTON PRESS or NOT.
if (isset($_POST["sentimento"])) {
  $id = $_POST["id"];
  $pagina = $_POST["pagina"];
  $user = $_SESSION["id"];
  $sentimento = $_POST["sentimento"];


  //echo "ID: $id";
  //echo "pagina: $pagina";
  //echo "User: $user";
  //echo "Sentimento: $sentimento";

  $insere = "INSERT INTO sentimentos (frase_id, users_id, sentimento) VALUES( '$id', '$user', '$sentimento')";

  $atualiza = "UPDATE sentimentos SET frase_id = '$id', users_id = '$user', sentimento = '$sentimento' WHERE frase_id = '$id'";

  $busca = "SELECT * FROM sentimentos WHERE frase_id = $id AND users_id = $user";
  //echo "<br>. $busca";

  $data = mysqli_query($link, "$busca");

  if ($data->num_rows == 0) {
    //echo "<br> == 0 <br> $data->num_rows";
    mysqli_query($link, "$insere");
    header("location:welcome.php?pagina=$pagina");
  } elseif ($data->num_rows == 1) {
    //echo "<br> == 1 <br> $data->num_rows";
    mysqli_query($link, "$atualiza");
    header("location:welcome.php?pagina=$pagina");
  }
}
