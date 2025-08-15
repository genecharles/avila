<?php 
$tabela = 'setor';
require_once("../../../conexao.php");

$telefone = $_POST['telefone'];
$responsavel = $_POST['responsavel'];
$municipio = $_POST['municipio'];
$endereco = $_POST['endereco'];
$nome = $_POST['nome'];
$id = $_POST['id'];

//validacao nome
$query = $pdo->query("SELECT * from $tabela where nome = '$nome'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$id_reg = @$res[0]['id'];
if(@count($res) > 0 and $id != $id_reg){
	echo 'Nome já Cadastrado!';
	exit();
}


if($id == ""){
$query = $pdo->prepare("INSERT INTO $tabela SET nome = :nome, endereco = :endereco, municipio = '$municipio', responsavel = :responsavel, telefone = :telefone ");
	
}else{
$query = $pdo->prepare("UPDATE $tabela SET nome = :nome, endereco = :endereco, municipio = '$municipio', responsavel = :responsavel, telefone = :telefone where id = '$id'");
}
$query->bindValue(":nome", "$nome");
$query->bindValue(":endereco", "$endereco");
$query->bindValue(":responsavel", "$responsavel");
$query->bindValue(":telefone", "$telefone");
$query->execute();

echo 'Salvo com Sucesso';
 ?>