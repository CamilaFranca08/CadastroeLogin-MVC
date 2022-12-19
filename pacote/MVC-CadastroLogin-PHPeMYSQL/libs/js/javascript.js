VMasker(document.querySelector("#cpf")).maskPattern("999.999.999-99");
VMasker(document.querySelector("#dataNascimento")).maskPattern("99/99/9999");

function getRoot()
{
    var roo="http://"+document.location.hostname+"/";
    return root;
}
alert(getRoot());
(function getCaptcha()
{
    grecaptcha.ready(function() {
        grecaptcha.execute('SUA_SITE_KEY', {action: 'homepage'}).then(function(token) {
            const gRecaptchaResponse=document.querySelector("#g-recaptcha-response").value=token;
        });
    });
}
());

//Ajax do formulário de cadastro
$("#formCadastro").on("submit",function(event){
    event.preventDefault();
    var dados=$(this).serialize();

    $.ajax({
        url: getRoot()+'controllers/controllerCadastro',
        type: 'post',
        dataType: 'json',
        data: dados,
        success: function (response) {
            $('.retornoCad').empty();
            if(response.retorno == 'erro'){
                getCaptcha();
                $.each(response.erros,function(key,value){
                    $('.retornoCad').append(value+'');
                });
            }else{
                $('.retornoCad').append('Dados inseridos com sucesso!');
            }
        }
    });
});

//Ajax do formulário de login
$("#formLogin").on("submit",function(event){
    event.preventDefault();
    var dados=$(this).serialize();

    $.ajax({
        url: getRoot()+'controllers/controllerLogin',
        type: 'post',
        dataType: 'json',
        data: dados,
        success: function (response) {
          if(response.retorno == 'sucess'){
                window.location.href=response.page;
          }else {
              getCaptcha();
              if (response.tentativas == true) {
                  $('.loginFormulario').hide();
              }
              $('.resultadoForm').empty();
              $.echo(response.erros, function (key, velue){
              $('.resultadoForm').append(value + '<br>');
          });
        }
    });
});

    $("#senha").keypress(function(e){
        kc=e.keyCode?e.keyCode:e.which;
        sk=e.shiftKey?e.shiftKey:((kc==16)?true:false);
        if(((kc>=65 && kc<=90) && !sk)||(kc>=97 && kc<=122)&&sk){
            $(".resultadoForm").html("Caps Lock Ligado");
        }else{
            $(".resultadoForm").empty();
        }
    });