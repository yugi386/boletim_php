<?php
//Importando biblioteca
require("images/phplot.php");

//instanciando classe
$grafico = new PHPlot(280,200);

//Indicamos o formato de imagem a ser usado
$grafico->SetFileFormat("png");
 
//Indicamos o título do gráfico e o título dos dados no eixo X e Y
$grafico->SetTitle("Disciplina: ".$_GET['nome']);
$grafico->SetXTitle("Avalia��es");
$grafico->SetYTitle("Notas");

// dados do gráfico
$dados = array(
 array("Prova1", $_GET['p1']),
 array("Prova2", $_GET['p2']),
 array("Atividade", $_GET['atividade']),
 array("M�dia",$_GET['media']),
 );

$grafico->SetDataValues($dados);

//Exibimos o gráfico
$grafico->DrawGraph();
?>