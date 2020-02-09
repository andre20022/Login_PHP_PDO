
// ANIMAÇÃO DO FORMULARIO DE CADASTRO E LOGIN 
let img = document.getElementById("img");

img.addEventListener("click",function(){

    img.src = "css/cadeado_aberto.png";
    
    img.addEventListener("dblclick",function(){

        img.src = "css/cadeado.png";

    });

});
// FIM DE ANIMAÇÃO DO FORMULARIO DE CADASTRO E LOGIN