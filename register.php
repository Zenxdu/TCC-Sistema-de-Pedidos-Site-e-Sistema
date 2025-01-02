<?php  
// Inicia a sessão
session_start(); 

// Verifica se o usuário já está logado como administrador ou cliente
if(isset($_SESSION['admin_sid']) || isset($_SESSION['customer_sid']))
{
    // Redireciona para a página inicial se já estiver logado
    header("location:index.php");
}
else{
  $error = isset($_GET['error']) ? $_GET['error'] : '';
  $success = isset($_GET['success']) ? $_GET['success'] : '';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="msapplication-tap-highlight" content="no">
  <title>Register</title>

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
  <link href="js/plugins/perfect-scrollbar/perfect-scrollbar.css" type="text/css" rel="stylesheet" media="screen,projection">

  <style type="text/css">
  .input-field div.error{
    position: relative;
    top: -1rem;
    left: 0rem;
    font-size: 0.8rem;
    color:#FF4081;
    -webkit-transform: translateY(0%);
    -ms-transform: translateY(0%);
    -o-transform: translateY(0%);
    transform: translateY(0%);
  }
  .input-field label.active{
      width:100%;
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
  .left-alert textarea.materialize-textarea + label:after{
      left:0px;
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
  .right-alert textarea.materialize-textarea + label:after{
      right:70px;
  }
  </style> 
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
      <form class="formValidate" id="formValidate" method="post" action="routers/register-router.php" novalidate="novalidate" class="col s12">
        <!-- Mensagens de erro e sucesso -->
        <?php if ($error == 'existente'): ?>
          <div class="error" style="color: red;">Nome de usuário ou email já existem. Por favor, escolha outros.</div>
        <?php elseif ($error == 'failed'): ?>
          <div class="error" style="color: red;">Falha ao criar a conta. Por favor, tente novamente.</div>
        <?php elseif ($success == 'true'): ?>
          <div class="success" style="color: green;">Conta criada com sucesso. Faça login para continuar.</div>
        <?php endif; ?>
        <div class="row">
          <div class="input-field col s12 center">
            <h4>Registrar-se</h4>
            <p class="center">Junte-se a nós!</p>
          </div>
        </div>
        <div class="row margin">
          <div class="input-field col s12">
            <i class="mdi-social-person-outline prefix"></i>
            <input name="username" id="username" type="text"  data-error=".errorTxt1">
            <label for="username">Usuário</label>
			<div class="errorTxt1"></div>			
          </div>
        </div>
        <div class="row margin">
          <div class="input-field col s12">
            <i class="mdi-social-person prefix"></i>
            <input name="name" id="name" type="text" data-error=".errorTxt2">
            <label for="name">Nome</label>
			<div class="errorTxt2"></div>			
          </div>
        </div>
        <div class="row margin">
          <div class="input-field col s12">
            <i class="mdi-communication-email prefix"></i>
            <input name="email" id="email" type="email" data-error=".errorTxt6">
            <label for="email">Email</label>
            <div class="errorTxt6"></div>
          </div>
        </div>
        <div class="row margin">
          <div class="input-field col s12" style="position: relative;">
            <i class="mdi-action-lock-outline prefix"></i>
            <input name="password" id="password" type="password" data-error=".errorTxt3">
            <label for="password">Senha</label>
            <img src="images/olhomostrar.png" alt="Mostrar/Esconder Senha" id="toggle-password" style="cursor: pointer; position: absolute; top: 15px; right: 10px; width: 20px; height: 20px;">
			<div class="errorTxt3"></div>			
          </div>
        </div>
        <div class="row margin">
    <div class="input-field col s12" style="position: relative;">
        <i class="mdi-action-lock-outline prefix"></i>
        <input name="confirm_password" id="confirm_password" type="password" data-error=".errorTxt5">
        <label for="confirm_password">Confirmar Senha</label>
        <img src="images/olhomostrar.png" alt="Mostrar/Esconder Senha" id="toggle-confirm-password" style="cursor: pointer; position: absolute; top: 15px; right: 10px; width: 20px; height: 20px;">
        <div class="errorTxt5"></div>
    </div>
</div>
        <div class="row margin">
          <div class="input-field col s12">
            <i class="mdi-communication-phone prefix"></i>
            <input name="phone" id="phone" type="number" data-error=".errorTxt4">
            <label for="phone">Telefone</label>
			<div class="errorTxt4"></div>			
          </div>
        </div>		
        <div class="row">
          <div class="input-field col s12">
          <button type="submit" class="btn waves-effect waves-light col s12">Cadastrar</button>
          </div>
          <div class="input-field col s12">
            <p class="margin center medium-small sign-up">Já tem uma conta? <a href="login.php">Login</a></p>
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
            phone: {
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
            phone: {
                required: "Insira seu Número de Contato",
                minlength: "Mínimo de 10 caracteres necessários.",
                maxlength: "Maximo de 15 caracteres"
            },
        },
        errorElement : 'div',
        errorPlacement: function(error, element) {
            var placement = $(element).data('error');
            if (placement) {
                $(placement).append(error)
            } else {
                error.insertAfter(element);
            }
        },
        submitHandler: function(form) {
            var username = $('#username').val();
            var email = $('#email').val();
            // Verificar se o usuário ou email já existem
            $.post('verificar.php', {username: username, email: email}, function(response) {
                if (response == 'existente') {
                    alert('Nome de usuário ou email já existem. Por favor, escolha outros.');
                } else {
                    form.submit(); 
                }
            });
        }
    });

    function limparCampos() {
        // Limpar o valor de todos os campos de entrada
        $('#username').val('');
        $('#name').val('');
        $('#email').val('');
        $('#password').val('');
        $('#confirm_password').val('');
        $('#phone').val('');
        
        // Limpar as mensagens de erro
        $('.errorTxt1').empty();
        $('.errorTxt2').empty();
        $('.errorTxt3').empty();
        $('.errorTxt4').empty();
        $('.errorTxt5').empty();
        $('.errorTxt6').empty();
    }

    // Chame a função para limpar os campos quando a página é carregada
    $(document).ready(function() {
        limparCampos();

        const togglePassword = document.getElementById('toggle-password');
        const passwordField = document.getElementById('password');
        const toggleConfirmPassword = document.getElementById('toggle-confirm-password');
        const confirmPasswordField = document.getElementById('confirm_password');

        togglePassword.addEventListener('click', function() {
            const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordField.setAttribute('type', type);
        });

        toggleConfirmPassword.addEventListener('click', function() {
            const type = confirmPasswordField.getAttribute('type') === 'password' ? 'text' : 'password';
            confirmPasswordField.setAttribute('type', type);
        });
    });
</script>
</body>
</html>
<?php
}
?>
