@extends('adminlte::page')

@section('title', 'Contas')

@section('content_header')
  <h1>Contas</h1>  
@stop

@section('content')
  <div class="box">
    @include('includes.alertas')
    <div class="box-header">
      <form action="{{route('movto.search')}}" method="post" 
            class="form form-inline">       
        {!! csrf_field() !!}

        <input type="text" name="nome" class="form-control" 
               placeholder="Descrição da Conta"
               style="margin-right: 5px;">   

        <select name="grupoconta_id" class="form-control" 
                style="margin-right: 5px;">
          <option value="">Seleção Grupo</option>        
          @foreach($grupoList as $key => $g)
            <option value="{{$g->id}}">{{$g->nome}}</option>
          @endforeach  
        </select>                

        <button type="submit" class="btn btn-primary">
        Pesquisar</button>
      </form>      
    </div>
  </div>
  <div class="box-body">    
    <table class="table table-borderred table-hover table-striped">
      <thead>
        <tr>
          <th>Status</th>
          <th>Grupo</th>
          <th>Conta</th>
          <th>DEPÓSITO</th>
          <th>Tipo</th>
        </tr>  
      </thead>
      <tbody>
        @forelse($contaList as $c)
         <tr>
          <td>{{$helper->recuperaStatus($c->status)}}</td>
          <td>{{$helper->recuperaNomeGrupo($c->grupoconta_id)}}</td>
          <td>{{mb_strtoupper($c->nome)}}</td> 
          <td>
             <form action="{{route('movto.deposito')}}" 
                   method="post">
                   {{csrf_field()}}
               <input type="hidden" name="conta_id" 
                      value="{{$c->id}}">
               
               <input type="number" name="valor" 
                      placeholder="0.00"
                      step="0.01" 
                      class="mb-1" 
                      style="width: 15%"> 
                <textarea class="form-control mb-1" 
                            rows="2"
                            name="comentario">
                </textarea>                        

               <button type="submit" 
                       class="btn btn-primary btn-sm">
                 Salvar 
               </button>       
             </form>
           </td>
           <td class="{{$c->tipo == 'Obrigatorio' ? 
                                    'alert alert-danger' : ''}}">
            {{$c->tipo}}
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
