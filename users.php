<?php 
include 'includes/connect.php';

if ($_SESSION['admin_sid'] == session_id()) {
?>
<!DOCTYPE html>
<html lang="pt">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="msapplication-tap-highlight" content="no">
  <title>Lista de Usuários</title>

  <!-- Favicons-->
  <link rel="icon" href="images/favicon/favicon-32x32.png" sizes="32x32">
  <link rel="apple-touch-icon-precomposed" href="images/favicon/apple-touch-icon-152x152.png">
  <meta name="msapplication-TileColor" content="#00bcd4">
  <meta name="msapplication-TileImage" content="images/favicon/mstile-144x144.png">

  <!-- CORE CSS-->
  <link href="css/materialize.min.css" type="text/css" rel="stylesheet" media="screen,projection">
  <link href="css/style.min.css" type="text/css" rel="stylesheet" media="screen,projection">
  <link href="css/custom/custom.min.css" type="text/css" rel="stylesheet" media="screen,projection">
  <link href="css/layouts/page-center.css" type="text/css" rel="stylesheet" media="screen,projection">
  <link href="js/plugins/perfect-scrollbar/perfect-scrollbar.css" type="text/css" rel="stylesheet" media="screen,projection">

  <style type="text/css">
    .input-field div.error {
      position: relative;
      top: -1rem;
      left: 0rem;
      font-size: 0.8rem;
      color: #FF4081;
      transform: translateY(0%);
    }

    .input-field label.active {
      width: 100%;
    }

    .left-alert input[type=text] + label:after,
    .left-alert input[type=password] + label:after,
    .left-alert input[type=email] + label:after,
    .left-alert input[type=url] + label:after,
    .left-alert input[type=time] + label:after,
    .left-alert input[type=date] + label:after,
    .left-alert input[type=datetime-local] + label:after,
    .left-alert input[type=tel] + label:after,
    .left-alert input[type=number] + label:after,
    .left-alert input[type=search] + label:after,
    .left-alert textarea.materialize-textarea + label:after {
      left: 0px;
    }

    .right-alert input[type=text] + label:after,
    .right-alert input[type=password] + label:after,
    .right-alert input[type=email] + label:after,
    .right-alert input[type=url] + label:after,
    .right-alert input[type=time] + label:after,
    .right-alert input[type=date] + label:after,
    .right-alert input[type=datetime-local] + label:after,
    .right-alert input[type=tel] + label:after,
    .right-alert input[type=number] + label:after,
    .right-alert input[type=search] + label:after,
    .right-alert textarea.materialize-textarea + label:after {
      right: 70px;
    }
  </style>
</head>

<body>
  <!-- Start Page Loading -->
  <div id="loader-wrapper">
    <div id="loader"></div>
    <div class="loader-section section-left"></div>
    <div class="loader-section section-right"></div>
  </div>
  <!-- End Page Loading -->

  <!-- //////////////////////////////////////////////////////////////////////////// -->

  <!-- START HEADER -->
  <header id="header" class="page-topbar">
    <!-- start header nav-->
    <div class="navbar-fixed">
      <nav class="navbar-color">
        <div class="nav-wrapper">
          <ul class="left">
            <li>
              <h1 class="logo-wrapper"><a href="index.php" class="brand-logo darken-1"></a> <span class="logo-text">Logo</span></h1>
            </li>
          </ul>
        </div>
      </nav>
    </div>
    <!-- end header nav-->
  </header>
  <!-- END HEADER -->

  <!-- //////////////////////////////////////////////////////////////////////////// -->

  <!-- START MAIN -->
  <div id="main">
    <!-- START WRAPPER -->
    <div class="wrapper">

      <!-- START LEFT SIDEBAR NAV-->
      <aside id="left-sidebar-nav">
        <ul id="slide-out" class="side-nav fixed leftside-navigation">
          <li class="user-details cyan darken-2">
            <div class="row">
              <div class="col col s4 m4 l4">
                <img src="images/avatar.jpg" alt="" class="circle responsive-img valign profile-image">
              </div>
              <div class="col col s8 m8 l8">
                <ul id="profile-dropdown" class="dropdown-content">
                  <li><a href="routers/logout.php"><i class="mdi-hardware-keyboard-tab"></i> Sair</a></li>
                </ul>
              </div>
              <div class="col col s8 m8 l8">
                <a class="btn-flat dropdown-button waves-effect waves-light white-text profile-btn" href="#" data-activates="profile-dropdown"><?php echo $name; ?> <i class="mdi-navigation-arrow-drop-down right"></i></a>
                <p class="user-roal"><?php echo $role; ?></p>
              </div>
            </div>
          </li>
          <li class="bold"><a href="index.php" class="waves-effect waves-cyan"><i class="mdi-action-add-shopping-cart"></i> Menu de Comida</a>
            <li class="bold"><a href="custom.php" class="waves-effect waves-cyan"><i class="mdi-editor-border-color"></i>Pedido Customizado</a></li>
          <li class="no-padding">
            <ul class="collapsible collapsible-accordion">
              <li class="bold"><a class="collapsible-header waves-effect waves-cyan"><i class="mdi-editor-insert-invitation"></i> Pedidos</a>
                <div class="collapsible-body">
                  <ul>
                    <li><a href="all-orders.php">Todos os Pedidos</a></li>
                    <?php
                    $sql = mysqli_query($con, "SELECT DISTINCT status FROM orders;");
                    while ($row = mysqli_fetch_array($sql)) {
                      echo '<li><a href="all-orders.php?status=' . $row['status'] . '">' . $row['status'] . '</a></li>';
                    }
                    ?>
                  </ul>
                </div>
              </li>
            </ul>
          </li>
          <li class="bold active"><a href="users.php" class="waves-effect waves-cyan"><i class="mdi-social-person"></i> Usuários</a></li>
        </ul>
        <a href="#" data-activates="slide-out" class="sidebar-collapse btn-floating btn-medium waves-effect waves-light hide-on-large-only cyan"><i class="mdi-navigation-menu"></i></a>
      </aside>
      <!-- END LEFT SIDEBAR NAV-->

      <!-- //////////////////////////////////////////////////////////////////////////// -->

      <!-- START CONTENT -->
      <section id="content">

        <!--breadcrumbs start-->
        <div id="breadcrumbs-wrapper">
          <div class="container">
            <div class="row">
              <div class="col s12 m12 l12">
                <h5 class="breadcrumbs-title">Lista de Usuários</h5>
              </div>
            </div>
          </div>
        </div>
        <!--breadcrumbs end-->

        <!--start container-->
        <div class="container">
          <p class="caption">Habilitar, Desabilitar ou Verificar Usuários.</p>
          <div class="divider"></div>
          <!--editableTable-->
          <div id="editableTable" class="section">
            <form class="formValidate" id="formValidate1" method="post" action="routers/user-router.php" novalidate="novalidate">
              <div class="row">
                <div class="col s12">
                  <h4 class="header">Lista de Usuários</h4>
                </div>
                <div class="col s12">
                  <table class="responsive-table">
                    <thead>
                      <tr>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Contato</th>
                        <th>Endereço</th>
                        <th>Papel</th>
                        <th>Habilitar</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $result = mysqli_query($con, "SELECT * FROM users");
                      while ($row = mysqli_fetch_array($result)) {
                        echo '<tr><td>' . $row["name"] . '</td>';
                        echo '<td>' . $row["email"] . '</td>';
                        echo '<td>' . $row["contact"] . '</td>';
                        echo '<td>' . $row["address"] . '</td>';
                        echo '<td><select name="' . $row['id'] . '_role" ' . ($row['role'] == 'Administrador' ? 'disabled' : '') . '>
                          <option value="Administrador"' . ($row['role'] == 'Administrador' ? 'selected' : '') . '>Administrador</option>
                          <option value="Cliente"' . ($row['role'] == 'Cliente' ? 'selected' : '') . '>Cliente</option>
                        </select></td>';
                        echo '<td><select name="' . $row['id'] . '_deleted" ' . ($row['role'] == 'Administrador' ? 'disabled' : '') . '>
                          <option value="1"' . ($row['deleted'] ? 'selected' : '') . '>Desabilitar</option>
                          <option value="0"' . (!$row['deleted'] ? 'selected' : '') . '>Habilitar</option>
                        </select></td>';
                      }
                      ?>
                    </tbody>
                  </table>
                </div>
                <div class="input-field col s12">
                  <button class="btn cyan waves-effect waves-light right" type="submit" name="action">Modificar
                    <i class="mdi-content-send right"></i>
                  </button>
                </div>
              </div>
            </form>
            <form class="formValidate" id="formValidate" method="post" action="routers/add-users.php" novalidate="novalidate">
              <div class="row">
                <div class="col s12">
                  <h4 class="header">Adicionar Usuário</h4>
                </div>
                <div class="col s12">
                  <table class="responsive-table">
                    <thead>
                      <tr>
                        <th>Nome de Usuário</th>
                        <th>Senha</th>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Número de Telefone</th>
                        <th>Endereço</th>
                        <th>Papel</th>
                        <th>Habilitar</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      echo '<tr><td><label for="username">Nome de Usuário</label><input id="username" name="username" type="text" data-error=".errorTxt02"><div class="errorTxt02"></div></td>';
                      echo '<td><label for="password">Senha</label><input id="password" name="password" type="password" data-error=".errorTxt03"><div class="errorTxt03"></div></td>';
                      echo '<td><label for="name">Nome</label><input id="name" name="name" type="text" data-error=".errorTxt04"><div class="errorTxt04"></div></td>';
                      echo '<td><label for="email">Email</label><input id="email" name="email" type="email"></td>';
                      echo '<td><label for="contact">Número de Telefone</label><input id="contact" name="contact" type="number" data-error=".errorTxt05"><div class="errorTxt05"></div></td>';
                      echo '<td><label for="address">Endereço</label><input id="address" name="address" type="text" data-error=".errorTxt06"><div class="errorTxt06"></div></td>';
                      echo '<td><select name="role">
                        <option value="Administrador">Administrador</option>
                        <option value="Cliente" selected>Cliente</option>
                      </select></td>';
                      echo '<td><select name="deleted">
                        <option value="1">Desabilitar</option>
                        <option value="0" selected>Habilitar</option>
                      </select></td></tr>';
                      ?>
                    </tbody>
                  </table>
                </div>
                <div class="input-field col s12">
                  <button class="btn cyan waves-effect waves-light right" type="submit" name="action">Adicionar
                    <i class="mdi-content-send right"></i>
                  </button>
                </div>
              </div>
            </form>
            <div class="divider"></div>

          </div>
        </div>
        <!--end container-->

      </section>
      <!-- END CONTENT -->
    </div>
    <!-- END WRAPPER -->

  </div>
  <!-- END MAIN -->

  <!-- //////////////////////////////////////////////////////////////////////////// -->

  <!-- START FOOTER -->
  <footer class="page-footer">
    <div class="footer-copyright">
      <div class="container">
        <span>Copyright © 2024 Todos os direitos reservados.</span>
        <span class="right"> Design e Desenvolvimento por Best Burgers</span>
      </div>
    </div>
  </footer>
  <!-- END FOOTER -->

  <!-- ================================================
  Scripts
  ================================================ -->

  <!-- jQuery Library -->
  <script type="text/javascript" src="js/plugins/jquery-1.11.2.min.js"></script>
  <!--angularjs-->
  <script type="text/javascript" src="js/plugins/angular.min.js"></script>
  <!--materialize js-->
  <script type="text/javascript" src="js/materialize.min.js"></script>
  <!--scrollbar-->
  <script type="text/javascript" src="js/plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>
  <script type="text/javascript" src="js/plugins/jquery-validation/jquery.validate.min.js"></script>
  <script type="text/javascript" src="js/plugins/jquery-validation/additional-methods.min.js"></script>

  <!--plugins.js - Some Specific JS codes for Plugin Settings-->
  <script type="text/javascript" src="js/plugins.min.js"></script>
  <!--custom-script.js - Add your own theme custom JS-->
  <script type="text/javascript" src="js/custom-script.js"></script>
  <script type="text/javascript">
    $("#formValidate").validate({
      rules: {
            username: {
                required: true,
                minlength: 5,
                maxlength: 20
            },
            name: {
                required: true,
                minlength: 5,
                maxlength: 30
            },
            email: {
                required: true,
                email: true,
                maxlength: 50
            },
            password: {
                required: true,
                minlength: 5,
                maxlength: 20
            },
            confirm_password: {
                required: true,
                minlength: 5,
                maxlength: 20,
                equalTo: "#password"
            },
            contact: {
                required: true,
                minlength: 10,
                maxlength: 15
            },
        },
        messages: {
            username: {
                required: "Insira seu Usuário",
                minlength: "Mínimo de 5 caracteres necessários.",
                maxlength: "Maximo de 20 caracteres"
            },
            name: {
                required: "Insira Seu Nome",
                minlength: "Mínimo de 5 caracteres necessários.",
                maxlength: "Maximo de 30 caracteres"
            },
            email: {
                required: "Insira seu Email",
                email: "Insira um Email válido",
                maxlength: "Maximo de 50 caracteres"
            },
            password: {
                required: "Insira a Senha",
                minlength: "Mínimo de 5 caracteres necessários.",
                maxlength: "Maximo de 20 caracteres",
            },
            confirm_password: {
                required: "Confirme sua Senha",
                minlength: "Mínimo de 5 caracteres necessários.",
                maxlength: "Maximo de 20 caracteres",
                equalTo: "As senhas não coincidem"
            },
            contact: {
                required: "Insira seu Número de Contato",
                minlength: "Mínimo de 10 caracteres necessários.",
                maxlength: "Maximo de 15 caracteres"
            },
        },
      errorElement: 'div',
      errorPlacement: function(error, element) {
        var placement = $(element).data('error');
        if (placement) {
          $(placement).append(error)
        } else {
          error.insertAfter(element);
        }
      }
    });
  </script>
</body>

</html>
<?php
}else {
  if ($_SESSION['customer_sid'] == session_id()) {
    header("location:index.php");
  } else {
    header("location:login.php");
  }
}
?>
