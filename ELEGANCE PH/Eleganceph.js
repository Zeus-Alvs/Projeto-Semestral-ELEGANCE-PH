
function mostrar() {
    document.getElementById("container").style.display = "block";
  }

  function mostrarMenu() {
    document.getElementById("cont").style.display = "block";
  }

  linkbase = "";
  function abririmagem(src, descricao, href, preco){
    document.getElementById('imagem-grande').src = src;
    document.getElementById('descricao').innerText = descricao;
    document.getElementById('overlay').style.display = 'flex';
    document.getElementById('preco').innerText = "R$" + preco;
    linkbase = href;
  }


  function comprar(){
    const tamanho = document.getElementsByName("tamanho");
    let op_tamanho = "";
    for(let i=0;i<tamanho.length;i++){
      if(tamanho[i].checked){
        op_tamanho = tamanho[i].value;
      }
    }
    if(op_tamanho == ""){
      alert("Selecione Tamanho");
    }
    else{
    const vlink = document.getElementById("vlink");
    vlink.href = linkbase + " Tamanho: " + op_tamanho;
  }
  }

  function fecharimagem(){
    document.getElementById('overlay').style.display = 'none';
  }


let miniCarrinhoItens = [];


function fecharMiniCarrinho() {
    document.getElementById('miniCarrinhoContainer').style.display = 'none';
    document.getElementById('vercarrinho').style.display=	'flex';
}

function verMiniCarrinho(){
  document.getElementById('miniCarrinhoContainer').style.display = 'flex';
  document.getElementById('vercarrinho').style.display=	'none';
}

function carrinho(){


    const tamanho = document.getElementsByName("tamanho");
    let op_tamanho = "";
    for(let i=0;i<tamanho.length;i++){
      if(tamanho[i].checked){
        op_tamanho = tamanho[i].value;
      }
    }

    if(op_tamanho == ""){
        alert("Por favor, selecione um Tamanho.");
        return;
    }

    document.getElementById('miniCarrinhoContainer').style.display = 'flex';
    document.getElementById('overlay').style.display = 'none';
    document.getElementById('vercarrinho').style.display=	'none';

    const productName = document.getElementById('descricao').innerText;
    const productPriceText = document.getElementById('preco').innerText;
    const productPrice = parseFloat(productPriceText.replace('R$', '').replace(',', '.'));

    const newItem = {
        name: productName,
        price: productPrice,
        size: op_tamanho,
        quantity: 1
    };

    const existingItemIndex = miniCarrinhoItens.findIndex(item =>
        item.name === newItem.name && item.size === newItem.size
    );

    if (existingItemIndex > -1) {
        miniCarrinhoItens[existingItemIndex].quantity += 1;
    } else {
        miniCarrinhoItens.push(newItem);
    }

    fecharimagem();
    renderizarMiniCarrinho(); 
    abrirMiniCarrinho(); 
}


function renderizarMiniCarrinho() {
    const miniCartItemsDiv = document.getElementById('miniCarrinhoItens');
    const miniCartTotalSpan = document.getElementById('miniCarrinhoTotal');
    miniCartItemsDiv.innerHTML = ''; 

    let total = 0;
    if (miniCarrinhoItens.length === 0) {
        miniCartItemsDiv.innerHTML = '<p>Seu mini carrinho está vazio.</p>';
    } else {
        miniCarrinhoItens.forEach((item, index) => {
            const itemElement = document.createElement('p');
            itemElement.textContent = `${item.name} (${item.size}) - Qtd: ${item.quantity} - R$ ${(item.price * item.quantity).toFixed(2)}`;
            miniCartItemsDiv.appendChild(itemElement); 
            total += item.price * item.quantity; 
        });
    }
    miniCartTotalSpan.textContent = total.toFixed(2);
}


function limparMiniCarrinho() {
    miniCarrinhoItens = []; 
    renderizarMiniCarrinho(); 
    alert('Mini carrinho limpo!');
}

function comprarminicarrinho(){
  let message  = "Olá, fiquei interessado nos seguintes itens:\n\n";

  miniCarrinhoItens.forEach((item, index) => {
    const itemElement = document.createElement('p');
    itemElement.textContent = `${item.name} (${item.size}) - Qtd: ${item.quantity} - R$ ${(item.price * item.quantity).toFixed(2)}`;
    miniCartItemsDiv.appendChild(itemElement); 
    total += item.price * item.quantity; 
    message += `${item.name} (tamanho: ${item.size}) - Quantidade: ${item.quantity} - Preço Unitário: R$ ${item.price.toFixed(2)} - 
    Subtotal: R$ ${(item.price * item.quantity).toFixed(2)}\n`;
});

  message += `\nTotal do carrinho: R$ ${total.toFixed(2)}`;
  const encodedMessage = encondeURIComponent(message);
  const clink = document.getElementById("clink");
  clink.href = `https://wa.me/5513991462611?text=${encodedMessage}`;
}

function mousedentro(){

  const produtos = document.getElementById("mousecima");
  produtos.style.display = "flex";
}

function mousefora(){

  const produtos = document.getElementById("mousecima");
  produtos.style.display = "none";
}