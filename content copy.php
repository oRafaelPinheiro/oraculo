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
$result_relatorio = "SELECT frase FROM cadastro";
$resultado_relatorio = mysqli_query($link, $result_relatorio);

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

      <div class="card-header">
        <div class="row">
          <div class="col-9">
            <h3 class="card-title"> Frase </h3>
            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                <i class="fas fa-minus"></i>
              </button>
              <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                <i class="fas fa-times"></i>
              </button>
            </div>
          </div>
          <div class="col-3">
            <h3 class="card-title"> Classificação </h3>
          </div>
        </div>
      </div>

      <div class="card-body">
        <div class="row">
          <div class="col-9">
            <!-- Frases -->
            <?php
            //$row = mysqli_fetch_array($resultado_relatorio); //verificar uso   
            while ($row_frases = mysqli_fetch_assoc($resultado_relatorio)) {;
            ?>

              <tr>

                <td class="text-center"><?php echo $row_frases["frase"]; ?></td>


              </tr>
            <?php } ?>

            <!-- Fim frase -->
          </div>
          <div class="col-3">
            <p> Positivo </p>
            <p> Neutro </p>
            <p> Negativo </p>



          </div>
        </div>
      </div>
      <div class="card-footer">
        <button> Próxima Frase</button>
      </div>




    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>



</div><!-- /.wrapper -->
<!-- /.content -->