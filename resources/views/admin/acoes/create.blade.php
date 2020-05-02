@extends('adminlte::page')

@section('title', 'Ações')

@section('content_header')
  <h1>Cadastro->Ações</h1>  
@stop

@section('content')
  <div class="box">    
    <div class="container">
      @include('includes.alertas')
      <form action="{{route('acoes.store')}}" method="post">
        {!! csrf_field() !!}
        
        <div class="form-group">
          <label for="name">Papel</label>
          <input type="text" name="papel" class="form-control"
                 placeholder="Descrição da Ação">                 
        </div>        

        <div class="form-group">
          <label for="preco">Preço</label>
          <input type="number" name="compra" class="form-control"
                  step="0.01" placeholder="Preço de compra">
        </div>

        <div class="form-group">
          <label for="quantidade">Quantidade</label>
          <input type="number" name="quantidade" class="form-control"
                 placeholder="Quantidade de compra">
        </div>

        <div class="form-group">
          <label for="dt_compra">Data Compra</label>
          <input type="date" name="dt_compra" class="form-control">
        </div>

        <div>
          <button type="submit" class="btn btn-info">Gravar
          </button>
        </div>
    </form>
  </div>    
@stop 
