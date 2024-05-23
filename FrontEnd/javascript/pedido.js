function showPopup(text) {
  var popupOverlay = document.getElementById('popupOverlay');
  var popupText = document.getElementById('popupText');

  popupOverlay.style.display = 'flex';
}


function hidePopup() {
  var popupOverlay = document.getElementById('popupOverlay');
  popupOverlay.style.display = 'none';
}

// Seletor para os inputs de número
var inputs = document.querySelectorAll('input[type="number"].item-checkbox');

// Array para armazenar as comidas selecionadas
var selecoes = [1,1];

// Função para tratar a alteração no valor do input
function handleInput() {
  var selectedFood = this.parentNode.querySelector('.food').innerText;
  var quantity = this.value;
  
  // Verificar se a comida já foi selecionada antes
  var selectedFoodIndex = selecoes.findIndex(function(selecao) {
    return selecao.comida === selectedFood;
  });
  
  // Atualizar a quantidade ou adicionar uma nova seleção ao array
  if (selectedFoodIndex !== -1) {
    selecoes[selectedFoodIndex].quantidade = quantity;
  } else {
    selecoes.push({ comida: selectedFood, quantidade: quantity });
  }
  
  // Exibir as seleções no console (apenas para demonstração)
  console.log('Seleções:', selecoes);
}

// Adicionar o evento input para cada input de número
inputs.forEach(function(input) {
  input.addEventListener('input', handleInput);
});


//funções CRUD
listarPedidos()
listarPedidos2()

function criar(){
  var tipo = document.getElementById("tipo").innerHTML;
  var orcamento = document.getElementById("orca").innerHTML
  var data = document.getElementById("data").innerHTML
  var numconvidado = document.getElementById("numconvidado").innerHTML
  var endereco = document.getElementById("endereco").innerHTML
  var observacao = document.getElementById("obs").innerHTML

  var e = criarPedido( tipo, orcamento, data, data, numconvidado, endereco, observacao, 0, 0, 0, 0);

  e.then( o => {
    if ( o.data == "Pedido cadastrado com sucesso!"){
        listarPedido();
        notifications(o.data)
    } else {
        notifications(o.data, "Message--orange", "yes")
        console.log(o.data)
    }
})
}

function del(){}
function alterar(){}



idPedido = 1;
function redirecionar(){
  window.location.href = "../views/comidas_cliente.html?idPedido=" + idPedido;
}



