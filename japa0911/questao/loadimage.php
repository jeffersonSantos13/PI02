<?php 
	
			
// 			// Verificação de dados OK, nenhum erro ocorrido, executa então o upload... 
// 	} else { 
		
// 			// Pega extensão do arquivo 
			
// 			preg_match("/\.(gif|bmp|png|jpg|jpeg){1}$/i", $arquivo["name"], $ext); 
			
// 			// Gera um nome único para a imagem

// 			// $imagem_nome = md5(uniqid(time())) . "." . $ext[1]; 
			
// 			$nomeFinal = time().'.jpg';

// 			$arquivo


// 			// Inserir imagem 

// 			$imagem_prepare = odbc_prepare($db, 'INSERT INTO Imagem (tituloImagem, bitmapImagem) output INSERTED.codImagem values (?, ?) ');


// 			if($query = odbc_execute($imagem_prepare, array($imagem_nome, $arquivo["tmp_name"]))){		
// 				$msg = "Não foi possivel inserir a imagem";
// 			} 	
// 			// move_uploaded_file($arquivo["tmp_name"], $imagem_dir); 
// 	}
	 	
	ini_set ('odbc.defaultlrl', 9000000);//muda configuração do PHP para trabalhar com imagens no DB

	if(isset($_FILES['flArquivo'])){

		if(	substr($_FILES['flArquivo']['type'], 0, 5) == 'image' &&
			$_FILES['flArquivo']['error'] == 0 &&
			($_FILES['flArquivo']['size'] > 0 && $_FILES['flArquivo']['size'] < 9000000)){
			//print_r($_FILES);
			$msg_sucesso = 'Arquivo recebido com sucesso';
			
			$file = fopen($_FILES['flArquivo']['tmp_name'],'rb');
			$fileParaDB = fread($file, filesize($_FILES['flArquivo']['tmp_name']));
			fclose($file);
			
			$stmt = odbc_prepare($db,'INSERT INTO Imagem 
											(tituloImagem, bitmapImagem)
											output inserted.codImagem 
											VALUES 
											(?,?)');

			// $nomeimagem = $_FILES['flArquivo'];
			// Corrigir o nome da img depois 

			if(odbc_execute($stmt, array( 'Teste', $fileParaDB))){

				$codImagem = odbc_fetch_array($stmt);
				$inserirImage = $codImagem['codImagem'];
										
				$msg .= '<br>Imagem armazenada no DB';					
			}else{
				$msg .= 'Erro ao salvar a Imagem no DB.';
				$inserirImage = 0;
			}		
		} else{
			if($_FILES['flArquivo']['size'] > 9000000){
				$base = log($_FILES['flArquivo']['size']) / log(1024);
				$sufixo = array("", "K", "M", "G", "T");
				$tam_em_mb = round(pow(1024, $base - floor($base)),2).$sufixo[floor($base)];
				$msg_erro = 'Tamanho m&aacute;ximo de imagem 9 Mb. Tamanho da imagem enviada: '.$tam_em_mb;
			} else{
				$msg_erro = 'S&oacute; s&atilde;o aceitos arquivos de imagem. Tamanho da imagem: '.$_FILES['flArquivo']['size'];
			}
		}
	}


 ?>