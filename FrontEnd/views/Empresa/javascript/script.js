listarComida();

document.querySelector("#search").addEventListener("input", function  (){
    listarComida("",this.value)
});

document.querySelector("#create_nome").addEventListener("input", function (){
    document.querySelector("#create-name").innerHTML = this.value;
})

document.querySelector("#create_image").addEventListener("input", function (){
    if(this.value != ""){
        document.querySelector("#create-img").src = this.value;
    } else {
        document.querySelector("#create-img").src = "../../imagens/logo.png";
    }
})

document.querySelector("#create_estoque").addEventListener("input", function (){
    document.querySelector("#create-estoque").innerHTML = this.value;
})

document.querySelector("#create_preco").addEventListener("input", function (){
    document.querySelector("#create-preco").innerHTML = this.value;
})

document.querySelector("#create_desc").addEventListener("input", function (){
    document.querySelector("#create-desc").innerHTML = this.value;
})

document.querySelectorAll(".show").forEach( canvas => {
    if(canvas.classList.contains("offcanvas-left")){
        canvas.style.display = "none";
    } else {
    canvas.classList.remove("show");
    }
})


function alterar(id){
    document.getElementById("create-name").innerHTML = document.getElementById("create_nome").value = document.getElementById(`_${id}-name`).innerHTML;
    document.getElementById("create-img").src = document.getElementById("create_image").value = document.getElementById(`_${id}-img`).src;
    document.getElementById("create-estoque").innerHTML = document.getElementById("create_estoque").value = document.getElementById(`_${id}-estoque`).innerHTML;
    document.getElementById("create-preco").innerHTML = document.getElementById("create_preco").value = document.getElementById(`_${id}-preco`).innerHTML;
    document.getElementById("create-desc").innerHTML = document.getElementById("create_desc").value = document.getElementById(`_${id}-desc`).innerHTML;
    document.getElementById("create_categoria").value = document.getElementById(`${id}`).getAttribute("data-categoria");
    document.getElementById("create_tipo").value = document.getElementById(`${id}`).getAttribute("data-tipo");

    document.getElementById("deletar").style.display = "block"
    document.getElementById("salvar").style.display = "block"
    document.getElementById("criar").style.display = "none"

    document.querySelectorAll(".offcanvas").forEach( canvas => {
        if(canvas.classList.contains("offcanvas-left")){
            canvas.style.display = "block";
            canvas.style.visibility = "visible";
            canvas.setAttribute("aria-hidden", "false")
        }
            canvas.classList.add("show");
    });

    document.querySelector("#salvar").addEventListener("click", function(){
        concludeAlter(id)
    });

    document.querySelector("#deletar").addEventListener("click", function(){
        del(id)
    });
}

function del(id){
    var e = delComida(id);

    e.then( o => {
        if ( o.data == "Comida deletada com sucesso!"){
            listarComida();
            document.querySelector(".btn-close").click();
            notifications(o.data)
        } else {
            notifications(o.data, "Message--orange", "yes")
            console.log(o.data)
        }
    })
}

 function concludeAlter(id){
    var nome =document.getElementById("create-name").innerHTML;
    var img =document.getElementById("create-img").src;
    var estoque = document.getElementById("create-estoque").innerHTML;
    var preco = document.getElementById("create-preco").innerHTML;
    var desc = document.getElementById("create-desc").innerHTML;
    var tipo = document.getElementById("create_tipo").value;
    var categoria = document.getElementById("create_categoria").value;
    //console.log(id)

    var e = modComida(id, nome, preco, estoque, tipo, categoria, desc, img);

    e.then( o => {
            if ( o.data == "Comida alterada com sucesso!"){
                listarComida();
                document.querySelector(".btn-close").click();
                notifications(o.data)
            } else {
                notifications(o.data, "Message--orange", "yes")
                console.log(o.data)
            }
        })
}

function criar(){
    var nome =document.getElementById("create-name").innerHTML;
    var img =document.getElementById("create-img").src;
    var estoque = document.getElementById("create-estoque").innerHTML;
    var preco = document.getElementById("create-preco").innerHTML;
    var desc = document.getElementById("create-desc").innerHTML;
    var tipo = document.getElementById("create_tipo").value;
    var categoria = document.getElementById("create_categoria").value;
    //console.log(id)

    var e = criarComida( nome, preco, estoque, tipo, categoria, desc, img);

    e.then( o => {
            if ( o.data == "Comida cadastrada com sucesso!"){
                listarComida();
                document.querySelector(".btn-close").click();
                notifications(o.data)
            } else {
                notifications(o.data, "Message--orange", "yes")
                console.log(o.data)
            }
        })
}

document.querySelector("#action").addEventListener("click", () => {
    document.getElementById("deletar").style.display = "none"
    document.getElementById("salvar").style.display = "none"
    document.getElementById("criar").style.display = "block"
})