listarRegistro();

document.querySelector("#search").addEventListener("input", function  (){
    listarRegistro(this.value)
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
        <span>${document.getElementById(`_${id}-desc`).getAttribute("data-Desc")}</span>
        
    `;
}

document.querySelector("#action").addEventListener("click", () => {
    document.getElementById("deletar").style.display = "none"
    document.getElementById("salvar").style.display = "none"
    document.getElementById("criar").style.display = "block"

    document.getElementById("create_data").value = ""
    document.getElementById("create_valor").value = ""
    document.getElementById("create_desc").value = ""


})

function criar(){
    data = document.getElementById("create_data").value
    valor = document.getElementById("create_valor").value
    desc = document.getElementById("create_desc").value

    var e = criarRegistro(data,valor,desc);

    e.then( o => {
        if ( o.data.status == "sucesso"){
            listarRegistro();
            document.querySelector(".btn-close").click();
            notifications("Registro cadastrado com sucesso")
        } else {
            notifications(o.data, "Message--orange", "yes")
            console.log(o.data)
        }
    })
}

function mod(id){

    document.getElementById("create_data").value = document.getElementById(`_${id}-data`).getAttribute("data-Data");
    document.getElementById("create_valor").value = document.getElementById(`_${id}-valor`).getAttribute("data-valor");
    document.getElementById("create_desc").value = document.getElementById(`_${id}-desc`).getAttribute("data-Desc");   

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
    var data = document.getElementById("create_data").value
    var valor = document.getElementById("create_valor").value
    var desc = document.getElementById("create_desc").value

    var e = modRegistro(id,data,valor,desc)

    e.then( o => {
        if ( o.data.status == "sucesso"){
            listarRegistro();
            document.querySelector(".btn-close").click();
            notifications("resgistro alterado com sucesso")
        } else{
            console.log(o.data)
            console.log(cpf)
            notifications("Erro", "Message--red", "yes")
        }
    })
}

function del(id){
    var e = delRegistro(id)

    e.then( o => {
        if ( o.data.status == "sucesso"){
            listarRegistro()
            document.querySelector(".btn-close").click();
            notifications("registro deletado com sucesso")
        } else {
            notifications("Erro", "Message--red", "yes")
        }
    })
}

IMask(document.getElementById("create_valor"), {
    mask: Number,
    scale: 2,
    thousandsSeparator: '',
    radix: '.'
  });
