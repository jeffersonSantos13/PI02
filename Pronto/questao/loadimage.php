<?php 
	 	
	ini_set ('odbc.defaultlrl', 9000000);//muda configuração do PHP para trabalhar com imagens no DB

	if(isset($_FILES['flArquivo'])){

		if (isset($_GET['ecod'])) {
			
			if(	substr($_FILES['flArquivo']['type'], 0, 5) == 'image' &&
				$_FILES['flArquivo']['error'] == 0 &&
				($_FILES['flArquivo']['size'] > 0 && $_FILES['flArquivo']['size'] < 9000000)){
				//print_r($_FILES);
				$msg_sucesso = 'Arquivo recebido com sucesso';
				
				$file = fopen($_FILES['flArquivo']['tmp_name'],'rb');
				$fileParaDB = fread($file, filesize($_FILES['flArquivo']['tmp_name']));
				fclose($file);			

				$stmt = odbc_prepare($db,"UPDATE 
											 Imagem
											SET 
												tituloImagem = ?,   
												bitmapImagem = ?
											WHERE 
												codImagem = ( SELECT codImagem FROM Questao WHERE codQuestao = ".$_GET['ecod'].")");

				// $nomeimagem = $_FILES['flArquivo'];
				$nomeimagem = $_FILES['flArquivo']['name'];

				if(odbc_execute($stmt, array( $nomeimagem , $fileParaDB))){

					$codImagem = odbc_fetch_array($stmt);
					$atualizarImage = $codImagem['codImagem'];
					
					$msg .= '<br>Imagem atualizada no DB';					
				}else{
					$msg .= 'Erro ao atualizar a Imagem no DB.';
					$atualizarImage = 0;
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

		} else {

			if(	substr($_FILES['flArquivo']['type'], 0, 5) == 'image' &&
				$_FILES['flArquivo']['error'] == 0 &&
				($_FILES['flArquivo']['size'] > 0 && $_FILES['flArquivo']['size'] < 9000000)){

				$file = fopen($_FILES['flArquivo']['tmp_name'],'rb');
				$fileParaDB = fread($file, filesize($_FILES['flArquivo']['tmp_name']));
				fclose($file);
				
				$stmt = odbc_prepare($db,'INSERT INTO Imagem 
												(tituloImagem, bitmapImagem)
												output inserted.codImagem 
												VALUES 
												(?,?)');

				$nomeimagem = $_FILES['flArquivo']['name'];

				if(odbc_execute($stmt, array( $nomeimagem, $fileParaDB))){

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
	}


 ?>