<?php

function getAcaoExcluirTurma($codigo){
    $sHTML = "<a id='acaoExcluir' href='http://localhost/sistemaescolar/api/turma/cadastrar_turma.php?ACAO=EXCLUIR&codigo=" . $codigo . "'>Excluir</a>";
    return $sHTML;
}

function getAcaoAlterarTurma($codigo){
    $sHTML = "<a id='acaoAlterar' href='http://localhost/sistemaescolar/api/turma/cadastrar_turma.php?ACAO=ALTERAR&codigo=" . $codigo . "'>Alterar</a>";
    return $sHTML;
}

require_once("../core/header.php");

echo '<h3 class="custom-text">CONSULTA DE TURMA</h3>';

$htmlTabelaTurmas = "<a href='turma.php'><button class='button' type='button'>Incluir<button></a>";
$htmlTabelaTurmas .= "<table border='1'>";

// HEADER DA TABLE
$htmlTabelaTurmas .= "<head>";

// TITULOS DA TABLE
$htmlTabelaTurmas .= "<tr>";
$htmlTabelaTurmas .= "  <th>Código</th>";
$htmlTabelaTurmas .= "  <th>Escola</th>";// Nome da Escola - buscar pelo codigo
$htmlTabelaTurmas .= "  <th>Nome</th>";
$htmlTabelaTurmas .= "  <th>Data Início</th>";
$htmlTabelaTurmas .= "  <th>Data Fim</th>";
$htmlTabelaTurmas .= "  <th>Status</th>";
$htmlTabelaTurmas .= "  <th>Período</th>";
$htmlTabelaTurmas .= "  <th colspan='2'>Ações</th>";
$htmlTabelaTurmas .= "</tr>";

$htmlTabelaTurmas .= "</head>";
$htmlTabelaTurmas .= "<tbody>";

// Inicializa a variável como um array vazio
$arDadosTurmas = array();

$dadosTurmas = @file_get_contents("turmas.json");
if($dadosTurmas){
    $arDadosTurmas = json_decode($dadosTurmas, true);

     // Se a decodificação falhar, inicializa como array vazio
     if (!is_array($arDadosTurmas)) { //!is_array verifica se a variável não é um array
        $arDadosTurmas = array();
    }
}

foreach($arDadosTurmas as $aDados){
    // ABRIR UMA NOVA LINHA
    $htmlTabelaTurmas .= "<tr>";
    $htmlTabelaTurmas .= "<td align='center'>" .(isset($aDados["codigo"]) ? $aDados ["codigo"] : 'Não existem dados') . "</td>";

    $nomeEscola = "ESCOLA TESTES"; // Funcao - Buscar pelo codigo, que nem a cidade em Escola

    $htmlTabelaTurmas .= "<td>" . $nomeEscola . "</td>";

    $htmlTabelaTurmas .= "<td>" . (isset($aDados["nome"]) ? $aDados ["nome"] :'Não existem dados') . "</td>";
    $htmlTabelaTurmas .= "<td>" . (isset($aDados["datainicio"]) ? $aDados ["datainicio"] :'Não existem dados') . "</td>";
    $htmlTabelaTurmas .= "<td>" . (isset($aDados["datafim"]) ? $aDados ["datafim"] :'Não existem dados') . "</td>";
    $htmlTabelaTurmas .= "<td>" . (isset($aDados["status"]) ? $aDados ["status"] :'Não existem dados') . "</td>";
    $htmlTabelaTurmas .= "<td>" . (isset($aDados["periodo"]) ? $aDados ["periodo"] :'Não existem dados') . "</td>";

    // Adiciona a ação de excluir aluno
    $codigo = (isset($aDados["codigo"]) ? $aDados["codigo"] : 'Não existem dados');

    $htmlTabelaTurmas .= '<td>';
    $htmlTabelaTurmas .= getAcaoExcluirTurma($codigo);
    $htmlTabelaTurmas .= '</td>';

    $htmlTabelaTurmas .= '<td>';
    $htmlTabelaTurmas .= getAcaoAlterarTurma($codigo);
    $htmlTabelaTurmas .= '</td>';

    // FECHAR A LINHA ATUAL
    $htmlTabelaTurmas .= "</tr>";
}

$htmlTabelaTurmas .= "</tbody>";
$htmlTabelaTurmas .= "</table>";

echo $htmlTabelaTurmas;

require_once("../core/footer.php");