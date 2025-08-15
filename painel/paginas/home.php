<?php 
$pag = 'home';

//total clientes
$query = $pdo->query("SELECT * from contemplados");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_contemplados = @count($res);

//total clientes mes
$query = $pdo->query("SELECT * from contemplados where dt_contemplado >= '$data_inicio_mes' and dt_contemplado <= '$data_final_mes'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_contemplados_mes = @count($res);


$empresas_cad = 0;
$empresas_cad_mes = 0;
$query = $pdo->query("SELECT * from clientes");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$empresas_cad = @count($res);

//total empresa mes
$query = $pdo->query("SELECT * from clientes where data_cad >= '$data_inicio_mes' and data_cad <= '$data_final_mes'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$empresas_cad_mes = @count($res);


$total_parecer_mes = 0;
$query = $pdo->query("SELECT * from parecer where data_cad >= '$data_inicio_mes' and data_cad <= '$data_final_mes'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_parecer_mes = @count($res);

$total_parecer = 0;
$query = $pdo->query("SELECT * from parecer");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_parecer = @count($res);


$total_fiscal = 0;
$total_fiscal_ativo = 0;
$query = $pdo->query("SELECT * from usuarios where nivel = 'Fiscal'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_fiscal = @count($res);


$query = $pdo->query("SELECT * from usuarios where nivel = 'Fiscal' AND ativo = 'Sim'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_fiscal_ativo = @count($res);


//verificar se ele tem a permissão de estar nessa página
	if(@$home == 'ocultar'){
		echo "<script>window.location='../index.php'</script>";
		exit();
	}
	?>


	<div class="mt-4 justify-content-between">
						
		<div class="row mb-2 m-2">
			<div class="col-xl-3 col-lg-3 col-md-6 col-6" style="padding:5px">
				<div style="padding:6px; background: #f5f5f5">
					<a class="" href="contemplados"><p class="mb-1">Pessoas Contempladas</p></a>
					<h5 class="mb-1"><?php echo $total_contemplados ?></h5>
					<p class="tx-11 text-muted">Este Mês<span class="text-success ms-2"><i class="fa fa-caret-up me-2"></i><span class="badge bg-success text-white tx-11"><?php echo $total_contemplados_mes ?></span></span></p>
				</div>
			</div>
			<div class="col-xl-3 col-lg-3 col-md-6 col-6" style="padding:5px">
				<div style="padding:6px; background: #f5f5f5">
					<a class="" href="empresas"><p class=" mb-1">Empresas Cadastras</p></a>
					<h5 class="mb-1"><?php echo $empresas_cad ?></h5>
					<p class="tx-11 text-muted">Este Mês<span class="text-danger ms-2"><i class="fa fa-caret-down me-2"></i><span class="badge bg-danger text-white tx-11"><?php echo $empresas_cad_mes ?></span></span></p>
				</div>
			</div>
			<div class="col-xl-3 col-lg-3 col-md-6 col-6" style="padding:5px">
				<div style="padding:6px; background: #f5f5f5">
					<a class="" href="parecer"><p class=" mb-1">Parecer Realizado</p></a>
					<h5 class="mb-1"><?php echo $total_parecer ?></h5>
					<p class="tx-11 text-muted">Este Mês<span class="text-warning ms-2"><i class="fa fa-caret-up me-2"></i><span class="badge bg-warning text-white tx-11"><?php echo $total_parecer_mes ?></span></span></p>
				</div>
			</div>
			<div class="col-xl-3 col-lg-3 col-md-6 col-6" style="padding:5px">
				<div style="padding:6px; background: #f5f5f5">
					<a class="" href="#"><p class=" mb-1">Fiscais</p></a>
					<h5 class="mb-1 <?php echo $classe_saldo ?>"><?php echo $total_fiscal ?></h5>
					<p class="tx-11 text-muted">Ativos<span class="text-success ms-2"><i class="fa fa-caret-up me-2"></i><span class="badge bg-success text-white tx-11"><?php echo $total_fiscal_ativo ?></span></span></p>
				</div>
			</div>
		</div>
		<div id="statistics2"></div>
						
					

		


	</div>	




	<div class="row">
		<div class="col-xl-6 col-lg-12 col-md-6 col-xs-12">
			<div class="card sales-card">
				<div class="row">
					<div class="col-8">
						<div class="ps-4 pt-4 pe-3 pb-4">
							<div class="">
								<h6 class="mb-2 tx-12 ">Obras Finalizadas</h6>
							</div>
							<div class="pb-0 mt-0">
								<div class="d-flex">
									<h4 class="tx-20 font-weight-semibold mb-2">54</h4>
								</div>
								<p class="mb-0 tx-12 text-muted">Contagem<i class="fa fa-caret-up mx-2 text-success"></i>
									<span class="text-success font-weight-semibold"> +</span>
								</p>
							</div>
						</div>
					</div>
					<div class="col-4">
						<div class="circle-icon bg-primary-transparent text-center align-self-center overflow-hidden">
							<i class="fe fe-shopping-bag tx-16 text-primary"></i>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-xl-6 col-lg-12 col-md-6 col-xs-12">
			<div class="card sales-card">
				<div class="row">
					<div class="col-8">
						<div class="ps-4 pt-4 pe-3 pb-4">
							<div class="">
								<h6 class="mb-2 tx-12">Obras Atrasadas</h6>
							</div>
							<div class="pb-0 mt-0">
								<div class="d-flex">
									<h4 class="tx-20 font-weight-semibold mb-2">09</h4>
								</div>
								<p class="mb-0 tx-12 text-muted">Contagem<i class="fa fa-caret-down mx-2 text-danger"></i>
									<span class="font-weight-semibold text-danger"> -</span>
								</p>
							</div>
						</div>
					</div>
					<div class="col-4">
						<div class="circle-icon bg-info-transparent text-center align-self-center overflow-hidden">
							<i class="fe fe-eye tx-16 text-info"></i>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-xl-6 col-lg-12 col-md-6 col-xs-12">
			<div class="card sales-card">
				<div class="row">
					<div class="col-8">
						<div class="ps-4 pt-4 pe-3 pb-4">
							<div class="">
								<h6 class="mb-2 tx-12">Obras em Andamento</h6>
							</div>
							<div class="pb-0 mt-0">
								<div class="d-flex">
									<h4 class="tx-20 font-weight-semibold mb-2">94</h4>
								</div>
								<p class="mb-0 tx-12 text-muted">Contagem<i class="fa fa-caret-up mx-2 text-success"></i>
									<span class=" text-success font-weight-semibold"> + </span>
								</p>
							</div>
						</div>
					</div>
					<div class="col-4">
						<div class="circle-icon bg-secondary-transparent text-center align-self-center overflow-hidden">
							<i class="fe fe-external-link tx-16 text-secondary"></i>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-xl-6 col-lg-12 col-md-6 col-xs-12">
			<div class="card sales-card">
				<div class="row">
					<div class="col-8">
						<div class="ps-4 pt-4 pe-3 pb-4">
							<div class="">
								<h6 class="mb-2 tx-12">Obras em Aguardo</h6>
							</div>
							<div class="pb-0 mt-0">
								<div class="d-flex">
									<h4 class="tx-22 font-weight-semibold mb-2">57</h4>
								</div>
								<p class="mb-0 tx-12  text-muted">Contagem<i class="fa fa-caret-down mx-2 text-danger"></i>
									<span class="text-danger font-weight-semibold"> - </span>
								</p>
							</div>
						</div>
					</div>
					<div class="col-4">
						<div class="circle-icon bg-warning-transparent text-center align-self-center overflow-hidden">
							<i class="fe fe-credit-card tx-16 text-warning"></i>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>





	<div class="row row-sm">
		<div class="col-sm-12 col-lg-12 col-xl-12 col-xxl-12">
			<div class="card">
				<div class="card-header pb-3">
					<h3 class="card-title mb-2">Evolução de Obras Concluídas</h3>
				</div>
				<div class="card-body p-0 customers mt-1">
					<div class="country-card pt-0">
						<div class="mb-4">
							<div class="d-flex">
								<span class="tx-13 font-weight-semibold">Empresa Imob Empreendimentos</span>
								<div class="ms-auto"><span class="text-danger mx-1"><i class="fe fe-trending-down"></i></span><span class="number-font">2.879</span> (65%)</div>
							</div>
							<div class="progress ht-8 br-5 mt-2">
								<div class="progress-bar progress-bar-striped progress-bar-animated bg-primary" style="width: 60%"></div>
							</div>
						</div>
						<div class="mb-4">
							<div class="d-flex mb-1">
								<span class="tx-13 font-weight-semibold">Engenharq Projetos e Construções</span>
								<div class="ms-auto"><span class="text-info mx-1"><i class="fe fe-trending-up"></i></span><span class="number-font">2.710</span> (55%)</div>
							</div>
							<div class="progress ht-8 br-5 mt-2">
								<div class="progress-bar progress-bar-striped progress-bar-animated bg-info" style="width: 50%"></div>
							</div>
						</div>
						<div class="mb-4">
							<div class="d-flex">
								<span class="tx-13 font-weight-semibold">Construtora Nova Estrutura</span>
								<div class="ms-auto"><span class="text-danger mx-1"><i class="fe fe-trending-down"></i></span><span class="number-font">1.229</span> (69%)</div>
							</div>
							<div class="progress ht-8 br-5 mt-2">
								<div class="progress-bar progress-bar-striped progress-bar-animated bg-secondary" style="width: 80%"></div>
							</div>
						</div>
						<div class="mb-4">
							<div class="d-flex">
								<span class="tx-13 font-weight-semibold">Prime Obras & Reformas</span>
								<div class="ms-auto"><span class="text-success mx-1"><i class="fe fe-trending-up"></i></span><span class="number-font">209</span> (5%)</div>
							</div>
							<div class="progress ht-8 br-5 mt-2">
								<div class="progress-bar progress-bar-striped progress-bar-animated bg-warning" style="width: 15%"></div>
							</div>
						</div>
						<div class="mb-4">
							<div class="d-flex">
								<span class="tx-13 font-weight-semibold">Construtora Pedra Firme</span>
								<div class="ms-auto"><span class="text-success mx-1"><i class="fe fe-trending-up"></i></span><span class="number-font">5.870</span> (86%)</div>
							</div>
							<div class="progress ht-8 br-5 mt-2">
								<div class="progress-bar progress-bar-striped progress-bar-animated bg-danger" style="width: 80%"></div>
							</div>
						</div>
						<div class="mb-4">
							<div class="d-flex">
								<span class="tx-13 font-weight-semibold">Edifica Brasil Engenharia</span>
								<div class="ms-auto"><span class="text-success mx-1"><i class="fe fe-trending-up"></i></span><span class="number-font">7.357</span> (73%)</div>
							</div>
							<div class="progress ht-8 br-5 mt-2">
								<div class="progress-bar progress-bar-striped progress-bar-animated bg-success" style="width: 70%"></div>
							</div>
						</div>
						<div class="mb-0">
							<div class="d-flex">
								<span class="tx-13 font-weight-semibold">Construtora Horizonte Azul</span>
								<div class="ms-auto"><span class="text-danger mx-1"><i class="fe fe-trending-down"></i></span><span class="number-font">4.291</span> (69%)</div>
							</div>
							<div class="progress ht-8 br-5 mt-2">
								<div class="progress-bar progress-bar-striped progress-bar-animated bg-purpple" style="width: 70%"></div>
							</div>
						</div>
					</div>

				</div>
			</div>
		</div>



		
	</div>