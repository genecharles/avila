<?php
$tabela = 'usuarios';
require_once("conexao.php");

$nome = $_POST['nome'];
$cpf = $_POST['cpf'];
$data_nasc = $_POST['data_nasc'];
$endereco = $_POST['endereco'];
$email = $_POST['email'];
$telefone = $_POST['telefone'];
$nivel = $_POST['nivel'];
$lotado = $_POST['lotado'];
$senha = '1234@';
$senha_crip = sha1($senha);


//$obs = $_POST['obs'];
$id = $_POST['id'];

$cpf = str_replace('.', '', $cpf);
$cpf = str_replace('-', '', $cpf);



//validar cpf
$query = $pdo->query("SELECT * FROM $tabela where cpf = '$cpf'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if($total_reg > 0 and $res[0]['id'] != $id){
	echo 'CPF já Cadastrado, escolha Outro!';
	exit();
}

//validar email
$query = $pdo->query("SELECT * FROM $tabela where email = '$email'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if($total_reg > 0 and $res[0]['id'] != $id){
	echo 'Email já Cadastrado, escolha Outro!';
	exit();
}


$query = $pdo->query("SELECT * FROM $tabela where id = '$id'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if($total_reg > 0){
	$foto = $res[0]['foto'];
}else{
	$foto = 'sem-perfil.jpg';
}

//SCRIPT PARA SUBIR FOTO NO SERVIDOR
$nome_img = date('d-m-Y H:i:s') .'-'.@$_FILES['foto']['name'];
$nome_img = preg_replace('/[ :]+/' , '-' , $nome_img);
$caminho = 'painel/images/perfil/' .$nome_img;

$imagem_temp = @$_FILES['foto']['tmp_name']; 

if(@$_FILES['foto']['name'] != ""){
	$ext = pathinfo($nome_img, PATHINFO_EXTENSION);   
	if($ext == 'png' or $ext == 'jpg' or $ext == 'jpeg' or $ext == 'gif'){ 

		if (@$_FILES['foto']['name'] != ""){

			//EXCLUO A FOTO ANTERIOR
			if($foto != "sem-perfil.jpg"){
				@unlink('painel/images/perfil/'.$foto);
			}

			$foto = $nome_img;
		}

		move_uploaded_file($imagem_temp, $caminho);
	}else{
		echo 'Extensão de Imagem não permitida!';
		exit();
	}
}



//if($id == ""){
$query = $pdo->prepare("INSERT INTO $tabela SET nome = :nome, cpf = :cpf, dt_nasc = '$data_nasc', email = :email, senha = '$senha', senha_crip = '$senha_crip', nivel = '$nivel', ativo = 'Não', foto = '$foto', telefone = :telefone, data = curDate(), endereco = :endereco, lotado = '$lotado' ");

$query->bindValue(":nome", "$nome");
$query->bindValue(":cpf", "$cpf");
$query->bindValue(":telefone", "$telefone");
$query->bindValue(":email", "$email");
$query->bindValue(":endereco", "$endereco");

$query->execute();
$ult_id = $pdo->lastInsertId();

	
/*}else{
	$query = $pdo->prepare("UPDATE $tabela SET nome = :nome, cpf = :cpf, telefone = :telefone, email = :email, endereco = :endereco, cargo = 3, data_cad = curDate(), data_nasc ='$data_nasc', obs = '', foto = '$foto', ativo = 'Não' WHERE id = '$id'");

$query->bindValue(":nome", "$nome");
$query->bindValue(":cpf", "$cpf");
$query->bindValue(":telefone", "$telefone");
$query->bindValue(":email", "$email");
$query->bindValue(":endereco", "$endereco");

$query->execute();


}*/

echo 'Realizado com sucesso, aguardar confirmação do CSE!'; 

 ?>
