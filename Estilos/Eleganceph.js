
  function mostrarMenu() {
    var menu = document.getElementById("cont");
    if (menu.style.display === "block") {
      menu.style.display = "none";
    } else {
      menu.style.display = "block";
    }
  }

 function mostrar() {
    var menu = document.getElementById("filtrosContainer"); 
    if (menu.style.display === "block") {
        menu.style.display = "none";
    } else {
        menu.style.display = "block";
    }
}
    // --- MEGA MENU (zeus ) ---
  window.addEventListener("scroll", function() {
        let header = document.querySelector('.menu');
        
        if (window.scrollY > 50) { 
            header.classList.add('menu-compact');
            

            if (header.classList.contains('menu-aberto')) {
                header.classList.remove('menu-aberto');
            }
        } else {
            header.classList.remove('menu-compact');
        }
    });


 
    function toggleMegaMenu() {
        const header = document.querySelector('.menu');
    
        header.classList.toggle('menu-aberto');
    }


    function ativarMarca(idConteudo, elementoBola) {

       const todasMarcas = document.querySelectorAll('.marca-item');
       todasMarcas.forEach(m => m.classList.remove('active'));
       elementoBola.classList.add('active');

       const todosConteudos = document.querySelectorAll('.mm-conteudo');
       todosConteudos.forEach(c => c.classList.remove('active'));
       
       const alvo = document.getElementById(idConteudo);
       if(alvo) alvo.classList.add('active');
    }
    
    // --- MEGA MENU MOBILE SANFONA MEU TBM (Zeus) ---


    function toggleMenuMobile() {
        const sidebar = document.getElementById('mobileSidebar');
        const overlay = document.getElementById('mobileOverlay');
        
        
        sidebar.classList.toggle('aberto');
        overlay.classList.toggle('aberto');
        
       
        if (sidebar.classList.contains('aberto')) {
            document.body.style.overflow = 'hidden';
        } else {
            document.body.style.overflow = 'auto';
        }
    }

    function toggleSubMenuMobile() {
        const submenu = document.getElementById('msSubmenu');
        const seta = document.getElementById('setaMobile');
        
        submenu.classList.toggle('ativo');
        
      
        if (submenu.classList.contains('ativo')) {
            seta.style.transform = "rotate(180deg)";
        } else {
            seta.style.transform = "rotate(0deg)";
        }
    }

    
    function toggleMarcaMobile(id) {
        const conteudo = document.getElementById(id);
        const botao = event.currentTarget; 
        
     
        conteudo.classList.toggle('aberto');
   
        botao.classList.toggle('ativo');
    }


    // ------------------------ eu acho q tudo isso abaixo é inutil até ultimo comentario, n tenho ctz
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

function mousedentro(){

  const produtos = document.getElementById("mousecima");
  produtos.style.display = "flex";
}

function mousefora(){

  const produtos = document.getElementById("mousecima");
  produtos.style.display = "none";
}


// pagina produtos filtros e ordenar
document.addEventListener("DOMContentLoaded", function() {
    
    // Seleciona tudo que pode disparar filtro
    const triggers = document.querySelectorAll('#ordenaPor, #filtroPreco, #filtroGenero, .filtro-check');

    triggers.forEach(el => {
        el.addEventListener('change', atualizarPagina);
    });

    function atualizarPagina() {
        const url = new URL(window.location.href);
        
        // 1. Limpa parâmetros antigos para reconstruir (evita duplicatas)
        url.searchParams.delete('marca[]');
        url.searchParams.delete('tipos[]');
        
        // 2. Pega selects simples (Ordem, Preço, Genero)
        const ordem = document.getElementById('ordenaPor').value;
        const preco = document.getElementById('filtroPreco').value;
        const genero = document.getElementById('filtroGenero').value;

        // Atualiza URL simples
        (ordem) ? url.searchParams.set('ordem', ordem) : url.searchParams.delete('ordem');
        (preco) ? url.searchParams.set('preco', preco) : url.searchParams.delete('preco');
        (genero) ? url.searchParams.set('genero', genero) : url.searchParams.delete('genero');

        // 3. Pega os Checkboxes (Marcas e Tipos)
        const checks = document.querySelectorAll('.filtro-check:checked');
        
        checks.forEach(check => {
            // check.name já é "marca[]" ou "tipos[]"
            // append adiciona mais um valor à mesma chave
            url.searchParams.append(check.name, check.value);
        });

        // 4. Recarrega
        window.location.href = url.toString();
    }
});



function buscaCep() {
    let cep = document.getElementById('cep').value.replace(/\D/g,'');
    if (cep.length === 8) {
        fetch(`https://viacep.com.br/ws/${cep}/json/`)
            .then(response => response.json())
            .then(data => {
                if (!data.erro) {
                    document.getElementById('rua').value = data.logradouro || '';
                } else {
                    alert("CEP não encontrado.");
                    document.getElementById('rua').value = '';
                }
            })
            .catch(() => alert("Erro ao consultar CEP."));
    }
}


document.getElementById('cep').addEventListener('blur', async function () {
    let cep = this.value.replace(/\D/g, '');

    function limparCampos() {
        document.getElementById('rua').value = "";
        document.getElementById('bairro').value = "";
        document.getElementById('cidade').value = "";
        document.getElementById('estado').value = "";
        }
        limparCampos();

         if(cep.length < 8 || cep.length > 8 ){
            alert("Digite novamente...");
            document.getElementById('cep').value = "";
        } 

    if (cep.length === 8) {
        const response = await fetch(`https://viacep.com.br/ws/${cep}/json/`);
        const data = await response.json();
    if (!data.erro) {
            document.getElementById('rua').value = data.logradouro;
            document.getElementById('bairro').value = data.bairro;
            document.getElementById('cidade').value = data.localidade;
            document.getElementById('estado').value = data.uf;
        }else{
            alert("CEP não encontrado")
            document.getElementById('cep').value = "";
        }
    }
});


