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
  <title>Todos os Pedidos</title>

  <!-- Favicons-->
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
            <li class="bold"><a href="index.php" class="waves-effect waves-cyan"><i class="mdi-action-add-shopping-cart"></i> Menu de Comida</a></li>
            <li class="bold"><a href="custom.php" class="waves-effect waves-cyan"><i class="mdi-editor-border-color"></i>Pedido Customizado</a></li>
            <li class="no-padding">
                <ul class="collapsible collapsible-accordion">
                    <li class="bold"><a class="collapsible-header waves-effect waves-cyan active"><i class="mdi-editor-insert-invitation"></i> Pedidos</a>
                        <div class="collapsible-body">
                            <ul>
                                <li class="<?php if (!isset($_GET['status'])) { echo 'active'; } ?>"><a href="all-orders.php">Todos os Pedidos</a></li>
                                <?php
                                // Recupera o status distinto dos pedidos
                                $sql = mysqli_query($con, "SELECT DISTINCT status FROM orders;");
                                while ($row = mysqli_fetch_array($sql)) {
                                    echo '<li class='.(isset($_GET['status']) && $_GET['status'] == $row['status'] ? 'active' : '').'><a href="all-orders.php?status='.$row['status'].'">'.$row['status'].'</a></li>';
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
                <h5 class="breadcrumbs-title">Todos os Pedidos</h5>
              </div>
            </div>
          </div>
        </div>
        <!-- Fim do breadcrumbs -->

        <!-- Início do container -->
        <div class="container">
          <p class="caption">Lista de pedidos de clientes com detalhes</p>
          <div class="divider"></div>
          <!-- Tabela editável -->
          <div id="work-collections" class="seaction">
            <?php
            // Verifica se um status específico foi passado na URL
            if (isset($_GET['status'])) {
                $status = $_GET['status'];
            } else {
                $status = '%';
            }
            // Seleciona todos os pedidos com o status especificado
            $sql = mysqli_query($con, "SELECT * FROM orders WHERE status LIKE '$status';");
            echo '<div class="row">
                <div>
                    <h4 class="header">Lista</h4>
                    <ul id="issues-collection" class="collection">';
            while ($row = mysqli_fetch_array($sql)) {
                $status = $row['status'];
                $deleted = $row['deleted'];
                // Exibe os detalhes do pedido
                echo '<li class="collection-item avatar">
                      <i class="mdi-content-content-paste red circle"></i>
                      <span class="collection-header">Pedido Nº '.$row['id'].'</span>
                      <p><strong>Data:</strong> '.$row['date'].'</p>
                      <p><strong>Tipo de Pagamento:</strong> '.$row['payment_type'].'</p>                              
                      <p><strong>Status:</strong> '.($deleted ? $status : '
                      <form method="post" action="routers/edit-orders.php">
                        <input type="hidden" value="'.$row['id'].'" name="id">
                        <select name="status">
                        <option value="Pedido Efetuado" '.($status == 'Pedido Efetuado' ? 'selected' : '').'>Pedido Efetuado</option>
                        <option value="Pedido em Preparo" '.($status == 'Pedido em Preparo' ? 'selected' : '').'>Pedido em Preparo</option>
                        <option value="Saiu Para Entrega" '.($status == 'Saiu Para Entrega' ? 'selected' : '').'>Saiu Para Entrega</option>      
                        <option value="Entregue" '.($status == 'Entregue' ? 'selected' : '').'>Entregue</option>
                        <option value="Cancelado pelo Dono" '.($status == 'Cancelado pelo Dono' ? 'selected' : '').'>Cancelado pelo Dono</option>
                          
                        </select>
                        <button class="btn waves-effect waves-light right submit" type="submit" name="action">Mudar Status
                          <i class="mdi-content-clear right"></i> 
                        </button>
                      </form>
                      ').'</p>
                      <a href="#" class="secondary-content"><i class="mdi-action-grade"></i></a>
                      </li>';
                $order_id = $row['id'];
                $customer_id = $row['customer_id'];
                // Seleciona os detalhes dos pedidos e o usuário que fez o pedido
                $sql1 = mysqli_query($con, "SELECT * FROM order_details WHERE order_id = $order_id AND quantity > 0;");
                $sql3 = mysqli_query($con, "SELECT * FROM users WHERE id = $customer_id;");
                while ($row3 = mysqli_fetch_array($sql3)) {
                    // Exibe os detalhes do usuário
                    echo '<li class="collection-item">
                    <div class="row">
                    <p><strong>Nome: </strong>'.$row3['name'].'</p>
                    <p><strong>Endereço: </strong>'.$row['address'].'</p>
                    '.($row3['contact'] == '' ? '' : '<p><strong>Contato: </strong>'.$row3['contact'].'</p>').'    
                    '.($row3['email'] == '' ? '' : '<p><strong>Email: </strong>'.$row3['email'].'</p>').'        
                    '.(!empty($row['description']) ? '<p><strong>Nota: </strong>'.$row['description'].'</p>' : '').'                                
                    </li>';                            
                }
                while ($row1 = mysqli_fetch_array($sql1)) {
                    // Exibe os detalhes dos itens do pedido
                    if ($row1['item_id'] != NULL) {
                        $item_id = $row1['item_id'];
                        $sql2 = mysqli_query($con, "SELECT * FROM items WHERE id = $item_id;");
                        while ($row2 = mysqli_fetch_array($sql2)){
                            $item_name = $row2['name'];
                        }
                        echo '<li class="collection-item">
                        <div class="row">
                        <div class="col s7">
                        <p class="collections-title"><strong>#'.$row1['item_id'].'</strong> '.$item_name.'</p>
                        </div>
                        <div class="col s2">
                        <span>'.$row1['quantity'].' Peças</span>
                        </div>
                        <div class="col s3">
                        <span>R$ '.$row1['price'].'</span>
                        </div>
                        </div>
                        </li>';
                    } elseif ($row1['ingredient_id'] != NULL) {
                        $ingredient_id = $row1['ingredient_id'];
                        $sql2 = mysqli_query($con, "SELECT * FROM ingredients WHERE id = $ingredient_id;");
                        while ($row2 = mysqli_fetch_array($sql2)){
                            $ingredient_name = $row2['name'];
                        }
                        echo '<li class="collection-item">
                        <div class="row">
                        <div class="col s7">
                        <p class="collections-title"><strong>#'.$row1['ingredient_id'].'</strong> '.$ingredient_name.'</p>
                        </div>
                        <div class="col s2">
                        <span>'.$row1['quantity'].' Unidade</span>
                        </div>
                        <div class="col s3">
                        <span>R$ '.$row1['price'].'</span>
                        </div>
                        </div>
                        </li>';
                    }
                }
                // Exibe o total do pedido
                echo'<li class="collection-item">
                    <div class="row">
                        <div class="col s7">
                            <p class="collections-title"> Total</p>
                        </div>
                        <div class="col s2">
                        <span> </span>
                        </div>
                        <div class="col s3">
                            <span><strong>R$ '.$row['total'].'</strong></span>
                        </div>';                                        
                if (!$deleted) {
                    echo '</div></li>';
                }
            }
            ?>
            </ul>
            </div>
        </div>
    </div>
</div>
<!-- Fim do container -->

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

<!-- Scripts ================================================ -->

<!-- Biblioteca jQuery -->
<script type="text/javascript" src="js/plugins/jquery-1.11.2.min.js"></script>    
<!-- angularjs -->
<script type="text/javascript" src="js/plugins/angular.min.js"></script>
<!-- materialize js -->
<script type="text/javascript" src="js/materialize.min.js"></script>
<!-- scrollbar -->
<script type="text/javascript" src="js/plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>       
<!-- plugins.js - Alguns códigos JS específicos para configurações de plugins -->
<script type="text/javascript" src="js/plugins.min.js"></script>
<!-- custom-script.js - Adicione seu próprio tema customizado JS -->
<script type="text/javascript" src="js/custom-script.js"></script>
</body>

</html>
<?php
} else {
    // Redireciona para a página de pedidos se o usuário for um cliente
    if ($_SESSION['customer_sid'] == session_id()) {
        header("location:orders.php");        
    } else {
        // Redireciona para a página de login se o usuário não estiver logado
        header("location:login.php");
    }
}
?>
