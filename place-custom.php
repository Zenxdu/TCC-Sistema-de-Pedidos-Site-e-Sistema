<?php 
include 'includes/connect.php';
include 'includes/wallet.php';
$total = 0;
if ($_SESSION['customer_sid'] == session_id()) {
    $user_id = $_SESSION['user_id'];
    $result = mysqli_query($con, "SELECT * FROM users WHERE id = $user_id");
    while ($row = mysqli_fetch_array($result)) {
        $name = $row['name'];    
        $address = $row['address'];
        $contact = $row['contact'];
    }
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="msapplication-tap-highlight" content="no">
  <title>Detalhes do Pedido</title>

  <!-- Favicons-->
  <link rel="icon" href="images/favicon/favicon-32x32.png" sizes="32x32">
  <link rel="apple-touch-icon-precomposed" href="images/favicon/apple-touch-icon-152x152.png">
  <meta name="msapplication-TileColor" content="#00bcd4">
  <meta name="msapplication-TileImage" content="images/favicon/mstile-144x144.png">

  <!-- CORE CSS-->
  <link href="css/materialize.min.css" type="text/css" rel="stylesheet" media="screen,projection">
  <link href="css/style.min.css" type="text/css" rel="stylesheet" media="screen,projection">
  <link href="css/custom/custom.min.css" type="text/css" rel="stylesheet" media="screen,projection">
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
    #orderPreview {
      border: 1px solid #ddd;
      padding: 10px;
      min-height: 400px;
    }
  </style>
</head>

<body>
  <div id="loader-wrapper">
    <div id="loader"></div>
    <div class="loader-section section-left"></div>
    <div class="loader-section section-right"></div>
  </div>

  <header id="header" class="page-topbar">
    <div class="navbar-fixed">
      <nav class="navbar-color">
        <div class="nav-wrapper">
          <ul class="left">
            <li><h1 class="logo-wrapper"><a href="index.php" class="brand-logo darken-1"></a> <span class="logo-text">Logo</span></h1></li>
          </ul>
        </div>
      </nav>
    </div>
  </header>

  <div id="main">
    <div class="wrapper">
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
                <a class="btn-flat dropdown-button waves-effect waves-light white-text profile-btn" href="#" data-activates="profile-dropdown"><?php echo $name;?> <i class="mdi-navigation-arrow-drop-down right"></i></a>
                <p class="user-roal"><?php echo $role;?></p>
              </div>
            </div>
          </li>
          <li class="bold"><a href="index.php" class="waves-effect waves-cyan"><i class="mdi-action-add-shopping-cart"></i>Fazer Pedido</a></li>
          <li class="bold active"><a href="custom.php" class="waves-effect waves-cyan"><i class="mdi-editor-border-color"></i>Pedido Customizado</a></li>
          <li class="no-padding">
            <ul class="collapsible collapsible-accordion">
              <li class="bold"><a class="collapsible-header waves-effect waves-cyan"><i class="mdi-editor-insert-invitation"></i> Pedidos</a>
                <div class="collapsible-body">
                  <ul>
                    <li><a href="orders.php">Todos os Pedidos</a></li>
                    <?php
                      $sql = mysqli_query($con, "SELECT DISTINCT status FROM orders WHERE customer_id = $user_id;");
                      while($row = mysqli_fetch_array($sql)){
                        echo '<li><a href="orders.php?status='.$row['status'].'">'.$row['status'].'</a></li>';
                      }
                    ?>
                  </ul>
                </div>
              </li>
            </ul>
          </li>
          <li class="bold"><a href="details.php" class="waves-effect waves-cyan"><i class="mdi-social-person"></i> Editar Detalhes</a></li>
        </ul>
        <a href="#" data-activates="slide-out" class="sidebar-collapse btn-floating btn-medium waves-effect waves-light hide-on-large-only cyan"><i class="mdi-navigation-menu"></i></a>
      </aside>

      <section id="content">
        <div id="breadcrumbs-wrapper">
          <div class="container">
            <div class="row">
              <div class="col s12 m12 l12">
                <h5 class="breadcrumbs-title">Detalhes do Pedido</h5>
              </div>
            </div>
          </div>
        </div>

        <div class="container">
          <p class="caption">Forneça os detalhes de entrega e pagamento.</p>
          <div class="divider"></div>
            <div class="row">
              <div class="col s12 m4 l3">
                <h4 class="header">Detalhes</h4>
              </div>
              <div>
                <div class="card-panel">
                  <div class="row">
                    <form class="formValidate col s12 m12 l12" id="formValidate" method="post" action="confirm-custom.php" novalidate="novalidate">
                      <div class="row">
                        <div class="input-field col s12">
                          <i class="mdi-action-home prefix"></i>
                          <input name="rua" id="rua" type="text" data-error=".errorTxt2">
                          <label for="rua" class="">Rua</label>
                          <div class="errorTxt2"></div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="input-field col s12">
                          <input name="bairro" id="bairro" type="text" data-error=".errorTxt3">
                          <label for="bairro" class="">Bairro</label>
                          <div class="errorTxt3"></div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="input-field col s12">
                          <input name="numero" id="numero" type="text" data-error=".errorTxt4">
                          <label for="numero" class="">Número</label>
                          <div class="errorTxt4"></div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="input-field col s12">
                          <input name="complemento" id="complemento" type="text" data-error=".errorTxt5">
                          <label for="complemento" class="">Complemento</label>
                          <div class="errorTxt5"></div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="input-field col s12">
                          <label for="payment_type">Forma de Pagamento</label><br><br>
                          <select id="payment_type" name="payment_type" class="browser-default">
                            <option value="Dinheiro">Dinheiro</option>
                            <option value="Cartão">Cartão</option>
                            <option value="Pix">Pix</option>              
                          </select>
                        </div>
                      </div>
                      <div class="row">
                        <div class="input-field col s12">
                          <button class="btn cyan waves-effect waves-light right" type="submit" name="action">Enviar
                            <i class="mdi-content-send right"></i>
                          </button>
                        </div>
                      </div>
                      <?php
                        foreach ($_POST as $key => $value) {
                          if($key == 'action' || $value == ''){
                            continue;
                          }
                          echo '<input name="'.$key.'" type="hidden" value="'.$value.'">';
                        }
                      ?>
                    </form>
                  </div>
                </div>
              </div>
              <div class="divider"></div>
            </div>
          </div>
        </div>

        <div class="container">
          <p class="caption">Recibo Estimado</p>
          <div class="divider"></div>
          <div id="work-collections" class="seaction">
            <div class="row">
              <div>
                <ul id="issues-collection" class="collection">
                  <?php
                    echo '<li class="collection-item avatar">
                      <i class="mdi-content-content-paste red circle"></i>
                      <p><strong>Nome:</strong>'.$name.'</p>
                      <p><strong>Número de Contato:</strong> '.$contact.'</p>
                      <a href="#" class="secondary-content"><i class="mdi-action-grade"></i></a>';
                    
                    foreach ($_POST as $key => $value) {
                      if($value == '' || $value == '0'){
                        continue; // Ignorar entradas vazias ou com valor zero
                      }
                      if(is_numeric($key)){
                        $result = mysqli_query($con, "SELECT * FROM ingredients WHERE id = $key");
                        while($row = mysqli_fetch_array($result)) {
                          $price = $row['price'];
                          $item_name = $row['name'];
                          $item_id = $row['id'];
                        }
                        $price = $value * $price;
                        echo '<li class="collection-item">
                          <div class="row">
                            <div class="col s7">
                              <p class="collections-title"><strong>#'.$item_id.' </strong>'.$item_name.'</p>
                            </div>
                            <div class="col s2">
                              <span>'.$value.' Peças</span>
                            </div>
                            <div class="col s3">
                              <span>R$ '.$price.'</span>
                            </div>
                          </div>
                        </li>';
                        $total += $price;
                      }
                    }
                    echo '<li class="collection-item">
                      <div class="row">
                        <div class="col s7">
                          <p class="collections-title"> Total</p>
                        </div>
                        <div class="col s2">
                          <span>&nbsp;</span>
                        </div>
                        <div class="col s3">
                          <span><strong>R$ '.$total.'</strong></span>
                        </div>
                      </div>
                    </li>';
                    if(!empty($_POST['description']))
                      echo '<li class="collection-item avatar"><p><strong>Nota: </strong>'.htmlspecialchars($_POST['description']).'</p></li>';
                  ?>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
  </div>

  <footer class="page-footer">
    <div class="footer-copyright">
      <div class="container">
        <span>Copyright © 2024 Todos os direitos reservados.</span>
        <span class="right"> Design e Desenvolvimento por Best Burgers</span>
        </div>
    </div>
  </footer>

  <script type="text/javascript" src="js/plugins/jquery-1.11.2.min.js"></script>    
  <script type="text/javascript" src="js/plugins/angular.min.js"></script>
  <script type="text/javascript" src="js/materialize.min.js"></script>
  <script type="text/javascript" src="js/plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>
  <script type="text/javascript" src="js/plugins/jquery-validation/jquery.validate.min.js"></script>
  <script type="text/javascript" src="js/plugins/jquery-validation/additional-methods.min.js"></script>
  <script type="text/javascript" src="js/plugins.min.js"></script>
  <script type="text/javascript" src="js/custom-script.js"></script>
  <script type="text/javascript">
        $("#formValidate").validate({
            rules: {
                rua: {
                    required: true,
                    minlength: 3,
                    maxlength: 40
                },
                bairro: {
                    required: true,
                    minlength: 3,
                    maxlength: 40
                },
                numero: {
                    required: true,
                    digits: true, // Aceita apenas dígitos
                    maxlength: 10 // Máximo de 10 dígitos
                },
                complemento: {
                    required: false,
                    maxlength: 10
                }
            },
            messages: {
                rua: {
                    required: "Digite a rua",
                    minlength: "Digite pelo menos 3 caracteres"
                },
                bairro: {
                    required: "Digite o bairro",
                    minlength: "Digite pelo menos 3 caracteres"
                },
                numero: {
                    required: "Digite o número",
                    digits: "Digite apenas números",
                    maxlength: "O número deve ter no máximo 10 dígitos"
                },
                complemento: {
                    required: "Digite o complemento",
                }
            },
            errorElement: 'div',
            errorPlacement: function(error, element) {
                var placement = $(element).data('error');
                if (placement) {
                    $(placement).append(error);
                } else {
                    error.insertAfter(element);
                }
            },
            submitHandler: function(form) {
                form.submit();
            }
        });
    </script>
</body>

</html>
<?php
}
else
{
  if($_SESSION['admin_sid'] == session_id())
  {
    header("location:admin-page.php");    
  }
  else{
    header("location:login.php");
  }
}
?>
