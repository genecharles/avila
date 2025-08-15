<?php 
$pag = 'situacao';
?>

<div class="justify-content-between">
 	<div class="left-content mt-2 mb-3">
 <a class="btn ripple btn-primary text-white" onclick="inserir()" type="button"><i class="fe fe-plus me-2"></i> Adicionar Status</a>



<div class="dropdown" style="display: inline-block;">                      
    <a href="#" aria-expanded="false" aria-haspopup="true" data-bs-toggle="dropdown" class="btn btn-danger dropdown" id="btn-deletar" style="display:none"><i class="fe fe-trash-2"></i> Deletar</a>
    <div  class="dropdown-menu tx-13">
        <div style="width: 240px; padding:15px 5px 0 10px;" class="dropdown-item-text">
            <p>Excluir Selecionados? <a href="#" onclick="deletarSel()"><span class="text-danger">Sim</span></a></p>
        </div>
    </div>
</div>

</div>

</div>


<div class="row row-sm">
	<div class="col-lg-12">
		<div class="card custom-card">
			<div class="card-body" id="listar">

			</div>
		</div>
	</div>
</div>

<input type="hidden" id="ids">

<div class="modal fade" id="modalForm" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header bg-primary text-white">
				<h4 class="modal-title" id="exampleModalLabel"><span id="titulo_inserir"></span></h4>
				 <button id="btn-fechar" aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button"><span class="text-white" aria-hidden="true">&times;</span></button>
			</div>
			<form id="form">
			<div class="modal-body">
				
				
					<div class="row">						

						<div class="col-md-8 mb-2">							
								<label>Status</label>
								<input type="text" class="form-control" id="status" name="status" placeholder="Informe Status" required>							
						</div>

						

						
					</div>

					<div class="row">						


						<div class="col-md-12 mb-2">							
								<label>Descrição</label>
								<input type="text" class="form-control" id="nome" name="nome" placeholder="Informe a Descrição">							
						</div>

						
					</div>

					

					<div class="col-md-4" style="margin-top: 22px">							
						<button id="btn_salvar" type="submit" class="btn btn-primary">Salvar</button>					
					</div>

			
					<input type="hidden" class="form-control" id="id" name="id">					

				<br>
				<small><div id="mensagem" align="center"></div></small>
			</div>
			
			</form>
		</div>
	</div>
</div>

$('#').text(status);
    	$('#').text(nome);
    	$('#').text(update_atF);
    	$('#')
<!-- Modal Dados -->
<div class="modal fade" id="modalDados" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header bg-primary text-white">
					<h4 class="modal-title" id="exampleModalLabel"><span id="titulo_dados"></span></h4>
					<button id="btn-fechar-dados" aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button"><span class="text-white" aria-hidden="true">&times;</span></button>
				</div>

				<div class="modal-body">


					<div class="row">


						<div class="col-md-12">
							<div class="tile">
								<div class="table-responsive">
									<table id="" class="text-left table table-bordered">
										<tr>
											<td class="bg-warning alert-warning w_150">Nome</td>
											<td><span id="nome_dados"></span></td>
										</tr>

										<tr>
											<td class="bg-warning alert-warning">Atualizado</td>
											<td><span id="update_atF_dados"></span></td>
										</tr>

										<tr>
											<td class="bg-warning alert-warning">Cadastrado</td>
											<td><span id="created_at_dados"></span></td>
										</tr>
										 

									</table>
								</div>
							</div>
						</div>



					</div>





				</div>

			</div>
		</div>
	</div>






<script type="text/javascript">var pag = "<?=$pag?>"</script>
<script src="js/ajax.js"></script>