@extends('adminlte::page')

@section('title', 'Contas')

@section('content_header')
  <h1>Cadastro->Conta</h1>  
@stop

@section('content')
  <div class="box">    
    <div class="container">
      @include('includes.alertas')
      <form action="{{route('conta.store')}}" method="post">
        {!! csrf_field() !!}
        
        <div class="form-group">
          <label for="name">Nome</label>
          <input type="text" name="nome" 
                 placeholder="Descrição da Conta" 
                 class="form-control">
        </div>        

        <div class="form-group">
          <label for="grupoConta_id">Grupo Contas</label>
          <select name="grupoconta_id" class="form-control">
            @foreach($grupoContas as $grupoC)  
              <option value="{{$grupoC->id}}">
                {{$grupoC->nome}}
              </option>
            @endforeach  
          </select>
        </div> 

        <div class="form-group">
          <label for="tipo">Tipo</label>
          <select name="tipo" class="form-control">
            <option value="Facultativo">Facultativo</option>
            <option value="Obrigatório">Obrigatório</option>
          </select>
        </div>             

        <div>
          <button type="submit" class="btn btn-info">Gravar
          </button>
        </div>
    </form>
  </div>    
@stop 
