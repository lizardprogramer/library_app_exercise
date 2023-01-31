<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Models\Author;
use Illuminate\Http\Request;

class AuthorsController extends Controller
{
    //Show author page
    public function show($id){
        $author=Author::with('books')->find($id);
        $user=auth()->user();
        if($user){
            $roleid=$user->role()->first()->admin_permission;
        }
        else{
            $roleid=0;
        }
        return view ('authors.single', [
            'role_id'=>$roleid,
            'author'=>$author
        ]);
    }


    //Delete the author
    public function destroy(Request $request, $id){
        $user=auth()->user();
        $roleid=$user->role()->first()->admin_permission;
    
        if($roleid){
            $books = Author::find($id)->books()->delete();
            $author = Author::find($id);
            $author->delete();

            //LOG
            $logFields['user_id']=$user['id'];
            $logFields['entity']='AUTHOR';
            $logFields['description']=$author->name .= ' - author deleted';
            $logFields['process']='Delete';
            Log::create($logFields);

            return redirect('/')->with('message', 'Author deleted successfully!');
        }
        else{
            abort(403, 'Unauthorized action');
        }
    }



    //Show add new author form
    public function addAuthor(){
        $user=auth()->user();
        $roleid=$user->role()->first()->admin_permission;
        $authors=Author::all()->sortBy('name');

        if($roleid){
            return view('authors.add-new-author', [
                'role_id'=>$roleid,
                'authors'=>$authors
            ]);
        }
        else{
            return redirect('/');
        }
    }

    //Add new author to database
    public function store(Request $request){
        $user=auth()->user();
        $formFields = $request->validate([
            'name' => 'required',
            'biography' => 'required'

        ]);

        if($request->hasFile('logo')){
            $formFields['picture'] = $request->file('logo')->store('logos', 'public');
        }

        Author::create($formFields);
        //LOG
        $logFields['user_id']=$user['id'];
        $logFields['entity']='AUTHOR';
        $logFields['description']=$formFields['name'] .= ' - author created';
        $logFields['process']='Create';
        Log::create($logFields);


        return back()->with('message', 'Author created successfully!'); 
    }

    //Show edit form
    public function edit($id){

        $user=auth()->user();
        $roleid=$user->role()->first()->admin_permission;
        $author=Author::find($id);

        if($roleid){
            return view('authors.edit-author', [
                'role_id'=>$roleid,
                'author'=>$author
            ]);
        }
        else{
            return redirect('/');
        }

    }

    //Update author
    public function update(Request $request, $id){
        $user=auth()->user();
        $formFields = $request->validate([
            'name' => 'required',
            'biography' => 'required'
        ]);
        if($request->hasFile('logo')){
            $formFields['picture'] = $request->file('logo')->store('logos', 'public');
        }
        
        $author=Author::find($id);
        $author->update($formFields);

        //LOG
        $logFields['user_id']=$user['id'];
        $logFields['entity']='AUTHOR';
        $logFields['description']= $author->name .= ' - author updated';
        $logFields['process']='Update';
        Log::create($logFields);

        return redirect('/')->with('message', 'Author successfuly updated!');
    }

}
