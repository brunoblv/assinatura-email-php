<form action="mailto:rogeriofazio@prefeitura.sp.gov.br" method="post" name="meu_formulario" enctype="text/plain">


      <legend>Login</legend>
        Login: <input type="text" name="login">
        Senha: <input type="password" name="senha">
        <p>
    </fieldset>
    <fieldset>
      <legend>Outras informações</legend>   
        Sexo:<br>
        <input type="radio" name="sexo" value="M">Masculino
        <input type="radio" name="sexo" value="F">Feminino
        <p>
        Deseja receber informações por:<br>
        <input type="checkbox" name="email" checked>E-mail
        <input type="checkbox" name="fone" checked>Telefone
        <input type="checkbox" name="correio" checked>Correio
        <p>
        Selecione uma cor: <input type="color" name="cor">
      </fieldset>
       <fieldset>
      <legend>Datas importantes</legend>  
        Selecione uma data: <input type="date">
        <p>
        Selecione uma data antes de 01/01/2012: <input type="date" name="data_2011" max="2011-12-31">
        <p>
        Selecione uma data depois de 01/01/2012: <input type="date" name="data_2012" min="2012-01-02">
        <p>
        Selecione uma data e um horário: <input type="datetime-local" name="data_hora_local">
        <p>
        </fieldset>

        <input type="reset" value="limpe os dados do formulário">

        <input type="submit" value="envie o formulário">
    </form>
</body>