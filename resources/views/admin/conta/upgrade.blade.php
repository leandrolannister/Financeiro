@extends('adminlte::page')

@section('title', 'Conta')

@section('content_header')
  <h1>Conta</h1>  
@stop

@section('content')
  <div class="box">    
    <div class="container">
      @include('includes.alertas')
      <form action="{{route('conta.update')}}" method="post">
        @csrf
        <input type="hidden" name="id" value="{{$conta->id}}">
        
        <div class="form-group">
          <label for="name">Nome</label>
          <input type="text" name="nome" 
                 placeholder="Descrição do Grupo de Contas" 
                 class="form-control"
                 value="{{$conta->nome}}">
        </div>

        <div style="margin-bottom: 5px;">
          <label for="nomegrupo">Grupo Contas</label>
          <select name="grupoconta_id" class="form-control">
            @foreach($grupocontas as $key => $g)
              <option value="{{$g->id}}" 
              <?= $conta->grupoconta_id == $g->id ? 'selected' 
                                                  : '' ?>>
                {{$g->nome}}
              </option>
            @endforeach  
          </select>  
        </div>

        <div style="margin-bottom: 5px;">
          <label for="tipo">Tipo</label>
          <select name="tipo" class="form-control">
             <option value="Facultativo"
             <?= $conta->tipo == 'Facultativo' ? 'selected' : '' ?>>  Facultativo
             </option>
             <option value="Obrigatorio"
             <?= $conta->tipo == 'Obrigatório' ? 'selected' : '' ?>>  Obrigátorio
             </option>  
          </select>
        </div>

        <div>
          <button type="submit" class="btn btn-info">Atualizar
          </button>
        </div>
    </form>
  </div>    
@stop 
