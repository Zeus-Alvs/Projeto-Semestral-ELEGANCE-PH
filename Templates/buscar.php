<?php 
require '../Scripts/config.php';
session_start();  
if(!isset($_SESSION['usuario_id'])){
  $cep = '00000-000';
}else {
  $cep = $_SESSION["usuario_cep"];
}
?>


<?php
$query = $pdo->query('SELECT id, nome, foto, marca, preco, genero, tipo FROM produto');
$produtos = $query->fetchAll(PDO::FETCH_ASSOC);

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

$termo = isset($_GET['pesquisa']) ? trim($_GET['pesquisa']) : "";

$stmt = $pdo->prepare("SELECT * FROM produto WHERE nome LIKE ?");
$stmt->execute(["%$termo%"]);
$resultados = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscar</title>
    <link rel="icon" href="Imagens/icone-topo.png">
    <link rel="stylesheet" href="../Estilos/stylev2.css">
</head>
<body>

<!-- HEADER MENU INICIO AAAAA-->

  <header class="menu">
    <div class="area-logo">
      <a href="home.php">
        <img class="logo" src="Imagens/icone-elegance.png" alt="Logo Elegance">
      </a>
    </div>

    <div class="conteudo-header"> 
      <div class="linha-topo">
        <form action="buscar.php" method="GET" class="search-box">
          <input class="button" type="text" name="pesquisa" placeholder="O que está buscando?" required>
          <button class="lupa" type="submit">
            <img id="lupa" src="Imagens/ICON LUPA.png" alt="Buscar">
          </button>
        </form>

        <div class="icones-topo">
          <?php if (!isset($_SESSION['usuario_id'])): ?>
            <!-- QUANDO NÃO ESTÁ LOGADO -->
            <a href="login.php" class="users-icon">
              <img src="Imagens/ICON PERFIL.png" style="width:45px; height:auto;">
              <div class="user-text">
                <span class="bem-vindo">Bem-vindo</span>
                <span class="entrar-txt"><u>Entrar</u> ou <u>cadastrar</u></span>
              </div>
              
            </a>
          <?php else: ?>
            <!-- QUANDO ESTÁ LOGADO -->
            <a href="dashboard.php" class="users-icon" style="padding-left:20px; padding-right: 40px;">
              <img src="<?php echo $_SESSION['usuario_foto']; ?>"
                style="width:45px; height:45px; border-radius:50%; object-fit:cover;">
              <span style="color:white; font-size:1.1rem;">
                Olá, <?php echo htmlspecialchars($_SESSION['usuario_nome']); ?>
              </span>
            </a>
          <?php endif; ?>

        </div>

      </div>
    

      <div class="linha-baixo">
        <div class="area-esquerda-dinamica">
          <div class="grupo-padrao">
            <div class="localizacao">
              <img src="Imagens/ICON PIN.png" alt="Pin" style="height: 18px; margin-right: 5px;">
              <span>Enviar para: <?php echo $cep ?></span>
            </div>
            <div class="btn-produtos" onclick="toggleMegaMenu()">
                      <span>Produtos</span>
                    <span class="seta">&#9660;</span>
                  </div>
              </div>

              <div class="grupo-ativo">
                  <button class="btn-fechar-menu" onclick="toggleMegaMenu()">
                      ✕ Fechar
                  </button>
                  <a href="produto.php" class="link-ver-todos">
                      Ver todos os produtos →
                  </a>
              </div>
        </div>
          <nav class="links-nav">
              <a class="topicos" href="quemSomos.php">Quem somos</a>
              <a class="topicos" href="pfrete.php">Política de frete</a>
          </nav>
      </div>

    </div>

  <button class="menuMobile" onclick="toggleMenuMobile()">
    <img src="Imagens/Menu.png" alt="Menu">
  </button>

  <div id="mobileOverlay" class="mobile-overlay" onclick="toggleMenuMobile()"></div>

  <div id="mobileSidebar" class="mobile-sidebar">
      
      <div class="ms-header">
          <?php if (!isset($_SESSION['usuario_id'])): ?>
          <a href="login.php" class="ms-link destaque" style="border-bottom: 0px;">
              <img src="Imagens/ICON PERFIL.png" style="height: 20px;"> 
              <u>Entrar</u> ou <u>Cadastrar</u>
          </a>

        <?php else: ?>
            <!-- QUANDO ESTÁ LOGADO -->
          <a href="dashboard.php" class="ms-link destaque" style="border-bottom: 0px;">
            <img src="<?php echo $_SESSION['usuario_foto']; ?>" style="width:45px; height:45px; border-radius:50%; object-fit:cover;">
              <span style="color:white; font-size:1.1rem;">
                Olá, <?php echo htmlspecialchars($_SESSION['usuario_nome']); ?>
              </span>
            </a>
          <?php endif; ?>

          <button class="ms-fechar" onclick="toggleMenuMobile()">✕</button>
      </div>

      <nav class="ms-nav">
          

          <a href="home.php" class="ms-link">Início</a>
          
          <div class="ms-accordion">
              <div class="ms-accordion-btn" onclick="toggleSubMenuMobile()">
                  Produtos <span id="setaMobile">&#9660;</span>
              </div>
              
              <div id="msSubmenu" class="ms-submenu">
                  <a href="produto.php" style="font-weight: bold; color: #D99E52;">Ver todos os produtos</a>
                  <div class="ms-lista-marcas">
                      
                      <div class="ms-marca-wrapper">
                          <button class="ms-marca-btn" onclick="toggleMarcaMobile('mobMarca1')">
                              <span>Nike</span>
                              <span class="ms-seta">›</span>
                          </button>
                          
                          <div id="mobMarca1" class="ms-marca-content">
                              <div class="ms-cat-grupo">
                                  <h4 class="ms-cat-titulo">Masculino</h4>
                                  <a href="produto.php?marca=NIKE&genero=Masculino&tipos=Tenis">Tênis</a>
                                  <a href="produto.php?marca=NIKE&genero=Masculino&tipos=Camiseta">Camisetas</a>
                                  <a href="produto.php?marca=NIKE&genero=Masculino&tipos=Legging">Leggings</a>
                              </div>
                              <div class="ms-cat-grupo">
                                  <h4 class="ms-cat-titulo">Feminino</h4>
                                  <a href="produto.php?marca=NIKE&genero=Feminino&tipos=Top">Tops</a>
                                  <a href="produto.php?marca=NIKE&genero=Masculino&tipos=Bone">Bones</a>
                                  <a href="produto.php?marca=NIKE&genero=Masculino&tipos=Camiseta">Camisetas</a>
                              </div>
                          </div>
                      </div>

                      <div class="ms-marca-wrapper">
                          <button class="ms-marca-btn" onclick="toggleMarcaMobile('mobMarca2')">
                              <span>Adidas</span>
                              <span class="ms-seta">›</span>
                          </button>
                          
                          <div id="mobMarca2" class="ms-marca-content">
                              <div class="ms-cat-grupo">
                                  <h4 class="ms-cat-titulo">Masculino</h4>
                                  <a href="produto.php?marca=ADIDAS&genero=Masculino&tipos=Meia">Meias</a>
                                  <a href="produto.php?marca=ADIDAS&genero=Masculino&tipos=Bermuda">Bermudas</a>
                                  <a href="produto.php?marca=ADIDAS&genero=Masculino&tipos=Shorts">Shorts</a>
                              </div>
                              <div class="ms-cat-grupo">
                                  <h4 class="ms-cat-titulo">Feminino</h4>
                                  <a href="produto.php?marca=ADIDAS&genero=Feminino&tipos=Mochila">Mochilas</a>
                                  <a href="produto.php?marca=ADIDAS&genero=Feminino&tipos=Legging">Leggings</a>
                                  <a href="produto.php?marca=ADIDAS&genero=Feminino&tipos=Chuteira">Chuteiras</a>
                              </div>
                          </div>
                      </div>

                      <div class="ms-marca-wrapper">
                          <button class="ms-marca-btn" onclick="toggleMarcaMobile('mobMarca3')">
                              <span>Puma</span>
                              <span class="ms-seta">›</span>
                          </button>
                          <div id="mobMarca3" class="ms-marca-content">
                              <div class="ms-cat-grupo">
                                  <h4 class="ms-cat-titulo">Masculino</h4>
                                  <a href="produto.php?marca=PUMA&genero=Masculino&tipos=Tenis">Tênis</a>
                                  <a href="produto.php?marca=PUMA&genero=Masculino&tipos=Camiseta">Camisetas</a>
                                  <a href="produto.php?marca=PUMA&genero=Masculino&tipos=Bermuda">Bermudas</a>
                                  <a href="produto.php?marca=PUMA&genero=Masculino&tipos=Bone">Bones</a>
                              </div>
                              <div class="ms-cat-grupo">
                                  <h4 class="ms-cat-titulo">Feminino</h4>
                                  <a href="produto.php?marca=PUMA&genero=Feminino&tipos=Top">Tops</a>
                                  <a href="produto.php?marca=PUMA&genero=Feminino&tipos=Legging">Leggings</a>
                                  <a href="produto.php?marca=PUMA&genero=Feminino&tipos=Meia">Meias</a>
                                  <a href="produto.php?marca=PUMA&genero=Feminino&tipos=Shorts">Shorts</a>
                              </div>
                          </div>
                      </div>

                      <div class="ms-marca-wrapper">
                          <button class="ms-marca-btn" onclick="toggleMarcaMobile('mobMarca4')">
                              <span>Mizuno</span>
                              <span class="ms-seta">›</span>
                          </button>
                          <div id="mobMarca4" class="ms-marca-content">
                              <div class="ms-cat-grupo">
                                  <h4 class="ms-cat-titulo">Masculino</h4>
                                  <a href="produto.php?marca=MIZUNO&genero=Masculino&tipos=Tenis">Tênis</a>
                                  <a href="produto.php?marca=MIZUNO&genero=Masculino&tipos=Mochila">Mochilas</a>
                                  <a href="produto.php?marca=MIZUNO&genero=Masculino&tipos=Meia">Meias</a>
                                  <a href="produto.php?marca=MIZUNO&genero=Masculino&tipos=Chuteira">Chuteiras</a>
                              </div>
                              <div class="ms-cat-grupo">
                                  <h4 class="ms-cat-titulo">Feminino</h4>
                                  <a href="produto.php?marca=MIZUNO&genero=Feminino&tipos=Shorts">Shorts</a>
                                  <a href="produto.php?marca=MIZUNO&genero=Feminino&tipos=Bone">Bones</a>
                                  <a href="produto.php?marca=MIZUNO&genero=Feminino&tipos=Tenis">Tênis</a>
                                  <a href="produto.php?marca=MIZUNO&genero=Feminino&tipos=Mochila">Mochilas</a>
                              </div>
                          </div>
                      </div>

                      <div class="ms-marca-wrapper">
                          <button class="ms-marca-btn" onclick="toggleMarcaMobile('mobMarca5')">
                              <span>Hugo Boss</span>
                              <span class="ms-seta">›</span>
                          </button>
                          <div id="mobMarca5" class="ms-marca-content">
                              <div class="ms-cat-grupo">
                                  <h4 class="ms-cat-titulo">Masculino</h4>
                                  <a href="produto.php?marca=HUGOBOSS&genero=Masculino&tipos=Camisetas">Camisetas</a>
                                  <a href="produto.php?marca=HUGOBOSS&genero=Masculino&tipos=Mochila">Mochilas</a>
                              </div>
                              <div class="ms-cat-grupo">
                                  <h4 class="ms-cat-titulo">Feminino</h4>
                                  <a href="produto.php?marca=HUGOBOSS&genero=Feminino&tipos=Mochila">Mochilas</a>
                                  <a href="produto.php?marca=HUGOBOSS&genero=Unissex&tipos=Tenis">Tênis Casual</a>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
          </div>

          <a href="quemSomos.php" class="ms-link">Quem somos</a>
          <a href="pfrete.php" class="ms-link">Política de frete</a>
      </nav>
  </div>

  <div id="megaMenu" class="mega-menu">


      <div class="mm-marcas">
          <div class="marca-item active" onmouseover="ativarMarca('marca1', this)">
             <img src="Imagens/ICON NIKE.png" alt="Marca 1">
             <span>Nike</span>
          </div>
          <div class="marca-item" onmouseover="ativarMarca('marca2', this)">
             <img src="Imagens/ICON ADIDAS.png" alt="Marca 2">
             <span>Adidas</span>
          </div>
          <div class="marca-item" onmouseover="ativarMarca('marca3', this)">
             <img src="Imagens/ICON PUMA.png" alt="Marca 3">
             <span>Puma</span>
          </div>
          <div class="marca-item" onmouseover="ativarMarca('marca4', this)">
             <img src="Imagens/ICON MIZUNO.png" alt="Marca 4">
             <span>Mizuno</span>
          </div>
          <div class="marca-item" onmouseover="ativarMarca('marca5', this)">
             <img src="Imagens/ICON HUGO BOSS.png" alt="Marca 5">
             <span>Hugo Boss</span>
          </div>
      </div>

      <div class="mm-divisor"></div>

      <div class="mm-conteudo-container">
          
          <div id="marca1" class="mm-conteudo active">
              <div class="coluna">
                  <h3>Nike Masculino</h3>
                  <a href="produto.php?marca=NIKE&genero=Masculino&tipos=Tenis">Tênis</a>
                  <a href="produto.php?marca=NIKE&genero=Masculino&tipos=Camiseta">Camisetas</a>
                  <a href="produto.php?marca=NIKE&genero=Masculino&tipos=Legging">Leggings</a>
              </div>
              <div class="coluna">
                  <h3>Nike Feminino</h3>
                  <a href="produto.php?marca=NIKE&genero=Feminino&tipos=Top">Tops</a>
                  <a href="produto.php?marca=NIKE&genero=Masculino&tipos=Bone">Bone</a>
                  <a href="produto.php?marca=NIKE&genero=Masculino&tipos=Camiseta">Camisetas</a>
              </div>
          </div>

          <div id="marca2" class="mm-conteudo">
              <div class="coluna">
                  <h3>Adidas Masculino</h3>
                  <a href="produto.php?marca=ADIDAS&genero=Masculino&tipos=Meia">Meia</a>
                  <a href="produto.php?marca=ADIDAS&genero=Masculino&tipos=Bermuda">Bermudas</a>
                  <a href="produto.php?marca=ADIDAS&genero=Masculino&tipos=Shorts">Shorts</a>
              </div>
              <div class="coluna">
                  <h3>Adidas Feminino</h3>
                  <a href="produto.php?marca=ADIDAS&genero=Feminino&tipos=Mochila">Mochilas</a>
                  <a href="produto.php?marca=ADIDAS&genero=Feminino&tipos=Legging">Leggings</a>
                  <a href="produto.php?marca=ADIDAS&genero=Feminino&tipos=Chuteira">Chuteiras</a>
              </div>
          </div>
          
          <div id="marca3" class="mm-conteudo">
            <div class="coluna">
                <h3>Puma Masculino</h3>
                <a href="produto.php?marca=PUMA&genero=Masculino&tipos=Camiseta">Camisetas</a>
                <a href="produto.php?marca=PUMA&genero=Masculino&tipos=Tenis">Tênis</a>
                <a href="produto.php?marca=PUMA&genero=Masculino&tipos=Bermuda">Bermudas</a>
                <a href="produto.php?marca=PUMA&genero=Masculino&tipos=Bone">Bones</a>
            </div>
            <div class="coluna">
                <h3>Puma Feminino</h3>
                <a href="produto.php?marca=PUMA&genero=Feminino&tipos=Legging">Leggings</a>
                <a href="produto.php?marca=PUMA&genero=Feminino&tipos=Meia">Meias</a>
                <a href="produto.php?marca=PUMA&genero=Feminino&tipos=Shorts">Shorts</a>
                <a href="produto.php?marca=PUMA&genero=Feminino&tipos=Top">Tops</a>
            </div>
          </div>
          <div id="marca4" class="mm-conteudo">
            <div class="coluna">
                <h3>Mizuno Masculino</h3>
                <a href="produto.php?marca=MIZUNO&genero=Masculino&tipos=Tenis">Tênis</a>
                <a href="produto.php?marca=MIZUNO&genero=Masculino&tipos=Mochila">Mochilas</a>
                <a href="produto.php?marca=MIZUNO&genero=Masculino&tipos=Meia">Meias</a>
                <a href="produto.php?marca=MIZUNO&genero=Masculino&tipos=Chuteira">Chuteiras</a>
            </div>
            <div class="coluna">
                <h3>Mizuno Feminino</h3>
                <a href="produto.php?marca=MIZUNO&genero=Feminino&tipos=Tenis">Tênis</a>
                <a href="produto.php?marca=MIZUNO&genero=Feminino&tipos=Mochila">Mochilas</a>
                <a href="produto.php?marca=MIZUNO&genero=Feminino&tipos=Shorts">Shorts</a>
                <a href="produto.php?marca=MIZUNO&genero=Feminino&tipos=Bone">Bone</a>
            </div>
          </div>
          <div id="marca5" class="mm-conteudo">
            <div class="coluna">
                <h3>Hugo Boss Masculino</h3>
                <a href="produto.php?marca=HUGOBOSS&genero=Masculino&tipos=Camisetas">Camisetas</a>
                <a href="produto.php?marca=HUGOBOSS&genero=Masculino&tipos=Mochila">Mochilas</a>
            </div>
            <div class="coluna">
                <h3>Hugo Boss Feminino</h3>
                <a href="produto.php?marca=HUGOBOSS&genero=Feminino&tipos=Mochila">Mochilas</a>
                <a href="produto.php?marca=HUGOBOSS&genero=Unissex&tipos=Tenis">Tênis</a>
            </div>
          </div>
      </div>
  </div>

  </header>

 <!-- HEADER MENU ESTILIZADO FIM AAA-->

<h2>Resultados para: <?= htmlspecialchars($termo) ?></h2>

<!-- ▬▬▬▬▬▬▬ BOTÃO DE FILTRO ▬▬▬▬▬▬▬ -->

<div class="ordenar">
    <label>Ordenar por:</label>
    <select id="ordenaPor">
        <option value="evendidos" <?php echo (isset($_GET['ordem']) && $_GET['ordem'] == 'evendidos') ? 'selected' : ''; ?>>Mais vendidos</option>
        <option value="avendidos" <?php echo (isset($_GET['ordem']) && $_GET['ordem'] == 'avendidos') ? 'selected' : ''; ?>>Menos vendidos</option>
        <option value="epreco" <?php echo (isset($_GET['ordem']) && $_GET['ordem'] == 'epreco') ? 'selected' : ''; ?>>Menor preço</option>
        <option value="apreco" <?php echo (isset($_GET['ordem']) && $_GET['ordem'] == 'apreco') ? 'selected' : ''; ?>>Maior preço</option>
    </select>
</div>
<div class="container">
<?php
    $filtroOrdem = $_GET['ordem'] ?? 'evendidos';
    $sqlOrderBy = "";

switch ($filtroOrdem) {
    case 'epreco':
        $sqlOrderBy = "ORDER BY preco ASC"; 
        break;
    case 'apreco':
        $sqlOrderBy = "ORDER BY preco DESC"; 
        break;
    case 'avendidos':
        $sqlOrderBy = "ORDER BY vendidos ASC"; 
        break;
    case 'evendidos':
    default:
        $sqlOrderBy = "ORDER BY vendidos DESC"; 
        break;
}
    $sql = "SELECT id, nome, foto, marca, preco, genero, tipo FROM produto " . $sqlOrderBy;
    $query = $pdo->query($sql);
    $produtos = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<!-- ▬▬▬▬▬▬▬ CONTAINER DOS FILTROS ▬▬▬▬▬▬▬ -->
    <div id="filtrosContainer">
        <div class="barra">
        <div class="Ord">
                <h2 class="txtOrd">Filtros</h2>

                <label for="filtroMarca">Marca:</label>
                <select id="filtroMarca">
                    <option value="">Todas as marcas</option>
                    <option value="NIKE">Nike</option>
                    <option value="HUGOBOSS">Hugo Boss</option>
                    <option value="MIZUNO">Mizuno</option>
                    <option value="PUMA">Puma</option>
                    <option value="ADIDAS">Adidas</option>
                </select>

                <label for="filtroPreco">Preço:</label>
                <select id="filtroPreco">
                    <option value="">Todos os preços</option>
                    <option value="0-100">Até R$100</option>
                    <option value="100-200">R$100 a R$200</option>
                    <option value="200-300">R$200 a R$300</option>
                    <option value="300-10000">Acima de R$300</option>
                </select>

                <label for="filtroGenero">Gênero:</label>
                <select id="filtroGenero">
                    <option value="">Todos os gêneros</option>
                    <option value="Masculino">Masculino</option>
                    <option value="Feminino">Feminino</option>
                    <option value="Unissex">Unissex</option>
                </select>

                <label for="filtroTipo">Tipo:</label>
                <select id="filtroTipo">
                    <option value="">Todos os tipos</option>
                    <option value="Camiseta">Camiseta</option>
                    <option value="Tenis">Tênis</option>
                    <option value="Bermuda">Bermuda</option>
                </select>
            </div>
        </div>
    </div>


<div class='produtos'>

<?php if (count($resultados) > 0): ?>
<?php
foreach ($resultados as $item){
    // DIV com os atributos usados pelo JavaScript
    echo "
    <div class='produto'
        data-marca='{$item['marca']}'
        data-preco='{$item['preco']}'
        data-genero='{$item['genero']}'
        data-tipo='{$item['tipo']}'
    >";
    
    if ($_SESSION['nivel'] === 'admin') {
        echo "
        <a href='EditarProdutos.php?id={$item['id']}'>
            <img src='{$item['foto']}' alt='{$item['nome']}'>
            <div class='info-slide'>
                <p class='nome'>".$item["nome"]."</p>
                <p class='preco'>R$ ".number_format($item["preco"], 2, ",", ".")."</p>
            </div>
        </a>";
    } else {
        echo "
        <a href='produtos.php?id={$item['id']}'>
            <img src='{$item['foto']}' alt='{$item['nome']}'>
            <div class='info-slide'>
                <p class='nome'>".$item["nome"]."</p>
                <p class='preco'>R$ ".number_format($item["preco"], 2, ",", ".")."</p>
            </div>
        </a>";
    }

    echo "</div>";
}
?>
    </div>
<?php else: ?>
    <p>Nenhum item encontrado.</p>
<?php endif; ?>
</div>

<!-- rodape --> 
<a class="WhtsAppFixo" href="https://wa.me/5513991462611" target="_blank" title="Fale conosco no WhatsApp">
  <img src="Imagens/zap.png" alt="WhatsApp">
</a>

<footer class="rodape-global">
  
  <div class="container-rodape">
    
    <div class="col-footer">
      <img class="logo-footer" src="Imagens/icone-elegance.png" alt="Elegance PH">
      <p class="desc-footer">
        Estilo, conforto e exclusividade. A Elegance PH traz o melhor da moda urbana para você.
      </p>
      <div class="redes-sociais">
        <a href="https://www.instagram.com/_eleganceph?igsh=ajlmOW9zZTE4cnAw" target="_blank">
            <img src="Imagens/ICON INSTAGRAM.png" alt="Instagram">
        </a>
        <a href="https://wa.me/5513991462611" target="_blank" >
            <img src="Imagens/zap.png" alt="WhatsApp" style="background-color: #da2c99; border-radius: 5px; filter: invert(1);">
        </a>
      </div>
    </div>

    <div class="col-footer">
      <h3>Institucional</h3>
      <ul class="lista-links">
        <li><a href="#">Início</a></li>
        <li><a href="quemSomos.php">Quem Somos</a></li>
        <li><a href="pfrete.php">Política de Frete</a></li>
      </ul>
    </div>

    <div class="col-footer">
      <h3>Ajuda & Conta</h3>
      <ul class="lista-links">
        <li><a href="dashboard.php">Minha Conta</a></li>
        <li><a href="dashboard.php">Meus Pedidos</a></li>
        <li><a href="dashboard.php">Carrinho</a></li>
      </ul>
    </div>

    <div class="col-footer">
      <h3>Atendimento</h3>
      <p class="info-contato">Seg. a Sex. das 9h às 18h</p>
      <p class="info-contato">WhatsApp: (13) 99146-2611</p>
      <p class="info-contato">Santos - SP</p>
      
      <div class="pagamento-footer">
        <h3>Formas de Pagamento</h3>
        <div class="icons-pag">
            <span>PIX</span>
            <span>Boleto</span>
            <span>Visa</span>
        </div>
      </div>
    </div>

  </div>

  <div class="copyright">
    <p>&copy; 2025 Elegance PH Santos. Todos os direitos reservados.</p>
  </div>
</footer>

<script src="../Estilos/Eleganceph.js"></script>

</body>

</html>

