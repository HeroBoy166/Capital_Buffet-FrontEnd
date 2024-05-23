listarUsuario();

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

    document.querySelectorAll(".cpf").forEach(field => {
        field.style.display = "flex"
    })

    document.getElementById("create_nome").value = ""
    document.getElementById("create_cpf").value = ""
    document.getElementById("create_cnpj").value = ""
    document.getElementById("create_cep").value = ""
    document.getElementById("create_senha").value = ""
    document.getElementById("create_email").value = ""
    document.getElementById("create_telefone").value = ""


})

function criar(){
    nome = document.getElementById("create_nome").value
    cpf = document.getElementById("create_cpf").value
    cep = document.getElementById("create_cep").value
    cnpj = document.getElementById("create_cnpj").value
    senha = document.getElementById("create_senha").value
    email = document.getElementById("create_email").value
    telefone = document.getElementById("create_telefone").value

    var e = criarUsuario(nome, senha, cpf, cnpj, cep, email,  telefone);

    e.then( o => {
        if ( o.data.status == "sucesso"){
            listarUsuario();
            document.querySelector(".btn-close").click();
            notifications("Conta cadastrada com sucesso")
        } else {
            notifications(o.data.causa, "Message--orange", "yes")
            console.log(o.data.causa)
        }
    })
}

function mod(id){

    document.getElementById("create_nome").value = document.getElementById(`_${id}-nome`).innerHTML;
    document.getElementById("create_cpf").value = document.getElementById(`_${id}-cpf-cnpj`).getAttribute("data-cpf");
    document.getElementById("create_cnpj").value = document.getElementById(`_${id}-cpf-cnpj`).getAttribute("data-cnpj");
    document.querySelectorAll(".cpf").forEach(field => {
        field.style.display = "none"
    })
    document.getElementById("create_senha").value = document.getElementById(`_${id}-senha`).innerHTML;
    document.getElementById("create_cep").value = document.getElementById(`_${id}-cep`).innerHTML;
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

function concludeAlter(id){
    var nome = document.getElementById("create_nome").value
    var cep = document.getElementById("create_cep").value
    var senha = document.getElementById("create_senha").value
    var email = document.getElementById("create_email").value
    var telefone = document.getElementById("create_telefone").value

    var e = modUsuario(id,nome,senha,cep,email,telefone)

    e.then( o => {
        if ( o.data.status == "sucesso"){
            listarUsuario();
            document.querySelector(".btn-close").click();
            notifications("conta alterada com sucesso")
        } else{
            console.log(o.data)
            notifications("Erro", "Message--red", "yes")
        }
    })
}

function del(id){
    var e = del(id)

    e.then( o => {
        if ( o.data.status == "sucesso"){
            listarUsuario();
            document.querySelector(".btn-close").click();
            notifications("conta deletada com sucesso")
        } else {
            notifications("Erro", "Message--red", "yes")
        }
    })
}

IMask(document.getElementById("create_cpf"), { mask: '000.000.000-00' });
IMask(document.getElementById("create_telefone"), { mask: '(00) 00000-0000' });
IMask(document.getElementById("create_cep"), { mask: '00000-000' });
IMask(document.getElementById("create_cnpj"), { mask: '00.000.000/0000-00' });
