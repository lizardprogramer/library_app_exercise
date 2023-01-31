<?php

namespace App\Http\Controllers;

use App\Models\Log;
use Illuminate\Http\Request;

class LogsController extends Controller
{
    public function index(){
        $user=auth()->user();
        $search=request('search');
        $entity=request('entity');
        $roleid=$user->role()->first()->admin_permission;
        $logs=Log::with('user')->get()->sortByDesc('created_at');

        

        if($roleid){
            if($search || $entity){
                $logs=Log::whereRelation('user', 'name', 'ilike', '%%' . $search . '%%')->orWhere('entity', 'ilike', '%%' . $search . '%%')->filter($entity)->with('user')->get()->sortByDesc('created_at');
                return view('logs.index',[
                    'role_id'=>$roleid,
                    'logs'=>$logs
                ]);
            }
            else{
                return view('logs.index', [
                    'role_id'=>$roleid,
                    'logs'=>$logs
            ]);
            }
        }
        else{
                return redirect('/');
            }
    }
}
