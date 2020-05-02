@extends('adminlte::page')

@section('title', 'Ações')

@section('content_header')
  <h1>Ações<h1>  
@stop

@section('content')
  <div class="box-body">  
    <div>
      <a href="{{route('acoes.create')}}">Cadastro</a>
    </div> 
    @include('includes.alertas') 
    <table class="table table-borderred table-hover table-striped">
      <thead>
        <tr>
          <th>Papel</th>
          <th>Compra</th>
          <th>Venda</th>
          <th>Lucro</th>
          <th>%</th> 
          <th>Quantidade</th>
          <th>Data Compra</th>
          <th>Data Venda</th>
        </tr>  
      </thead>
      <tbody>
        @forelse($acoesList as $a)
         <tr>
          <td>{{$a->papel}}</td>
          
          <td class="alert alert-primary">  
            {{number_format($a->compra, 2,'.',',')}}
          </td>
          <td class="alert alert-success">      
            {{number_format($a->venda,2,'.',',')}}
          </td>
          <td class="alert alert-danger">
            {{$helper->calcularLucroAcoes($a->compra, $a->quantidade, $a->venda)}}
          </td>
          <td class="alert alert-dark">
            {{$helper->calcularPorcentagemAcoes($a->compra,
            $a->quantidade, $a->venda)}}
          </td> 
          <td>{{$a->quantidade}}</td> 
          <td class="alert alert-warning">  
            {{$helper->formatDate($a->dt_compra)}}</td>
          <td>{{$helper->formatDate($a->dt_venda)}}</td>
          
          <td>
            <form action="{{route('acoes.upgrade')}}" method="post">
              {{csrf_field()}}
              <input type="hidden" name="id" value="{{$a->id}}">
              <button type="submit" class="btn btn-success btn-sm">
                <i class="fas fa-pen"></i> 
              </button>       
            </form>
          </td> 
           <td>
            <form action="{{route('acoes.destroy')}}" method="post">
              {{csrf_field()}}
              <input type="hidden" name="id" value="{{$a->id}}">
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
    {{$acoesList->links()}} 
  </div>
@stop 
