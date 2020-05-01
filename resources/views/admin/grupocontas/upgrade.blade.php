@extends('adminlte::page')

@section('title', 'Grupo Contas')

@section('content_header')
  <h1>Manutenção->Grupo de Contas</h1>  
@stop

@section('content')
  <div class="box">    
    <div class="container">
      @include('includes.alertas')
      <form action="{{route('grupocontas.update')}}" method="post">
        {!! csrf_field() !!}
        <input type="hidden" name="id" value="{{$grupo->id}}">
        
        <div class="form-group">
          <label for="name">Nome</label>
          <input type="text" name="nome" 
                 placeholder="Descrição do Grupo de Contas" 
                 class="form-control"
                 value="{{$grupo->nome}}">
        </div>        

        <div class="form-group">
          <label for="tipo">Tipo</label>
          <select name="tipo" class="form-control">
            <option 
              value="Despesa" 
              <?= $grupo->tipo == 'Despesa' ? 'selected' : '' ?>>
              Despesa
            </option>
            
            <option 
              value="Receita"
              <?= $grupo->tipo == 'Receita' ? 'selected' : '' ?>>
              Receita
            </option>
          </select>
        </div>

        <div class="form-group">
          <label for="classificacao">Classificação</label>
          <select name="classificacao" class="form-control">
            <option value="Consumo" 
              <?= $grupo->classificacao == 'Consumo' ? 'selected' 
                                                     : '' ?>
              >Consumo
            </option>

            <option value="Diversão" 
              <?= $grupo->classificacao == 'Diversão' ? 'selected' 
                                                      : '' ?>
              >Diversão
            </option>
            
            <option value="Cursos"
              <?= $grupo->classificacao == 'Cursos' ? 'selected' 
                                                    : '' ?>
              >Cursos
            </option>

            <option value="Lucro"
              <?= $grupo->classificacao == 'Lucro' ? 'selected' 
                                                    : '' ?>
              >Lucro
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
