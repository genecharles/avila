<?php 
include('../../conexao.php');
include('data_formatada.php');

$filtro_fiscal = $_GET['filtro_fiscal'];
$dataInicial = $_GET['dataInicial'];
$dataFinal = $_GET['dataFinal'];


$dataInicialF = implode('/', array_reverse(@explode('-', $dataInicial)));
$dataFinalF = implode('/', array_reverse(@explode('-', $dataFinal)));	


if ($filtro_fiscal == '') {
	$filtro_fiscaliz = '';
}else{
	$filtro_fiscaliz = "and prc.id_fiscal = '$filtro_fiscal'";
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
						<b><big>RELATÓRIO QUANTIDADE DE VISITAS</big></b><br> REALIZADA POR FISCAL <br> <?php echo mb_strtoupper($data_hoje) ?>
				</td>
			</tr>		
		</table>
	</div>

<br>


		<table id="cabecalhotabela" style="border-bottom-style: solid; font-size: 9px; margin-bottom:10px; width: 100%; table-layout: fixed;">
			<thead>
				
				<tr id="cabeca" style="margin-left: 0px; background-color:#CCC">
					<td style="width:10%">COD</td>
					<td style="width:30%">NOME FISCAL</td>
					<td style="width:15%">TELEFONE</td>
					<td style="width:10%">QTD VISITAS</td>
					
					
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



$query9 = $pdo->query("SELECT prc.id_fiscal, usr.nome as nome_fiscal, usr.telefone, count(*) as qtd_visitas 
	FROM parecer prc 
	INNER JOIN usuarios usr ON usr.id = prc.id_fiscal 
	WHERE prc.data_cad >= '$dataInicial' and prc.data_cad <= '$dataFinal' $filtro_fiscaliz
	group by prc.id_fiscal");
$res9 = $query9->fetchAll(PDO::FETCH_ASSOC);
$linhas9 = @count($res9);
if($linhas9 > 0){
for($i9=0; $i9<$linhas9; $i9++){
	$id_fiscal = $res9[$i9]['id_fiscal'];
	$nome_fiscal = $res9[$i9]['nome_fiscal'];
	$telefone = $res9[$i9]['telefone'];
	$qtd_visitas = $res9[$i9]['qtd_visitas'];

  	 ?>

  	 
      <tr>
<td style="width:10%">
	<?php echo $id_fiscal ?></td>
<td style="width:30%"><?php echo $nome_fiscal ?></td>
<td style="width:15%; color:red"><?php echo $telefone ?></td>
<td style="width:10%; color:green"><?php echo $qtd_visitas ?></td>

    </tr>

<?php } }  ?>
				</tbody>
	
			</thead>
		</table>
	


</div>
<hr>
		
</body>

</html>


