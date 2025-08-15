<?php 
$tabela = 'situacao';
require_once("../../../conexao.php");

@session_start();
$id_usuario = @$_SESSION['id'];


$status = $_POST['status'];
$nome = $_POST['nome'];
$id = $_POST['id'];



if($id == ""){
$query = $pdo->prepare("INSERT INTO $tabela SET status = :status, nome = :nome, update_at = curDate() ");
	
}else{
$query = $pdo->prepare("UPDATE $tabela SET status = :status, nome = :nome where id = '$id'");
}
$query->bindValue(":status", "$status");
$query->bindValue(":nome", "$nome");
$query->execute();

echo 'Salvo com Sucesso';
 ?>