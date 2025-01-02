<?php 
session_start();
if (isset($_SESSION['admin_sid']) || isset($_SESSION['customer_sid'])) {
    header("location:index.php");
    exit();
}

$error = ''; // Inicialize a variável de erro

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'includes/connect.php'; // Incluir a conexão com o banco de dados

    $emailDestinatario = $_POST['email'];

    // Verificar se o e-mail é válido
    if (!filter_var($emailDestinatario, FILTER_VALIDATE_EMAIL)) {
        $error = "Não é possível enviar para esse e-mail.";
    } else {
        // Verificar se o e-mail existe no banco de dados
        $stmt = $con->prepare("SELECT email FROM users WHERE email = ?");
        $stmt->bind_param("s", $emailDestinatario);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            require 'vendor/autoload.php'; // Carregar a biblioteca SendGrid

            $codigo = rand(1000, 9999); // Gera um código de 4 dígitos

            // Salvar o código no banco de dados associado ao e-mail do usuário
            $stmt = $con->prepare("UPDATE users SET reset_code = ? WHERE email = ?");
            $stmt->bind_param("is", $codigo, $emailDestinatario);
            $stmt->execute();

            try {
                $email = new \SendGrid\Mail\Mail();
                $email->setFrom("eduardo.coltro@aluno.ifsp.edu.br", "TCC");
                $email->setSubject("Seu código de recuperação de senha");
                $email->addTo($emailDestinatario, "Destinatário");
                $email->addContent("text/plain", "Seu código de mudança de senha é: $codigo");
                $email->addContent("text/html", "<strong>Seu código de mudança de senha é:</strong> $codigo");

                // Substitua 'YOUR_SENDGRID_API_KEY' pela sua chave de API do SendGrid
                $sendgrid = new \SendGrid('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');
                $response = $sendgrid->send($email);

                if ($response->statusCode() == 202) {
                    // Redirecionar para a página de mudança de senha
                    header("Location: changepassword.php?email=$emailDestinatario");
                    exit();
                } else {
                    echo "Falha ao enviar o e-mail. Código de status: " . $response->statusCode();
                    echo " Corpo da resposta: " . $response->body();
                }
            } catch (Exception $e) {
                $error = 'Não foi possível enviar o e-mail. Por favor, tente novamente mais tarde.';
            }
        } else {
            $error = "E-mail não encontrado no banco de dados.";
        }
        $stmt->close();
        $con->close();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="msapplication-tap-highlight" content="no">
  <title>Recuperar Senha</title>

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
      <form method="POST" action="forgotpassword.php" class="login-form" id="form">
        <div class="row">
          <div class="input-field col s12 center">
            <h4>Recuperar Senha</h4>
            <p class="center">Digite seu e-mail para receber o código de recuperação de senha.</p>
          </div>
        </div>
        <?php
        if (isset($error)) {
            echo '<div class="row margin">
                <div class="col s12 center">
                    <span class="red-text text-darken-4">'.$error.'</span>
                </div>
              </div>';
        }
        ?>
        <div class="row margin">
          <div class="input-field col s12">
            <i class="mdi-communication-email prefix"></i>
            <input name="email" id="email" type="email" required>
            <label for="email">E-mail</label>
          </div>
        </div>
        <div class="row">
          <a href="javascript:void(0);" onclick="document.getElementById('form').submit();" class="btn waves-effect waves-light col s12">Enviar</a>
        </div>
        <div class="row">
          <div class="input-field col s12">
            <p class="margin center medium-small sign-up">Lembrou sua senha? <a href="login.php">Login</a></p>
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
</body>
</html>
