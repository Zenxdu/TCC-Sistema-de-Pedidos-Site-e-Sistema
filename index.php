<?php
include 'includes/connect.php';
include 'includes/wallet.php';

if (isset($_SESSION['customer_sid']) && $_SESSION['customer_sid'] == session_id()) {
?>
<!DOCTYPE html>
<html lang="pt">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="msapplication-tap-highlight" content="no">
  <title>Fazer Pedido</title>

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
  <!-- INCLUDED PLUGIN CSS ON THIS PAGE -->
  <link href="js/plugins/perfect-scrollbar/perfect-scrollbar.css" type="text/css" rel="stylesheet" media="screen,projection">
  <link href="js/plugins/data-tables/css/jquery.dataTables.min.css" type="text/css" rel="stylesheet" media="screen,projection">
  
  <style type="text/css">

.dataTables_info {
            display: none;
        }
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
    .dropdown-button i {
      display: inline-block;
      vertical-align: middle;
    }
    .input-field label {
      color: #9e9e9e;
      transform: translateY(-140%);
    }
    .input-field input:focus + label, .input-field input:not([value=""]) + label {
      transform: translateY(-140%) scale(0.8);
    }
    table th, table td {
      white-space: nowrap;
    }
    @media (max-width: 992px) {
    #trText {
        width: 150px;
    }
  }

    [class^="errorTxt"] {
    color: red;
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

  <!-- START HEADER -->
  <header id="header" class="page-topbar">
    <!-- start header nav-->
    <div class="navbar-fixed">
      <nav class="navbar-color">
        <div class="nav-wrapper">
          <ul class="left">
            <li><h1 class="logo-wrapper"><a href="index.php" class="brand-logo darken-1"></a> <span class="logo-text">Logo</span></h1></li>
          </ul>
        </div>
      </nav>
    </div>
    <!-- end header nav-->
  </header>
  <!-- END HEADER -->

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
                <a class="btn-flat dropdown-button waves-effect waves-light white-text profile-btn" href="#" data-activates="profile-dropdown"><?php echo $name;?> <i class="mdi-navigation-arrow-drop-down right"></i></a>
                <p class="user-roal"><?php echo $role;?></p>
              </div>
            </div>
          </li>
          <li class="bold active"><a href="index.php" class="waves-effect waves-cyan"><i class="mdi-action-add-shopping-cart"></i>Fazer Pedido</a></li>
          <li class="bold"><a href="custom.php" class="waves-effect waves-cyan"><i class="mdi-editor-border-color"></i>Pedido Customizado</a></li>
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
      <!-- END LEFT SIDEBAR NAV-->

      <!-- START CONTENT -->
      <section id="content">

        <!--breadcrumbs start-->
        <div id="breadcrumbs-wrapper">
          <div class="container">
            <div class="row">
              <div class="col s12 m12 l12">
                <h5 class="breadcrumbs-title">Pedido</h5>
              </div>
            </div>
          </div>
        </div>
        <!--breadcrumbs end-->

        <!--start container-->
        <div class="container">
          <p class="caption">Peça sua comida aqui.</p>
          <div class="divider"></div>
          <form class="formValidate" id="formValidate" method="post" action="place-order.php" novalidate="novalidate">
            <div class="row">
              <div class="col s1 m4 l1">
                <h4 class="header">Pedir Comida</h4>
              </div>
              <div>
                <table id="data-table-customer" class="responsive-table display" cellspacing="10">
                  <thead>
                    <tr id="trText">
                      <th id="thimagem">Imagem</th>
                      <th id="thnome">Nome</th>
                      <th id="thpreço">Preço do Item/Peça</th>
                      <th id="thquantidade">Quantidade</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $result = mysqli_query($con, "SELECT * FROM items WHERE NOT deleted;");
                    while($row = mysqli_fetch_array($result)) {
                      echo '<tr><td><img src="'.$row["image_path"].'" class="responsive-img" width="100" height="100"></td><td>'.$row["name"].'</td><td>'.$row["price"].'</td>';                      
                      echo '<td><div class="input-field col s12"><label for='.$row["id"].' class="active">Quantidade</label>';
                      echo '<input id="'.$row["id"].'" name="'.$row['id'].'" type="number" value="0" data-error=".errorTxt'.$row["id"].'" class="item-quantity" data-price="'.$row["price"].'"><div class="errorTxt'.$row["id"].'"></div></td></tr>';
                    }
                    ?>
                  </tbody>
                </table>
                <div>
                  <h5>Total do Pedido: R$ <span id="total-price">0.00</span></h5>
                </div>
              </div>
              <div class="input-field col s12">
                <i class="mdi-editor-mode-edit prefix"></i>
                <textarea id="description" name="description" class="materialize-textarea"></textarea>
                <label for="description" class="">Alguma observação (opcional)</label>
              </div>
              <div>
                <div class="input-field col s12">
                  <button class="btn cyan waves-effect waves-light right" type="submit" name="action" id="submitOrder" disabled>Pedir
                    <i class="mdi-content-send right"></i>
                  </button>
                </div>
              </div>
            </div>
          </form>
          <div class="divider"></div>
        </div>
        <!--end container-->

      </section>
      <!-- END CONTENT -->
    </div>
    <!-- END WRAPPER -->
  </div>
  <!-- END MAIN -->

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

  <!-- Scripts -->
  <script type="text/javascript" src="js/plugins/jquery-1.11.2.min.js"></script>    
  <script type="text/javascript" src="js/plugins/angular.min.js"></script>
  <script type="text/javascript" src="js/materialize.min.js"></script>
  <script type="text/javascript" src="js/plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>
  <script type="text/javascript" src="js/plugins/data-tables/js/jquery.dataTables.min.js"></script>
  <script type="text/javascript" src="js/plugins/data-tables/data-tables-script.js"></script>
  <script type="text/javascript" src="js/plugins/jquery-validation/jquery.validate.min.js"></script>
  <script type="text/javascript" src="js/plugins/jquery-validation/additional-methods.min.js"></script>
  <script type="text/javascript" src="js/plugins.min.js"></script>
  <script type="text/javascript" src="js/custom-script.js"></script>
  <script type="text/javascript">
    $(document).ready(function(){
        $("#formValidate").validate({
            rules: {
                <?php
                $result = mysqli_query($con, "SELECT * FROM items WHERE NOT deleted;");
                $rowCount = mysqli_num_rows($result);
                $counter = 0;
                while($row = mysqli_fetch_array($result)) {
                    echo $row["id"] . ': {
                        min: 0,
                        max: 10
                    }';
                    $counter++;
                    if ($counter < $rowCount) {
                        echo ',';
                    }
                }
                ?>,
            },
            messages: {
                <?php
                // Reset counter
                $counter = 0;
                // Reset result pointer
                mysqli_data_seek($result, 0);
                while($row = mysqli_fetch_array($result)) {
                    echo $row["id"] . ': {
                        min: "Mínimo 0",
                        max: "Máximo 10"
                    }';
                    $counter++;
                    if ($counter < $rowCount) {
                        echo ',';
                    }
                }
                ?>,
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
            highlight: function(element) {
                $(element).removeClass('valid');
                $(element).addClass('invalid');
            },
            unhighlight: function(element) {
                $(element).removeClass('invalid');
            }
        });

        // Habilitar/desabilitar o botão de pedido com base na quantidade
        $("input[type='number']").on("input", function() {
            let totalQuantity = 0;
            let totalPrice = 0.0;
            $("input[type='number']").each(function() {
                let quantity = parseInt($(this).val());
                totalQuantity += quantity;
                let price = parseFloat($(this).data('price'));
                totalPrice += quantity * price;
            });
            $("#total-price").text(totalPrice.toFixed(2));
            if (totalQuantity > 0) {
                $("#submitOrder").prop("disabled", false);
            } else {
                $("#submitOrder").prop("disabled", true);
            }
        });

        // Definir o valor como 0 se o campo estiver vazio ao sair do campo
        $("input[type='number']").on("blur", function() {
            if ($(this).val() === "") {
                $(this).val(0);
                $(this).removeClass('valid');  // Remover a classe 'valid' para evitar a cor verde
            }
        });
    });
  </script>
  <script type="text/javascript">
    $("#formValidate").validate({
      rules: {
        description: {
          maxlength: 100
        },
      },
      messages: {
        description: {
          maxlength: "O comprimento máximo é de 100 caracteres"
        },
      },
      errorElement: 'div',
      errorPlacement: function(error, element) {
        var placement = $(element).data('error');
        if (placement) {
          $(placement).append(error);
        } else {
          error.insertAfter(element);
        }
      }
   });
  </script>
  <script>
document.addEventListener('DOMContentLoaded', function() {
    var form = document.getElementById('formValidate');
    var inputs = document.querySelectorAll('.item-quantity');
    
    inputs.forEach(function(input) {
        input.addEventListener('input', function() {
            var errorDiv = document.querySelector(input.getAttribute('data-error'));
            if (parseInt(input.value) > 10) {
                errorDiv.textContent = 'A quantidade não pode ser maior que 10.';
            } else {
                errorDiv.textContent = '';
            }
        });
    });

    form.addEventListener('submit', function(event) {
        var isValid = true;
        inputs.forEach(function(input) {
            var errorDiv = document.querySelector(input.getAttribute('data-error'));
            if (parseInt(input.value) > 10) {
                errorDiv.textContent = 'A quantidade não pode ser maior que 10.';
                isValid = false;
            }
        });
        if (!isValid) {
            event.preventDefault(); // Impede o envio do formulário
        }
    });
});
</script>
</body>

</html>
<?php
} else {
    if (isset($_SESSION['admin_sid']) && $_SESSION['admin_sid'] == session_id()) {
        header("location:admin-page.php");		
    } else {
        header("location:login.php");
    }
}
?>
