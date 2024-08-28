<?php

// Pega a URL atual que está sendo acessada
$request_uri = $_SERVER['REQUEST_URI'];

// Inicializa as variáveis que vamos usar para os caminhos
$url_inicial = "";
$url_inicial_css = "/sistemaescolar/api/";

// Verifica se a URL atual contém "/sistemaescolar/api/"
if (strpos($request_uri, "/sistemaescolar/api/") !== false) {
    // Se sim, define os caminhos para incluir "api/"
    $url_inicial_css = "/sistemaescolar/api/";
    $url_inicial = "api/";
}

// Imprime o HTML do cabeçalho
echo '
<!DOCTYPE html>
<html lang="pt-br">
    <head>
          <meta charset="UTF-8">
          <title>Sistema Escolar</title>
          <!-- Link para o arquivo de estilo CSS -->
          <link rel="stylesheet" href="' . $url_inicial_css . 'css/style.css">
          <link rel="stylesheet" href="' . $url_inicial_css . 'css/button.css">
          <link rel="stylesheet" href="' . $url_inicial_css . 'css/header.css">
          <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap">
          <link href="https://fonts.googleapis.com/css2?family=Nothing+You+Could+Do&display=swap" rel="stylesheet">

    </head>
<body class="background-06">
    <div class="header">
        <ul>
            <!-- Links para as páginas do sistema -->
            <li><a href="/sistemaescolar/' . $url_inicial . 'index.php">Home</a></li>
            <li><a href="/sistemaescolar/' . $url_inicial . 'aluno/consulta_aluno.php">Alunos</a></li>
            <li><a href="/sistemaescolar/' . $url_inicial . 'turma/consulta_turma.php">Turma</a></li>
            <li><a href="/sistemaescolar/' . $url_inicial . 'professor/consulta_professor.php">Professor</a></li>
            <li><a href="/sistemaescolar/' . $url_inicial . 'escola/consulta_escola.php">Escola</a></li>
            <li><a href="/sistemaescolar/' . $url_inicial . 'geradorboletim/index.html">Gerador Boletim</a></li>
        </ul>
        <hr>
    </div>

    <div class="container">'; // abre o container
?>
