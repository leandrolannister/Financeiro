@extends('adminlte::page')

@section('title', 'Tesouro')

@section('content_header')
  <h1>Cadastro->Tesouro</h1>  
@stop

@section('content')
  <div class="box">    
    <div class="container">
      @include('includes.alertas')
      <form action="{{route('tesouro.store')}}" method="post">
        {!! csrf_field() !!}
        
        <div class="form-group">
          <label for="nome">Nome</label>
          <input type="text" name="nome" class="form-control"
                 placeholder="Descrição do Papel">                 
        </div>        

        <div class="form-group">
          <label for="compra">Compra</label>
          <input type="number" name="compra" class="form-control"
                  step="0.01" placeholder="Preço de compra">
        </div>

        <div class="form-group">
          <label for="venda">Venda</label>
          <input type="number" name="venda" class="form-control"
                  step="0.01" placeholder="Preço de Venda">
        </div>        

        <div class="form-group">
          <label for="dt_compra">Data Compra</label>
          <input type="date" name="dt_compra" class="form-control">
        </div>

        <div class="form-group">
          <select name="tipo" class="form-control">
            <option value="Reserva">Reserva</option>
            <option value="Curso">Curso</option>
            <option value="Bens">Bens</option>
            <option value="Aposentadoria">Aposentadoria</option>  
          </select>
        </div>

        <div>
          <button type="submit" class="btn btn-info">Salvar
          </button>
        </div>
    </form>
  </div>    
@stop 
