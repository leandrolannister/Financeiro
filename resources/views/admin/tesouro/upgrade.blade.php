@extends('adminlte::page')

@section('title', 'Ações')

@section('content_header')
  <h1>Atualização->Tesouro</h1>  
@stop

@section('content')
  <div class="box">    
    <div class="container">
      @include('includes.alertas')
      <form action="{{route('tesouro.update')}}" method="post">
        {!! csrf_field() !!}

        <input type="hidden" name="id" value="{{$papel->id}}">
        
        <div class="form-group">
          <label for="nome">Nome</label>
          <input type="text" name="nome" class="form-control"
                 placeholder="Descrição do Tesouro"
                 value="{{$papel->nome}}">                 
        </div>        

        <div class="form-group">
          <label for="compra">Compra</label>
          <input type="number" name="compra" class="form-control"
                  step="0.01" placeholder="Preço de compra"
                  value="{{$papel->compra}}">
        </div>        

        <div class="form-group">
          <label for="venda">Venda</label>
          <input type="number" name="venda" class="form-control"
                  step="0.01" placeholder="Preço de venda"
                  value="{{$papel->venda}}">
        </div>

        <div class="form-group">
          <label for="dt_compra">Compra</label>
          <input type="date" name="dt_compra" class="form-control"
                 value="{{$papel->dt_compra}}">
        </div>

        <div class="form-group">
          <select name="tipo" class="form-control">
            <option value="Reserva"
                    <?=$papel->tipo == 'Reserva' ? 'selected' : '';?>>Reserva
            </option>
            <option value="Curso"
                    <?=$papel->tipo == 'Curso' ? 'selected' : '';?>
                    >Curso
            </option>
            <option value="Bens"
                    <?=$papel->tipo == 'Bens' ? 'selected' : '';?>
                    >Bens
            </option>
            <option value="Aposentadoria"
                    <?=$papel->tipo == 'Aposentadoria' ? 
                                            'selected' : '';?>
                    >Aposentadoria
            </option>  
          </select>
        </div>

        <div class="form-group">
          <select name="status" class="form-control">
            <option value='1'
                    <?=$papel == '1' ? 'selected' : '' ?>>Ativo
            </option>
            <option value='0'
                    <?=$papel == '0' ? 'selected' : '' ?>>Desativado
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
