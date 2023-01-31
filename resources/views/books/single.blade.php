<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="icon" href="images/favicon.ico" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
    integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <script src="//unpkg.com/alpinejs" defer></script>
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
        theme: {
          extend: {
            colors: {
              laravel: '#750D37',
              background: '#F7F9F7',
              color2: '#DBF9F0',
              color3: '#B3DEC1'
            },
          },
        },
      }
  </script>
  <title>Library App</title>
</head>

<body class="mb-48">
  <nav class="flex justify-between items-center mb-4">
    <a href="http://localhost/LibraryApp/public/index"><img class="w-10" src="{{asset('images/book-logo10.png')}}"
        alt="" class="logo" /></a>
    <ul class="flex space-x-10 mr-10 text-lg mt-5">
      @auth
      <li>
        <span class="">
          Welcome: {{auth()->user()->name}}
        </span>
      </li>
      @if($role_id)
      <li>
        <i class="fa-solid fa-user"></i> Administrator
      </li>
      @else
      <li>
        <a href="http://localhost/LibraryApp/public/books/mybooks"
          class="bg-background text-center text-black py-4 rounded-xl hover:opacity-50"><i class="fa-solid fa-book"></i>
          My books</a>
      </li>
      @endif
      <form class="inline  hover:opacity-50" method="POST" action="http://localhost/LibraryApp/public/logout">
        @csrf
        <button type="submit">
          <i class="fa-solid fa-door-closed"></i> Logout
        </button>
      </form>
      </li>
      @else
      <li>
        <a href="http://localhost/LibraryApp/public/register" class="hover:text-laravel">
          <i class="fa-solid fa-user-plus"></i> Register
        </a>
      </li>
      <li>
        <a href="http://localhost/LibraryApp/public/login" class="hover:text-laravel">
          <i class="fa-solid fa-arrow-right-to-bracket"></i>
          Login
        </a>
      </li>
      @endauth
    </ul>
  </nav>
  <main>
    @include('partials._hero')
    <a href="{{ URL::previous() }}" class="inline-block text-black ml-4 mb-4"><i class="fa-solid fa-arrow-left"></i>
      Back</a>
    <div class="mx-4">
      <div class="bg-gray-50 border border-gray-200 p-10 rounded">
        <div class="flex flex-col items-center justify-center text-center">
          <img class="w-48 mr-6 mb-6"
            src="{{$book->picture ? asset ('storage/' . $book->picture) : asset('/images/no-image.png')}}" alt="" />

          <h3 class="text-2xl mb-4">{{$book->title}}</h3>
          <div class="text-xl font-bold mb-6"><a
              href="http://localhost/LibraryApp/public/authors/{{$book->author->id}}">{{$book->author->name}}</a></div>
          <div>
            <div class="text-lg space-y-6">
              <p>
                {{$book->description}}
              </p>
            </div>
          </div>
          @auth
          @if($role_id)
          <div class="space-y-6 text-center mt-10">
            <table class="w-full table-auto rounded-sm">
              <tbody>
                <tr class="bg-background">
                  <td class="px-6 py-8 text-lg text-black">
                    <form method="POST" action="http://localhost/LibraryApp/public/books/{{$book->id}}">
                      @csrf
                      @method('DELETE')
                      <button class="text-red-500">
                        <i class="fa-solid fa-trash-can"></i>
                        Delete
                      </button>
                    </form>
                  </td>
                  <td class="px-6 py-8 text-lg text-black">
                    <a href="http://localhost/LibraryApp/public/admin/books/edit/{{$book->id}}"
                      class="text-green-400 px-6 py-2 rounded-xl"><i class="fa-solid fa-pen-to-square"></i>
                      Edit</a>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          @endif
          @endauth
        </div>
      </div>
      <x-card>
        <h1 class="text-2xl uppercase text-black mb-10 mt-10 ml-4 font-bold text-center">
          COPIES AVALIABLE IN OUR LIBRARY<span class="text-black"></span>
        </h1>
        @if(count($book->copys))
        <table class="w-full table-auto rounded-sm">
          <tbody>
            <tr class="border-gray-300 bg-laravel font-bold">
              <td
                class="px-4 py-8 border-t border-b border-r border-l border-gray-300 text-lg text-white text-center w-30px">
                <p>ISBN</p>
              </td>
              <td
                class="px-4 py-8 border-t border-b border-r border-l border-gray-300 text-lg text-white text-center w-30px">
                <p>PUBLISHER</p>
              </td>
              <td class="px-4 py-8 border-t border-b border-r border-gray-300 text-lg text-white text-center w-30px">
                <p>LANGUAGE</p>
              </td>
              <td class="px-4 py-8 border-t border-b border-r border-gray-300 text-lg text-white text-center">
                <p>BORROWED</p>
              </td>
            </tr>
            @foreach($copies as $copy)
            <tr class="border-gray-300 bg-background">
              <td
                class="px-4 py-8 border-t border-b border-r border-l border-gray-300 text-lg text-black text-center w-30px hover:opacity-50">
                <p><a href="http://localhost/LibraryApp/public/copies/{{$copy->id}}">{{$copy->ISBN}}</a></p>
              </td>
              <td
                class="px-4 py-8 border-t border-b border-r border-l border-gray-300 text-lg text-black text-center w-30px">
                <p>{{$copy->publisher}}</p>
              </td>

              <td class="px-4 py-8 border-t border-b border-r border-gray-300 text-lg text-black text-center w-30px">
                <p>{{$copy->language}}</p>
              </td>
              @if($role_id)
              @if($copy->borrowed)
              <td
                class="px-4 py-8 border-t border-b border-r border-gray-300 text-lg text-red-400 text-center hover:opacity-50">
                <p><a href="http://localhost/LibraryApp/public/admin/users/{{$copy->user_id}}">Borrowed by:
                    {{$copy->user->name}}
                </p>
              </td>
              @else
              <td class="px-4 py-8 border-t border-b border-r border-gray-300 text-lg text-green-400 text-center">
                <p>Avaliable</p>
              </td>
              @endif
              @else
              @if($copy->borrowed)
              <td class="px-4 py-8 border-t border-b border-r border-gray-300 text-lg text-red-400 text-center">
                <p>Not avaliable</p>
              </td>
              @else
              <td class="px-4 py-8 border-t border-b border-r border-gray-300 text-lg text-green-400 text-center">
                <p>Avaliable</p>
              </td>
              @endif
              @endif
            </tr>
            @endforeach
          </tbody>
        </table>
        @else
        <div class="text-black mb-5 text-center font-solid">No copies of this book in our library!</div>
        @endif
      </x-card>
      @auth
      @if($role_id)
      <x-card>
        <h1 class="text-2xl uppercase text-black mb-10 mt-10 ml-4 font-bold text-center">
          ADD NEW COPY<span class="text-black"></span>
        </h1>
        <form method="POST" action="http://localhost/LibraryApp/public/copies" enctype="multipart/form-data">
          @csrf
          <input type="hidden" name="book_id" value={{$book->id}}>
          <table class="w-full table-auto rounded-sm">
            <tbody>
              <tr class="border-gray-300 bg-white">
                <div class="mb-6">
                  <td
                    class="px-4 py-8 border-t border-b border-r border-l border-gray-300 text-lg text-blacck text-center w-30px">
                    <label for="publisher" class="inline-block text-lg mb-2">Publisher</label>
                    <input type="text" class="border border-gray-200 rounded p-2 w-full" name="publisher"
                      value="{{old('publisher')}}" />

                    @error('publisher')
                    <p class="text-red-500 text xs mt-1">{{$message}}</p>
                    @enderror
                  </td>
                </div>
                <div class="mb-6">
                  <td
                    class="px-4 py-8 border-t border-b border-r border-gray-300 text-lg text-blacck text-center w-30px">
                    <label for="ISBN" class="inline-block text-lg mb-2">ISBN (13 digit)</label>
                    <input type="text" class="border border-gray-200 rounded p-2 w-full" name="ISBN"
                      value="{{old('ISBN')}}" />

                    @error('ISBN')
                    <p class="text-red-500 text xs mt-1">{{$message}}</p>
                    @enderror
                  </td>
                </div>
                <div class="mb-6">
                  <td
                    class="px-4 py-8 border-t border-b border-r border-gray-300 text-lg text-blacck text-center w-30px">
                    <label for="language" class="inline-block text-lg mb-2">Language</label>
                    <input type="text" class="border border-gray-200 rounded p-2 w-full" name="language"
                      value="{{old('language')}}" />

                    @error('language')
                    <p class="text-red-500 text xs mt-1">{{$message}}</p>
                    @enderror
                  </td>
                </div>
                <td class="px-4 py-8 border-t border-b border-r border-gray-300 text-lg text-black text-center w-30px">
                  <div class="">
                    <button class="bg-laravel text-white rounded py-2 px-4 hover:opacity-50">
                      Add copy
                    </button>
                </td>
    </div>
    </tr>
    </tbody>
    </table>
    </form>
    </x-card>
    @endif
    @endauth
  </main>
  <footer
    class="fixed bottom-0 left-0 w-full flex items-center justify-start font-bold bg-laravel text-background h-20 mt-24 opacity-90 md:justify-center">
    <p class="ml-2">Copyright &copy; 2022, All Rights reserved</p>
  </footer>
  <x-flash-message />
</body>

</html>