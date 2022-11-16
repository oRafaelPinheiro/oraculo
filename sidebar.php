<!-- Main Sidebar Container -->
<aside class="main-sidebar main-sidebar-custom sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="index.php" class="brand-link">
    <img src="images/logo.png" alt="OraculoLogo" class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light">Oraculo</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="info">
        <a href="#" class="d-block">Bem vindo <?php echo htmlspecialchars($_SESSION["username"]); ?></a>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->

        <?php if ($_SESSION["id"] == '1') {
          echo "<li class='nav-item'>";
          echo "<a href='insert.php' class='nav-link'>";
          echo "<i class='nav-icon fas fa-edit'></i>";
          echo "<p>";
          echo "Upload Chat*";
          echo "</p>";
          echo "</a>";
          echo "</li>";
        } ?>

        <li class="nav-item">
          <a href="welcome.php" class="nav-link">
            <i class="nav-icon ion ion-clipboard mr-1"></i>
            <p>
              Frases
            </p>
          </a>
        </li>

        <li class="nav-item">
          <a href="reset-password.php" class="nav-link">
            <i class="nav-icon far fa-chart-bar"></i>
            <p>
              Redefinir sua senha
            </p>
          </a>
        </li>

        <?php if ($_SESSION["id"] == '1') {
          echo "<li class='nav-item'>";
          echo "<a href='register.php' class='nav-link'>";
          echo "<i class='nav-icon fas fa-th'></i>";
          echo "<p>";
          echo "Cadastrar novo Usuário";
          echo "</p>";
          echo "</a>";
          echo "</li>";
        } ?>


        <li class="nav-item">
          <a href="logout.php" class="nav-link">
            <i class="nav-icon fas fa-th"></i>
            <p>
              Sair do sistema
            </p>
          </a>
        </li>

      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>