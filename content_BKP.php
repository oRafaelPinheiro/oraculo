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


//Selecionar  os itens da página
$result_relatorio = "SELECT * FROM cadastro";
$resultado_relatorio = mysqli_query($link, $result_relatorio);

$result_classificacao = "SELECT * FROM sentimentos";
$resultado_classificacao = mysqli_query($link, $result_classificacao);

?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Frases</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section><!-- /.content-header -->

  <!-- Main content -->
  <section class="content">
    <div class="card">

      <div class="card-body">
        <!-- Frases -->
        <table class="table">
          <thead>
            <tr>
              <th>ID</th>
              <th>ChatRoom</th>
              <th>Frase</th>
              <th>Classificação</th>
              <th>Classificar?</th>
            </tr>
          </thead>

          <tbody>
            <?php
            while ($row_frases = mysqli_fetch_assoc($resultado_relatorio)) {;
              

            ?>
              <form action="sentimento.php" method="post">
                <tr>
                  <td><?php echo $row_frases["id"]; ?></td>
                  <td><?php echo $row_frases["chatroom"]; ?></td>
                  <td><?php echo $row_frases["frase"]; ?></td>
                  <td><?php echo $row_sentimentos["sentimento"]; ?></td>

                  <td>
                    <div class="btn-group">
                      <input type="hidden" name="id" value="<?php echo $row_frases["id"]; ?>" />
                      <button type="submit" class="btn btn-success" name="sentimento" value="positiva"> Positiva </button>
                      <button type="submit" class="btn btn-secondary" name="sentimento" value="neutra"> Neutra </button>
                      <button type="submit" class="btn btn-danger" name="sentimento" value="negativa"> Negativa </button>
                    </div>
                  </td>
                </tr>
              </form>

            <?php } ?>
          </tbody>
          <!-- Fim frase -->
        </table>
      </div>




    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>