<?php 
require_once("conexao.php");
@session_start();

$query = $pdo->query("SELECT * from usuarios");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$linhas = @count($res);
$senha = '123';
$senha_crip = sha1($senha);
if($linhas == 0){
	$pdo->query("INSERT INTO usuarios SET nome = '$nome_sistema', email = '$email_sistema', senha = '', senha_crip = '$senha_crip', nivel = 'Administrador', ativo = 'Sim', foto = 'sem-foto.jpg', telefone = '$telefone_sistema', data = curDate() ");
}

?>



<!DOCTYPE html>
<html lang="pt-BR">

<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<head>
	<!-- META DATA -->
	<meta charset="UTF-8">
	<meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="Description" content="Fluxo Comunicação Inteligente">
	<meta name="Author" content="Gene Aguiar">
	<meta name="Keywords" content="fluxo, comunicacao, inteligente, marketing, whatsapp"/>

	<!-- TITLE -->
	<title><?php echo $nome_sistema ?></title>


	<link rel="icon" href="img/icone.png" type="image/x-icon"/>
	<link href="assets/css/icons.css" rel="stylesheet">
	<link id="style" href="assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
	<link href="assets/css/style.css" rel="stylesheet">
	<link href="assets/css/custom.css" rel="stylesheet">
	<link href="assets/css/style-dark.css" rel="stylesheet">
	<link href="assets/css/style-transparent.css" rel="stylesheet">
	<link href="assets/css/skin-modes.css" rel="stylesheet" />
	<link href="assets/css/animate.css" rel="stylesheet">




</head>


<!-- GLOBAL-LOADER -->
<div id="global-loader">
	<img src="img/loader.gif" class="loader-img loader loader_mobile" alt="">
</div>
<!-- /GLOBAL-LOADER -->

<body class="ltr error-page1 bg-primary" id="pagina">


	<div class="square-box">
		<div></div>
		<div></div>
		<div></div>
		<div></div>
		<div></div>
		<div></div>
		<div></div>
		<div></div>
		<div></div>
		<div></div>
		<div></div>
		<div></div>
		<div></div>
		<div></div>
		<div></div>
	</div>


	<div class="page" >


		<div class="page-single">
			<div class="container">
				<div class="row">
					<div class="col-xl-5 col-lg-6 col-md-8 col-sm-8 col-xs-10 card-sigin-main mx-auto my-auto py-4 justify-content-center">
						<div class="card-sigin">
							<!-- Demo content-->
							<div class="main-card-signin d-md-flex">
								<div class="wd-100p"><div class="d-flex mb-4 justify-content-center"><a href="index.php"><img src="img/logo.png" class="sign-favicon" alt="logo" width="130px"></a></div>
								<div align="center" style="font-size: 55px; margin-top: -45px; color: #0bb3e6;">ArchSync</div>
								<div class="">
									<div class="main-signup-header">

										<div class="panel panel-primary">

											<div class="panel-body tabs-menu-body border-0 p-3">			

												<?php
												if(isset($_SESSION['msg'])){

													echo '<div class="alert alert-danger mg-b-0 mb-3 alert-dismissible fade show" role="alert">
													<strong><span class="alert-inner--icon"><i class="fe fe-slash"></i></span></strong> '.$_SESSION['msg'].'!
													<button aria-label="Close" class="btn-close" data-bs-dismiss="alert" type="button"><span aria-hidden="true">&times;</span></button>
													</div>';

													unset($_SESSION['msg']);
												}
												?>		




												<form method="post" action="autenticar.php">
													<div class="form-group">
														<label>Usuário</label> 
														<input class="form-control" name="usuario" placeholder="Digite seu Usuário" id="usuario" type="text" required value="">
													</div>
													<div class="form-group">
														<label class="control-label">Senha</label>           
														<input id="password-field" type="password" class="form-control" name="senha" placeholder="Digite sua Senha" required value="">
														<span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>        
													</div>

													<div class="form-group" style="margin-left: 22px">
														<span><input class="form-check-input" type="checkbox" value="Sim" name="salvar" id="salvar_acesso"></span>
														<span class="control-label" style="margin-top:5px">Salvar Acesso</span>         							 	
													</div>

													<button class="btn btn-primary btn-block">Entrar no Sistema</button>

												</form>													

											</div>
										</div>

										
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>





</body>

</html>





<!-- Modal -->
<div class="modal fade" id="precadastroModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header bg-primary text-white">
				<h4 class="modal-title" id="tituloModal">Pré Cadastro</h4>

				<button id="btn-fechar-cadastro" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
					<span aria-hidden="true" class="text-white">&times;</span>
				</button>

			</div>
			<form method="post" id="form-precadastro">
				<div class="modal-body">
					<div class="row">
						<div class="col-md-3">
							<div class="form-group"> 
								<label>Foto</label> 
								<input type="file" name="foto" onChange="carregarImg();" id="foto" required>
							</div>
						</div>
						<div class="col-md-2">
							<div id="divImg">
								<img src="painel/images/perfil/sem-foto.jpg"  width="100px" id="target">									
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-5">						
							<div class="form-group"> 
								<label>Nome</label> 
								<input type="text" class="form-control" name="nome" id="nome" required> 
							</div>						
						</div>

						<div class="col-md-4">						
							<div class="form-group"> 
								<label>CPF</label> 
								<input type="text" class="form-control" name="cpf" id="cpf" required> 
							</div>						
						</div>

						<div class="col-md-3">						
							<div class="form-group"> 
								<label>Data Nascimento</label>
								<input type="date" class="form-control" name="data_nasc" id="data_nasc" value="<?php echo date('Y-m-d') ?>" required> 
							</div>						
						</div>

						

					</div>


					
					<div class="row">

						<div class="col-md-5">
							<div class="form-group"> 
								<label>Endereço</label> 
								<input type="text" class="form-control" name="endereco" id="endereco" placeholder="Rua X Número 20 Bairro X" required> 
							</div>
						</div>

						<div class="col-md-4">						
							<div class="form-group"> 
								<label>Email</label> 
								<input type="email" class="form-control" name="email" id="email" required> 
							</div>						
						</div>

						<div class="col-md-3">						
							<div class="form-group"> 
								<label>Telefone</label> 
								<input type="text" class="form-control" name="telefone" id="telefone" required> 
							</div>						
						</div>

					</div>

					<div class="row">

						<div class="col-md-6 mb-2 col-6">							
							<label>Cargo</label>
							<select class="form-select" name="nivel" id="nivel" required>
								<option value="">Selecione</option>
								<?php 
								$query = $pdo->query("SELECT * from cargos where nome != 'Administrador' order by id asc");
								$res = $query->fetchAll(PDO::FETCH_ASSOC);
								$linhas = @count($res);
								if($linhas > 0){
									for($i=0; $i<$linhas; $i++){ ?>
										<option value="<?php echo $res[$i]['nome'] ?>"><?php echo $res[$i]['nome'] ?></option>
									<?php } } ?>
								</select>							
							</div>

							<div class="col-md-6 mb-2 col-6">							
								<label>Lotado/Setor</label>
								<select class="form-select" name="lotado" id="lotado" required>
									<option value="">Selecione</option>
									<?php 
									$query = $pdo->query("SELECT * from setor order by nome asc");
									$res = $query->fetchAll(PDO::FETCH_ASSOC);
									$linhas = @count($res);
									if($linhas > 0){
										for($i=0; $i<$linhas; $i++){ ?>
											<option value="<?php echo $res[$i]['id'] ?>"><?php echo $res[$i]['nome'] ?></option>
										<?php } } ?>
									</select>							
								</div>

							</div>

							<br>
							<input type="hidden" name="cargo" id="cargo" value="3">
							<input type="hidden" name="id" id="id"> 
							<small><div id="mensagem" align="center" class="mt-3"></div></small>

							<div class="modal-footer">
								<button id="btn-enviar" type="submit" class="btn btn-primary">Enviar</button>
							</div>					

						</div>






					</form>

				</div>
			</div>
		</div>





		<!-- Modal -->
		<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content">
					<div class="modal-header bg-primary text-white">
						<h5 class="modal-title" id="exampleModalLabel">Recuperar Senha</h5>
						<button aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button"><span aria-hidden="true" class="text-white">&times;</span></button>

					</div>
					<form method="post" id="form-recuperar">
						<div class="modal-body">
							<label for="recipient-name" class="col-form-label">Email:</label>
							<input placeholder="Digite seu Email" class="form-control" type="email" name="email" id="email-recuperar" required>        	

							<br>
							<small><div id="mensagem-recuperar" align="center"></div></small>
						</div>
						<div class="modal-footer">  
							<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>    
							<button type="submit" class="btn btn-primary">Recuperar Senha</button>
						</div>
					</form>
				</div>
			</div>
		</div>


		<form action="autenticar.php" method="post" style="display:none">
			<input type="text" name="id" id="id_usua">
			<button type="submit" id="btn_auto"></button>
		</form>


		<script src="assets/plugins/jquery/jquery.min.js"></script>
		<script src="assets/plugins/bootstrap/js/popper.min.js"></script>
		<script src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>
		<script src="assets/plugins/moment/moment.js"></script>
		<script src="assets/js/eva-icons.min.js"></script>        
		<script src="assets/plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>
		<script src="assets/js/themecolor.js"></script>
		<script src="assets/js/custom.js"></script>

		<!-- Mascaras JS -->
		<script type="text/javascript" src="painel/js/mascaras.js"></script>

		<!-- Ajax para funcionar Mascaras JS -->
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.11/jquery.mask.min.js"></script> 

		<script type="text/javascript">
			$(document).ready(function() {

				var email_usuario = localStorage.email_usu;
				var senha_usuario = localStorage.senha_usu;
				var id_usuario = localStorage.id_usu;
				var redirecionar = "<?=$entrar_automatico?>";

				if(id_usuario != "" && id_usuario != undefined && redirecionar == 'Sim'){
					$('#pagina').hide();
					$('#id_usua').val(id_usuario);
					$('#btn_auto').click();
				}else{
					$('#pagina').show();
				}

				if(email_usuario != "" && email_usuario != undefined){
					$('#salvar_acesso').prop('checked', true);
				}else{
					$('#salvar_acesso').prop('checked', false);
				}

				$('#usuario').val(email_usuario);
				$('#password-field').val(senha_usuario);

			});
		</script>


		<script>
			$(".toggle-password").click(function() {

				$(this).toggleClass("fa-eye fa-eye-slash");
				var input = $($(this).attr("toggle"));
				if (input.attr("type") == "password") {
					input.attr("type", "text");
				} else {
					input.attr("type", "password");
				}
			});
		</script>


		<script type="text/javascript">
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
		</script>


		<script type="text/javascript">
			$("#form-recuperar").submit(function () {

				$('#mensagem-recuperar').text('Enviando!!');

				event.preventDefault();
				var formData = new FormData(this);

				$.ajax({
					url: "recuperar-senha.php",
					type: 'POST',
					data: formData,

					success: function (mensagem) {
						$('#mensagem-recuperar').text('');
						$('#mensagem-recuperar').removeClass()
						if (mensagem.trim() == "Recuperado com Sucesso") {

							$('#email-recuperar').val('');
							$('#mensagem-recuperar').addClass('text-success')
							$('#mensagem-recuperar').text('Sua Senha foi enviada para o Email')			

						} else {

							$('#mensagem-recuperar').addClass('text-danger')
							$('#mensagem-recuperar').text(mensagem)
						}


					},

					cache: false,
					contentType: false,
					processData: false,

				});

			});
		</script>


		<script type="text/javascript">
			$("#form-precadastro").submit(function () {

				event.preventDefault();
				var formData = new FormData(this);

				$.ajax({
					url: "precadastro.php",
					type: 'POST',
					data: formData,

					success: function (mensagem) {

						$('#mensagem').removeClass()
						$('#mensagem').addClass('text-info')
						$('#mensagem').text("Enviando!!")

						if(mensagem.trim() === 'Realizado com sucesso, aguardar confirmação do CSE!'){

							$('#mensagem').addClass('text-success')                       

							$('#email').val('');                      

							$('#mensagem').text(mensagem);
							$('#target').attr("src", "painel/images/perfil/sem-foto.jpg");
							$('#nome').val('');
							$('#cpf').val('');
							$('#data_nasc').val('');
							$('#endereco').val('');
							$('#email').val('');
							$('#telefone').val('');
							$('#nivel').val('');
							$('#lotado').val('');
							$('#btn-enviar').hide();
                        //$('#btn-fechar-cadastro').click();
                        //location.reload();

                    } else {

                    	$('#mensagem').addClass('text-danger')
                    	$('#mensagem').text(mensagem)

                    }


                },

                cache: false,
                contentType: false,
                processData: false,

            });

			});
		</script>