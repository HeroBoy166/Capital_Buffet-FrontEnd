listarFuncionario();

document.querySelector("#search").addEventListener("input", function  (){
    listarFuncionario(this.value)
});

document.querySelector("#action").addEventListener("click", function (){
    document.querySelector(".off").classList.remove("ss")
    document.querySelector(".off").classList.add("s")
});

document.querySelector("#act").addEventListener("click", function (){
    document.querySelector(".off").classList.remove("s")
    document.querySelector(".off").classList.add("ss")
});

document.querySelector(".header-navigation-actions").addEventListener("mouseover", function(){
    var i = document.querySelector(".ph-lightning-bold")
    if(i){
        i.classList.remove("ph-lightning-bold")
        i.classList.add("ph-lightning-fill")
    }
})

document.querySelector(".header-navigation-actions").addEventListener("mouseout", function(){
    var i = document.querySelector(".ph-lightning-fill")
    if(i){
        i.classList.remove("ph-lightning-fill")
        i.classList.add("ph-lightning-bold")
    }
})

function contatoFuncionario(id){
    document.querySelector(".row1").innerHTML = `
        <span>${document.getElementById(`_${id}-contatos`).getAttribute("data-telefone")}</span>
        <span>${document.getElementById(`_${id}-contatos`).getAttribute("data-email")}</span>
        
    `;
}

document.querySelector("#action").addEventListener("click", () => {
    document.getElementById("deletar").style.display = "none"
    document.getElementById("salvar").style.display = "none"
    document.getElementById("criar").style.display = "block"

    document.getElementById("create_nome").value = ""
    document.getElementById("create_cpf").value = ""
    document.getElementById("create_cargo").value = ""
    document.getElementById("create_salario").value = ""
    document.getElementById("create_email").value = ""
    document.getElementById("create_telefone").value = ""


})

function criar(){
    nome = document.getElementById("create_nome").value
    cpf = document.getElementById("create_cpf").value
    cargo = document.getElementById("create_cargo").value
    salario = document.getElementById("create_salario").value
    email = document.getElementById("create_email").value
    telefone = document.getElementById("create_telefone").value

    var e = criarFuncionario(nome,cpf,cargo,salario,email,telefone);

    e.then( o => {
        if ( o.data.status == "sucess"){
            listarFuncionario();
            document.querySelector(".btn-close").click();
            notifications("funcionário cadastrado com sucesso")
        } else {
            notifications(o.data, "Message--orange", "yes")
            console.log(o.data)
        }
    })
}

function mod(id){

    document.getElementById("create_nome").value = document.getElementById(`_${id}-nome`).innerHTML;
    document.getElementById("create_cpf").value = document.getElementById(`_${id}-cpf`).innerHTML;
    document.getElementsByClassName("cpf")[0].style.display = "none"
    document.getElementsByClassName("cpf")[1].style.display = "none"
    document.getElementById("create_cargo").value = document.getElementById(`_${id}-cargo`).innerHTML;
    document.getElementById("create_salario").value = document.getElementById(`_${id}-salario`).getAttribute("data-salario");
    document.getElementById("create_email").value = document.getElementById(`_${id}-contatos`).getAttribute("data-email");
    document.getElementById("create_telefone").value = document.getElementById(`_${id}-contatos`).getAttribute("data-telefone");   

    document.getElementById("deletar").style.display = "block"
    document.getElementById("salvar").style.display = "block"
    document.getElementById("criar").style.display = "none"

    
    document.querySelector("#salvar").addEventListener("click", function(){
        concludeAlter(id)
    });

    document.querySelector("#deletar").addEventListener("click", function(){
        del(id)
    });

    document.querySelector(".off").classList.remove("ss")
    document.querySelector(".off").classList.add("s")
}

function concludeAlter(cpf){
    var nome = document.getElementById("create_nome").value
    var cargo = document.getElementById("create_cargo").value
    var salario = document.getElementById("create_salario").value
    var email = document.getElementById("create_email").value
    var telefone = document.getElementById("create_telefone").value

    var e = modFuncionario(nome,cpf,cargo,salario,email,telefone)

    e.then( o => {
        if ( o.data.status == "sucesso"){
            listarFuncionario();
            document.querySelector(".btn-close").click();
            notifications("funcionário alterado com sucesso")
        } else{
            console.log(o.data)
            console.log(cpf)
            notifications("Erro", "Message--red", "yes")
        }
    })
}

function del(id){
    var e = delFuncionario(id)

    e.then( o => {
        if ( o.data.status == "sucesso"){
            listarFuncionario();
            document.querySelector(".btn-close").click();
            notifications("funcionário deletado com sucesso")
        }
        if(o.data.causa == "faz parte de pedido"){
            notifications("O funcionário em questão faz parte de um pedido", "Message--orange", "yes")
            console.log(o.data)
        } else {
            notifications("Erro", "Message--red", "yes")
        }
    })
}

IMask(document.getElementById("create_cpf"), { mask: '000.000.000-00' });
IMask(document.getElementById("create_telefone"), { mask: '(00) 00000-0000' });
IMask(document.getElementById("create_salario"), {
    mask: Number,
    scale: 2,
    thousandsSeparator: '',
    radix: '.'
  });