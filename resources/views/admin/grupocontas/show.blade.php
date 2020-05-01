@extends('adminlte::page')

@section('title', 'Grupo de Contas')

@section('content_header')
  <h1>Grupo de Contas</h1>
@stop

@section('content')
  <div class="box">
    @include('includes.alertas')
    <div class="box-header">
      <form action="{{route('grupocontas.search')}}"
            method="post" class="form form-inline">
        {!! csrf_field() !!}

        <input type="text" name="nome" class="form-control"
               placeholder="Descrição do Grupo"
               style="margin-right: 5px;">

        <button type="submit" class="btn btn-primary">
          Pesquisar
        </button>
      </form>
    </div>
  </div>
  <div class="box-body">
    <table class="table table-borderred table-hover">
      <thead>
        <tr>
          <th>id</th>
          <th>Nome</th>
          <th>Tipo</th>
          <th>Status</th>
          <th>Classificação</th>
          <th>Criado em</th>
          <th>Alterado em</th>
        </tr>
      </thead>
      <tbody>
        @forelse($grupocontasList as $gc)
         <tr class="{{$gc->status ? '' : 'alert alert-danger'}}">
          <td>{{$gc->id}}</td>
          <td>{{$gc->nome}}</td>
          <td>{{$gc->tipo}}</td>
          <td>{{$helper->recuperaStatus($gc->status)}}</td>
          <td>{{$gc->classificacao}}</td>
          <td>{{$helper->formatDate($gc->created_at)}}</td>
          <td>{{$helper->formatDate($gc->updated_at)}}</td>
          <td>
            <form action="{{route('grupocontas.upgrade')}}" 
                  method="post">
                   {{csrf_field()}}
              <input type="hidden" name="grupoconta_id" 
                     value="{{$gc->id}}">
              <button type="submit" 
                       class="btn btn-primary btn-sm">
                <i class="fas fa-pen"></i> 
              </button>       
            </form>
          </td> 
          <td>
            <form action="{{route('grupocontas.turn')}}" 
                  method="post">
                   {{csrf_field()}}
              <input type="hidden" name="id" value="{{$gc->id}}">
              <button type="submit" 
                       class="btn btn-success btn-sm">
                <i class="fas fa-power-off"></i> 
              </button>       
             </form>
          </td>  
          <td>
            <form action="{{route('grupocontas.destroy')}}" 
                  method="post">
                   {{csrf_field()}}
              <input type="hidden" name="id" value="{{$gc->id}}">
              <button type="submit" 
                       class="btn btn-danger btn-sm">
                <i class="fas fa-trash"></i> 
              </button>       
             </form>
           </td>           
         </tr>
         @empty
           <p>sem Registro</p>
         @endforelse
      </tbody>
    </table>
    @if(isset($grupos))
      {{$grupocontasList->appends($grupos)->links()}}
    @else
      {{$grupocontasList->links()}}
    @endif
  </div>
@stop
