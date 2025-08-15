<?php 
$tabela = 'contemplados';
require_once("../../../conexao.php");

$id = $_POST['id'];

$query1 = $pdo->query("SELECT * FROM parecer where id_contemplado = '$id'");
$res1 = $query1->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res1);
if($total_reg > 0){
	echo 'Exclusão não permitido! Parecer já relacionado ao registro!';
	exit();
}

$pdo->query("DELETE FROM $tabela WHERE id = '$id' ");
echo 'Excluído com Sucesso';
?>