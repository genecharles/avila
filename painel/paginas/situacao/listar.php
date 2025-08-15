<?php 
$tabela = 'situacao';
require_once("../../../conexao.php");

$query = $pdo->query("SELECT * from $tabela order by id desc");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$linhas = @count($res);
if($linhas > 0){
echo <<<HTML
<small>
	<table class="table table-bordered text-nowrap border-bottom dt-responsive" id="tabela">
	<thead> 
	<tr> 
	<th align="center" width="5%" class="text-center">Selecionar</th>
	<th>Status</th>	
	<th class="">Nome</th>	
	<th class="esc">Data</th>	
	
	<th>Ações</th>
	</tr> 
	</thead> 
	<tbody>	
	<small>
HTML;


for($i=0; $i<$linhas; $i++){
	$id = $res[$i]['id'];
	$status = $res[$i]['status'];
	$nome = $res[$i]['nome'];
	$created_at = $res[$i]['created_at'];
	$update_at = $res[$i]['update_at'];
	

	$update_atF = implode('/', array_reverse(@explode('-', $update_at)));
	$created_atF = date('d/m/Y H:i:s', strtotime($created_at));
	

echo <<<HTML

<tr>
<td align="center">
<div class="custom-checkbox custom-control">
<input type="checkbox" class="custom-control-input" id="seletor-{$id}" onchange="selecionar('{$id}')">
<label for="seletor-{$id}" class="custom-control-label mt-1 text-dark"></label>
</div>
</td>
<td><i class=""></i> {$status}</td>
<td class=""> {$nome} </td>	
<td class="esc">{$update_atF}</td>

<td>
	<big><a class="icones_mobile" href="#" onclick="editar('{$id}','{$status}','{$nome}')" title="Editar Dados"><i class="fa fa-edit text-primary"></i></a></big>

	<div class="icones_mobile" class="dropdown" style="display: inline-block;">                      
        <a href="#" aria-expanded="false" aria-haspopup="true" data-bs-toggle="dropdown" class="dropdown"><i class="fa fa-trash text-danger"></i> </a>
        <div  class="dropdown-menu tx-13">
            <div class="dropdown-item-text botao_excluir">
               <p>Confirmar Exclusão? <a href="#" onclick="excluir('{$id}')"><span class="text-danger">Sim</span></a></p>
            </div>
        </div>
    </div>

<big><a class="icones_mobile" href="#" onclick="mostrar('{$status}','{$nome}','{$update_atF}','{$created_atF}')" title="Mostrar Dados"><i class="fa fa-info-circle text-primary"></i></a></big>



</td>
</tr>
HTML;

}


echo <<<HTML
</small>
</tbody>
<small><div align="center" id="mensagem-excluir"></div></small>

</table>
</small>


HTML;

}else{
	echo 'Nenhum Registro Encontrado!';
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
	function editar(id, status, nome){
		$('#mensagem').text('');
    	$('#titulo_inserir').text('Editar Registro');

    	$('#id').val(id);
    	$('#status').val(status);
    	$('#nome').val(nome);
    	
    	$('#modalForm').modal('show');
	}


	function mostrar(status, nome, update_atF, created_at){
	
    	$('#titulo_dados').text(status);
    	$('#nome_dados').text(nome);
    	$('#update_atF_dados').text(update_atF);
    	$('#created_at_dados').text(created_at);
    	

    	$('#modalDados').modal('show');
	}

	function limparCampos(){
		$('#id').val('');
    	$('#status').val('');
    	$('#nome').val('');

    	$('#ids').val('');
    	$('#btn-deletar').hide();	
    	$('#btn-baixar').hide();	
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
			$('#btn-baixar').hide();
		}else{
			$('#btn-deletar').show();
			$('#btn-baixar').show();
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


	function deletarSelBaixar(){
		var ids = $('#ids').val();
		var id = ids.split("-");

		for(i=0; i<id.length-1; i++){
			var novo_id = id[i];
				$.ajax({
					url: 'paginas/' + pag + "/baixar_multiplas.php",
					method: 'POST',
					data: {novo_id},
					dataType: "html",

					success:function(result){
						//alert(result)
						
					}
				});		
		}

		setTimeout(() => {
		  	buscar();
			limparCampos();
		}, 1000);

		
	}


	
</script>