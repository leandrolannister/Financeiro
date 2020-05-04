@extends('adminlte::page')

@section('title', 'Tesouro')

@section('content_header')
  <h1>Tesouro<h1>  
@stop

@section('content')
  <div class="box-body">  
    <div>
      <a href="{{route('tesouro.create')}}">Cadastro</a>
    </div> 
    @include('includes.alertas') 
    <table class="table table-borderred table-hover table-striped">
      <thead>
        <tr>
          <th>Nome</th>
          <th style="text-align: center;">Compra</th>
          <th style="text-align: center;">Venda</th>
          <th style="text-align: center;">Saldo</th>
          <th style="text-align: center;">Data Compra</th>
          <th>Tipo</th>
          <th>Status</th>
        </tr>  
      </thead>
      <tbody>
        @forelse($tesourosList as $key => $t)
         <tr>
          <td>{{$t->nome}}</td>
          <td class="alert alert-primary" 
              style="text-align: center">
            {{number_format($t->compra,2,'.',',')}}
          </td>
          <td class="alert alert-success" 
              style="text-align: center" >
            {{number_format($t->venda,2,'.',',')}}
          </td> 
          <td class="alert alert-danger" style="text-align: center">
            {{number_format($t->venda - $t->compra,2,'.',',')}}
          </td>
          <td class="alert alert-dark" style="text-align: center">
            {{$helper->formatDate($t->dt_compra)}}
          </td>
          <td>{{$t->tipo}}</td> 
          <td>{{$t->status}}</td>            
          <td>
            <form action="{{route('tesouro.upgrade')}}" 
                  method="post">
              {{csrf_field()}}
              <input type="hidden" name="id" value="{{$t->id}}">
              <button type="submit" class="btn btn-success btn-sm">
                <i class="fas fa-pen"></i> 
              </button>       
            </form>
          </td> 
          <td>
            <form action="{{route('tesouro.destroy')}}" 
                  method="post">
              {{csrf_field()}}
              <input type="hidden" name="id" value="{{$t->id}}">
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
    {{$tesourosList->links()}}
  </div>
@stop 
