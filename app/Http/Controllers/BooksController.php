<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Models\Book;
use App\Models\Copy;
use App\Models\Author;
use Illuminate\Http\Request;

class BooksController extends Controller
{
    //Show all books
    public function index(){
        $search=request('search');
        $user=auth()->user();
        if($user){
        $roleid=$user->role()->first()->admin_permission;
            if($search){
                $books=Book::whereRelation('author', 'name', 'ilike', '%%' . $search . '%%')->orWhere('title', 'like', '%' . $search . '%')->with('copys')->get()->sortBy(function($query){
                    return $query->author->name;
                });
                return view('books.index',[
                    'role_id'=>$roleid,
                    'books'=>$books
                ]);
            }
            else{
                $books=Book::with('author')->with('copys')->get()->sortBy(function($query){
                    return $query->author->name;
                });
                return view('books.index',[
                    'role_id'=>$roleid,
                    'books'=>$books
                ]);
            }
        }
        else{
            $roleid=false;
            if($search){
                $books=Book::whereRelation('author', 'name', 'like', '%' . $search . '%')->orWhere('title', 'like', '%' . $search . '%')->with('copys')->get()->sortBy(function($query){
                return $query->author->name;
            });
                return view('books.index', [
                    'role_id'=>$roleid,
                    'books'=>$books
                ]);
            }
            else{
                $books=Book::with('author')->get()->sortBy(function($query){
                    return $query->author->name;
                });
                return view('books.index', [
                    'role_id'=>$roleid,
                    'books'=>$books
                ]);
            }
        }
    }

    //Show single book
    public function show($id){
        $user=auth()->user();
        $book=Book::with('author')->with('copys')->find($id);
        $copies=Copy::with('user')->where('book_id', 'like', '%' . $id . '%')->get();
        if($user){
            $roleid=$user->role()->first()->admin_permission;
            $booksCount=Copy::with('user')->where('user_id', 'like', '%' . $user->id . '%')->get();
        }
        else{
            $roleid=0;
            $booksCount=Copy::all();
        }
        if($book){
            return view('books.single',[
                'role_id'=>$roleid,
                'book'=>$book,
                'booksCount'=>$booksCount,
                'copies'=>$copies
            ]);
        }
        else{
            abort('404');
        }
    }

    //Show my books
    public function mybooks(){
        $user=auth()->user();
        $roleid=$user->role()->first()->admin_permission;
        if($roleid){
            return redirect('/index');
        }
        else{
            $books=Copy::with('user')->with('book')->where('user_id', 'like', '%' . $user->id . '%')->get();
            return view('books.mybooks',[
                'role_id'=>$roleid,
                'books'=>$books
            ]);
        }
    }

    
    //Show add new book form
    public function addBook(){
        $user=auth()->user();
        $roleid=$user->role()->first()->admin_permission;
        $authors=Author::all()->sortBy('name');

        if($roleid){
            return view('books.add-new-book', [
                'role_id'=>$roleid,
                'authors'=>$authors
            ]);
        }
        else{
            return redirect('/index');
        }
    }

    //Add new book to database
    public function store(Request $request){
        $user=auth()->user();
        $formFields = $request->validate([
            'title' => 'required',
            'author_id' => 'required',
            'description' => 'required'

        ]);

        if($request->hasFile('logo')){
            $formFields['picture'] = $request->file('logo')->store('logos', 'public');
        }

        Book::create($formFields);

        //LOG
        $logFields['user_id']=$user['id'];
        $logFields['entity']='BOOK';
        $logFields['description']=$formFields['title'] .= ' - book created';
        $logFields['process']='Create';
        Log::create($logFields);

        return redirect('/')->with('message', 'Book created successfully!'); 
    }

    //Delete the book
    public function destroy(Request $request, $id){
        $user=auth()->user();
        $roleid=$user->role()->first()->admin_permission;
    
        
        if($roleid){
            $book = Book::find($id);
            $book->delete();
            //LOG
            $logFields['user_id']=$user['id'];
            $logFields['entity']='BOOK';
            $logFields['description']=$book->title .= ' - book deleted';
            $logFields['process']='Delete';
            Log::create($logFields);

            return redirect('/')->with('message', 'Book deleted successfully!');
        }
        else{
            abort(403, 'Unauthorized action');
        }        
    }

    //Show edit form
    public function edit($id){

        $user=auth()->user();
        $roleid=$user->role()->first()->admin_permission;
        $book=Book::find($id);
        $authors=Author::all();

        if($roleid){
            return view('books.edit-book', [
                'role_id'=>$roleid,
                'book'=>$book,
                'authors'=>$authors
            ]);
        }
        else{
            return redirect('/');
        }

    }

    //Update book
    public function update(Request $request, $id){
        $user=auth()->user();
        $formFields = $request->validate([
            'title' => 'required',
            'author_id' => 'required',
            'description' => 'required'
        ]);
        if($request->hasFile('logo')){
            $formFields['picture'] = $request->file('logo')->store('logos', 'public');
        }
        $book=Book::find($id);
        $book->update($formFields);

        //LOG
        $logFields['user_id']=$user['id'];
        $logFields['entity']='BOOK';
        $logFields['description']= $book->title .= ' - book updated';
        $logFields['process']='Update';
        Log::create($logFields);


        return redirect('/')->with('message', 'Book successfuly updated!');
    }
    
}
