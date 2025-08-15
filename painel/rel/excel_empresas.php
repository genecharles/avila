<?php
require_once("../../conexao.php");

$dadosXls = "";
$dadosXls .= " <table border='1' >";

$dadosXls .= " <tr>";
$dadosXls .= " <th>Nome</th>";
$dadosXls .= " <th>Nome Fantasia</th>";
$dadosXls .= " <th>CNPJ</th>";
$dadosXls .= " <th>Telefone</th>";
$dadosXls .= " <th>Endereco</th>";
$dadosXls .= " <th>Contrato</th>";
$dadosXls .= " </tr>";


$query = $pdo->query("SELECT * from clientes order by nome desc");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$linhas = @count($res);
if($linhas > 0){
for($i=0; $i<$linhas; $i++){
	$id = $res[$i]['id'];
	$nome = $res[$i]['nome'];
	$telefone = $res[$i]['telefone'];
	$cnpj = $res[$i]['cnpj'];	
	$endereco = $res[$i]['endereco'];
	$tipo_pessoa = $res[$i]['tipo_pessoa'];
	$fantasia = $res[$i]['fantasia'];
	
	$contrato = $res[$i]['contrato'];
	//$data_nasc = $res[$i]['data_nasc'];

	//$data_cadF = implode('/', array_reverse(@explode('-', $data_cad)));
	//$data_nascF = implode('/', array_reverse(@explode('-', $data_nasc)));

	$tel_whatsF = '55'.preg_replace('/[ ()-]+/' , '' , $telefone);

$dadosXls .= " <tr>";
$dadosXls .= " <td>".@utf8_decode($nome)."</td>";
$dadosXls .= " <td>".@utf8_decode($fantasia)."</td>";
$dadosXls .= " <td>".$cnpj."</td>";
$dadosXls .= " <td>".$telefone."</td>";
$dadosXls .= " <td>".@utf8_decode($endereco)."</td>";
$dadosXls .= " <td>".$contrato."</td>";
$dadosXls .= " </tr>";

}
}


$dadosXls .= " </table>";

$arquivo = "rel-empresas.xls";

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$arquivo.'"');
header('Cache-Control: max-age=0');

echo $dadosXls;
exit;

?>