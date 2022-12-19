<?php
namespace Classes;

use Models\ClassCadastro;
use ZxcvbnPhp\Zncvbn;
use Classes\ClassPassword;

class ClassValidate{

    private $erro=[];
    private $cadastro;
    private $password;
    private $login;
    private $tentativas;
    private $session;

    public function __construct()
    {
        $this->cadastro=new ClassCadastro();
        $this->password=new ClassPassword();
        $this->login=new ClassLogin();
        $this->session=new ClassSessions();
    }

#Validação final do login
    public function validateFinalLogin($email)
    {
        if(count($this->getErro()) >0){
            $this->login->insertAttempt();
        }else{
            $this->login->deleteAttempt();
            $this->session->setSessions($email);
        }
    }
    public function getErro()
    {
        return $this->erro;
    }

    public function setErro($erro)
    {
        array_push($this->erro,$erro);
    }

    public function validateFields($par)
    {
        $i=0;
        foreach ($par as $key => $value){
            if(empty($value)){
                $i++;
            }
        }
        if($i==0){
            return true;
        }else{
            $this->setErro("Preencha todos os dados!");
            return false;
        }
    }
    #Validação email
    public function validateEmail($par)
    {
        if(filter_var($par, FILTER_VALIDATE_EMAIL)){
            return true;
        }else{
            $this->setErro("Email inválido!");
            return false;
        }
    }

    public function validateIssetEmail($email,$action=null)
    {
        $b=$this->cadastro->getIssetEmail($email);

        if($action==null){
            if($b > 0){
                $this->setErro("Email já cadastrado!");
                return false;
            }else{
                return true;
            }
        }else{
            if($b > 0){
                return true;
            }else{
                $this->setErro("Email não cadastrado!");
                return false;
            }
        }
    }
#Validação data
    public function validateData($par)
    {
        $data=\DateTime::createFromFormat("d/m/Y",$par);
        if(($data) && ($data->format("d/m/Y") === $par)){
            return true;
        }else{
            $this->setErro("Data inválida!");
            return false;
        }
    }

#Validação cpf
    public function validateCpf($par)
    {
        $cpf = preg_replace('/[^0-9]/', '', (string) $par);
        if (strlen($cpf) != 11){
            $this->setErro("Cpf Inválido!");
            return false;
        }
        for ($i = 0, $j = 10, $soma = 0; $i < 9; $i++, $j--)
            $soma += $cpf($i) * $j;
        $resto = $soma % 11;
        if ($cpf(9) != ($resto < 2 ? 0 : 11 - $resto))
        {
            $this->setErro("Cpf Inválido!");
            return false;
        }
        for ($i = 0, $j = 11, $soma = 0; $i < 10; $i++, $j--)
            $soma += $cpf($i) * $j;
        $resto = $soma % 11;
        return $cpf(10) == ($resto < 2 ? 0 : 11 - $resto);
    }
            #Verificar se a senha é igual a confirmação de senha
    public function validateConfSenha($senha,$senhaConf)
    {
        if($senha === $senhaConf){
            return true;
        }else{
            $this->setErro("Senha diferente de confirmação de senha!");
        }
    }

        #Verificar a força da senha
    public function validateStrongSenha($senha,$par=null)
    {
        $zxcvbn=new Zxcvbn();
        $strength = $zxcvbn->passwordStrength($senha);

        if($par==null){
            if($strength['score'] >= 3){
                return true;
            }else{
                $this->setErro("Utilize uma senha mais forte!");
            }
        }else{

        }
    }

    #Verificação da senha digitada com o hash no banco de dados
    public function validateSenha($email,$senha)
    {

    }
    public function validateFinalCad($arrVar)
    {
        $this->cadastro->insertCad($arrVar);
    }
    #Verificar se o captcha está correto
    public function validateCaptcha($captcha,$score=0.5)
    {
        $return=file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".SECRETKEY."&response={$captcha}");
        $response=json_decode($return);
        if($response->success == true && $response->score >= $score){
            return true;
        }else{
            $this->setErro("Captcha Inválido! Atualize a página e tente novamente.");
        }
    }
    public function validateAttemptLogin()
    {
        if($this->login->countAttempt() >= 5){
            $this->setErro("Você realizou mais de 5 tentativas!");
            $this->tentativas=true;
            return false;
        }else{
            $this->tentativas=false;
            return true;
        }

    }


#Validação final do login
    public function validateFinalLogin($email)
    {
        if(count($this->getErro()) >0){
            $this->login->insertAttempt();

            $arrResponse=[
                "retorno"=>"erro",
                "erros"=>$this->getErro(),
                "tentativas"=>$this->tentativas
            ];
        }else{
            $this->login->deleteAttempt();
            $this->session->setSessions($email);

            $arrResponse=[
                "retorno"=>"success",
                "page"=>'areaRestrita',
                "tentativas"=>$this->tentativas
            ];
        }
        return json_encode($arrResponse);
    }
    public function validateUserActive($email)
    {
        $user=$this->login->getDataUser($email);
        if($user["data"]["status"] == "confirmation"){
            if(strtotime($user["data"]["dataCriacao"])<= strtotime(date("Y-m-d H:i:s"))-432000){
                $this->setErro("Ative seu cadastro pelo link do email");
                return false;
            }else{
                return true;
            }
        }else{
            return true;
        }
    }
}


