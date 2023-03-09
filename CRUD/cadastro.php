<?php
$obj_mysqli = new mysqli('127.0.0.1', 'root', '', 'tutocrudphp');      //conexão com o banco de dados  //id,nome,senha,nome da base

if ($obj_mysqli->connect_errno)         //se encontrar um erro, echo vai avisar
{
        echo " Ocorreu um erro na conexão com o banco de dados.";
        exit;
}

mysqli_set_charset($obj_mysqli, 'utf8');        //chamar a conexão com o utf-8

//incluímos um código aqui...
    $id = -1;                   
    $nome = "";
    $email = "";
    $cpf = "";
    $data_nasc = "";
    $n = 5;
    function getName($n, $nome){
        $characters = '0123456789'; 
        $randomString = '';

        for($i = 0 ; $i < $n; $i++){
            $index = rand(0,strlen($characters) - 1);
            $randomString .= $characters[$index];

        }

        return $nome." - ".$randomString;
    }

//Validando a existência dos dados
if (isset($_POST["Nome"]) && isset($_POST["Email"]) && isset($_POST["CPF"]) && isset($_POST["data_nasc"]))      //criar a existência de dados
{
    if (empty($_POST["Nome"]))                                  //pedir obrigação nos campos escolhidos
        $erro = "Campo nome obrigatório";                   
    else
    if (empty($_POST["Email"]))
        $erro = "Campo e-mail obrigatório";
    else 
    if (empty($_POST["CPF"]))
        $erro = "Campo cidade obrigatório";
    else
    if (empty($_POST["data_nasc"]))
        $erro = "Campo uf obrigatório";
    else
    {
        
            $id = $_POST["Id"];
            $nome = $_POST["Nome"];
            $email = $_POST["Email"];                  
            $cpf = $_POST["CPF"];
            $data_nasc = $_POST["data_nasc"];
           

         
                    if($id == -1)
                    {
            $stmt = $obj_mysqli->prepare("INSERT INTO `cliente`(`Nome`,`Email`,`CPF`,`data_nasc`) VALUES (?,?,?,?)");           //variável de instrução 
            $stmt->bind_param('ssiss', $nome, $email, $cpf, $data_nasc);    //parâmetro para correlacionar com as variáveis de cima. "ssss"= string,string,string,string.

            if(!$stmt->execute())     //Se a variável de instrução não executar, recebe um erro.  (! = não)
            {
                $erro = $stmt->error;
            }
            else                      //Senão, sucesso!
            {
                $sucesso = "Dados cadastrados com sucesso!";
                header("Location:cadastro.php");            //atualizar a página sozinho
                exit;
               }
            }
        }}





$nome = isset($_GET["Nome"]) ? $_GET["Nome"] : null;
$email = isset($_GET["Email"]) ? $_GET["Email"] : null;
$cpf = isset($_GET["CPF"]) ? $_GET["CPF"] : null;
$data_nasc = isset($_GET["data_nasc"]) ? $_GET["data_nasc"] : null;

?>





<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD em PHP</title>

   <style>

body {
        background-image: url(img/ela.jpg);
        background-attachment: fixed;
        background-size: cover;
        backdrop-filter: blur(1px);
    }

    .caixa{
        width: 450px;
        height: 650px;
        margin-left: 1150px;
        margin-top: 200px;
        border-radius: 10px;
        padding-top: 20px;
        padding-left: 10px;
        box-shadow: 2px 2px 10px black;
        text-align: center;
        color: white;
        padding-top: 50px


    }


    #textonome{
        border-radius: 15px;
        border-color: lightblue;
        width: 200px;
        height: 30px;
        margin-top: 10px;
    }

    #nome{
        margin-left: -130px;
        font-size: 20px;
        color: white;
    }

    #textoemail{
        border-radius: 15px;
        border-color: lightblue;
        width: 200px;
        height: 30px;
        margin-top: 10px;
    }

    #email{
        margin-left: -130px;
        font-size: 20px;
        color: white;
    }

    #textocpf{
        border-radius: 15px;
        border-color: lightblue;
        width: 200px;
        height: 30px;
        margin-top: 10px;
    }

    #CPF{
        margin-left: -130px;
        font-size: 20px;
        color: white;
    }

    #textonasc{
        border-radius: 15px;
        border-color: lightblue;
        width: 200px;
        height: 30px;
        margin-top: 10px;
    }

    #nasc{
        margin-left: -20px;
        font-size: 20px;
        color: white;
    }

    #textousername{
        border-radius: 15px;
        border-color: lightblue;
        width: 200px;
        height: 30px;
        margin-top: 10px;
    }

    #botao{
        border-radius: 20px;
        width: 100px;
        height: 30px;
        background-color: lightblue;
        border-color: lightblue;
        color: black;
        font-family: Arial, Helvetica, sans-serif;

    }
   

   </style>

</head>

<body>
  

<div class="caixa">

<?php
    if(isset($erro))
                echo '<div style="color:#F00">'.$erro.'</div><br/><br/>';
    else
    if(isset($sucesso))
                echo '<div style="color:#00f">'.$sucesso.'</div><br/><br/>';
    ?>

    <form action="<?= $_SERVER["PHP_SELF"]?>" method="POST">
        <label id="nome">Nome:<br /></label>
        <input type="text" name="Nome" placeholder="Qual é o seu Nome ?" id="textonome"><br /><br />
        <label id="email">E-mail:<br /></label>
        <input type="email" name="Email" placeholder="Qual seu e-mail ?" id="textoemail"><br /><br />
        <label id="CPF">CPF:<br /></label>
        <input type="text" name="CPF" placeholder="CPF" id="textocpf"><br /><br />
        <label id="nasc">Data de Nascimento:<br /></label>
        <input type="date" name="data_nasc" id="textonasc"><br /><br />
        <input type="hidden" name="Id">
      

        <input id="botao" type="submit" name="cadastrar" value="Cadastrar">
    </form>



</div>
</table>
</body>
</html>