@extends('adminlte::page')

@section('title', 'Contas')

@section('content_header')
  <h1>Contas</h1>  
@stop

@section('content')
  <div class="box">
    @include('includes.alertas')
    <div class="box-header">
      <form action="{{route('conta.search')}}" method="post" 
            class="form form-inline">       
        {!! csrf_field() !!}

        <input type="text" name="nome" class="form-control" 
               placeholder="Descrição da Conta"
               style="margin-right: 5px;">

        <select name="grupoconta" class="form-control" 
                style="margin-right: 5px;">
          <option value="">Seleção Grupo</option>        
          @foreach($grupocontas as $key => $g)
            <option value="{{$g->id}}">{{$g->nome}}</option>
          @endforeach  
        </select>       

        <button type="submit" class="btn btn-primary">
        Pesquisar</button>
      </form>      
    </div>
  </div>
  <div class="box-body">    
    <table class="table table-borderred table-hover">
      <thead>
        <tr>
          <th>id</th>
          <th>Nome</th>
          <th>Grupo</th>            
          <th>Status</th>
          <th>Tipo</th>           
        </tr>  
      </thead>
      <tbody>
        @forelse($contaList as $c)
         <tr class="{{$c->status ? '' : 'alert alert-danger'}}">
          <td>{{$c->id}}</td>
          <td>{{mb_strtoupper($c->nome)}}</td>
          <td>{{$helper->recuperaNomeGrupo($c->grupoconta_id)}}</td>
          <td>{{$helper->recuperaStatus($c->status)}}</td>
          <td>{{$c->tipo}}</td>
          <td>
            <form action="{{route('conta.upgrade')}}" 
                  method="post">
                   {{csrf_field()}}
              <input type="hidden" name="id" value="{{$c->id}}">
              <button type="submit" 
                       class="btn btn-primary btn-sm">
                <i class="fas fa-pen"></i> 
              </button>       
            </form>
          </td> 
          <td>
            <form action="{{route('conta.turn')}}" 
                  method="post">
                   {{csrf_field()}}
              <input type="hidden" name="id" value="{{$c->id}}">
              <button type="submit" 
                       class="btn btn-success btn-sm">
                <i class="fas fa-power-off"></i> 
              </button>       
             </form>
          </td>  
          <td>
            <form action="{{route('conta.destroy')}}" 
                  method="post">
                   {{csrf_field()}}
              <input type="hidden" name="id" value="{{$c->id}}">
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
    @if(isset($contas))
      {{$contaList->appends($contas)->links()}}
    @else  
      {{$contaList->links()}}
    @endif  
  </div>
@stop	
