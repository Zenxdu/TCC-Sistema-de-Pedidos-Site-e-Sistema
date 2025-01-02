<?php
session_start(); 
if(isset($_SESSION['admin_sid']) || isset($_SESSION['customer_sid']))
{
    header("location:index.php");
}
else{
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="msapplication-tap-highlight" content="no">
  <title>Login</title>

  <!-- Favicons-->
  <link rel="icon" href="images/favicon/favicon-32x32.png" sizes="32x32">
  <!-- Favicons-->
  <link rel="apple-touch-icon-precomposed" href="images/favicon/apple-touch-icon-152x152.png">
  <!-- For iPhone -->
  <meta name="msapplication-TileColor" content="#00bcd4">
  <meta name="msapplication-TileImage" content="images/favicon/mstile-144x144.png">
  <!-- For Windows Phone -->

  <!-- CORE CSS-->
  <link href="css/materialize.min.css" type="text/css" rel="stylesheet" media="screen,projection">
  <link href="css/style.min.css" type="text/css" rel="stylesheet" media="screen,projection">
  <!-- Custome CSS-->    
  <link href="css/custom/custom.min.css" type="text/css" rel="stylesheet" media="screen,projection">
  <link href="css/layouts/page-center.css" type="text/css" rel="stylesheet" media="screen,projection">

  <!-- INCLUDED PLUGIN CSS ON THIS PAGE -->
  <link href="js/plugins/perfect-scrollbar/perfect-scrollbar.css" type="text/css" rel="stylesheet" media="screen,projection">
  
</head>

<body class="cyan">
  <!-- Start Page Loading -->
  <div id="loader-wrapper">
      <div id="loader"></div>        
      <div class="loader-section section-left"></div>
      <div class="loader-section section-right"></div>
  </div>
  <!-- End Page Loading -->

  <div id="login-page" class="row">
    <div class="col s12 z-depth-4 card-panel">
      <form method="post" action="routers/router.php" class="login-form" id="form">
        <div class="row">
          <div class="input-field col s12 center">
            <p class="center login-form-text">Login para fazer seu Pedido</p>
          </div>
        </div>
        <?php
        if (isset($_SESSION['login_error'])) {
            echo '<div class="row"><div class="col s12"><div id="login-error" class="card-panel red lighten-2">' . $_SESSION['login_error'] . '</div></div></div>';
            unset($_SESSION['login_error']);
        }
        ?>
        <div class="row margin">
          <div class="input-field col s12">
            <i class="mdi-social-person-outline prefix"></i>
            <input name="username" id="username" type="text">
            <label for="username" class="center-align">Usuário</label>
          </div>
        </div>
        <div class="row margin">
          <div class="input-field col s12" style="position: relative;">
            <i class="mdi-action-lock-outline prefix"></i>
            <input name="password" id="password" type="password">
            <label for="password">Senha</label>
            <img src="images/olhomostrar.png" alt="Mostrar/Esconder Senha" id="toggle-password" style="cursor: pointer; position: absolute; top: 15px; right: 10px; width: 20px; height: 20px;">
          </div>
        </div>
        <div class="row">
          <a href="javascript:void(0);" onclick="document.getElementById('form').submit();" class="btn waves-effect waves-light col s12">Login</a>
        </div>
        <div class="row">
          <div class="input-field col s6 m6 l6">
            <p class="margin medium-small center-align"><a href="forgotpassword.php">Esqueceu a senha?</a></p>
          </div>
          <div class="input-field col s6 m6 l6">
            <p class="margin medium-small"><a href="register.php">Registre-se Agora!</a></p>
          </div>
        </div>
      </form>
    </div>
  </div>

  <!-- ================================================
    Scripts
    ================================================ -->

  <!-- jQuery Library -->
  <script type="text/javascript" src="js/plugins/jquery-1.11.2.min.js"></script>
  <!--materialize js-->
  <script type="text/javascript" src="js/materialize.min.js"></script>
  <!--scrollbar-->
  <script type="text/javascript" src="js/plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>
  <!--plugins.js - Some Specific JS codes for Plugin Settings-->
  <script type="text/javascript" src="js/plugins.min.js"></script>
  <!--custom-script.js - Add your own theme custom JS-->
  <script type="text/javascript" src="js/custom-script.js"></script>

  <script type="text/javascript">
    // Esconde a mensagem de erro após 5 segundos
    document.addEventListener('DOMContentLoaded', function() {
      const loginError = document.getElementById('login-error');
      if (loginError) {
        setTimeout(() => {
          loginError.style.display = 'none';
        }, 4000);
      }

      const togglePassword = document.getElementById('toggle-password');
      const passwordField = document.getElementById('password');

      togglePassword.addEventListener('click', function() {
        const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordField.setAttribute('type', type);
      });
    });
  </script>
</body>
</html>
<?php
}
?>
