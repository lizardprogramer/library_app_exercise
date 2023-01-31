<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Models\Copy;
use Illuminate\Http\Request;

class CopysController extends Controller
{
    //Return copy
    public function return(Request $request, $id){
        $formFields=$request->all('borrowed');
        $user=auth()->user();
        $copy=Copy::find($id);
        $formFields['user_id']=$user['id'];

            
        $copy->update($formFields);

        //LOG
        $logFields['user_id']=$user['id'];
        $logFields['entity']='COPY';
        $logFields['description']=$copy->ISBN .= ' - copy returned';
        $logFields['process']='Update';
        Log::create($logFields);

        return back()->with('message', 'Copy successfuly returned');    
    }

    //Show single copy
    public function show($id){
        $user=auth()->user();
        $copy=Copy::with('book')->with('user')->find($id);
        

        if($user){
            $roleid=$user->role()->first()->admin_permission;
            $booksCount=Copy::with('user')->where('user_id', 'like', '%' . $user->id . '%')->get();
        }
        else{
            $roleid=0;
            $booksCount=Copy::all();
        }
        
        if($copy){
            return view('copies.single',[
                'role_id'=>$roleid,
                'copy'=>$copy,
                'booksCount'=>$booksCount
            ]);
        }
        else{
            abort('404');
        }
    }

    //Borrow the copy
    public function borrow(Request $request, $id){
        $formFields=$request->all('borrowed');
        $user=auth()->user();
        $copy=Copy::find($id);
        $formFields['user_id']=$user['id'];
        
        $copy->update($formFields);

        //LOG
        $string=$copy->ISBN .= ' - copy borrowed by ';
        $logFields['user_id']=$user['id'];
        $logFields['entity']='COPY';
        $logFields['description']=$string .= $user->name;
        $logFields['process']='Update';
        Log::create($logFields);

        return back()->with('message', 'Book successfuly borrowed');
    }

    //Add new copy to database
    public function store(Request $request){

        $user=auth()->user();

        $formFields = $request->validate([
            'publisher' => 'required',
            'ISBN' => 'digits:13',
            'language' => 'required',
            'book_id'=> 'required'
        ]);

        $formFields['user_id']=$user['id'];
        $formFields['borrowed']=false;

        Copy::create($formFields);

        //LOG
        $logFields['user_id']=$user['id'];
        $logFields['entity']='COPY';
        $logFields['description']=$formFields['ISBN'] .= ' - copy created';
        $logFields['process']='Create';
        Log::create($logFields);

        return back()->with('message', 'Copy created successfully!'); 
    }

    //Delete the copy
    public function destroy(Request $request, $id){
        $user=auth()->user();
        $roleid=$user->role()->first()->admin_permission;
    
        
        if($roleid){
            $copy = Copy::find($id);
            $copy->delete();
             //LOG
            $logFields['user_id']=$user['id'];
            $logFields['entity']='COPY';
            $logFields['description']=$copy->ISBN .= ' - copy deleted';
            $logFields['process']='Delete';
            Log::create($logFields);
            return redirect('/')->with('message', 'Copy deleted successfully!');
        }
        else{
            abort(403, 'Unauthorized action');
        }        
    }

    //Show edit form
    public function edit($id){

        $user=auth()->user();
        $roleid=$user->role()->first()->admin_permission;
        $copy=Copy::find($id);

        if($roleid){
            return view('copies.edit-copy', [
                'role_id'=>$roleid,
                'copy'=>$copy,
            ]);
        }
        else{
            return redirect('/');
        }

    }

    //Update copy
    public function update(Request $request, $id){
        $user=auth()->user();
        $formFields = $request->validate([
            'publisher' => 'required',
            'ISBN' => 'digits:13',
            'language' => 'required'
        ]);

        $copy=Copy::find($id);
        $copy->timestamps = false;
        $copy->update($formFields);

        //LOG
        $logFields['user_id']=$user['id'];
        $logFields['entity']='COPY';
        $logFields['description']=$copy->ISBN .= ' - copy updated';
        $logFields['process']='Update';
        Log::create($logFields);

        return redirect('/')->with('message', 'Copy successfuly updated!');
    }
    
}
