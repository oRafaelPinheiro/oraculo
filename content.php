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


$user_id = $_SESSION["id"];

$busca = "SELECT * FROM cadastro c
LEFT JOIN sentimentos s
ON s.frase_id = c.id and s.users_id = $user_id
LEFT JOIN users u
ON u.u_id = s.users_id
WHERE s.users_id = $user_id or u.u_id is null
ORDER by c.id
";

$total_reg = "10";

$pagina = $_GET['pagina'];
if (!$pagina) {
  $pc = "1";
} else {
  $pc = $pagina;
}

$inicio = $pc - 1;
$inicio = $inicio * $total_reg;


$limite = mysqli_query($link, "$busca LIMIT $inicio,$total_reg");
$todos = mysqli_query($link, "$busca");

$tr = mysqli_num_rows($todos); // verifica o número total de registros
$tp = $tr / $total_reg; // verifica o número total de páginas

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
        <h3 class="card-title">Classificação das Frases</h3>
      </div>

      <div class="card-body">
        <!-- Frases -->
        <table class="table">
          <thead>
            <tr>
              <th>ID</th>
              <th>ChatRoom</th>
              <th>Frase</th>
              <th>Classificação</th>
              <th data-toggle="tooltip" title="Realizar nova calssificação?"> 
                Classificar
                <span><ion-icon name="help-outline"></ion-icon></span>
            
              </th>
            </tr>
          </thead>

          <tbody>
            <?php
            while ($row_frases = mysqli_fetch_array($limite)) {;
            ?>
              <form action="sentimento.php" method="post">
                <tr>
                  <td><?php echo $row_frases["id"]; ?></td>
                  <td><?php echo $row_frases["chatroom"]; ?></td>
                  <td><?php echo $row_frases["frase"]; ?></td>
                  <td><?php echo $row_frases["sentimento"]; ?></td>

                  <td>
                    <div class="btn-group">
                      <input type="hidden" name="id" value="<?php echo $row_frases["id"]; ?>" />
                      <input type="hidden" name="pagina" value="<?php echo $pc; ?>" />
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

      <div class="card-footer clearfix">
        <ul class="pagination pagination-sm m-0">
          <?php
          $anterior = $pc - 1;
          $proximo = $pc + 1;
          if ($pc > 1) {
            echo "<li class='page-item'><a class='page-link' href='?pagina=$anterior'>« Anterior</a></li>";
          }
          if ($pc < $tp) {
            echo "<li class='page-item'><a class='page-link' href='?pagina=$proximo'>Próxima »</a></li>";
          }
          ?>
        </ul>



      </div>




    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>


<script>
    // jQuery code for initializing a tooltip
    $(document).ready(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>