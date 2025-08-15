<?php
@session_start();
$pag = 'contemplados';

$id_usuario = @$_SESSION['id'];
$usuario_lotado = @$_SESSION['lotado'];

if ($usuario_lotado != 16) {
	$query1 = $pdo->query("SELECT * FROM usuarios_atuacoes where usuario = '$id_usuario'");
	$res1 = $query1->fetchAll(PDO::FETCH_ASSOC);
	$permissoes = [];
	foreach ($res1 as $linha1) {
	    $permissoes[] = $linha1['permissao'];
	}	
	$lista_permissoes = implode(',', array_map('intval', $permissoes));	
	$sql_setor = 'WHERE id in ('.$lista_permissoes.') OR id = '.$usuario_lotado;
	
}else{	
	$sql_setor = '';
}
 ?>

 <div class="justify-content-between">
 	<div class="left-content mt-2 mb-3">
		<a class="btn ripple btn-primary text-white" onclick="inserir()" type="button">
		 	<i class="fe fe-plus me-2"></i> Adicionar <?php echo ucfirst($pag); ?>
		</a>

		<div class="dropdown" style="display: inline-block;">                      
		    <a href="#" aria-expanded="false" aria-haspopup="true" data-bs-toggle="dropdown" class="btn btn-danger dropdown" id="btn-deletar" style="display:none"><i class="fe fe-trash-2"></i> Deletar</a>
		    <div  class="dropdown-menu tx-13">
		        <div style="width: 240px; padding:15px 5px 0 10px;" class="dropdown-item-text">
		            <p>Excluir Selecionados? <a href="#" onclick="deletarSel()"><span class="text-danger">Sim</span></a></p>
		        </div>
		    </div>
		</div>

		<div style="display: inline-block; margin-bottom: 10px; margin: 10px 10px;">

			<input type="date" name="dataInicial"  class="form-control2" id="dataInicial" style="height:35px; width:49%; font-size: 13px;" value="<?php echo date('Y-m-d') ?>" required onchange="buscar()">

			<input type="date" name="dataFinal" class="form-control2" id="dataFinal" style="height:35px; width:49%; font-size: 13px;" value="<?php echo date('Y-m-d') ?>" required onchange="buscar()">	
		</div>

		<div class="ocultar_mobile" style="display: inline-block;">
			<select class="form-select" aria-label="Default select example" name="status" id="status" onchange="buscar()">
				<option value="">Todos</option>
				<option value="Aguardo">Abertos</option>
				<option value="Iniciado">Iniciados</option>
				<option value="Atrasado">Atrasados</option>
				<option value="Concluído">Finalizados</option>				
				<option value="Hoje">Abertos Hoje</option>
			</select>
		</div>

		<a style="position:absolute; right:40px;" href="rel/excel_contemplados.php" type="button" class="btn btn-success ocultar_mobile_app" target="_blank"><span class="fa fa-file-excel-o"></span> Exportar</a>

	</div>

</div>

<div class="row">

	<div class="col-md-12" align="center">


		<a style="width: 100px; background-color: green; font-size:11px; margin-bottom: 3px; " href="#" class="btn btn-success" title="Todas" onclick="$('#dataFiltro').val('Tudo'); $('#status').val('').change(); ">TODOS</a>	

		<a style="width: 100px; font-size:11px; margin-bottom: 3px; " href="#" class="btn btn-info" title="Abertos" onclick="$('#dataFiltro').val('Tudo'); $('#status').val('Aguardo').change(); ">ABERTOS</a>

		<a style="width: 100px; background-color: blue; border-color: blue; font-size:10px; margin-bottom: 3px; " href="#" title="Iniciados" class="btn btn-warning" onclick="$('#dataFiltro').val('Tudo'); $('#status').val('Iniciado').change(); ">INICIADOS</a>

		<a style="width: 100px; font-size:11px; margin-bottom: 3px; " href="#" class="btn btn-danger" title="Atrasados" onclick="$('#dataFiltro').val('Tudo'); $('#status').val('Atrasado').change(); ">ATRASADOS</a>

		<a style="width: 100px; font-size:11px; margin-bottom: 3px; " href="#" class="btn btn-secondary" title="Finalizados" onclick="$('#dataFiltro').val('Tudo'); $('#status').val('Concluído').change(); ">FINALIZADOS</a>
		


		<input type="hidden" id="status_busca" name="status">
		<input type="hidden" id="dataFiltro" name="dataFiltro">
		
		
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
						<div class="col-md-6 mb-2">							
								<label>Nome</label>
								<input type="text" class="form-control" id="nome" name="nome" placeholder="Nome pessoa contemplada" required>							
						</div>

						<div class="col-md-3 mb-2">
							<label>CPF</label> 
								<input type="text" class="form-control" name="cpf" id="cpf" required>
						</div>

						<div class="col-md-3">							
							<label>Telefone</label>
							<input type="text" class="form-control" id="telefone" name="telefone" placeholder="Telefone contato">							
						</div>

						

						
					</div>

					<div class="row">

						<div class="col-md-6 mb-2 col-3">
							<label>Serviços</label>
							<input type="text" class="form-control" id="servico" name="servico" placeholder="Informe Serviço" required>							
						</div>
						

						<div class="col-md-3 mb-2">
							<label>Grupo Contemplação</label>
							<select name="grupo" id="grupo" class="sel2" style="width:100%; height:35px" required> 
								<option value="Grupo 1">Grupo 1</option>
								<option value="Grupo 2">Grupo 2</option>
								<option value="Grupo 3">Grupo 3</option>
								<option value="Grupo 4">Grupo 4</option>
							</select>
						</div>

						<div class="col-md-3">							
							<label>Evento</label>
							<input type="text" class="form-control" id="evento" name="evento" placeholder="Informe evento">
						</div>

						

						
					</div>

					


					<div class="row">

						<div class="col-md-6 mb-2">	
							<label>Empresa</label>
							<select name="empresa" id="empresa" class="sel2" style="width:100%; height:35px" required>
								<option value="">Selecione</option>
								<?php 
								$query = $pdo->query("SELECT * from clientes order by id asc");
								$res = $query->fetchAll(PDO::FETCH_ASSOC);
								$linhas = @count($res);
								if($linhas > 0){
									for($i=0; $i<$linhas; $i++){
										echo '<option value="'.$res[$i]['id'].'">'.$res[$i]['fantasia'].'</option>';
									}
								}
								?>	
							</select>							
						</div>

						<div class="col-md-3 mb-2 col-3">
							<label>Data Contemplado</label>
							<input type="date" class="form-control" id="dt_contemplado" name="dt_contemplado" required>
						</div>
						<div class="col-md-3 mb-2 col-3">
							<label>Número Contemplado</label>
							<input type="text" class="form-control" id="contemplacao_numero" name="contemplacao_numero" required>
						</div>

						
					</div>

					<div class="row">
						<div class="col-md-3 mb-2 col-3">
							<label>Data Ordem Serviço</label>
							<input type="date" class="form-control" id="dt_os" name="dt_os" >
						</div>

						<div class="col-md-3 mb-2 col-3">
							<label>Data Conlcusão</label>
							<input type="date" class="form-control" id="dt_conclusao" name="dt_conclusao" >
						</div>

						<div class="col-md-3 mb-2">
							<label>Nível Prioridade</label>
							<select name="prioridade" id="prioridade" class="sel2" style="width:100%; height:35px" required>
								<option value="Baixa">Baixa</option>
								<option value="Média">Média</option>
								<option value="Alta">Alta</option>
								<option value="Máxima">Máxima</option>
							</select>
						</div>

						<div class="col-md-3 mb-2 col-3">
							<label>Evidência </label>
							<input type="text" class="form-control" id="evidencia" name="evidencia" placeholder="Situação do Parecer" readonly>
						</div>


					</div>

				


					<div class="row">
						<div class="col-md-2 mb-2">
							<label>CEP</label>
							<input type="text" class="form-control" id="cep" name="cep" placeholder="Digite o CEP"
								onblur="pesquisacep(this.value);">
						</div>
						<div class="col-md-5 mb-2">
							<label>Rua</label>
							<input type="text" class="form-control" id="endereco" name="endereco" placeholder="Ex. Rua Central">
						</div>
						<div class="col-md-2 mb-2">
							<label>Número</label>
							<input type="text" class="form-control" id="numero" name="numero" placeholder="1500">
						</div>
						<div class="col-md-3 mb-2">
							<label>Complemento</label>
							<input type="text" class="form-control" id="complemento" name="complemento" placeholder="Bloco B AP 104">
						</div>
					</div>

					<div class="row">
						<div class="col-md-4 mb-2">
							<label>Bairro</label>
							<input type="text" class="form-control" id="bairro" name="bairro" placeholder="Bairro">
						</div>
						<div class="col-md-5 mb-2">
							<label>Cidade</label>
							<input type="text" class="form-control" id="cidade" name="cidade" placeholder="Cidade">
						</div>
						<div class="col-md-3 mb-2">
							<label>Estado</label>
							<select class="form-select" id="estado" name="estado">
								<option value="">Selecionar</option>
								<option value="AC">Acre</option>
								<option value="AL">Alagoas</option>
								<option value="AP">Amapá</option>
								<option value="AM">Amazonas</option>
								<option value="BA">Bahia</option>
								<option value="CE">Ceará</option>
								<option value="DF">Distrito Federal</option>
								<option value="ES">Espírito Santo</option>
								<option value="GO">Goiás</option>
								<option value="MA">Maranhão</option>
								<option value="MT">Mato Grosso</option>
								<option value="MS">Mato Grosso do Sul</option>
								<option value="MG">Minas Gerais</option>
								<option value="PA">Pará</option>
								<option value="PB">Paraíba</option>
								<option value="PR">Paraná</option>
								<option value="PE">Pernambuco</option>
								<option value="PI">Piauí</option>
								<option value="RJ">Rio de Janeiro</option>
								<option value="RN">Rio Grande do Norte</option>
								<option value="RS">Rio Grande do Sul</option>
								<option value="RO">Rondônia</option>
								<option value="RR">Roraima</option>
								<option value="SC">Santa Catarina</option>
								<option value="SP">São Paulo</option>
								<option value="SE">Sergipe</option>
								<option value="TO">Tocantins</option>
								<option value="EX">Estrangeiro</option>
							</select>
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
		<div class="modal-dialog">
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
											<td class="bg-warning alert-warning w_150">CPF</td>
											<td><span id="cpf_dados"></span></td>
										</tr>

										<tr>
											<td class="bg-warning alert-warning">Telefone</td>
											<td><span id="telefone_dados"></span></td>
										</tr>

										<tr>
											<td class="bg-warning alert-warning">Grupo</td>
											<td><span id="grupo_dados"></span></td>
										</tr>

										<tr>
											<td class="bg-warning alert-warning w_150">Endereço</td>
											<td><span id="endereco_dados"></span> - <span id="numero_dados"></span> - <span id="bairro_dados"></span></td>
										</tr>

										<tr>
											<td class="bg-warning alert-warning w_150">Estado</td>
											<td><span id="estado_dados"></span></td>
										</tr>
									
										<tr>
											<td class="bg-warning alert-warning w_150">CEP</td>
											<td><span id="cep_dados"></span></td>
										</tr>
										
										<tr>
											<td class="bg-warning alert-warning w_150">Complemento</td>
											<td><span id="complemento_dados"></span></td>
										</tr>

										<tr>
											<td class="bg-warning alert-warning w_150">Evento</td>
											<td><span id="evento_dados"></span></td>
										</tr>

										<tr>
											<td class="bg-warning alert-warning w_150">Prioridade</td>
											<td><span id="prioridade_dados"></span></td>
										</tr>

										<tr>
											<td class="bg-warning alert-warning w_150">Data Contemplação</td>
											<td><span id="dt_contemplado_dados"></span></td>
										</tr>

										<tr>
											<td class="bg-warning alert-warning w_150">Serviço</td>
											<td><span id="servico_dados"></span></td>
										</tr>

										<tr>
											<td class="bg-warning alert-warning w_150">Nr Contemplação</td>
											<td><span id="contemplacao_numero_dados"></span></td>
										</tr>

										<tr>
											<td class="bg-warning alert-warning w_150">Empresa</td>
											<td><span id="empresa_dados"></span></td>
										</tr>

										<tr>
											<td class="bg-warning alert-warning w_150">Dt Ordem Serviço</td>
											<td><span id="dt_os_dados"></span></td>
										</tr>

										<tr>
											<td class="bg-warning alert-warning w_150">Data Conclusão</td>
											<td><span id="dt_conclusao_dados"></span></td>
										</tr>

										<tr>
											<td class="bg-warning alert-warning w_150">Status</td>
											<td><span id="evidencia_dados"></span></td>
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





	<!-- Modal -->
	<div class="modal fade" id="modalBaixar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header bg-primary text-white">
					<h4 class="modal-title" id="tituloModal">Completar Transferência para: <span id="destino_transferir"> </span></h4>
					 <button id="btn-fechar-transferir" aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button"><span class="text-white" aria-hidden="true">&times;</span></button>
				</div>
				<form id="form-transferir" method="post">
					<div class="modal-body">


						<div class="row">

							<div class="col-md-6 mb-2">							
								<label>Informe Motivo Transferência</label>
								<input type="text" class="form-control" id="motivotransfere" name="motivotransfere" placeholder="" required>							
							</div>

							<div class="col-md-6">
								<div class="mb-3">
									<label >Data da Transferência</label>
									<input type="date" class="form-control" name="dt_transferencia"  id="dt_transferencia" value="<?php echo date('Y-m-d') ?>" >
								</div>
							</div>

							
						</div>




						<small><div id="mensagem-transferir" align="center"></div></small>

						<input type="hidden" class="form-control" name="id_transferir"  id="id_transferir">
						<input type="hidden" class="form-control" id="unidade_transferir" name="unidade_transferir">
						<input type="hidden" class="form-control" id="jovem_transferir" name="jovem_transferir">


					</div>
					<div class="modal-footer">
						
						<button type="submit" class="btn btn-success">Transferir</button>
					</div>
				</form>
			</div>
		</div>
	</div>







	<!-- Modal Arquivos -->
	<div class="modal fade" id="modalArquivos" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header bg-primary text-white">
					<h4 class="modal-title" id="tituloModal">Gestão de Arquivos - <span id="nome-arquivo"> </span></h4>
					 <button id="btn-fechar-arquivos" aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button"><span class="text-white" aria-hidden="true">&times;</span></button>
				</div>
				<form id="form-arquivos" method="post">
					<div class="modal-body">

						<div class="row">
							<div class="col-md-8">						
								<div class="form-group"> 
									<label>Arquivo</label> 
									<input class="form-control" type="file" name="arquivo_conta" onChange="carregarImgArquivos();" id="arquivo_conta">
								</div>	
							</div>
							<div class="col-md-4">	
								<div id="divImgArquivos">
									<img src="images/arquivos/sem-foto.png"  width="60px" id="target-arquivos">									
								</div>					
							</div>




						</div>

						<div class="row" >
							<div class="col-md-8">
								<input type="text" class="form-control" name="nome-arq"  id="nome-arq" placeholder="Nome do Arquivo * " required>
							</div>

							<div class="col-md-4">										 
								<button type="submit" class="btn btn-primary">Inserir</button>
							</div>
						</div>

						<hr>

						<small><div id="listar-arquivos"></div></small>

						<br>
						<small><div align="center" id="mensagem-arquivo"></div></small>

						<input type="hidden" class="form-control" name="id-arquivo"  id="id-arquivo">


					</div>
				</form>
			</div>
		</div>
	</div>


	<!-- Modal Contas -->
<div class="modal fade" id="modalAcompanhamento" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header bg-primary text-white">
				<h4 class="modal-title" id="exampleModalLabel"><span id="titulo_contas"></span></h4>
				<button id="btn-fechar-contas" aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button"><span
						class="text-white" aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body">
				<div id="listar_acompanhamento" style="margin-top: 15px">
				</div>
				<input type="hidden" id="id_contas">
			</div>
		</div>
	</div>
</div>


<!-- Modal Contrato Venda -->
	<div class="modal fade" id="modalRelatorioTransferencia" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="tituloModal">Preencher Relatório - <span id="nome-vistoria"> </span></h4>
					<button id="btn-fechar-vistoria" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="margin-top: -20px">
						<span aria-hidden="true">&times;</span>
					</button>

					

				</div>
				<form id="form-vistoria" method="post" action="rel/relatorio_transferencia_class.php" target="_blank">
					<div class="modal-body">

					
						
					

						<br>
						<small><div align="center" id="mensagem-vistoria"></div></small>

						<input type="hidden" class="form-control" name="id-vistoria"  id="id-vistoria">


					</div>

					<div class="modal-footer">
					<button type="submit" class="btn btn-primary">Gerar Relatório</button>
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





	<script type="text/javascript">
			$("#form-arquivos").submit(function () {
				event.preventDefault();
				var formData = new FormData(this);

				$.ajax({
					url: 'paginas/' + pag + "/arquivos.php",
					type: 'POST',
					data: formData,

					success: function (mensagem) {
						$('#mensagem-arquivo').text('');
						$('#mensagem-arquivo').removeClass()
						if (mensagem.trim() == "Inserido com Sucesso") {                    
						//$('#btn-fechar-arquivos').click();
						$('#nome-arq').val('');
						$('#arquivo_conta').val('');
						$('#target-arquivos').attr('src','images/arquivos/sem-foto.png');
						listarArquivos();
					} else {
						$('#mensagem-arquivo').addClass('text-danger')
						$('#mensagem-arquivo').text(mensagem)
					}

				},

				cache: false,
				contentType: false,
				processData: false,

			});

			});
		</script>

		<script type="text/javascript">
			function listarArquivos(){
				var id = $('#id-arquivo').val();	
				$.ajax({
					url: 'paginas/' + pag + "/listar-arquivos.php",
					method: 'POST',
					data: {id},
					dataType: "text",

					success:function(result){
						$("#listar-arquivos").html(result);
					}
				});
			}

		</script>




<script type="text/javascript">
		function carregarImgArquivos() {
			var target = document.getElementById('target-arquivos');
			var file = document.querySelector("#arquivo_conta").files[0];

			var arquivo = file['name'];
			resultado = arquivo.split(".", 2);

			if(resultado[1] === 'pdf'){
				$('#target-arquivos').attr('src', "images/pdf.png");
				return;
			}

			if(resultado[1] === 'rar' || resultado[1] === 'zip'){
				$('#target-arquivos').attr('src', "images/rar.png");
				return;
			}

			if(resultado[1] === 'doc' || resultado[1] === 'docx' || resultado[1] === 'txt'){
				$('#target-arquivos').attr('src', "images/word.png");
				return;
			}


			if(resultado[1] === 'xlsx' || resultado[1] === 'xlsm' || resultado[1] === 'xls'){
				$('#target-arquivos').attr('src', "images/excel.png");
				return;
			}


			if(resultado[1] === 'xml'){
				$('#target-arquivos').attr('src', "images/xml.png");
				return;
			}



			var reader = new FileReader();

			reader.onloadend = function () {
				target.src = reader.result;
			};

			if (file) {
				reader.readAsDataURL(file);

			} else {
				target.src = "";
			}
		}
	</script>




	<script type="text/javascript">
	$("#form-transferir").submit(function () {
		event.preventDefault();
		var formData = new FormData(this);

		$.ajax({
			url: 'paginas/' + pag + "/transferir-jovem-unidade.php",
			type: 'POST',
			data: formData,

			success: function (mensagem) {
				$('#mensagem-transferir').text('');
				$('#mensagem-transferir').removeClass()
				if (mensagem.trim() == "Inserido com Sucesso") {  
						$('#id_transferir').val('');
						$('#dt_transferencia').val('');
						$('#unidade_transferir').val('').change();
						$('#jovem_transferir').val('');
						
						$('#btn-fechar-transferir').click();
						listar();
					} else {
						$('#mensagem-transferir').addClass('text-danger');
						$('#mensagem-transferir').text(mensagem);
					}

				},

				cache: false,
				contentType: false,
				processData: false,

			});

	});
</script>

<script>

	function carregarImg() {
		var target = document.getElementById('target');
		var file = document.querySelector("#foto").files[0];
		var reader = new FileReader();

		reader.onloadend = function () {
			target.src = reader.result;
		};

		if (file) {
			reader.readAsDataURL(file);

		} else {
			target.src = "";
		}
	}


	function limpa_formulário_cep() {
		//Limpa valores do formulário de cep.
		document.getElementById('endereco').value = ("");
		document.getElementById('bairro').value = ("");
		document.getElementById('cidade').value = ("");
		document.getElementById('estado').value = ("");
		//document.getElementById('ibge').value=("");
	}

	function meu_callback(conteudo) {
		if (!("erro" in conteudo)) {
			//Atualiza os campos com os valores.
			document.getElementById('endereco').value = (conteudo.logradouro);
			document.getElementById('bairro').value = (conteudo.bairro);
			document.getElementById('cidade').value = (conteudo.localidade);
			document.getElementById('estado').value = (conteudo.uf);
			//document.getElementById('ibge').value=(conteudo.ibge);
		} //end if.
		else {
			//CEP não Encontrado.
			limpa_formulário_cep();
			alert("CEP não encontrado.");
		}
	}

	function pesquisacep(valor) {

		//Nova variável "cep" somente com dígitos.
		var cep = valor.replace(/\D/g, '');

		//Verifica se campo cep possui valor informado.
		if (cep != "") {

			//Expressão regular para validar o CEP.
			var validacep = /^[0-9]{8}$/;

			//Valida o formato do CEP.
			if (validacep.test(cep)) {

				//Preenche os campos com "..." enquanto consulta webservice.
				document.getElementById('endereco').value = "...";
				document.getElementById('bairro').value = "...";
				document.getElementById('cidade').value = "...";
				document.getElementById('estado').value = "...";
				//document.getElementById('ibge').value="...";

				//Cria um elemento javascript.
				var script = document.createElement('script');

				//Sincroniza com o callback.
				script.src = 'https://viacep.com.br/ws/' + cep + '/json/?callback=meu_callback';

				//Insere script no documento e carrega o conteúdo.
				document.body.appendChild(script);

			} //end if.
			else {
				//cep é inválido.
				limpa_formulário_cep();
				alert("Formato de CEP inválido.");
			}
		} //end if.
		else {
			//cep sem valor, limpa formulário.
			limpa_formulário_cep();
		}
	};
</script>


<script type="text/javascript">
	function buscar(){
		var dataInicial = $('#dataInicial').val();
		var dataFinal = $('#dataFinal').val();
		var status = $('#status').val();
		var dataFiltro = $('#dataFiltro').val();

		listar(dataInicial, dataFinal, status, '', dataFiltro);
		$('#dataFiltro').val('');

	}
</script>

<script src="//js.nicedit.com/nicEdit-latest.js" type="text/javascript"></script>
<script type="text/javascript">bkLib.onDomLoaded(nicEditors.allTextAreas);</script>