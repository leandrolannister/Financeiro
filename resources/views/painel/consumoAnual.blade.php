<h2>Consumo Anual</h2>
<div class="box-body">
  <table class="table table-borderred table-hover">
    <thead>
      <tr>
        <th>Receitas</th>          
        <th>Despesas</th>                    
      </tr>
    </thead>
    <tbody>
      @forelse($valorAnual as $key => $valor)
      <tr>
        <td>{{mb_strtoupper($key)}}</td>
        <td>{{number_format($valor,2,'.',',')}}</td>
      </tr>
      @empty
        <p>Sem Registros</p>
      @endforelse  
    </tbody>
  </table> 
  <span class="{{$valorAnual['receita'] > $valorAnual['despesa'] 
        ? 'badge badge-success' 
        : 'badge badge-danger'}}">
    <h3>Saldo: R$
    {{number_format(
        $valorAnual['receita'] - $valorAnual['despesa'],2,'.',',')}}
    </h3>    
  </span>
</div>
