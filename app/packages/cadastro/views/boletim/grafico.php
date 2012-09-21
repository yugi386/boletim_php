<?php
//Importando biblioteca
require("images/phplot.php");

//instanciando classe
$grafico = new PHPlot(280,200);
// $grafico->SetPlotType('bars');  grafico de barras

//Indicamos o formato de imagem a ser usado
$grafico->SetFileFormat("png");
 
//Indicamos o tÃ­tulo do grÃ¡fico e o tÃ­tulo dos dados no eixo X e Y
$grafico->SetTitle("Disciplina: ".$_GET['nome']);
$grafico->SetXTitle("Avaliações");
$grafico->SetYTitle("Notas");

// dados do grÃ¡fico
$dados = array(
 array("Prova1", (float)$_GET['p1']),
 array("Prova2", (float)$_GET['p2']),
 array("Atividade", (float)$_GET['atividade']),
 array("Média",(float)$_GET['media']),
 );

$grafico->SetDataValues($dados);

//Exibimos o grÃ¡fico
$grafico->DrawGraph();
?>

<?php
/*
#incluindo a classe. verifique se diretorio e versao sao iguais, altere se precisar
include(‘phplot-5.0.4/phplot.php’);
#Matriz utilizada para gerar os graficos
$data = array(
  array(‘Jan‘, 20, 2, 4), array(‘Fev‘, 30, 3, 4), array(‘Mar‘, 20, 4, 14),
  array(‘Abr‘, 30, 5, 4), array(‘Mai‘, 13, 6, 4), array(‘Jun‘, 37, 7, 24),
  array(‘Jul‘, 10, 8, 4), array(‘Ago‘, 15, 9, 4), array(‘Set‘, 20, 5, 12),
  array(‘Out‘, 28, 4, 14), array(‘Nov‘, 16, 7, 14), array(‘Dez‘, 24, 3, 15),
);
#Instancia o objeto e setando o tamanho do grafico na tela
$plot = new PHPlot(800,600);
#Tipo de borda, consulte a documentacao
$plot->SetImageBorderType(‘plain‘);
#Tipo de grafico, nesse caso barras, existem diversos(pizza…)
$plot->SetPlotType(‘bars‘);
#Tipo de dados, nesse caso texto que esta no array
$plot->SetDataType(‘text-data‘);
#Setando os valores com os dados do array
$plot->SetDataValues($data);
#Titulo do grafico
$plot->SetTitle(‘Cadastro de usuários no Site‘);
#Legenda, nesse caso serao tres pq o array possui 3 valores que serao apresentados
$plot->SetLegend(array(‘Estudantes‘,’Colunistas‘, ‘Desenvolvedores‘));
#Utilizados p/ marcar labels, necessario mas nao se aplica neste ex. (manual) :
$plot->SetXTickLabelPos(‘none‘);
$plot->SetXTickPos(‘none‘);
#Gera o grafico na tela
$plot->DrawGraph();
*/
?>