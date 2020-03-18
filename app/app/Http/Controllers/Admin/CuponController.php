<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Cupon;
use App\Venda;


class CuponController extends Controller
{
	public function index()
	{
		$cupons = Cupon::all();
		return view('admin.cupons.index',compact('cupons'));
	}

	public function index_user()
	{
		$user_id = auth()->user()->id;
		$cupons = Cupon::where('parceiro_id',$user_id)->orWhere('user_id',$user_id)->get();


		return view('admin.cupons.index',compact('cupons'));
	}

	public function store(Request $r)
	{
		$r->validate([
    		'codigo' => 'required|unique:cupons',
    		'fim' => 'required',
    		'tipo' => 'required',
    		'desconto' => 'required_if:tipo,desconto',
    		'dias' => 'required_if:tipo,promocional',
		]);

		
		$cupon = new Cupon($r->except('_token'));
		$cupon->save();

       	return back()
            ->with('success','Cupom adicionado!');
	}

	public function delete($id)
	{
		$cupon = Cupon::find($id);
		if($cupon->users->count() == 0){
			$cupon->delete();
			return back()
            ->with('success','Cupom Deletado!');
		}else{
			return back()
            ->with('error','Cupom NÃO pode ser EXCLUIDO, tem usuários utilizando ele!');
		}
	}

	public function deleteUsers($id)
	{
		$delete = Cupon::find($id)->users()->detach();

		if ($delete)
		{
			return back()
            ->with('success','Usuários Deletados!');
		}
		else
		{
			return back()
            ->with('error','Erro ao excluir Usuários');
		}
	}

	public function relatorio($id){
		$cupon = Cupon::find($id);
		return view('admin.cupons.relatorio',compact('cupon'));
	}

	public function relatorio_search(Request $request){
		$venda = new Venda();
		$cupon = Cupon::find($request->id);
		$usuarios_cupom = $cupon->users;
		$vendas_cupon = array();
		$total_pago = 0;
		$total_pedidos = 0;
		foreach ($usuarios_cupom as $key => $usuario) {
			$vendas_count = $usuario->vendas()->whereDate('created_at','>=',$request->data_inicio)->whereDate('created_at','<=',$request->data_fim)->where('plano','profissional')->where('status','Paga')->count();
			$vendas_cupon[$usuario->email] = $vendas_count;

			//10% PRO JAIRO E 10% PRO FRAZÃO
			$total_pago += $vendas_count*($venda->getValorPlanoProfissonal()*10/100);
			$total_pedidos +=$vendas_count;	
		}

		return view('admin.cupons.relatorio',compact('cupon','vendas_cupon','total_pago','total_pedidos'));
	}

}
