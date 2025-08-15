<?php 
$tabela = 'situacao';
require_once("../../../conexao.php");

$id = $_POST['id'];

$query = $pdo->query("SELECT * FROM $tabela where id = '$id'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if($total_reg > 0){
	$status = $res[0]['status'];
}

$query = $pdo->query("SELECT * FROM contemplados where evidencia = '$status'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if($total_reg > 0){
	echo 'Exclusão não permitido. Existem Contemplados com esse Status!';
	exit();
}

$pdo->query("DELETE FROM $tabela WHERE id = '$id' ");
echo 'Excluído com Sucesso';
?>