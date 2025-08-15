<?php 
$pag = 'empresas';

 ?>



 <div class="justify-content-between">
 	<div class="left-content mt-2 mb-3">
	 <a class="btn ripple btn-primary text-white" onclick="inserir()" type="button"><i class="fe fe-plus me-2"></i> Adicionar <?php echo ucfirst($pag); ?></a>



	<div class="dropdown" style="display: inline-block;">                      
	    <a href="#" aria-expanded="false" aria-haspopup="true" data-bs-toggle="dropdown" class="btn btn-danger dropdown" id="btn-deletar" style="display:none"><i class="fe fe-trash-2"></i> Deletar</a>
	        <div  class="dropdown-menu tx-13">
	            <div style="width: 240px; padding:15px 5px 0 10px;" class="dropdown-item-text">
	                <p>Excluir Selecionados? <a href="#" onclick="deletarSel()"><span class="text-danger">Sim</span></a></p>
	            </div>
	        </div>
	</div>
	<a style="position:absolute; right:40px;" href="rel/excel_empresas.php" type="button" class="btn btn-success ocultar_mobile_app" target="_blank"><span class="fa fa-file-excel-o"></span> Exportar</a>

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


<!-- Modal Perfil -->
<div class="modal fade" id="modalForm" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header bg-primary text-white">
				<h4 class="modal-title" id="exampleModalLabel"><span id="titulo_inserir"></span></h4>
				 <button id="btn-fechar" aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button"><span class="text-white" aria-hidden="true">&times;</span></button>
			</div>
			<form id="form">
			<div class="modal-body">

					<div class="row">
						<div class="col-md-6 mb-2 col-6">							
								<label>Nome</label>
								<input type="text" class="form-control" id="nome" name="nome" placeholder="Nome Proprietário" required>							
						</div>

						<div class="col-md-6 col-6">							
								<label>Nome Fantasia</label>
								<input type="text" class="form-control" id="fantasia" name="fantasia" placeholder="Nome Fantasia Empresa" required>							
						</div>

							

						
					</div>


					<div class="row">

						<div class="col-md-3 col-6">							
								<label>Telefone</label>
								<input type="text" class="form-control" id="telefone" name="telefone" placeholder="Telefone">							
						</div>

						<div class="col-md-3 mb-2">							
							<label>Responsável</label>
							<input type="text" class="form-control" id="responsavel" name="responsavel" placeholder="Informe nome" >						
						</div>

						<div class="col-md-3 mb-2 col-6">							
							<label>Pessoa</label>
							<select name="tipo_pessoa" id="tipo_pessoa" class="form-select" onchange="mudarPessoa()">
								<option value="Física">Física</option>
								<option value="Jurídica">Jurídica</option>
							</select>							
						</div>		

						<div class="col-md-3 mb-2 col-6">							
							<label>CPF / CNPJ</label>
							<input type="text" class="form-control" id="cnpj" name="cnpj" placeholder="CPF/CNPJ" >							
						</div>

						

						

						
					</div>

					<div class="row">

						<div class="col-md-4">							
							<label>Contrato</label>
							<input type="text" class="form-control" id="contrato" name="contrato" placeholder="" >							
						</div>

						<div class="col-md-8">							
							<label>Empenho</label>
							<input type="text" class="form-control" id="empenho" name="empenho" placeholder="" >							
						</div>

						

					
					</div>

					<div class="row">
						
						<div class="col-md-6 mb-2">
							<label>Endereço</label>
							<input type="text" class="form-control" id="endereco" name="endereco" placeholder="Ex. Rua Central, Nr 356 - Bairro Centro">
						</div>

						<div class="col-md-6 mb-2">							
							<label>Observação</label>
							<input type="text" class="form-control" id="obs" name="obs" placeholder="Campo de observação" >							
						</div>
						
					</div>

					

					

					


					<input type="hidden" class="form-control" id="id" name="id">					

				<br>
				<small><div id="mensagem" align="center"></div></small>
			</div>
			<div class="modal-footer">       
				<button type="submit" id="btn_salvar" class="btn btn-primary">Salvar</button>
			</div>
			</form>
		</div>
	</div>
</div>


<!-- Modal Dados -->
	<div class="modal fade" id="modalDados" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog ">
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
											<td class="bg-warning alert-warning">Nome Fantasia</td>
											<td><span id="fantasia_dados"></span></td>
										</tr>

										<tr>
											<td class="bg-warning alert-warning">Telefone</td>
											<td><span id="telefone_dados"></span></td>
										</tr>

										<tr>
											<td class="bg-warning alert-warning">Tipo Pessoa</td>
											<td><span id="pessoa_dados"></span></td>
										</tr>

										<tr>
											<td class="bg-warning alert-warning w_150">CNPJ/CPF</td>
											<td><span id="cnpj_dados"></span></td>
										</tr>

										<tr>
											<td class="bg-warning alert-warning w_150">Endereço</td>
											<td><span id="endereco_dados"></span></td>
										</tr>

										

										<tr>
											<td class="bg-warning alert-warning w_150">Responsável</td>
											<td><span id="responsavel_dados"></span></td>
										</tr>

										<tr>
											<td class="bg-warning alert-warning w_150">Contrato / Empenho</td>
											<td><span id="contrato_dados"> / <span id="empenho_dados"></span></td>
										</tr>

										<tr>
											<td class="bg-warning alert-warning w_150">Observação</td>
											<td><span id="obs_dados"></span></td>
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

<script type="text/javascript">
	function mudarPessoa(){
		var pessoa = $('#tipo_pessoa').val();
		if(pessoa == 'Física'){
			$('#cnpj').mask('000.000.000-00');
			$('#cnpj').attr("placeholder", "Insira CPF");
		}else{
			$('#cnpj').mask('00.000.000/0000-00');
			$('#cnpj').attr("placeholder", "Insira CNPJ");
		}
	}
</script>