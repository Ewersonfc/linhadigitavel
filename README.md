# linhadigitavel
[![Latest Stable Version](https://poser.pugx.org/ewersonfc/linhadigitavel/v)](//packagist.org/packages/ewersonfc/linhadigitavel)
[![Latest Unstable Version](https://poser.pugx.org/ewersonfc/linhadigitavel/v/unstable)](//packagist.org/packages/ewersonfc/linhadigitavel)
[![Total Downloads](https://poser.pugx.org/ewersonfc/linhadigitavel/downloads)](//packagist.org/packages/ewersonfc/linhadigitavel)
[![License](https://poser.pugx.org/ewersonfc/linhadigitavel/license)](//packagist.org/packages/ewersonfc/linhadigitavel)

 
Esta biblioteca tem a finalidade de extrair a Linha Digitável de boletos **PDF 1.4 e 1.7** e Imagens. Em algumas situações especificas a mesma usa auxílio da API do OCR SPACE (https://ocr.space/ocrapi), fazendo assim necessária a Key da API para maior taxa de sucesso na Extração. 
    
 ## Instanciando a Classe
    $class = new LinhaDigitavel([
        'type' => TypeConstant::ELIMINATION, // required
        'apiKey' => 'xxxxxxx', // requred
        'production' => true, // Optional
        'tempFolder' => './PATH_TO_TEMP_FOLDER' // Optional
    ]);
    
 ## Parâmetros disponiveis
 ### type (Required) :
  Esse parâmetro é utilizado para definir a forma que será realizado o *Parse* do arquivo, sendo as opções disponiveis:
  - **'pdf'** : Realiza o parse diretamente na biblioteca, funcionando muito bem e rapido para arquivos PDF gerados através da Web ou programas.
  - **'img'** : É um pouco mais lento que a opção anterior por utilizar a *API* do OCR SPACE, mas em alguns casos, onde serão utilizadas imagens ou PDF's contendo boletos scanneados tem uma taxa maior de sucesso.
  - **'elimination'** : Tenta realizar o parse com o método *'pdf'* e **caso não consiga**, tenta utilizar o método *'img'*.
  - **'both'** : Realiza a extração com ambos métodos.
  
 ### *apiKey* (Required) :
 Chave de acesso da API do OCR SPACE (https://ocr.space/ocrapi) utilizada para o parser das Imagens
 
 ### *production* (Optional) :
 Este parâmetro é utilizado para controlar o uso da API Key
 
 ### *tempFolder* (Optional) :
 Durante o processo a biblioteca cria alguns arquivos temporários para controlar qual servidor da API será utilizado, esse parametro serve para controlarmos onde esses arquivos temporarios serão salvos.
 
## Extraindo a Linha Digitável
### Método
    $linhadigitavel = $class->convertArchive("https://[LINK_PARA_O_BOLETO].pdf");
    
### Response 
    Array
    (
        [html] => Array
            (
            )

        [img] => Array
            (
                [0] => Array
                    (
                        [0] => 200000000000000000000001020500000000000000000200
                    )
            )
    );

** Exemplo meramente ilustrativo
  
