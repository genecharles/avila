<?php 
$tabela = 'clientes';
require_once("../../../conexao.php");

@session_start();
$id_usuario = @$_SESSION['id'];


$nome = $_POST['nome'];
$fantasia = $_POST['fantasia'];
$tipo_pessoa = $_POST['tipo_pessoa'];
$cnpj = $_POST['cnpj'];
$endereco = $_POST['endereco'];
$responsavel = $_POST['responsavel'];
$telefone = $_POST['telefone'];
$contrato = $_POST['contrato'];
$empenho = $_POST['empenho'];
$obs = $_POST['obs'];
$id = $_POST['id'];



//validacao cpf
if($cnpj != ""){
	$query = $pdo->query("SELECT * from $tabela where cnpj = '$cnpj'");
	$res = $query->fetchAll(PDO::FETCH_ASSOC);
	$id_reg = @$res[0]['id'];
	if(@count($res) > 0 and $id != $id_reg){
		echo 'CNPJ/CPF já Cadastrado!';
		exit();
	}
}


//validacao telefone
/**if($telefone != ""){
	$query = $pdo->query("SELECT * from $tabela where telefone = '$telefone'");
	$res = $query->fetchAll(PDO::FETCH_ASSOC);
	$id_reg = @$res[0]['id'];
	if(@count($res) > 0 and $id != $id_reg){
		echo 'Telefone já Cadastrado!';
		exit();
	}
}
**/



if($id == ""){
$query = $pdo->prepare("INSERT INTO $tabela SET nome = :nome, fantasia = :fantasia, telefone = :telefone, responsavel = :responsavel, endereco = :endereco, cnpj = :cnpj, tipo_pessoa = :tipo_pessoa, contrato = :contrato, empenho = :empenho, obs = :obs");
	
}else{
$query = $pdo->prepare("UPDATE $tabela SET nome = :nome, fantasia = :fantasia, telefone = :telefone, responsavel = :responsavel, endereco = :endereco, cnpj = :cnpj, tipo_pessoa = :tipo_pessoa, contrato = :contrato, empenho = :empenho, obs = :obs where id = '$id'");
}
$query->bindValue(":nome", "$nome");
$query->bindValue(":fantasia", "$fantasia");
$query->bindValue(":telefone", "$telefone");
$query->bindValue(":endereco", "$endereco");
$query->bindValue(":responsavel", "$responsavel");
$query->bindValue(":cnpj", "$cnpj");
$query->bindValue(":tipo_pessoa", "$tipo_pessoa");
$query->bindValue(":contrato", "$contrato");
$query->bindValue(":empenho", "$empenho");
$query->bindValue(":obs", "$obs");
$query->execute();

echo 'Salvo com Sucesso';


 ?>
