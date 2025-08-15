<?php 
$tabela = 'parecer';
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
	<th>Contemplado</th>
	<th>Empresa</th>
	<th>Status</th>
	<th>Fiscal</th>
	<th>Ações</th>
	</tr> 
	</thead> 
	<tbody>	
HTML;


for($i=0; $i<$linhas; $i++){
	$id = $res[$i]['id'];
	$id_contemplado = $res[$i]['id_contemplado'];
	$data_cad = $res[$i]['data_cad'];
	$acao = $res[$i]['acao'];
	$evidencia = $res[$i]['evidencia'];
	$id_fiscal = $res[$i]['id_fiscal'];
	$situacao = $res[$i]['situacao'];
	$obs = $res[$i]['obs'];
	$id_empresa = $res[$i]['id_empresa'];

	$data_cadF = implode('/', array_reverse(@explode('-', $data_cad)));

	$query1 = $pdo->query("SELECT SUBSTRING_INDEX(nome, ' ', 1) as nome FROM usuarios where id = '$id_fiscal'");
	$res1 = $query1->fetchAll(PDO::FETCH_ASSOC);
	if(@count($res1) > 0){
		$nome_fiscal = $res1[0]['nome'];
	}else{
		$nome_fiscal = 'Sem Registro';
	}

	$query2 = $pdo->query("SELECT * FROM contemplados where id = '$id_contemplado'");
	$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
	if(@count($res2) > 0){
		$nome_contemplado = $res2[0]['nome'];
	}else{
		$nome_contemplado = 'Sem Registro';
	}

	$query3 = $pdo->query("SELECT * FROM clientes where id = '$id_empresa'");
	$res3 = $query3->fetchAll(PDO::FETCH_ASSOC);
	if(@count($res3) > 0){
		$nome_empresa = $res3[0]['nome'];
	}else{
		$nome_empresa = 'Sem Registro';
	}
	
		
echo <<<HTML
<tr>
<td align="center">
<div class="custom-checkbox custom-control">
<input type="checkbox" class="custom-control-input" id="seletor-{$id}" onchange="selecionar('{$id}')">
<label for="seletor-{$id}" class="custom-control-label mt-1 text-dark"></label>
</div>
</td>
<td>{$nome_contemplado}</td>
<td>{$nome_empresa}</td>
<td>{$evidencia}</td>
<td>{$nome_fiscal}</td>
<td>

	<big><a class="btn btn-info btn-sm" href="#" onclick="editar('{$id}','{$id_contemplado}','{$acao}','{$evidencia}','{$situacao}','{$obs}','{$id_empresa}')" title="Editar Dados"><i class="fa fa-edit "></i></a></big>

	<div class="dropdown" style="display: inline-block;">                      
                        <a class="btn btn-danger btn-sm" href="#" aria-expanded="false" aria-haspopup="true" data-bs-toggle="dropdown" class="dropdown"><i class="fa fa-trash"></i> </a>
                        <div  class="dropdown-menu tx-13">
                       <div class="dropdown-item-text botao_excluir">
                        <p>Confirmar Exclusão? <a href="#" onclick="excluir('{$id}')"><span class="text-danger">Sim</span></a></p>
                        </div>
                        </div>
                        </div>
</td>
</tr>
HTML;

}


echo <<<HTML
</tbody>
<small><div align="center" id="mensagem-excluir"></div></small>
</table>
HTML;

}else{
	echo '<small>Nenhum Registro Encontrado!</small>';
}

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
	function editar(id, id_contemplado, acao, evidencia, situacao, obs, id_empresa){
		$('#mensagem').text('');
    	$('#titulo_inserir').text('Editar Registro');

    	$('#id').val(id);
    	$('#id_contemplado').val(id_contemplado).change();
    	$('#acao').val(acao);
    	$('#evidencia').val(evidencia);
    	$('#situacao').val(situacao);
    	$('#obs').val(obs);
    	$('#id_empresa').val(id_empresa).change();
    
    	$('#modalForm').modal('show');
	}



	function limparCampos(){
		$('#id').val('');
    	$('#id_contemplado').val('').change();
    	$('#acao').val('');
    	$('#evidencia').val('');
    	$('#situacao').val('');
    	$('#obs').val('');
    	$('#id_empresa').val('').change();

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