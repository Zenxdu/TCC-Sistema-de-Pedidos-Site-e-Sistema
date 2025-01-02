<?php
// Carregar a biblioteca do banco de dados
require 'vendor/autoload.php'; 

// Verificar se o método de solicitação é POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Incluir a conexão com o banco de dados
    include 'includes/connect.php'; 

    // Obter dados do formulário
    $email = $_POST['email'];
    $codigo = $_POST['codigo'];
    $nova_senha = $_POST['nova_senha'];
    $confirmar_nova_senha = $_POST['confirmar_nova_senha'];

    // Validar o código
    if (strlen($codigo) != 4 || !ctype_digit($codigo)) {
        $error = "Código de recuperação inválido. Deve ter 4 dígitos.";
    }
    // Validar a nova senha
    elseif (strlen($nova_senha) < 5 || strlen($nova_senha) > 20) {
        $error = "A senha deve ter entre 5 e 20 caracteres.";
    }
    // Verificar o código no banco de dados associado ao e-mail do usuário
    else {
        $stmt = $con->prepare("SELECT reset_code FROM users WHERE email=?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->bind_result($codigo_db);
        $stmt->fetch();
        $stmt->close();

        // Comparar código fornecido com o código no banco de dados
        if ($codigo_db == $codigo) {
            // Verificar se as senhas coincidem
            if ($nova_senha === $confirmar_nova_senha) {
                // Atualizar a senha no banco de dados
                $hash = $nova_senha; // Certifique-se de usar hashing seguro
                $stmt = $con->prepare("UPDATE users SET password=?, reset_code=NULL WHERE email=?");
                $stmt->bind_param("ss", $hash, $email);
                $stmt->execute();
                $stmt->close();

                // Exibir mensagem de sucesso e redirecionar para a página de login
                echo "<script>alert('Senha alterada com sucesso.'); window.location.href='login.php';</script>";
                exit();
            } else {
                // Exibir mensagem de erro se as senhas não coincidirem
                $error = "As senhas não coincidem.";
            }
        } else {
            // Exibir mensagem de erro se o código de recuperação for inválido
            $error = "Código de recuperação inválido.";
        }
    }

    // Fechar a conexão com o banco de dados
    $con->close();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="msapplication-tap-highlight" content="no">
  <title>Mudar Senha</title>

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
  <!-- Custom CSS-->    
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
      <form method="POST" action="changepassword.php" class="login-form" id="formValidate">
        <div class="row">
          <div class="input-field col s12 center">
            <h4>Mudar Senha</h4>
            <p class="center">Digite o código recebido e sua nova senha.</p>
          </div>
        </div>
        <?php
        // Exibir mensagem de erro, se houver
        if (isset($error)) {
            echo '<div class="row margin">
                <div class="col s12 center">
                    <span class="red-text text-darken-4">'.$error.'</span>
                </div>
              </div>';
        }
        ?>
        <input type="hidden" name="email" value="<?php echo isset($_GET['email']) ? htmlspecialchars($_GET['email']) : ''; ?>">
        <div class="row margin">
          <div class="input-field col s12">
            <i class="mdi-communication-vpn-key prefix"></i>
            <input name="codigo" id="codigo" type="text" required>
            <label for="codigo">Código</label>
          </div>
        </div>
        <div class="row margin">
          <div class="input-field col s12" style="position: relative;">
            <i class="mdi-action-lock-outline prefix"></i>
            <input name="nova_senha" id="nova_senha" type="password" required>
            <label for="nova_senha">Nova Senha</label>
            <img src="images/olhomostrar.png" alt="Mostrar/Esconder Senha" id="toggle-nova-senha" style="cursor: pointer; position: absolute; top: 15px; right: 10px; width: 20px; height: 20px;">
          </div>
        </div>
        <div class="row margin">
          <div class="input-field col s12" style="position: relative;">
            <i class="mdi-action-lock-outline prefix"></i>
            <input name="confirmar_nova_senha" id="confirmar_nova_senha" type="password" required>
            <label for="confirmar_nova_senha">Confirmar Nova Senha</label>
            <img src="images/olhomostrar.png" alt="Mostrar/Esconder Senha" id="toggle-confirmar-nova-senha" style="cursor: pointer; position: absolute; top: 15px; right: 10px; width: 20px; height: 20px;">
          </div>
        </div>
        <div class="row">
          <a href="javascript:void(0);" onclick="document.getElementById('formValidate').submit();" class="btn waves-effect waves-light col s12">Mudar Senha</a>
        </div>
        <div class="row">
          <div class="input-field col s12">
            <p class="margin center medium-small sign-up">Lembrou sua senha? <a href="login.php">Login</a></p>
          </div>
        </div>
      </form>
    </div>
  </div>

  <!-- Scripts -->
  <script type="text/javascript" src="js/plugins/jquery-1.11.2.min.js"></script>
  <script type="text/javascript" src="js/materialize.min.js"></script>
  <script type="text/javascript" src="js/plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>
  <script type="text/javascript" src="js/plugins/jquery-validation/jquery.validate.min.js"></script>
  <script type="text/javascript" src="js/plugins/jquery-validation/additional-methods.min.js"></script>
  <script type="text/javascript" src="js/plugins.min.js"></script>
  <script type="text/javascript" src="js/custom-script.js"></script>
  <script type="text/javascript">
    $("#formValidate").validate({
      rules: {
        codigo: {
            required: true,
            minlength: 4,
            maxlength: 4,
            digits: true
        },
        nova_senha: {
            required: true,
            minlength: 5,
            maxlength: 20
        },
        confirmar_nova_senha: {
            required: true,
            minlength: 5,
            maxlength: 20,
            equalTo: "#nova_senha"
        },
      },
      messages: {
        codigo: {
            required: "Insira o código de recuperação",
            minlength: "O código deve ter 4 dígitos",
            maxlength: "O código deve ter 4 dígitos",
            digits: "O código deve conter apenas números"
        },
        nova_senha: {
            required: "Insira a nova senha",
            minlength: "A senha deve ter no mínimo 5 caracteres",
            maxlength: "A senha deve ter no máximo 20 caracteres"
        },
        confirmar_nova_senha: {
            required: "Confirme a nova senha",
            minlength: "A senha deve ter no mínimo 5 caracteres",
            maxlength: "A senha deve ter no máximo 20 caracteres",
            equalTo: "As senhas não coincidem"
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

    document.addEventListener('DOMContentLoaded', function() {
        const toggleNovaSenha = document.getElementById('toggle-nova-senha');
        const novaSenhaField = document.getElementById('nova_senha');
        const toggleConfirmarNovaSenha = document.getElementById('toggle-confirmar-nova-senha');
        const confirmarNovaSenhaField = document.getElementById('confirmar_nova_senha');

        toggleNovaSenha.addEventListener('click', function() {
            const type = novaSenhaField.getAttribute('type') === 'password' ? 'text' : 'password';
            novaSenhaField.setAttribute('type', type);
        });

        toggleConfirmarNovaSenha.addEventListener('click', function() {
            const type = confirmarNovaSenhaField.getAttribute('type') === 'password' ? 'text' : 'password';
            confirmarNovaSenhaField.setAttribute('type', type);
        });
    });
  </script>
</body>
</html>
