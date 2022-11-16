<?php
// Incluir arquivo de configuração
require_once "config.php";
 
// Defina variáveis e inicialize com valores vazios
$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";
 
// Processando dados do formulário quando o formulário é enviado
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validar nome de usuário
    if(empty(trim($_POST["username"]))){
        $username_err = "Por favor coloque um nome de usuário.";
    } elseif(!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["username"]))){
        $username_err = "O nome de usuário pode conter apenas letras, números e sublinhados.";
    } else{
        // Prepare uma declaração selecionada
        $sql = "SELECT u_id FROM users WHERE username = :username";
        
        if($stmt = $pdo->prepare($sql)){
            // Vincule as variáveis à instrução preparada como parâmetros
            $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);
            
            // Definir parâmetros
            $param_username = trim($_POST["username"]);
            
            // Tente executar a declaração preparada
            if($stmt->execute()){
                if($stmt->rowCount() == 1){
                    $username_err = "Este nome de usuário já está em uso.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Ops! Algo deu errado. Por favor, tente novamente mais tarde.";
            }

            // Fechar declaração
            unset($stmt);
        }
    }
    
    // Validar senha
    if(empty(trim($_POST["password"]))){
        $password_err = "Por favor insira uma senha.";     
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "A senha deve ter pelo menos 6 caracteres.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validar e confirmar a senha
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Por favor, confirme a senha.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "A senha não confere.";
        }
    }
    
    // Verifique os erros de entrada antes de inserir no banco de dados
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err)){
        
        // Prepare uma declaração de inserção
        $sql = "INSERT INTO users (username, password) VALUES (:username, :password)";
         
        if($stmt = $pdo->prepare($sql)){
            // Vincule as variáveis à instrução preparada como parâmetros
            $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);
            $stmt->bindParam(":password", $param_password, PDO::PARAM_STR);
            
            // Definir parâmetros
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            
            // Tente executar a declaração preparada
            if($stmt->execute()){
                // Redirecionar para a página de login
                header("location: index.php");
            } else{
                echo "Ops! Algo deu errado. Por favor, tente novamente mais tarde.";
            }

            // Fechar declaração
            unset($stmt);
        }
    }
    
    // Fechar conexão
    unset($pdo);
}
?>
 
 <!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Novo Teste</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- IonIcons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>

<body class="hold-transition sidebar">
    <div class="wrapper">
        <div id="navbar">
            <?php @include('navbar.php');  ?>
        </div>
        <div id="sidebar">
            <?php @include('sidebar.php'); ?>
        </div>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Cadastro de Novo Usuário</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Cadastro de Novo Usuário</li>
                    </ol>
                </div>
                </div>
            </div><!-- /.container-fluid -->
            </section><!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
            <div class="container-fluid">
                <div class="row">
                <!-- left column -->
                <div class="col-md-6">
                    <!-- general form elements -->
                    <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Por favor, preencha este formulário para criar uma conta.</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Nome do usuário:</label>
                                <input type="text" name="username" class="form-control" placeholder="Usuário <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                                <span class="invalid-feedback"><?php echo $username_err; ?></span>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Senha:</label>
                                <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>">
                                <span class="invalid-feedback"><?php echo $password_err; ?></span>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Nova senha:</label>
                                <input type="password" name="confirm_password" class="form-control" placeholder="Digite Novamente <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>">
                                <span class="invalid-feedback" ><?php echo $confirm_password_err; ?></span>
                            </div>
                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer">
                            <input type="submit" class="btn btn-primary" value="Criar Conta">
                            <input type="reset" class="btn btn-secondary ml-2" value="Apagar Dados">
                        </div>
                        
                    </form>
                    </div>
                    <!-- /.card -->
                </div>
                <!--/.col (right) -->
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
            </section>
            <!-- /.content -->
            </div>
        <div id="footer">
            <?php @include('footer.php') ?>
        </div>
    </div><!-- /.wrapper -->
    <!-- /.content -->

    <!-- REQUIRED SCRIPTS -->
    <!-- jQuery -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE -->
    <script src="dist/js/adminlte.js"></script>
</body>
</html>