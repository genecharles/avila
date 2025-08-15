<?php
@session_start();
$usuario_lotado = @$_SESSION['lotado'];//nao esta trazendo
$id_usuario = @$_SESSION['id'];
$data_atual = date('Y-m-d');

$tabela = 'contemplados';
require_once("../../../conexao.php");

$dataInicial = @$_POST['p1'];
$dataFinal = @$_POST['p2'];
$status = '%'.@$_POST['p3'].'%';
$filtro = @$_POST['p4'];
$dataFiltro = @$_POST['p5'];

if($dataFiltro != ""){
	$dataInicial = '2000-01-01';
}

if($dataFinal == ""){
	$dataFinal = $data_atual;
}

if($dataInicial == ""){
	$dataInicial = $data_atual;
}

if($filtro == 'filtro'){
	if($status == ""){
		$query = $pdo->query("SELECT * from $tabela WHERE dt_cad = curDate() order by id desc ");
	}else{
		$query = $pdo->query("SELECT * from $tabela WHERE evidencia LIKE '$status' order by id desc ");		
	}
	
}else{

	$query = $pdo->query("SELECT * from $tabela WHERE dt_cad >= '$dataInicial' and dt_cad <= '$dataFinal' and evidencia LIKE '$status' order by id desc ");
}

if($status == "%Hoje%"){
	$query = $pdo->query("SELECT * from $tabela WHERE dt_cad = curDate() order by id desc ");
}



echo <<<HTML
<small>
HTML;
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$linhas = @count($res);
if($linhas > 0){
echo <<<HTML
	<table class="table table-bordered text-nowrap border-bottom dt-responsive" id="tabela">
	<thead> 
	<tr> 
	<th align="center" width="5%" class="text-center">Selecionar</th>
	<th>Nome</th>	
	<th class="esc">CPF</th>	
	<th class="esc">Telefone</th>			
	<th class="esc">Bairro</th>
	<th class="esc">Cidade</th>
	<th class="esc">Cadastro</th>
	<th class="esc">Status</th>	
	<th>Ações</th>
	</tr> 
	</thead> 
	<tbody>	
HTML;

for($i=0; $i<$linhas; $i++){//
	$id = $res[$i]['id'];
	$nome = $res[$i]['nome'];
	$cpf = $res[$i]['cpf'];
	$telefone = $res[$i]['telefone'];
	$grupo = $res[$i]['grupo'];	
	$cep = $res[$i]['cep'];
	$endereco = $res[$i]['endereco'];
	$numero = $res[$i]['numero'];
	$bairro = $res[$i]['bairro'];
	$complemento = $res[$i]['complemento'];
	$cidade = $res[$i]['cidade'];
	$estado = $res[$i]['estado'];
	$evento = $res[$i]['evento'];	
	$prioridade = $res[$i]['prioridade'];
	$dt_contemplado = $res[$i]['dt_contemplado'];
	$servico = $res[$i]['servico'];
	$contemplacao_numero = $res[$i]['contemplacao_numero'];
	$empresa = $res[$i]['empresa'];
	$dt_os = $res[$i]['dt_os'];
	$dt_conclusao = $res[$i]['dt_conclusao'];
	$evidencia = $res[$i]['evidencia'];
	$dt_cad = $res[$i]['dt_cad'];
	
	
	$cpfF = '';

	$qtd = strlen($cpf);
		if($qtd >= 11) {
			if($qtd === 11 ) {
				$docFormatado = substr($cpf, 0, 3) . '.' .
	                            substr($cpf, 3, 3) . '.' .
	                            substr($cpf, 6, 3) . '-' .
	                            substr($cpf, 9, 2);
			}
			@$cpfF = $docFormatado;
		}

$query3 = $pdo->query("SELECT * FROM clientes where id = '$empresa'");
	$res3 = $query3->fetchAll(PDO::FETCH_ASSOC);
	if(@count($res3) > 0){
		$nome_empresa = $res3[0]['nome'];
	}else{
		$nome_empresa = 'Não Informado';
	}
	

	$query4 = $pdo->query("SELECT * FROM usuarios where id = '$usuario'");
	$res4 = $query4->fetchAll(PDO::FETCH_ASSOC);
	if(@count($res4) > 0){
		$usr_cad = $res4[0]['nome'];
	}else{
		$usr_cad = 'Não Informado';
	}

	
	
	$enderecoF2 = rawurlencode($endereco);

	$dt_osF = implode('/', array_reverse(@explode('-', $dt_os)));
	$dt_conclusaoF = implode('/', array_reverse(@explode('-', $dt_conclusao)));
	$dt_cadF = implode('/', array_reverse(@explode('-', $dt_cad)));
	$dt_contempladoF = implode('/', array_reverse(@explode('-', $dt_contemplado)));
	

echo <<<HTML
<tr class="">
<td align="center">
<div class="custom-checkbox custom-control">
<input type="checkbox" class="custom-control-input" id="seletor-{$id}" onchange="selecionar('{$id}')">
<label for="seletor-{$id}" class="custom-control-label mt-1 text-dark"></label>
</div>
</td>
<td>{$nome}</td>
<td class="esc">{$cpf}</td>
<td class="esc">{$telefone}</td>
<td class="esc">{$bairro}</td>
<td class="esc">{$cidade}</td>
<td class="esc">{$dt_cadF}</td>
<td class="esc">{$evidencia}</td>
<td>
	<a class="btn btn-info btn-sm" href="#" onclick="editar('{$id}','{$nome}','{$cpf}','{$telefone}','{$grupo}', '{$enderecoF2}', '{$numero}', '{$bairro}', '{$cidade}', '{$estado}', '{$cep}', '{$complemento}', '{$evento}', '{$prioridade}', '{$dt_contemplado}', '{$servico}', '{$contemplacao_numero}', '{$empresa}', '{$dt_os}', '{$dt_conclusao}', '{$evidencia}')" title="Editar Dados"><i class="fa fa-edit "></i></a>

	<div class="dropdown" style="display: inline-block;">                      
        <a class="btn btn-danger btn-sm" href="#" aria-expanded="false" aria-haspopup="true" data-bs-toggle="dropdown" class="dropdown"><i class="fa fa-trash "></i> </a>
        <div  class="dropdown-menu tx-13">
            <div class="dropdown-item-text botao_excluir">
                <p>Confirmar Exclusão? <a href="#" onclick="excluir('{$id}')"><span class="text-danger">Sim</span></a></p>
            </div>
        </div>
    </div>

<a class="btn btn-primary btn-sm" href="#" onclick="mostrar('{$nome}','{$cpf}','{$telefone}','{$grupo}', '{$endereco}', '{$numero}', '{$bairro}', '{$cidade}', '{$estado}', '{$cep}', '{$complemento}', '{$evento}','{$prioridade}','{$dt_contempladoF}','{$servico}', '{$contemplacao_numero}','{$nome_empresa}', '{$dt_osF}', '{$dt_conclusaoF}', '{$evidencia}')" title="Mostrar Dados"><i class="fa fa-info-circle "></i></a>



</td>
</tr>
HTML;
}


echo <<<HTML
		</tbody> 
		<small><div align="center" id="mensagem-excluir"></div></small>
	</table>
	<br>
	<!-- info rodapé -->
	
</small>
HTML;
}else{
	echo 'Clique no Botão TODOS!';
}


echo <<<HTML
</tbody>
<small><div align="center" id="mensagem-excluir"></div></small>
</table>
HTML;
?>



<script type="text/javascript">
	$(document).ready( function () {		
    $('#tabela').DataTable({
    	"language" : {
            //"url" : '//cdn.datatables.net/plug-ins/1.13.2/i18n/pt-BR.json'
        },
        "ordering": false,
		"stateSave": true
    });
} );
</script>

<script type="text/javascript">
	function editar(id, nome, cpf, telefone, grupo, endereco, numero, bairro, cidade,estado, cep, complemento, evento, prioridade, dt_contemplado, servico, contemplacao_numero, empresa, dt_os, dt_conclusao, evidencia){
		$('#mensagem').text('');
    	$('#titulo_inserir').text('Editar Registro');

    	$('#id').val(id);
    	$('#nome').val(nome);
    	$('#cpf').val(cpf);
    	$('#telefone').val(telefone);
    	$('#grupo').val(grupo).change();;
    	$('#endereco').val(decodeURIComponent(endereco));
    	$('#numero').val(numero);
		$('#bairro').val(bairro);
		$('#cidade').val(cidade);
		$('#estado').val(estado).change();
		$('#cep').val(cep);
		$('#complemento').val(complemento);


    	$('#evento').val(evento);
    	$('#prioridade').val(prioridade).change();;
    	$('#dt_contemplado').val(dt_contemplado);
    	$('#servico').val(servico);
    	
    	$('#contemplacao_numero').val(contemplacao_numero);
    	$('#empresa').val(empresa).change();
    	$('#dt_os').val(dt_os);
    	$('#dt_conclusao').val(dt_conclusao);
    	$('#evidencia').val(evidencia);
    	
    	$('#modalForm').modal('show');
	}


	function mostrar(nome, cpf, telefone, grupo, endereco, numero, bairro, cidade, estado, cep, complemento, evento, prioridade, dt_contemplado, servico, contemplacao_numero, empresa, dt_os, dt_conclusao, evidencia){
		    	
    	$('#titulo_dados').text(nome);
    	$('#cpf_dados').text(cpf);
    	$('#telefone_dados').text(telefone);
    	$('#grupo_dados').text(grupo);
    	$('#endereco_dados').text(endereco);
    	$('#numero_dados').text(numero);
    	$('#bairro_dados').text(bairro);
    	$('#cidade_dados').text(cidade);

    	$('#estado_dados').text(estado);
    	$('#cep_dados').text(cep);
    	$('#complemento_dados').text(complemento);
    	$('#evento_dados').text(evento);
    	$('#prioridade_dados').text(prioridade);
    	$('#dt_contemplado_dados').text(dt_contemplado);
    	$('#servico_dados').text(servico);
    	$('#contemplacao_numero_dados').text(contemplacao_numero);
    	$('#empresa_dados').text(empresa);
    	$('#dt_os_dados').text(dt_os);
    	$('#dt_conclusao_dados').text(dt_conclusao);
    	$('#evidencia_dados').text(evidencia);
    	
    	$('#modalDados').modal('show');
	}

	function limparCampos(){
		$('#id').val('');
    	$('#nome').val('');
    	$('#cpf').val('');
    	$('#telefone').val('');
    	$('#grupo').val('').change();;
    	$('#endereco').val('');
    	$('#numero').val('');
		$('#bairro').val('');
		$('#cidade').val('');
		$('#estado').val('').change();
		$('#cep').val('');
		$('#complemento').val('');


    	$('#evento').val('');
    	$('#prioridade').val('').change();;
    	$('#dt_contemplado').val('');
    	$('#servico').val('');
    	
    	$('#contemplacao_numero').val('');
    	$('#empresa').val('').change();
    	$('#dt_os').val('');
    	$('#dt_conclusao').val('');
    	$('#evidencia').val('');

    	$('#ids').val('');
    	$('#btn-deletar').hide();	
	}

	function selecionar(id){

		var ids = $('#ids').val();

		if($('#seletor-'+id).is(":checked") == true){
			var novo_id = ids + id + '-';
			$('#ids').val(novo_id);
		}else{
			var retirar = ids.replace(id + '-', '');
			$('#ids').val(retirar);
		}

		var ids_final = $('#ids').val();
		if(ids_final == ""){
			$('#btn-deletar').hide();
		}else{
			$('#btn-deletar').show();
		}
	}

	function deletarSel(){
		var ids = $('#ids').val();
		var id = ids.split("-");
		
		for(i=0; i<id.length-1; i++){
			excluirMultiplos(id[i]);			
		}

		setTimeout(() => {
		  	listar();	
		}, 1000);

		limparCampos();
	}


	function mostrarAcompanhamento(nome, id) {

		$('#titulo_contas').text(nome);
		$('#id_contas').val(id);

		$('#modalAcompanhamento').modal('show');
		listarAcompanhamento(id);

	}


	function listarAcompanhamento(id) {

		$.ajax({
			url: 'paginas/' + pag + "/listar_acompanhamento.php",
			method: 'POST',
			data: {
				id
			},
			dataType: "html",

			success: function(result) {
				$("#listar_acompanhamento").html(result);
			}
		});
	}


	function arquivo(id, nome){
	    $('#id-arquivo').val(id);    
	    $('#nome-arquivo').text(nome);
	    $('#modalArquivos').modal('show');
	    $('#mensagem-arquivo').text(''); 
	    $('#arquivo_conta').val('');
	    listarArquivos();   
	}


	function transferenciaSetor(id, nome){		
		
	    $('#id-vistoria').val(id);        
	    $('#nome-vistoria').text(nome);
	    
	    $('#modalRelatorioTransferencia').modal('show');
	    $('#mensagem-vistoria').text(''); 
	    
	}

</script>