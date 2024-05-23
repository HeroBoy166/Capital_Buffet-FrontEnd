var order = "0";
let type = "";
var communication = {};

document.querySelectorAll('a').forEach(one => {
    if(one.getAttribute("data-Type")){

        one.addEventListener('click', function (){

            const foodTypes = document.querySelectorAll('a');
            foodTypes.forEach( type =>{type.classList.remove("active");});
            this.classList.add("active");
            type = this.getAttribute("data-Type");
            if(type == "0"){
                type = "";
            }
            listarComida();
            //console.log(type+ order );
        });
    }
});

document.querySelectorAll("l").forEach( one => {
    one.addEventListener('click', function (){

        document.querySelectorAll('l').forEach( toggle =>{
                toggle.classList.remove("active");
        });

        this.classList.toggle("active");
        order = this.getAttribute("data-order");
        //console.log(type+order);
        listarComida();

    });
})
function set(){
    var action = document.querySelectorAll(".material-symbols-outlined");
    action.forEach(MP => {

        if(MP.classList.contains("plus")){
            MP.addEventListener("click", function (){
                var number = document.getElementById("n"+this.id);
                var counter = parseInt(number.innerHTML);
                var name = document.getElementById(this.id+"-name").getAttribute("data-id");
                if( document.getElementById("c"+this.id).checked && parseInt(number.getAttribute("data-limit")) > counter){
                    number.innerHTML = counter + 1;
                    communication[name] = counter + 1;
                    console.log(JSON.stringify(communication))
                    console.log(JSON.parse(JSON.stringify(communication)))
                }
            });
        } else if(MP.classList.contains("minus")){
            MP.addEventListener("click", function (){
                var number = document.getElementById("n"+this.id);
                var counter = parseInt(number.innerHTML);
                var name = document.getElementById(this.id+"-name").getAttribute("data-id");
                if(counter >= 1 && document.getElementById("c"+this.id).checked ){
                    number.innerHTML = counter - 1;
                    communication[name] = counter - 1;
                    console.log(JSON.stringify(communication))
                    console.log(JSON.parse(JSON.stringify(communication)))
                }
            });
        }

    });


    var toggle = document.querySelectorAll("input");
    toggle.forEach( toggler => {
        if(toggler.getAttribute("data-Toggle")){
            toggler.addEventListener("click", function (){
                if(this.checked){
                document.querySelectorAll("."+this.getAttribute("data-Toggle")).forEach( act => { act.classList.remove("gray")} )
            } else {
                document.querySelectorAll("."+this.getAttribute("data-Toggle")).forEach( act => { act.classList.add("gray")} )
                document.getElementById("n"+this.getAttribute("data-Toggle")).innerHTML = "0";
                var name = document.getElementById(this.getAttribute("data-Toggle")+"-name").getAttribute("data-id")
                communication[name] = 0;
                console.log(JSON.stringify(communication))
                console.log(JSON.parse(JSON.stringify(communication)))
            }
            })
        }
    });
}


function articleCreate(content){
    var response = "";
    var quantity = 0;
    var checked = "";
    var gray = "";
    Object.keys(content).forEach(function(key, index){
        if (typeof(content[index].nome) == "undefined" || content[index].estoque == "0" ){
        
        }else{
            quantity = 0
            checked = ""
            gray = "gray"
            if(communication.hasOwnProperty(content[index].id)){
                quantity = communication[content[index].id]
                checked = "checked"
                gray = ""
            }
        response += `
        <article class="card" data-Type="${content[index].categoria}">
			<div class="card-header">
				<div>
					<span></span>
					<h3 id="_${content[index].id}-name" data-id="${content[index].id}">${content[index].nome}</h3>
				</div>
				<label class="toggle">
					<input type="checkbox" id="c_${content[index].id}" data-Toggle="_${content[index].id}" ${checked}>
					<span></span>
				</label>
			</div>
			<div class="card-body">
        <img src="${content[index].img || "../imagens/logo.png"}"/>
			</div>
			<div class="card-footer">
				<a href="#">Quantity:</a><hr>
				<span id="_${content[index].id}" class="material-symbols-outlined minus _${content[index].id} ${gray}">do_not_disturb_on</span>
				<number data-limit="${content[index].estoque}" id="n_${content[index].id}">${quantity}</number>
				<span id="_${content[index].id}" class="material-symbols-outlined plus _${content[index].id} ${gray}">add_circle</span>
			</div>
			<div id ="_${content[index].id}price" data-price="${content[index].preco}" class="price">Price: R$ ${content[index].preco}</div>
	    </article>`;
    }
    });
    return response;
}


//COMIDAS
function criarComida(nome, preco, estoque, tipo, categoria, desc, imagem){
    axios.get("../..//PHP/Comidas/cadastrarComida.php", { 
        params:{
        nome:nome,
        preco: preco,
        estoque: estoque,
        tipo: tipo,
        categoria: categoria,
        desc: desc,
        imagem: imagem
    }}).then( e => {
        console.log(e)
    }).catch();
}

function listarComida(nome, categoria){
    axios.get("../..//PHP/Comidas/listarComidas.php" ,{params:{
        querry: nome,
        ordem: order,
        tipo: categoria,
        categoria: type
    }}
    ).then( e => {
        document.querySelector(".card-grid").innerHTML = articleCreate(e.data);
        set();
        console.log(e.data)
    }).catch();
}
listarComida();
document.querySelector("#search").addEventListener("keydown", function  (){
    listarComida(this.value, "")
});
document.querySelector("#search").addEventListener("keyup", function  (){
    listarComida(this.value, "")
});

function delComida(id){
    axios.get("../..//PHP/Comidas/deletarComida.php", { params:{
            id:id
        }
    }).then(e => {
        console.log(e)
    }).catch()
}

function modComida(id, nome, preco, estoque, tipo, categoria, desc, imagem){
    axios.get("../..//PHP/Comidas/alterarComida.php", { 
        params:{
        id: id,
        nome: nome,
        preco: preco,
        estoque: estoque,
        tipo: tipo,
        categoria: categoria,
        desc: desc,
        imagem: imagem
    }}).then( e => {
        console.log(e)
    }).catch();
}

//UTILITARIOS
function criarUtilitario( nome, preco, estoque, desc, imagem){
    axios.get("../..//PHP/Utilitarios/cadastrarUtilitario.php", { 
        params:{
            nome: nome,
            preco: preco,
            estoque: estoque,
            desc: desc,
            imagem: imagem
        }}).then( e => {
            console.log(e.data)
        }). catch();
}

function listarUtilitario(nome, ordem){
    axios.get("../..//PHP/Utilitarios/listarUtilitarios.php" ,{params:{
        nome: nome || "",
        ordem: ordem || "",
    }}
    ).then( e => {
        console.log(e.data)
    }).catch();
}

function modUtilitario(id, nome, preco, estoque, desc, imagem){
 axios.get("../../PHP/Utilitarios/alterarUtilitario.php", {
    params:{
        id: id,
        nome: nome,
        preco: preco,
        estoque: estoque,
        desc: desc,
        imagem: imagem
    }}).then( e =>{
        console.log(e.data)
    }).catch();
}

function delUtilitario(id){
    axios.get("../../PHP/Utilitarios/deletarUtilitario.php", {
        params:{
            id: id
        }
    }).then( e =>{
        console.log(e.data)
    }).catch();
}

//FUNCIONARIOS
function criarFuncionario(nome, cpf, cargo, salario, email, telefone){
    axios.get("../../PHP/Funcionarios/cadastrarFuncionario.php", {
        params:{
            nome: nome,
            cpf: cpf,
            cargo: cargo,
            salario: salario,
            email: email,
            telefone: telefone
        }
    } ).then(e => {
        console.log(e.data)
    }).catch();
}

function modFuncionario(nome, cpf, cargo, salario, email, telefone){
    axios.get("../../PHP/Funcionarios/alterarFuncionario.php", {
        params: {
            nome: nome,
            cpf: cpf,
            cargo: cargo,
            salario: salario,
            email: email,
            telefone: telefone
        }
    }).then( e => {
        console.log(e,data)
        console.log("status: " + e.data.status)
            if (e.data.cause){
                console.log("causa: " + e.data.causa)
            }
    }).catch();
}

function delFuncionario(cpf){
    axios.get("../../PHP/Funcionarios/deletarFuncionario.php", {
        params:{
            cpf: cpf
        }}).then( e =>{
            console.log("status: "+e.data.status)
            if (e.data.status == "falha"){
                console.log("causa: "+e.data.causa)
            }
        }).catch();
}

function listarCargos(){
    axios.get("../../PHP/Funcionarios/listarCargos.php", {params:{}})
        .then(e => {
            console.log(e.data);
        })
}

//USUARIOS
function criarUsuario(nome, senha, cpf, cnpj, cep,  email, telefone){
    axios.get("../../PHP/Usuarios/criarConta.php", {
        params:{
            nome: nome,
            senha:senha,
            cpf:cpf,
            cnpj:cnpj,
            cep:cep,
            email:email,
            telefone:telefone
        }
    }).then(e=>{
        console.log(e.data.status)
        if(e.data.status == "falha"){
            console.log(`causa: ${e.data.causa}`)
        }
    }).catch();
}

function listarUsuario(query){
    axios.get("../../PHP/Usuarios/listarContas.php", {
        params:{
            query:query
        }
    }).then(e=>{
        console.log(e.data)
    }).catch();
}

function modUsuario(id, nome, senha, cep,  email, telefone, admin){
    axios.get("../../PHP/Usuarios/alterarConta.php", {
        params:{
            id:id,
            nome: nome,
            senha:senha,
            cpf:cpf,
            cnpj:cnpj,
            cep:cep,
            email:email,
            telefone:telefone,
            admin: admin
        }
    }).then(e=>{
        console.log(e.data.status)
        if(e.data.status == "falha"){
            console.log(`causa: ${e.data.causa}`)
        }
    }).catch();
}

function delUsuario(id){
    axios.get("../../PHP/Usuarios/deletarConta.php", {
        params:{
            id: id
        }
    }).then( e => {
        console.log("status: "+e.data.status);
        if(e.data.status == "falha"){
            console.log("causa: "+ e.data.causa)
        }
    })
}

function login(email, senha){
    axios.get("../../PHP/Usuarios/login.php", {
        params:{
            email: email,
            senha: senha
        }
    }).then(e=>{
        console.log(e.data)
    }).catch();
}

//REGISTROS FINANCEIROS
function criarRegistro(data, valor, desc){
    axios.get("../../PHP/Registros_Financeiros/cadastrarRegistro.php", {
        params:{
            data: data,
            valor: valor,
            desc: desc
        }
    }).then( e => {
        console.log(e.data)
    }).catch();
}

function listarRegistro(querry){
    axios.get("../../PHP/Registros_Financeiros/listarRegistros.php", {
        params:{
            querry: querry
        }
    }).then( e => {
        console.log(e.data)
    }).catch();
}

function modRegistro(id, data, valor, desc){
    axios.get("../../PHP/Registros_Financeiros/alterarRegistro.php", {
        params:{
            id: id,
            valor: valor,
            data: data,
            desc: desc
        }
    }).then(e => {
        console.log(e)
    })
}

function delRegistro(id){
    axios.get("../../PHP/Registros_Financeiros/deletarRegistro.php", {
        params:{
            id:id
        }
    }).then( e => {
        console.log(e.data)
    })
}

//PEDIDOS
function criarPedido(tipo, orcamento, inicio, fim, qtd_convidados, endereco, observacoes, qtd_comidas, qtd_utilitarios, qtd_cargos, usuario_id){
    axios.get("../../PHP/Pedidos/criarPedido.php", {
        params:{
            tipo: tipo, 
            orcamento: orcamento, 
            inicio: inicio, 
            fim: fim, 
            qtd_convidados: qtd_convidados, 
            endereco: endereco, 
            observacoes: observacoes, 
            qtd_comidas: qtd_comidas, 
            qtd_utilitarios: qtd_utilitarios, 
            qtd_cargos: qtd_cargos, 
            usuario_id: usuario_id
        }
    }).then( e => {
        console.log(e.data)
    }).catch();
}

function listarPedido(querry){ //Não alterei o listarPedidos.php, lembre de mudar depois
    axios.get("../../PHP/Pedidos/listarPedidos.php", {
        params:{
            querry: querry
        }
    }).then( e => {
        console.log(e.data)
    }).catch();
}

function listarPedido2(querry){ //Não alterei o listarPedidos2.php, lembre de mudar depois
    axios.get("../../PHP/Pedidos/listarPedidos2.php", {
        params:{
            querry: querry
        }
    }).then( e => {
        console.log(e.data)
    }).catch();
}

function modPedido(id_pedido, tipo, status, inicio, fim, qtd_convidados, endereco, observacoes, qtd_comidas, qtd_utilitarios, qtd_cargos, usuario_id){
    axios.get("../../PHP/Pedidos/alterarPedido.php", {
        params:{
            id_pedido: id_pedido,
            tipo: tipo,
            status: status,
            inicio: inicio, 
            fim: fim, 
            qtd_convidados: qtd_convidados, 
            endereco: endereco, 
            observacoes: observacoes, 
            qtd_comidas: qtd_comidas, 
            qtd_utilitarios: qtd_utilitarios, 
            qtd_cargos: qtd_cargos,
            usuario_id: usuario_id
        }
    }).then(e => {
        console.log(e)
    })
}

function delPedido(id){
    axios.get("../../PHP/Pedidos/deletarPedido.php", {
        params:{
            id: id
        }
    }).then( e => {
        console.log(e.data)
    })
}