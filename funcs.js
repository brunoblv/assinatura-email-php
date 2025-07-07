function valida() {

    if (form['usuario'].value == "") {
        alert("O campo USUARIO e obrigatorio");
        form['usuario'].focus();
        return false
    }

    if (form['senha'].value == "") {
        alert("O campo SENHA e obrigatorio");
        form['senha'].focus();
        return false
    }
    carregar_btn = document.querySelector("#container_formulario")
	
	setTimeout(() => {
    carregar_btn.innerHTML = "<div class='anima_carregando'></div>Carregando Formulário...";
	}, 400);
}
