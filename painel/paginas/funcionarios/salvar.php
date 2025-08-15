<?php 
$tabela = 'usuarios';
require_once("../../../conexao.php");

$lotado = $_POST['lotado'];
$nome = $_POST['nome'];
$email = $_POST['email'];
$telefone = $_POST['telefone'];
$nivel = $_POST['nivel'];
$endereco = $_POST['endereco'];
$senha = '123';
$senha_crip = sha1($senha);
$cpf = $_POST['cpf'];
$id = $_POST['id'];

//validacao email
$query = $pdo->query("SELECT * from $tabela where email = '$email'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$id_reg = @$res[0]['id'];
if(@count($res) > 0 and $id != $id_reg){
	echo 'Email já Cadastrado!';
	exit();
}

//validacao telefone
$query = $pdo->query("SELECT * from $tabela where telefone = '$telefone'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$id_reg = @$res[0]['id'];
if(@count($res) > 0 and $id != $id_reg){
	echo 'Telefone já Cadastrado!';
	exit();
}

//validar troca da foto
$query = $pdo->query("SELECT * FROM $tabela where id = '$id'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if ($total_reg > 0) {
	$foto = $res[0]['foto'];
} else {
	$foto = 'sem-foto.jpg';
}

//SCRIPT PARA SUBIR FOTO NO SERVIDOR
$nome_img = date('d-m-Y H:i:s') . '-' . @$_FILES['foto']['name'];
$nome_img = preg_replace('/[ :]+/', '-', $nome_img);
$caminho = '../../images/perfil/' . $nome_img;
$imagem_temp = @$_FILES['foto']['tmp_name'];

if (@$_FILES['foto']['name'] != "") {
	$ext = pathinfo($nome_img, PATHINFO_EXTENSION);
	if ($ext == 'png' or $ext == 'jpg' or $ext == 'jpeg' or $ext == 'gif' or $ext == 'PNG' or $ext == 'JPG' or $ext == 'JPEG' or $ext == 'GIF') {

		//EXCLUO A FOTO ANTERIOR
		if ($foto != "sem-foto.jpg") {
			@unlink('../../images/perfil/' . $foto);
		}

		$foto = $nome_img;

		//pegar o tamanho da imagem
		list($largura, $altura) = getimagesize($imagem_temp);
		if ($largura > 1400) {
			if ($ext == 'png') {
				$image = imagecreatefrompng($imagem_temp);
			} else if ($ext == 'jpeg' or $ext == 'jpg') {
				$image = imagecreatefromjpeg($imagem_temp);
			} else {
				die("Formato de imagem não suportado.");
			}

			// Reduza a qualidade para 20% ajuste conforme necessário
			imagejpeg($image, $caminho, 20);
			imagedestroy($image);

		} else {
			move_uploaded_file($imagem_temp, $caminho);
		}

	} else {
		echo 'Extensão de Imagem não permitida!';
		exit();
	}
}


if($id == ""){
$query = $pdo->prepare("INSERT INTO $tabela SET nome = :nome, email = :email, senha = '', senha_crip = '$senha_crip', nivel = '$nivel', ativo = 'Sim', foto = '$foto', telefone = :telefone, data = curDate(), endereco = :endereco, cpf = :cpf, lotado = '$lotado' ");
	$query->bindValue(":nome", "$nome");
	$query->bindValue(":email", "$email");
	$query->bindValue(":telefone", "$telefone");
	$query->bindValue(":endereco", "$endereco");
	$query->bindValue(":cpf", "$cpf");
	$query->execute();
	$ult_id = $pdo->lastInsertId();//esse ID recupera na linha 117

}else{
	$query = $pdo->prepare("UPDATE $tabela SET nome = :nome, email = :email, nivel = '$nivel', telefone = :telefone, endereco = :endereco, cpf = :cpf, foto = '$foto', lotado = '$lotado' where id = '$id'");
	$query->bindValue(":nome", "$nome");
	$query->bindValue(":email", "$email");
	$query->bindValue(":telefone", "$telefone");
	$query->bindValue(":endereco", "$endereco");
	$query->bindValue(":cpf", "$cpf");
	$query->execute();

}


echo 'Salvo com Sucesso';


 ?>
