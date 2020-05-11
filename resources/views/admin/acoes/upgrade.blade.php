@extends('adminlte::page')

@section('title', 'Ações')

@section('content_header')
  <h1>Atualização->Ações</h1>  
@stop

@section('content')
  <div class="box">    
    <div class="container">
      @include('includes.alertas')
      <form action="{{route('acoes.update')}}" method="post">
        {!! csrf_field() !!}
        @method('PUT')

        <input type="hidden" name="id" value="{{$acao->id}}">
        
        <div class="form-group">
          <label for="papel">Papel</label>
          <input type="text" name="papel" 
                 class="form-control"
                 placeholder="Descrição da Ação"
                 value="{{$acao->papel}}">                 
        </div>        

       <div class="form-group">
          <label for="compra">Preço</label>
          <input type="number" name="compra" class="form-control"
                  step="0.01" placeholder="Preço de compra"
                  value="{{$acao->compra}}">
        </div>

        <div class="form-group">
          <label for="quantidade">Quantidade</label>
          <input type="number" name="quantidade" class="form-control"
                 placeholder="Quantidade de compra"
                 value="{{$acao->quantidade}}">
        </div>

        <div class="form-group">
          <label for="venda">Venda</label>
          <input type="number" name="venda" class="form-control"
                  step="0.01" placeholder="Preço de venda"
                  value="{{$acao->venda}}">
        </div>

        <div class="form-group">
          <label for="dt_compra">Compra</label>
          <input type="date" name="dt_compra" class="form-control"
                 value="{{$acao->dt_compra}}">
        </div>

        <div class="form-group">
          <label for="dt_venda">Venda</label>
          <input type="date" name="dt_venda" class="form-control"
                 value="{{$acao->dt_venda}}">
        </div>

        <div>
          <button type="submit" class="btn btn-info">Atualizar
          </button>
        </div>
    </form>
  </div>    
@stop 
