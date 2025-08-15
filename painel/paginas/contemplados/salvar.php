<?php
$tabela = 'contemplados';
require_once("../../../conexao.php");

$nome = $_POST['nome'];
$cpf = $_POST['cpf'];
$telefone = $_POST['telefone'];
$grupo = $_POST['grupo'];
$evento = $_POST['evento'];
$prioridade = $_POST['prioridade'];
$servico = $_POST['servico'];

$empresa = $_POST['empresa'];
$dt_contemplado = $_POST['dt_contemplado'];
$contemplacao_numero = $_POST['contemplacao_numero'];
$dt_os = $_POST['dt_os'];
$dt_conclusao = $_POST['dt_conclusao'];
$evidencia = $_POST['evidencia'];


$endereco = $_POST['endereco'];
$numero = $_POST['numero'];
$bairro = $_POST['bairro'];
$cidade = $_POST['cidade'];
$cep = $_POST['cep'];
$complemento = $_POST['complemento'];
$estado = $_POST['estado'];
$id = $_POST['id'];



//validacao cpf
$query = $pdo->query("SELECT * from $tabela where cpf = '$cpf'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$id_reg = @$res[0]['id'];
if(@count($res) > 0 and $id != $id_reg){
	echo 'CPF já Cadastrado!';
	exit();
}

if($id == ""){
$query = $pdo->prepare("INSERT INTO $tabela SET nome = :nome, cpf = :cpf, telefone = :telefone, grupo = '$grupo', evento = :evento, prioridade = :prioridade, dt_contemplado = :dt_contemplado, servico = :servico, endereco = :endereco, numero = :numero, bairro = :bairro, cidade = :cidade, estado = :estado, cep = :cep, complemento = :complemento, contemplacao_numero = :contemplacao_numero, empresa = '$empresa', dt_os = :dt_os, dt_conclusao = :dt_conclusao, evidencia = :evidencia, dt_cad = curDate() ");
	
}else{
$query = $pdo->prepare("UPDATE $tabela SET nome = :nome, cpf = :cpf, telefone = :telefone, grupo = '$grupo', evento = :evento, prioridade = :prioridade, dt_contemplado = :dt_contemplado, servico = :servico, endereco = :endereco, numero = :numero, bairro = :bairro, cidade = :cidade, estado = :estado, cep = :cep, complemento = :complemento, contemplacao_numero = :contemplacao_numero, empresa = '$empresa', dt_os = :dt_os, dt_conclusao = :dt_conclusao, evidencia = :evidencia where id = '$id'");
}
$query->bindValue(":endereco", "$endereco");
$query->bindValue(":numero", "$numero");
$query->bindValue(":bairro", "$bairro");
$query->bindValue(":servico", "$servico");
$query->bindValue(":cidade", "$cidade");
$query->bindValue(":estado", "$estado");
$query->bindValue(":cep", "$cep");
$query->bindValue(":complemento", "$complemento");
$query->bindValue(":nome", "$nome");
$query->bindValue(":cpf", "$cpf");
$query->bindValue(":telefone", "$telefone");
$query->bindValue(":evento", "$evento");
$query->bindValue(":prioridade", "$prioridade");
$query->bindValue(":dt_contemplado", "$dt_contemplado");
$query->bindValue(":contemplacao_numero", "$contemplacao_numero");
$query->bindValue(":dt_os", "$dt_os");
$query->bindValue(":dt_conclusao", "$dt_conclusao");
$query->bindValue(":evidencia", "$evidencia");
$query->execute();

echo 'Salvo com Sucesso';


 ?>
