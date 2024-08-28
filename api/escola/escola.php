<?php
// Inclui o arquivo de cabeçalho do site
require_once("../core/header.php");

// Função para obter os dados da escola a partir de um código
function getDadosEscola($codigoAlterar){
    // Inicializa variáveis para armazenar os dados da escola
    $descricao = "";
    $cidade = "";

    // Tenta ler o conteúdo do arquivo JSON com os dados das escolas
    $dados = file_get_contents("escola.json");
    if ($dados === false) {
        die("Erro ao ler o arquivo escola.json");
    }

    // Converte o conteúdo JSON em um array associativo
    $arDados = json_decode($dados, true);

    // Inicializa variáveis para os tipos de ensino
    $tipo_ensino_creche = "";
    $tipo_ensino_basico = "";
    $tipo_ensino_fundamental = "";    
    $tipo_ensino_medio = "";
    $tipo_ensino_profissional = "";
    $tipo_ensino_tecnico = "";
    $tipo_ensino_superior = "";

    // Flag para verificar se a escola foi encontrada
    $encontrouEscola = false;

    // Percorre os dados das escolas para encontrar a escola com o código especificado
    foreach($arDados as $aDados){
        $codigoAtual = $aDados["codigo"];
        if($codigoAlterar == $codigoAtual){
            // Define a flag para verdadeiro
            $encontrouEscola = true;

            // Obtém os dados da escola
            $descricao = $aDados["descricao"];
            $cidade = $aDados["cidade"];
            
            // Define as variáveis dos tipos de ensino baseadas nos dados
            if($aDados["tipo_ensino_creche"] == 1){
                $tipo_ensino_creche = " checked ";
            }
            if($aDados["tipo_ensino_basico"] == 1){
                $tipo_ensino_basico = " checked ";
            }
            if($aDados["tipo_ensino_fundamental"] == 1){
                $tipo_ensino_fundamental = " checked ";
            }
            if($aDados["tipo_ensino_medio"] == 1){
                $tipo_ensino_medio = " checked ";
            }
            if($aDados["tipo_ensino_profissional"] == 1){
                $tipo_ensino_profissional = " checked ";
            }
            if($aDados["tipo_ensino_tecnico"] == 1){
                $tipo_ensino_tecnico = " checked ";
            }
            if($aDados["tipo_ensino_superior"] == 1){
                $tipo_ensino_superior = " checked ";
            }

            // Sai do loop assim que a escola é encontrada
            break;
        }
    }

    // Retorna os dados da escola encontrados
    return array(
        $descricao,
        $cidade,
        $tipo_ensino_creche,
        $tipo_ensino_basico,
        $tipo_ensino_fundamental,
        $tipo_ensino_medio,
        $tipo_ensino_profissional,
        $tipo_ensino_tecnico,
        $tipo_ensino_superior,
        $encontrouEscola
    );
}

// Inicializa variáveis para o formulário
$codigo = "";
$descricao = "";
$cidade = "";

// Inicializa variáveis para os tipos de ensino
$tipo_ensino_creche = "";
$tipo_ensino_basico = "";
$tipo_ensino_fundamental = "";
$tipo_ensino_medio = "";
$tipo_ensino_profissional = "";
$tipo_ensino_tecnico = "";
$tipo_ensino_superior = "";

// Inicializa variáveis para as opções de cidade no formulário
$selected_1 = "";
$selected_2 = "";
$selected_3 = "";
$selected_4 = "";
$selected_5 = "";
$selected_6 = "";

// Mensagem padrão caso a escola não seja encontrada
$mensagemEscolaNaoEncontrada = "";

// Define a ação padrão do formulário como "INCLUIR"
$acaoFormulario = "INCLUIR";

// Verifica se o parâmetro "ACAO" está presente na URL
if(isset($_GET["ACAO"])){
    $acao = $_GET["ACAO"];  // Atribui o valor do parâmetro "ACAO" à variável $acao
    if($acao == "ALTERAR"){
        // Se a ação for "ALTERAR", ajusta o formulário para alterar uma escola existente
        $acaoFormulario = "ALTERAR";

        $codigo = $_GET["codigo"]; // Obtém o código da escola a ser alterada
        list(
            $descricao,
            $cidade,
            $tipo_ensino_creche,
            $tipo_ensino_basico,
            $tipo_ensino_fundamental,
            $tipo_ensino_medio,
            $tipo_ensino_profissional,
            $tipo_ensino_tecnico,
            $tipo_ensino_superior,
            $encontrouEscola
        ) = getDadosEscola($codigo); // Obtém os dados da escola para o código especificado

        // Define a seleção da cidade com base nos dados
        switch($cidade){
            case 1:
                $selected_1 = " selected ";
                break;
            case 2:
                $selected_2 = " selected ";
                break;
            case 3:
                $selected_3 = " selected ";
                break;
            case 4:
                $selected_4 = " selected ";
                break;
            case 5:
                $selected_5 = " selected ";
                break;
            case 6:
                $selected_6 = " selected ";
                break;
        }

        // Atualiza a mensagem de erro se a escola não for encontrada
        if($encontrouEscola){
            $mensagemEscolaNaoEncontrada = "";
        } else {
            $mensagemEscolaNaoEncontrada = "Não foi encontrado nenhuma escola para o código informado! Código: ";
            $mensagemEscolaNaoEncontrada .= $codigo;
        }
    }
}

// Monta o HTML do formulário
$sHTML = '<div> <link rel="stylesheet" href="../css/formulario.css">';

// Adiciona o título do formulário e a mensagem de erro, se houver
$sHTML .= '<h2 style="text-align:center;">Formulário de Escola</h2>
    <h3>' . $mensagemEscolaNaoEncontrada . '</h3>
    <form action="cadastrar_escola.php" method="POST">
        <input type="hidden" id="ACAO" name="ACAO" value="' . $acaoFormulario . '">'; // Define a ação do formulário

// Adiciona o campo de código (oculto e visível)
$sHTML .= '<label for="codigo">Código:</label>
        <input type="hidden" id="codigo" name="codigo" value="' . $codigo . '" required>
        <input type="text" id="codigoTela" name="codigoTela" value="' . $codigo . '" disabled>';

// Adiciona o campo de descrição
$sHTML .= '<label for="descricao">Descrição:</label>
        <input type="text" id="descricao" name="descricao" required value="' . $descricao . '">';

// Adiciona o campo de cidade com as opções
$sHTML .= '<label for="cidade">Cidade:</label>
        <select id="cidade" name="cidade">
            <option value="1" ' . $selected_1 . '>Rio do Sul</option>
            <option value="2" ' . $selected_2 . '>Ibirama</option>
            <option value="3" ' . $selected_3 . '>Ituporanga</option>
            <option value="4" ' . $selected_4 . '>Joinvile</option>
            <option value="5" ' . $selected_5 . '>Florianópolis</option>
            <option value="6" ' . $selected_6 . '>Blumenau</option>
        </select> 
        <br>      
        <br>';

// Adiciona os campos de tipo de ensino
$sHTML .= '<label for="">Tipo Ensino:</label>
        <div style="display:flex;width:85%;flex-wrap:wrap;">
            <label for="tipo_ensino_creche">Creche:</label>
            <input type="checkbox" id="tipo_ensino_creche" name="tipo_ensino_creche" ' . $tipo_ensino_creche . '>
            
            <label for="tipo_ensino_basico">Básico:</label>
            <input type="checkbox" id="tipo_ensino_basico" name="tipo_ensino_basico" ' . $tipo_ensino_basico . '>
            
            <label for="tipo_ensino_fundamental">Fundamental:</label>
            <input type="checkbox" id="tipo_ensino_fundamental" name="tipo_ensino_fundamental" ' . $tipo_ensino_fundamental . '>
                        
            <label for="tipo_ensino_medio">Médio:</label>
            <input type="checkbox" id="tipo_ensino_medio" name="tipo_ensino_medio" ' . $tipo_ensino_medio . '>
            
            <label for="tipo_ensino_profissional">Profissional:</label>
            <input type="checkbox" id="tipo_ensino_profissional" name="tipo_ensino_profissional" ' . $tipo_ensino_profissional . '>
            
            <label for="tipo_ensino_tecnico">Técnico:</label>
            <input type="checkbox" id="tipo_ensino_tecnico" name="tipo_ensino_tecnico" ' . $tipo_ensino_tecnico . '>

            <label for="tipo_ensino_superior">Superior:</label>
            <input type="checkbox" id="tipo_ensino_superior" name="tipo_ensino_superior" ' . $tipo_ensino_superior . '>
        </div>

        <br>      
        <br> 

        <input type="submit" value="Enviar">'; // Botão de envio do formulário

$sHTML .= '</div>';

// Exibe o HTML do formulário
echo $sHTML;

// Inclui o arquivo de rodapé do site
require_once("../core/footer.php");
?>
