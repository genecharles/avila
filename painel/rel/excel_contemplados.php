<?php
require_once("../../conexao.php");

$dadosXls = "";
$dadosXls .= " <table border='1' >";

$dadosXls .= " <tr>";
$dadosXls .= " <th>Nome</th>";
$dadosXls .= " <th>CPF</th>";
$dadosXls .= " <th>Telefone</th>";
$dadosXls .= " <th>Bairro</th>";
$dadosXls .= " <th>Prioridade</th>";
$dadosXls .= " <th>Dt Contemplado</th>";
$dadosXls .= " <th>Empresa</th>";
$dadosXls .= " <th>CNPJ</th>";
$dadosXls .= " <th>Status</th>";
$dadosXls .= " </tr>";


$query = $pdo->query("SELECT * from contemplados order by nome desc");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$linhas = @count($res);
if($linhas > 0){
for($i=0; $i<$linhas; $i++){
	$id = $res[$i]['id'];
	$nome = $res[$i]['nome'];
	$cpf = $res[$i]['cpf'];	
	$telefone = $res[$i]['telefone'];	
	$bairro = $res[$i]['bairro'];
	$prioridade = $res[$i]['prioridade'];	
	$dt_contemplado = $res[$i]['dt_contemplado'];
	$evidencia = $res[$i]['evidencia'];
	$empresa = $res[$i]['empresa'];
	$dt_contempladoF = implode('/', array_reverse(@explode('-', $dt_contemplado)));

	$nome_empresa = 'Não escalado';
	$cnpj_empresa = '';

	$query2 = $pdo->query("SELECT * FROM clientes where id = '$empresa'");
	$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
	$total_reg2 = @count($res2);
	if ($total_reg2 > 0) {
	    $nome_empresa = $res2[0]['nome'];
	    $cnpj_empresa = $res2[0]['cnpj'];
	}
	
$dadosXls .= " <tr>";
$dadosXls .= " <td>".@utf8_decode($nome)."</td>";
$dadosXls .= " <td>".$cpf."</td>";
$dadosXls .= " <td>".$telefone."</td>";
$dadosXls .= " <td>".@utf8_decode($bairro)."</td>";


$dadosXls .= " <td>".@utf8_decode($prioridade)."</td>";
$dadosXls .= " <td>".$dt_contempladoF."</td>";
$dadosXls .= " <td>".@utf8_decode($nome_empresa)."</td>";
$dadosXls .= " <td>".$cnpj_empresa."</td>";
$dadosXls .= " <td>".@utf8_decode($evidencia)."</td>";
$dadosXls .= " </tr>";

}
}


$dadosXls .= " </table>";

$arquivo = "rel-contemplados.xls";

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$arquivo.'"');
header('Cache-Control: max-age=0');

echo $dadosXls;
exit;

?>