@extends('adminlte::page')

@section('title', 'Gráfico')

@section('content_header')
  <h1>Gráfico</h1>  
@stop

@section('content')
  <div class="box">
    @include('includes.alertas')
    <div class="box-header">
      <form action="{{route('painel.graficoPeriodo')}}" 
            method="post" class="form form-inline"
            style="margin-bottom: 7px;">
            {!! csrf_field() !!}

        <input type="month" name="data" 
               class="form-control"
               style="margin-right: 5px;">      

        <button type="submit" class="btn btn-primary">
          Pesquisar
        </button>
      </form>      
    </div>
    @if(empty($dados))
      <p>sem Registro</p>
    @endif
  </div>
  <script type="text/javascript" 
          src="https://www.gstatic.com/charts/loader.js">
  </script>
  <script>
    google.charts.load("current", {packages:["corechart"]});
    google.charts.setOnLoadCallback(drawChart);
    
    function drawChart() {
      var data = google.visualization.arrayToDataTable([
        ['Nome', 'Valor'],  
        <?php
        foreach($dados as $key => $d):
          echo 
            "['". mb_strtoupper($d->nome) ."',". $d->valor ."],"; 
        endforeach;
        ?>          
      ]);

      var options = {
        title: 'GRÁFICO DE CONSUMO',
        is3D: true,
      };

      var chart = new google.visualization.PieChart(
        document.getElementById('piechart_3d'));
        chart.draw(data, options);
      }
    </script>
 <div class="container">
   <div id="piechart_3d" style="width: 900px; height: 700px;">
   </div>
 </div> 
@stop 
