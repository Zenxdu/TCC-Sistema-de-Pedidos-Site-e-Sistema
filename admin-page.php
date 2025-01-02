<?php
// Inclui o arquivo de conexão com o banco de dados
include 'includes/connect.php';

// Verifica se o usuário logado é um administrador
if ($_SESSION['admin_sid'] == session_id()) {
?>
<!DOCTYPE html>
<html lang="pt">

<head>
  <!-- Configurações de meta tags -->
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="msapplication-tap-highlight" content="no">
  <title>Menu de Comida</title>

  <!-- Ícones de favoritos -->
  <link rel="icon" href="images/favicon/favicon-32x32.png" sizes="32x32">
  <link rel="apple-touch-icon-precomposed" href="images/favicon/apple-touch-icon-152x152.png">
  <meta name="msapplication-TileColor" content="#00bcd4">
  <meta name="msapplication-TileImage" content="images/favicon/mstile-144x144.png">

  <!-- CSS principal -->
  <link href="css/materialize.min.css" type="text/css" rel="stylesheet" media="screen,projection">
  <link href="css/style.min.css" type="text/css" rel="stylesheet" media="screen,projection">
  <link href="css/custom/custom.min.css" type="text/css" rel="stylesheet" media="screen,projection">

  <!-- Plugins de CSS incluídos nesta página -->
  <link href="js/plugins/perfect-scrollbar/perfect-scrollbar.css" type="text/css" rel="stylesheet" media="screen,projection">
  <link href="js/plugins/data-tables/css/jquery.dataTables.min.css" type="text/css" rel="stylesheet" media="screen,projection">
  
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

    @media only screen and (max-width: 992px) {
        /* Oculta a seta do select em telas pequenas */
        .select-wrapper span.caret {
            display: none;
        }
        /* Ajusta a largura do select para evitar sobreposição */
        .select-wrapper input.select-dropdown {
            padding-right: 5px;
        }
        .select-wrapper {
        z-index: 0; /* Garante que o select não esteja sobreposto ao input de preço */
        }
        input[type="text"], input[type="number"] {
        z-index: 1; /* Eleva o z-index do campo de preço */
        position: relative; /* Necessário para aplicar z-index */
        }
    }

  </style> 
</head>

<body>
  <!-- Início do carregamento da página -->
  <div id="loader-wrapper">
      <div id="loader"></div>        
      <div class="loader-section section-left"></div>
      <div class="loader-section section-right"></div>
  </div>
  <!-- Fim do carregamento da página -->

  <!-- Início do cabeçalho -->
  <header id="header" class="page-topbar">
    <!-- Início da navegação do cabeçalho -->
    <div class="navbar-fixed">
        <nav class="navbar-color">
            <div class="nav-wrapper">
                <ul class="left">                      
                  <li><h1 class="logo-wrapper"><a href="index.php" class="brand-logo darken-1"></a> <span class="logo-text">Logo</span></h1></li>
                </ul>
            </div>
        </nav>
    </div>
    <!-- Fim da navegação do cabeçalho -->
  </header>
  <!-- Fim do cabeçalho -->

  <!-- Início do principal -->
  <div id="main">
    <!-- Início do wrapper -->
    <div class="wrapper">

      <!-- Início da navegação da barra lateral esquerda -->
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
          <li class="bold active"><a href="index.php" class="waves-effect waves-cyan"><i class="mdi-action-add-shopping-cart"></i> Menu de Comida</a></li>
          <li class="bold"><a href="admin-custom.php" class="waves-effect waves-cyan"><i class="mdi-editor-border-color"></i>Menu de Customizados</a></li>
          <li class="no-padding">
            <ul class="collapsible collapsible-accordion">
              <li class="bold"><a class="collapsible-header waves-effect waves-cyan"><i class="mdi-editor-insert-invitation"></i> Pedidos</a>
                <div class="collapsible-body">
                  <ul>
                    <li><a href="all-orders.php">Todos os Pedidos</a></li>
                    <?php
                      // Recupera o status distinto dos pedidos
                      $sql = mysqli_query($con, "SELECT DISTINCT status FROM orders;");
                      while ($row = mysqli_fetch_array($sql)) {
                        echo '<li><a href="all-orders.php?status='.$row['status'].'">'.$row['status'].'</a></li>';
                      }
                    ?>
                  </ul>
                </div>
              </li>
            </ul>
          </li>
          <li class="bold"><a href="users.php" class="waves-effect waves-cyan"><i class="mdi-social-person"></i> Usuários</a></li>				
        </ul>
        <a href="#" data-activates="slide-out" class="sidebar-collapse btn-floating btn-medium waves-effect waves-light hide-on-large-only cyan"><i class="mdi-navigation-menu"></i></a>
      </aside>
      <!-- Fim da navegação da barra lateral esquerda -->

      <!-- Início do conteúdo -->
      <section id="content">

        <!-- Início do breadcrumbs -->
        <div id="breadcrumbs-wrapper">
          <div class="container">
            <div class="row">
              <div class="col s12 m12 l12">
                <h5 class="breadcrumbs-title">Menu de Comida</h5>
              </div>
            </div>
          </div>
        </div>
        <!-- Fim do breadcrumbs -->

        <!-- Início do container -->
        <div class="container">
          <p class="caption">Adicionar, Editar ou Remover Itens do Menu.</p>
          <div class="divider"></div>
          <form class="formValidate" id="formValidate" method="post" action="routers/menu-router.php" novalidate="novalidate" enctype="multipart/form-data">
            <div class="row">
              <div class="col s2 m2 l3">
                <h4 class="header">Pedir Comida</h4>
              </div>
              <div>
                <table id="data-table-admin" class="responsive-table display" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Imagem</th>
                      <th>Nome</th>
                      <th>Preço do Item/Peça</th>
                      <th>Disponível</th>
                      <th>Excluir</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    // Recupera todos os itens do menu
                    $result = mysqli_query($con, "SELECT * FROM items");
                    while ($row = mysqli_fetch_array($result)) {
                      echo '<tr>
                        <td><img src="'.$row["image_path"].'" class="responsive-img" width="100" height="100"><input type="file" name="'.$row["id"].'_image"></td>
                        <td><div class="input-field col s12"><label for="'.$row["id"].'_name">Nome</label>';
                      echo '<input value="'.$row["name"].'" id="'.$row["id"].'_name" name="'.$row['id'].'_name" type="text" data-error=".errorTxt'.$row["id"].'"><div class="errorTxt'.$row["id"].'"></div></td>';					
                      echo '<td><div class="input-field col s12"><label for="'.$row["id"].'_price">Preço</label>';
                      echo '<input value="'.$row["price"].'" id="'.$row["id"].'_price" name="'.$row['id'].'_price" type="text" data-error=".errorTxt'.$row["id"].'"><div class="errorTxt'.$row["id"].'"></div></td>';                   
                      echo '<td>';
                      if ($row['deleted'] == 0) {
                        $text1 = 'selected';
                        $text2 = '';
                      } else {
                        $text1 = '';
                        $text2 = 'selected';						
                      }
                      echo '<select name="'.$row['id'].'_hide">
                        <option value="1" '.$text1.'>Disponível</option>
                        <option value="2" '.$text2.'>Não Disponível</option>
                      </select></td>
                      <td>
                        <form action="routers/delete-item.php" method="post" onsubmit="return confirm(\'Tem certeza que deseja excluir este item?\');">
                          <input type="hidden" name="id" value="'.$row["id"].'">
                          <button type="submit" class="btn red waves-effect waves-light">Excluir</button>
                        </form>
                      </td>
                      </tr>';
                    }
                    ?>
                  </tbody>
                </table>
              </div>
              <div class="input-field col s12">
                <a class="btn cyan waves-effect waves-light left"  href="add-item-page.php">Adicionar Item
                  <i class="mdi-content-send right"></i>
                </a>
                <button class="btn cyan waves-effect waves-light right" type="submit" name="action">Modificar
                  <i class="mdi-content-send right"></i>
                </button>
              </div>
            </div>
          </form>
          <div class="divider"></div>
        </div>
      </section>
      <!-- Fim do conteúdo -->
    </div>
    <!-- Fim do wrapper -->
  </div>
  <!-- Fim do principal -->

  <!-- Início do rodapé -->
  <footer class="page-footer">
    <div class="footer-copyright">
      <div class="container">
        <span>Copyright © 2024 Todos os direitos reservados.</span>
        <span class="right"> Design e Desenvolvimento por Best Burgers</span>
      </div>
    </div>
  </footer>
  <!-- Fim do rodapé -->

  <!-- ================================================
  Scripts
  ================================================ -->
  
  <!-- Biblioteca jQuery -->
  <script type="text/javascript" src="js/plugins/jquery-1.11.2.min.js"></script>    
  <!-- angularjs -->
  <script type="text/javascript" src="js/plugins/angular.min.js"></script>
  <!-- materialize js -->
  <script type="text/javascript" src="js/materialize.min.js"></script>
  <!-- scrollbar -->
  <script type="text/javascript" src="js/plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>
  <!-- data-tables -->
  <script type="text/javascript" src="js/plugins/data-tables/js/jquery.dataTables.min.js"></script>
  <script type="text/javascript" src="js/plugins/data-Ttables/data-tables-script.js"></script>
  
  <script type="text/javascript" src="js/plugins/jquery-validation/jquery.validate.min.js"></script>
  <script type="text/javascript" src="js/plugins/jquery-validation/additional-methods.min.js"></script>
  
  <!-- plugins.js - Alguns códigos JS específicos para configurações de plugins -->
  <script type="text/javascript" src="js/plugins.min.js"></script>
  <!-- custom-script.js - Adicione seu próprio tema customizado JS -->
  <script type="text/javascript" src="js/custom-script.js"></script>
  <script type="text/javascript">
    $("#formValidate").validate({
        rules: {
            <?php
            // Apenas os campos dentro de 'formValidate' serão considerados
            $result = mysqli_query($con, "SELECT * FROM items");
            $items = [];
            while ($row = mysqli_fetch_array($result)) {
                $id = $row['id'];
                $items[] = "'{$id}_name': {
                    required: true,
                    minlength: 5,
                    maxlength: 50
                }, '{$id}_price': {
                    required: true,
                    min: 0,
                    max: 100
                }";
            }
            echo implode(", ", $items);
            ?>
        },
        messages: {
            <?php
            $result = mysqli_query($con, "SELECT * FROM items");
            $messages = [];
            while ($row = mysqli_fetch_array($result)) {
                $id = $row['id'];
                $messages[] = "'{$id}_name': {
                    required: 'Insira o nome do item',
                    minlength: 'O comprimento mínimo é de 5 caracteres',
                    maxlength: 'O comprimento máximo é de 50 caracteres'
                }, '{$id}_price': {
                    required: 'Insira o preço do item',
                    min: 'O preço mínimo do item é 0',
                    max: 'O preço maximo do item é 100'
                }";
            }
            echo implode(", ", $messages);
            ?>
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
</body>
</html>
<?php
} else {
  // Redireciona para a página inicial se o usuário for um cliente
  if ($_SESSION['customer_sid'] == session_id()) {
    header("location:index.php");		
  } else {
    // Redireciona para a página de login se o usuário não estiver logado
    header("location:login.php");
  }
}
?>
