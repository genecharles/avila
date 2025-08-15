<?php 
include('../../conexao.php');
include('data_formatada.php');

$filtro_status = $_GET['filtro_status'];
$dataInicial = $_GET['dataInicial'];
$dataFinal = $_GET['dataFinal'];


$dataInicialF = implode('/', array_reverse(@explode('-', $dataInicial)));
$dataFinalF = implode('/', array_reverse(@explode('-', $dataFinal)));

if ($filtro_status == '') {
	$filtro_status = '%%';
}


?>
<!DOCTYPE html>
<html>
<head>

<style>

@import url('https://fonts.cdnfonts.com/css/tw-cen-mt-condensed');
@page { margin: 145px 20px 25px 20px; }
#header { position: fixed; left: 0px; top: -110px; bottom: 100px; right: 0px; height: 35px; text-align: center; padding-bottom: 100px; }
#content {margin-top: 0px;}
#footer { position: fixed; left: 0px; bottom: -60px; right: 0px; height: 80px; }
#footer .page:after {content: counter(page, my-sec-counter);}
body {font-family: 'Tw Cen MT', sans-serif;}

.marca{
	position:fixed;
	left:50;
	top:100;
	width:80%;
	opacity:8%;
}

</style>

</head>
<body>
<?php 
if($marca_dagua == 'Sim'){ ?>
<img class="marca" src="<?php echo $url_sistema ?>img/logo.jpg">	
<?php } ?>


<div id="header" >

	<div style="border-style: solid; font-size: 10px; height: 50px;">
		<table style="width: 100%; border: 0px solid #ccc;">
			<tr>
				<td style="border: 1px; solid #000; width: 7%; text-align: left;">
					<img style="margin-top: 7px; margin-left: 7px;" id="imag" src="<?php echo $url_sistema ?>img/logo.jpg" width="110px">
				</td>
				<td style="width: 30%; text-align: left; font-size: 13px;">
					
				</td>
				<td style="width: 1%; text-align: center; font-size: 13px;">
				
				</td>
				<td style="width: 47%; text-align: right; font-size: 9px;padding-right: 10px;">
						<b><big>RELATÓRIO QUANTIDADE DE VISITAS</big></b><br> POR CASA CONTEMPLADAS<br> <?php echo mb_strtoupper($data_hoje) ?>
				</td>
			</tr>		
		</table>
	</div>

<br>


		<table id="cabecalhotabela" style="border-bottom-style: solid; font-size: 9px; margin-bottom:10px; width: 100%; table-layout: fixed;">
			<thead>
				
				<tr id="cabeca" style="margin-left: 0px; background-color:#CCC">
					<td style="width:30%">PESSOAS CONTEMPLADAS</td>
					<td style="width:10%">TELEFONE</td>
					<td style="width:30%">EMPRESAS</td>
					<td style="width:10%">CADASTRADO</td>
					<td style="width:10%">CONTEMPLADO</td>
					<td style="width:10%">VISITAS</td>
					
					
				</tr>
			</thead>
		</table>
</div>

<div id="footer" class="row">
<hr style="margin-bottom: 0;">
	<table style="width:100%;">
		<tr style="width:100%;">
			<td style="width:60%; font-size: 10px; text-align: left;"><?php echo $nome_sistema ?> Telefone: <?php echo $telefone_sistema ?></td>
			<td style="width:40%; font-size: 10px; text-align: right;"><p class="page">Página  </p></td>
		</tr>
	</table>
</div>

<div id="content" style="margin-top: 0;">



		<table style="width: 100%; table-layout: fixed; font-size:9px; text-transform: uppercase;">
			<thead>
				<tbody>
					<?php



$query9 = $pdo->query("SELECT prc.id_contemplado, cntp.nome as nome_contemplado, cntp.telefone, cntp.dt_contemplado, cntp.dt_cad, cntp.empresa, cntp.evidencia as status, count(*) as qtd_visitas 
	FROM parecer prc 
	INNER JOIN contemplados cntp ON cntp.id = prc.id_contemplado
	WHERE cntp.dt_cad >= '$dataInicial' and cntp.dt_cad <= '$dataFinal'  and cntp.evidencia LIKE '$filtro_status'
	group by prc.id_contemplado ORDER BY cntp.nome");
$res9 = $query9->fetchAll(PDO::FETCH_ASSOC);
$linhas9 = @count($res9);
if($linhas9 > 0){
for($i9=0; $i9<$linhas9; $i9++){
	$id_contemplado = $res9[$i9]['id_contemplado'];
	$nome_pessoa = $res9[$i9]['nome_contemplado'];
	$tel_pessoa = $res9[$i9]['telefone'];
	$dt_contemplado = $res9[$i9]['dt_contemplado'];
	$dt_cad = $res9[$i9]['dt_cad'];
	$id_empresa = $res9[$i9]['empresa'];
	$status = $res9[$i9]['status'];
	$qtd_visitas = $res9[$i9]['qtd_visitas'];


$query = $pdo->query("SELECT * from clientes where id = '$id_empresa'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$linhas = @count($res);
if($linhas > 0){
for($i=0; $i<$linhas; $i++){
	$id = $res[$i]['id'];
	$nome_empresa = $res[$i]['nome'];
	$cnpj_empresa = $res[$i]['cnpj'];
	$fantasia_empresa = $res[$i]['fantasia'];
	
	$dt_contempladoF = implode('/', array_reverse(@explode('-', $dt_contemplado)));
	$dt_cadF = implode('/', array_reverse(@explode('-', $dt_cad)));
	

	} 

}else{
	//continue para ele pular para o proximo
	continue;
	//se usar break ele para toda instrução
}
  	 ?>

  	 
      <tr>
<td style="width:30%">
	<?php echo $nome_pessoa ?></td>
<td style="width:10%"><?php echo $tel_pessoa ?></td>
<td style="width:30%; color:red"><?php echo $nome_empresa ?></td>
<td style="width:10%; color:green"><?php echo $dt_cadF ?></td>
<td style="width:10%"><?php echo $dt_contempladoF ?></td>
<td style="width:10%"><?php echo $qtd_visitas ?></td>
    </tr>

<?php } }  ?>
				</tbody>
	
			</thead>
		</table>
	


</div>
<hr>
		
</body>

</html>


