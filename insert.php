<?php
// Inicialize a sessão
session_start();

// Verifique se o usuário está logado, se não, redirecione-o para uma página de login
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}
require_once "config.php";
require_once "connecta.php";
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bem vindo</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- IonIcons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>

<body class="hold-transition layout-fixed">
    <div class="wrapper">

        <div id="sidebar">
            <?php @include('sidebar.php');  ?>
        </div>
        <div id="navbar">
            <?php @include('navbar.php');  ?>
        </div>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Upload de novo Chatroom</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">Upload de novo Chatroom</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section><!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                <?php //https://zetcode.com/php/json/

                    $chatroom = '';
                    $filename = '';
                    $data = file_get_contents($filename); //data read from json file

                    $frases = json_decode($data);  //decode a data

                    $user = $_SESSION["username"];

                    // use prepare statement for insert query
                    $st = mysqli_prepare($link, 'INSERT INTO cadastro(chatroom, frase, usuario_sistema) VALUES (?, ?, ?)');

                    // bind variables to insert query params
                    mysqli_stmt_bind_param($st, 'sss', $chatroom, $frase1, $user);

                    ?>

                    <div class="table-container">
                        <table id="tbstyle">
                            <thead>
                                <tr>
                                    <th>ChatRoom: </th>
                                    <th> <?php echo $chatroom ?> </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th>Id</th>
                                    <th>Text</th>
                                </tr>
                                
                                <?php $i=50 ; foreach ($frases as $frase) { ?>
                                    <tr>
                                        <?php if ($i-- > 0 AND !empty($frase->text)) {?>
                                        <td> <?= $frase->id; ?> </td>
                                        <td> <?= $frase->text; ?> </td>
                                    </tr>
                                    <?php
                                    $frase1 = $frase->text;

                            // execute insert query
                            mysqli_stmt_execute($st);
                            ?>

                                <?php }} ?>
                            </tbody>
                    </div><!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>

    </div>

    <!-- REQUIRED SCRIPTS -->
    <!-- jQuery -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE -->
    <script src="dist/js/adminlte.js"></script>
</body>

</html>