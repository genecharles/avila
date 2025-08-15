<?php 
$tabela = 'clientes';
require_once("../../../conexao.php");

$query = $pdo->query("SELECT * from $tabela order by id desc");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$linhas = @count($res);
if($linhas > 0){
echo <<<HTML

	<table class="table table-bordered text-nowrap border-bottom dt-responsive" id="tabela">
	<thead> 
	<tr> 
	<th align="center" width="5%" class="text-center">Selecionar</th>
	<th>Nome</th>	
	<th >Telefone</th>	
	<th >Contrato</th>			
	<th >CNPJ</th>
	<th >Tipo Pessoa</th>
	<th >Data Cadastro</th>	
	<th>Ações</th>
	</tr> 
	</thead> 
	<tbody>	
HTML;

for($i=0; $i<$linhas; $i++){
	$id = $res[$i]['id'];
		$nome = $res[$i]['nome'];
		$fantasia = $res[$i]['fantasia'];
		$tipo_pessoa = $res[$i]['tipo_pessoa'];
		$cnpj = $res[$i]['cnpj'];
		$endereco = $res[$i]['endereco'];
		$responsavel = $res[$i]['responsavel'];
		$telefone = $res[$i]['telefone'];
		$contrato = $res[$i]['contrato'];
		$empenho = $res[$i]['empenho'];		
		$obs = $res[$i]['obs'];
		
		
	$ocultar_whats= 'ocultar';
	
	

	if ($telefone != '') {
		$ocultar_whats= '';
		$tel_whatsF = '55'.preg_replace('/[ ()-]+/' , '' , $telefone);
	}

	

echo <<<HTML
<tr>
<td align="center">
<div class="custom-checkbox custom-control">
<input type="checkbox" class="custom-control-input" id="seletor-{$id}" onchange="selecionar('{$id}')">
<label for="seletor-{$id}" class="custom-control-label mt-1 text-dark"></label>
</div>
</td>
<td>{$nome}</td>
<td>{$telefone}</td>
<td>{$contrato}</td>
<td>{$cnpj}</td>
<td><span class="badge bg-primary me-1 my-2 p-1"><big>{$tipo_pessoa}</big></span></td>
<td>{$empenho}</td>
<td>
	<a class="icones_mobile" href="#" onclick="editar('{$id}','{$nome}','{$fantasia}','{$tipo_pessoa}','{$cnpj}','{$endereco}','{$responsavel}','{$telefone}','{$contrato}','{$empenho}','{$obs}')" title="Editar Dados"><i class="fa fa-edit text-primary"></i></a>

	<div class="dropdown" style="display: inline-block;">                      
        <a class="icones_mobile" href="#" aria-expanded="false" aria-haspopup="true" data-bs-toggle="dropdown" class="dropdown"><i class="fa fa-trash text-danger"></i> </a>
        <div  class="dropdown-menu tx-13">
             <div class="dropdown-item-text botao_excluir">
                <p>Confirmar Exclusão? <a href="#" onclick="excluir('{$id}')"><span class="text-danger">Sim</span></a></p>
            </div>
        </div>
    </div>

<a class="icones_mobile" href="#" onclick="mostrar('{$id}','{$nome}','{$fantasia}','{$tipo_pessoa}','{$cnpj}','{$endereco}','{$responsavel}','{$telefone}','{$contrato}','{$empenho}','{$obs}')" title="Mostrar Dados"><i class="fa fa-info-circle text-primary"></i></a>



<a class="icones_mobile $ocultar_whats" class="" href="http://api.whatsapp.com/send?1=pt_BR&phone={$tel_whatsF}" title="Whatsapp" target="_blank"><i class="fa fa-whatsapp " style="color:green"></i></a>


</td>
</tr>
HTML;

}

}else{
	echo 'Não possui nenhum cadastro!';
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
	function editar(id, nome, fantasia, tipo_pessoa, cnpj, endereco, responsavel, telefone, contrato, empenho, obs){
		$('#mensagem').text('');
    	$('#titulo_inserir').text('Editar Registro');

    	$('#id').val(id);
    	$('#nome').val(nome);
    	$('#fantasia').val(fantasia);
    	$('#tipo_pessoa').val(tipo_pessoa).change();
    	$('#cnpj').val(cnpj);
    	$('#endereco').val(endereco); 
    	
    	$('#responsavel').val(responsavel);    	
    	$('#telefone').val(telefone);
    	$('#contrato').val(contrato);
    	$('#empenho').val(empenho);
    	$('#obs').val(obs);

    	$('#modalForm').modal('show');
	}


	function mostrar(id, nome, fantasia, tipo_pessoa, cnpj, endereco, responsavel, telefone, contrato, empenho, obs){
		    	
    	$('#titulo_dados').text(nome);
    	$('#fantasia_dados').text(fantasia);
		$('#pessoa_dados').text(tipo_pessoa);
		$('#cnpj_dados').text(cnpj);
		$('#endereco_dados').text(endereco);
		
		$('#responsavel_dados').text(responsavel);
		$('#telefone_dados').text(telefone);
		$('#contrato_dados').text(contrato);
		$('#empenho_dados').text(empenho);
		$('#obs_dados').text(obs);
    	
    	$('#modalDados').modal('show');
	}

	function limparCampos(){
		$('#id').val('');
    	$('#nome').val('');
    	$('#email').val('');
    	$('#telefone').val('');
    	$('#endereco').val('');
    	$('#cpf').val('');
    	$('#tipo_pessoa').val('Física').change();
    	$('#data_nasc').val('');

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
</script>