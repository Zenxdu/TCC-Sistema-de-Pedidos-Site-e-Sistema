<?php
include 'includes/connect.php';
include 'includes/wallet.php';

if (isset($_SESSION['customer_sid']) && $_SESSION['customer_sid'] == session_id()) {
    // Fetch ingredients from the database
    $ingredients = [];
    $result = mysqli_query($con, "SELECT * FROM ingredients WHERE deleted = 0");
    while ($row = mysqli_fetch_assoc($result)) {
        $ingredients[] = $row;
    }
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
  <link rel="apple-touch-icon-precomposed" href="images/favicon/apple-touch-icon-152x152.png">
  <meta name="msapplication-TileColor" content="#00bcd4">
  <meta name="msapplication-TileImage" content="images/favicon/mstile-144x144.png">

  <!-- Include React and ReactDOM from CDN -->
  <script src="https://unpkg.com/react@17/umd/react.production.min.js" crossorigin></script>
  <script src="https://unpkg.com/react-dom@17/umd/react-dom.production.min.js" crossorigin></script>
  <script src="https://unpkg.com/@babel/standalone@7/babel.min.js"></script>

  <!-- Include your custom scripts and styles -->
  <link href="css/materialize.min.css" type="text/css" rel="stylesheet" media="screen,projection">
  <link href="css/style.min.css" type="text/css" rel="stylesheet" media="screen,projection">
  <link href="css/custom/custom.min.css" type="text/css" rel="stylesheet" media="screen,projection">
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
    #orderPreview {
      border: 1px solid #ddd;
      padding: 10px;
      min-height: 400px;
    }
    .dropdown-button i {
      display: inline-block;
      vertical-align: middle;
    }
    .lanche {
      position: relative;
      width: 200px;
      margin: 0 auto;
    }
    .lanche img {
      position: absolute;
      left: 50%;
      transform: translateX(-50%);
    }
    .pao-cima {
      top: 0;
      width: 150px;
      height: auto;
    }
    .pao-baixo {
      width: 150px;
      height: auto;
    }
    .ingrediente {
      width: 100px;
      height: auto;
    }
    .ingrediente-container {
      position: absolute;
      left: 50%;
      transform: translateX(-50%);
      display: flex;
      align-items: center;
    }
    .quantidade {
      margin-right: 10px;
      background: #fff;
      border-radius: 50%;
      width: 20px;
      height: 20px;
      display: flex;
      align-items: center;
      justify-content: center;
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
                <h5 class="breadcrumbs-title">Pedido</h5>
              </div>
            </div>
          </div>
        </div>

        <div class="container">
          <p class="caption">Peça sua comida aqui.</p>
          <div class="divider"></div>

          <form class="formValidate" id="formValidate" method="post" action="place-custom.php" novalidate="novalidate">
            <div class="row">
              <div class="col s12 m12 l12">
                <h4>Seu Lanche</h4>
                <div id="orderPreview"></div>
              </div>
              <div class="input-field col s12">
                <i class="mdi-editor-mode-edit prefix"></i>
                <textarea id="description" name="description" class="materialize-textarea"></textarea>
                <label for="description" class="">Alguma observação(opcional)</label>
              </div>
              <div id="hiddenFields"></div>
              <div>
                <div class="input-field col s12">
                  <button id="submitBtn" class="btn cyan waves-effect waves-light right" type="submit" name="action" disabled>Pedir
                    <i class="mdi-content-send right"></i>
                  </button>
                </div>
              </div>
            </div>
          </form>
          <div class="divider"></div>
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
  <script type="text/javascript" src="js/plugins/data-tables/js/jquery.dataTables.min.js"></script>
  <script type="text/javascript" src="js/plugins/data-tables/data-ttables-script.js"></script>
  <script type="text/javascript" src="js/plugins/jquery-validation/jquery.validate.min.js"></script>
  <script type="text/javascript" src="js/plugins/jquery-validation/additional-methods.min.js"></script>
  <script type="text/javascript" src="js/plugins.min.js"></script>
  <script type="text/javascript" src="js/custom-script.js"></script>

  <script type="text/babel">
    const ingredientesFromServer = <?php echo json_encode($ingredients); ?>;

    class Lanche extends React.Component {
      render() {
        const { ingredientes } = this.props;
        const addedIngredientes = Object.keys(ingredientes).filter(ingrediente => ingredientes[ingrediente].quantity > 0);
        
        return (
          <div className="lanche" style={{ height: `${100 + addedIngredientes.length * 90 + 100}px` }}>
            <img src="images/pao-cima.png" alt="Pão de cima" className="pao-cima" />
            {addedIngredientes.map((ingrediente, index) => (
              <div key={ingrediente} className="ingrediente-container" style={{ top: `${150 + index * 70}px`, position: 'relative' }}>
                <span className="quantidade">{ingredientes[ingrediente].quantity}</span>
                <img
                  src={ingredientes[ingrediente].image_path}
                  alt={ingrediente}
                  className="ingrediente"
                />
              </div>
            ))}
            <img src="images/pao-baixo.png" alt="Pão de baixo" className="pao-baixo" style={{ top: `${100 + addedIngredientes.length * 90}px` }} />
          </div>
        );
      }
    }

    class App extends React.Component {
      constructor(props) {
        super(props);
        this.state = {
          ingredientes: ingredientesFromServer.reduce((acc, ingrediente) => {
            acc[ingrediente.id] = {
              quantity: 0,
              price: ingrediente.price,
              image_path: ingrediente.image_path,
              name: ingrediente.name
            };
            return acc;
          }, {})
        };
      }

      updateIngrediente = (ingredienteId, quantidade) => {
        if (quantidade > 10) {
          alert('Você só pode selecionar até 10 unidades de cada ingrediente.');
          quantidade = 10;
        }
        
        this.setState(prevState => {
          const ingredientes = { ...prevState.ingredientes };
          ingredientes[ingredienteId].quantity = quantidade;
          return { ingredientes };
        }, this.updateHiddenFields);
      };

      updateHiddenFields = () => {
        const { ingredientes } = this.state;
        const hiddenFields = document.getElementById('hiddenFields');
        hiddenFields.innerHTML = '';
        
        let hasIngredients = false;
        Object.keys(ingredientes).forEach(ingredienteId => {
          if (ingredientes[ingredienteId].quantity > 0) {
            hasIngredients = true;
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = ingredienteId;
            input.value = ingredientes[ingredienteId].quantity;
            hiddenFields.appendChild(input);
          }
        });

        const submitBtn = document.getElementById('submitBtn');
        submitBtn.disabled = !hasIngredients;
      };

      calculateTotal = () => {
        const { ingredientes } = this.state;
        return Object.keys(ingredientes).reduce((total, ingredienteId) => {
          return total + (ingredientes[ingredienteId].quantity * ingredientes[ingredienteId].price);
        }, 0).toFixed(2);
      };

      render() {
        const { ingredientes } = this.state;
        return (
          <div>
            <h1>Monte seu Lanche</h1>
            <Lanche ingredientes={ingredientes} />
            <div>
              {Object.keys(ingredientes).map(ingredienteId => (
                <div key={ingredienteId}>
                  <label>Quantidade de {ingredientes[ingredienteId].name}:</label>
                  <input 
                    type="number" 
                    value={ingredientes[ingredienteId].quantity} 
                    min="0" 
                    max="10"
                    onChange={(e) => this.updateIngrediente(ingredienteId, parseInt(e.target.value) || 0)} 
                  />
                  <span>Preço: R$ {(ingredientes[ingredienteId].quantity * ingredientes[ingredienteId].price).toFixed(2)}</span>
                </div>
              ))}
            </div>
            <div>
              <h3>Total: R$ {this.calculateTotal()}</h3>
            </div>
          </div>
        );
      }
    }

    ReactDOM.render(<App />, document.getElementById('orderPreview'));
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
