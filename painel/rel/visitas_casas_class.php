<?php 
require_once("../../conexao.php");

$filtro_status = $_POST['filtro_status'];
$dataInicial = $_POST['dataInicial'];
$dataFinal = $_POST['dataFinal'];

//echo 'aq: '.$filtro_status;
//exit();

//$filtro_tipo = "receber";
//$filtro_empresa = urlencode($_POST['filtro_empresa']);
//$filtro_pendentes = $_POST['filtro_pendentes'];

$html = file_get_contents($url_sistema."painel/rel/visitas_casas.php?filtro_status=$filtro_status&dataInicial=$dataInicial&dataFinal=$dataFinal");

//CARREGAR DOMPDF
require_once '../dompdf/autoload.inc.php';
use Dompdf\Dompdf;
use Dompdf\Options;

header("Content-Transfer-Encoding: binary");
header("Content-Type: image/png");

//INICIALIZAR A CLASSE DO DOMPDF
$options = new Options();
$options->set('isRemoteEnabled', TRUE);
$pdf = new DOMPDF($options);


//Definir o tamanho do papel e orientação da página
$pdf->set_paper('A4', 'portrait');

//CARREGAR O CONTEÚDO HTML
$pdf->load_html($html);

//RENDERIZAR O PDF
$pdf->render();
//NOMEAR O PDF GERADO


$pdf->stream(
	'sintetico_rec.pdf',
	array("Attachment" => false)
);

 ?>