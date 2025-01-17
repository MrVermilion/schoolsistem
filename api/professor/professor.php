<?php
require_once("../core/header.php");

function getDadosProfessor($codigoProfessorAlterar){
    $nome = "";
    $email = "";

    // VAI BUSCAR OS DADOS DE PROFESSORES.JSON
    $dadosProfessor = @file_get_contents("professores.json");

    // TRANSFORMAR EM ARRAY
    $arDadosProfessores = json_decode($dadosProfessor, true);

    $encontrouProfessor = false;
    foreach($arDadosProfessores as $aDados){
        $codigoAtual = $aDados["codigo"];
        if($codigoProfessorAlterar == $codigoAtual){
            $encontrouProfessor = true;
            $nome = $aDados["nome"];
            $email = $aDados["email"];

            // para a execução do loop
            break;
        }
    }

    return array($nome, $email, $encontrouProfessor);
}

// Verificar se existe ação
$codigo = "";
$nome = "";
$email = "";
$display = "block;";

$encontrouProfessor = false;
$mensagemProfessorNaoEncontrado = "";

$acaoFormulario = "INCLUIR";
if(isset($_GET["ACAO"])){
    $acao = $_GET["ACAO"];
    if($acao == "ALTERAR"){
        $acaoFormulario = "ALTERAR";

        $display = "none;";
        $codigo = $_GET["codigo"];
        list($nome, $email, $encontrouProfessor) = getDadosProfessor($codigo);

        if($encontrouProfessor){
            // Limpa a mensagem de erro
            $mensagemProfessorNaoEncontrado = "";
        } else {
            $mensagemProfessorNaoEncontrado = "Não foi encontrado nenhum Professor para o codigo informado! Código: ";
            // Adiciona o codigo do professor no fim
            $mensagemProfessorNaoEncontrado .= $codigo;
        }
    }
}

$sHTML = '<div> <link rel="stylesheet" href="../css/formulario.css">';

// FORMULARIO DE CADASTRO DE PROFESSORES
$sHTML .= '<h2 style="text-align:center;">Formulário de Professor</h2>
    <h3>' . $mensagemProfessorNaoEncontrado . '</h3>
    <form action="cadastrar_professor.php" method="POST">
        <input type="hidden" id="ACAO" name="ACAO" value="' . $acaoFormulario . '">

        <label for="codigo">Código:</label>
        <input type="hidden" id="codigo" name="codigo" value="' . $codigo . '" required>
        <input type="text" id="codigoTela" name="codigoTela" value="' . $codigo . '" disabled>

        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" required value="' . $nome . '">

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required value="' . $email . '">

        <div style="display:' . $display . ';">
            <label for="senha">Senha:</label>
            <input type="password" id="senha" name="senha" value="">
        </div>

        <input type="submit" value="Enviar">
    </form>';

// CONSULTA DE PROFESSOR
$sHTML .= '<h2 style="text-align:center;">Consulta de Professor</h2>
</div>';

echo $sHTML;

require_once("../core/footer.php");
