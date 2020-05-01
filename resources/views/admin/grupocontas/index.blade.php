@extends('adminlte::page')

@section('title', 'Grupo Contas')

@section('content_header')
  <h1>Cadastro->Grupo de Contas</h1>  
@stop

@section('content')
  <div class="box">    
    <div class="container">
      @include('includes.alertas')
      <form action="{{route('grupocontas.store')}}" method="post">
        {!! csrf_field() !!}
        
        <div class="form-group">
          <label for="name">Nome</label>
          <input type="text" name="nome" 
                 placeholder="Descrição do Grupo de Contas" 
                 class="form-control">
        </div>        

        <div class="form-group">
          <label for="tipo">Tipo</label>
          <select name="tipo" class="form-control">
            <option value="Despesa">Despesa</option>
            <option value="Receita">Receita</option>
          </select>
        </div> 

        <div class="form-group">
          <label for="classificacao">Classificação</label>
          <select name="classificacao" class="form-control">
            <option value="Consumo">Consumo</option>
            <option value="Diversão">Diversão</option>
            <option value="Cursos">Cursos</option>
            <option value="Lucro">Lucro</option>     
          </select>
        </div>             

        <div>
          <button type="submit" class="btn btn-info">Gravar
          </button>
        </div>
    </form>
  </div>    
@stop 
