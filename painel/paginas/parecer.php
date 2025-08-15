<?php 
$pag = 'parecer';
?>

<div class="justify-content-between">
 	<div class="left-content mt-2 mb-3">
 <a class="btn ripple btn-primary text-white" onclick="inserir()" type="button"><i class="fe fe-plus me-2"></i> Adicionar Parecer</a>



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
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header bg-primary text-white">
				<h4 class="modal-title" id="exampleModalLabel"><span id="titulo_inserir"></span></h4>
				 <button id="btn-fechar" aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button"><span class="text-white" aria-hidden="true">&times;</span></button>
			</div>
			<form id="form">
			<div class="modal-body">
				
				

					<div class="row">

						<div class="col-md-8 mb-2 col-6">
							<label>Pessoa Contemplada</label>							
							<select name="id_contemplado" id="id_contemplado" class="sel2" style="width:100%; height:35px" required>
								<option value="0"></option>
							  <?php 
							  	$query = $pdo->query("SELECT * from contemplados order by nome asc");
								$res = $query->fetchAll(PDO::FETCH_ASSOC);
								$linhas = @count($res);
								if($linhas > 0){
									for($i=0; $i<$linhas; $i++){ ?>
										<option value="<?php echo $res[$i]['id'] ?>"><?php echo $res[$i]['nome'] ?> : <?php echo $res[$i]['cpf'] ?></option>
								<?php } } ?>
							</select>	
						</div>

						<div class="col-md-4 mb-2 col-6">
							<label>Evidência</label>
							<select class="form-select" name="evidencia" id="evidencia" required>
								<option value="0"></option>
							  <?php 
							  	$query = $pdo->query("SELECT * from situacao order by id asc");
								$res = $query->fetchAll(PDO::FETCH_ASSOC);
								$linhas = @count($res);
								if($linhas > 0){
									for($i=0; $i<$linhas; $i++){ ?>
										<option value="<?php echo $res[$i]['status'] ?>"><?php echo $res[$i]['nome'] ?></option>
								<?php } } ?>
							</select>	
						</div>

						
					</div>

					<div class="row">						

					

						<div class="col-md-8 mb-2">							
								<label>Ação</label>
								<input type="text" class="form-control" id="acao" name="acao" placeholder="Qual ação?">							
						</div>
					
						
						<div class="col-md-4 mb-2">							
								<label>Situação</label>
								<input type="text" class="form-control" id="situacao" name="situacao" placeholder="Descreva a situação">							
						</div>

						
						

					</div>

					<div class="row">
						<div class="col-md-12 mb-2">							
								<label>Observação</label>
								<input type="text" class="form-control" id="obs" name="obs" placeholder="caso tenha alguma informação">							
						</div>
					</div>

					

					

					<div class="col-md-4" style="margin-top: 22px">							
						<button id="btn_salvar" type="submit" class="btn btn-primary">Registrar</button>					
					</div>

			
					<input type="hidden" class="form-control" id="id" name="id">					

				<br>
				<small><div id="mensagem" align="center"></div></small>
			</div>
			
			</form>
		</div>
	</div>
</div>



<script type="text/javascript">var pag = "<?=$pag?>"</script>
<script src="js/ajax.js"></script>

<script type="text/javascript">
	$(document).ready(function() {
		$('.sel2').select2({
			dropdownParent: $('#modalForm')
		});
	});
</script>