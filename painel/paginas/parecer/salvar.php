<?php
@session_start();
$tabela = 'parecer';
require_once("../../../conexao.php");

$id_usuario = @$_SESSION['id'];

$id = $_POST['id'];
$id_contemplado = $_POST['id_contemplado'];
$acao = $_POST['acao'];
$evidencia = $_POST['evidencia'];
$situacao = $_POST['situacao'];
$obs = $_POST['obs'];
$id_empresa = 0;

//pegar empresa do contemplado
$query = $pdo->query("SELECT * from contemplados where id = '$id_contemplado'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$id_reg = @$res[0]['id'];
if(@count($res) > 0){
	$id_empresa = $res[0]['empresa'];
}


if($id == ""){
	$query = $pdo->prepare("INSERT INTO $tabela SET id_contemplado = '$id_contemplado', data_cad = curDate(), acao = :acao, evidencia = :evidencia, id_fiscal = '$id_usuario', situacao = :situacao, obs = :obs, id_empresa = '$id_empresa'");
		
	$pdo->query("UPDATE contemplados SET evidencia = '$evidencia' where id = '$id_contemplado'");
	
}else{
$query = $pdo->prepare("UPDATE $tabela SET id_contemplado = '$id_contemplado', acao = :acao, evidencia = :evidencia, situacao = :situacao, obs = :obs, id_empresa = '$id_empresa' where id = '$id'");
}
$query->bindValue(":acao", "$acao");
$query->bindValue(":evidencia", "$evidencia");
$query->bindValue(":situacao", "$situacao");
$query->bindValue(":obs", "$obs");
$query->execute();

echo 'Salvo com Sucesso';
 ?>