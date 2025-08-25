<?php

namespace App\Http\Controllers;
use App\Models\onlinestore;
use App\Models\UserAccount;
use App\Models\User;
use App\Models\AccountDeletionRequest;
use App\Models\SupportRequest;
use Illuminate\Validation\Rule;
use App\Models\Promotion;
use App\Models\PromotionRequest;
use App\Models\Discount;
use Carbon\Carbon;
use App\Models\ListaPromocion;
use Illuminate\Http\Request;

class InformationController extends Controller
{
    public function politics()
    {
        return view('info.politics');
    }
    public function pol()
    {
        
        return view('info.politics');
    }
    public function tyc()
    {
        return view('info.tyc');
    }
    public function prom()
    {
        $basic=Promotion::where('id_type',1)->where('active','<',2)->count();
        $medium=Promotion::where('id_type',2)->where('active','<',2)->count();
        $premium=Promotion::where('id_type',2)->where('active','<',2)->count();
        $lbasic=ListaPromocion::where('id',1)->first()->max;
        $lmedium=ListaPromocion::where('id',2)->first()->max;
        $lpremium=ListaPromocion::where('id',3)->first()->max;
        $fecha = Carbon::now()->addDays(2)->format('Y-m-d');
        return view('info.prom', compact('fecha','basic','medium','premium','lbasic','lmedium','lpremium'));
    }
    public function promcreate(Request $request)
    {
        $request->validate([
            'username' => 'exists:users,username'
        ], [
            'username.exists' => 'Invalid User.'
        ]);
        

        if (!$request->isMethod('post') || !$request->has('startday')) {
            return redirect()->back();
        }
        $startday = Carbon::parse($request->startday);

        $userId = User::where('username', $request->username)->first()->id;

        $endDay = Carbon::parse($request->startday)->addDays(3);
        $st=$endDay->subDays(3);
        $hola=Carbon::parse($request->startday)->addDays(3);
            
        $promotion = new Promotion([
            'IdUsr' => $userId,
            'name' => $request->nombre,
            'email' => $request->email,
            'id_type' => $request->input('paquete') ==="basico"?1:($request->input('paquete')==="standar"?2:3), // Necesitas una lógica para asignar esto basado en 'paquete'
            'include' => $request->has('include') ? 1 : 0,
            'method' => 1,
            'startday' => $endDay->format('Y-m-d'),
            'endDay' => $hola->format('Y-m-d'),
            'nowpay' => $request->nowpay,
            'active' => 0,
            'paymentDay'=> $now = Carbon::now(),
            'idDiscount' =>  $request->idDiscount ?? null,
            'nowpay'=>$request->nowpay,
            
        ]);

        $promotion->save();

        return back()->with('success', 'Promoción creada con éxito.');
    }
    public function promcreateu(Request $request)
    {
        $request->validate([
            'mensaje' => 'required|min:10',
        ]);

        $promotion = new PromotionRequest([
            'name' => $request->nombre,
            'email' => $request->email,
            'package' => 0,
            'message'=>$request->mensaje        
        ]);

        $promotion->save();

        return back()->with('success', 'Promoción creada con éxito.');
    }
    public function fqa()
    {
        return view('info.fq&a');
    }
    public function addac()
    {
        $stores=onlinestore::all();
        return view('info.addac',['onlineStores'=>$stores]);
    }
    
    public function addstore(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255',
            'profile_link' => 'nullable|url'
        ]);
        
        UserAccount::create($request->all());
        
        return redirect()->back()->with('success', 'Formulario enviado con éxito.');
    }
    public function remac()
    {
        
        return view('info.remac');
    }
    public function remacdel(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'username' => 'required|string',
        ]);

        $userAccount = User::where('username', $request->username)->first();
        

        if (!$userAccount) {
            return redirect()->back()->with('error', 'Usuario no encontrado.');
        }
        
        AccountDeletionRequest::create([
            'user_account_id' => $userAccount->id, 
            'email' => $request->email,
            'reason'=>$request->reason
        ]);

        return redirect()->back()->with('success', 'Solicitud de eliminación enviada con éxito.');
    
    }
    public function support()
    {
        return view('info.support');
    }
    public function supportStore(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'message' => 'required',
        ]);

        SupportRequest::create($request->all());

        return redirect()->back()->with('success', 'Tu mensaje ha sido enviado. ¡Gracias por contactarnos!');
    
    }
}
