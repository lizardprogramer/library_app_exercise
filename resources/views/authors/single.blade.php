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
            src="{{$author->picture ? asset ('storage/' . $author->picture) : asset('/images/no-image.png')}}" alt="" />

          <h3 class="text-2xl mb-10">{{$author->name}}</h3>
          <div class="border border-gray-200 w-full mb-6"></div>
          <div>
            <h3 class="text-3xl font-bold mb-4">
              Biography
            </h3>
            <div class="text-lg space-y-6">
              <p>
                {{$author->biography}}
              </p>
            </div>
          </div>
        </div>
        @auth
        @if($role_id)
        <div class="space-y-6 text-center mt-10">
          <table class="w-full table-auto rounded-sm text-center">
            <tbody>
              <tr class="bg-background text-center">
                <td class="px-10 py-5 text-lg text-black text-right">
                  <form method="POST" action="http://localhost/LibraryApp/public/admin/authors/{{$author->id}}">
                    @csrf
                    @method('DELETE')
                    <button class="text-red-500">
                      <i class="fa-solid fa-trash-can"></i>
                      Delete
                    </button>
                  </form>
                </td>
                <td class="px-6 py-5 text-lg text-black text-left">
                  <a href="http://localhost/LibraryApp/public/admin/authors/edit/{{$author->id}}"
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
      <h3 class="text-2xl font-bold mb-10 ml-4 mt-10">BOOKS IN OUR CATALOGUE:</h3>
      <table class="w-full table-auto rounded-sm">
        <tbody>
          @foreach ($author->books as $book)
          <tr class="border-gray-300 text-center hover:bg-laravel hover:text-white">
            <td class="px-4 py-8 border-t border-b border-gray-300 text-lg text-black-400">
              <p>
                <a href="http://localhost/LibraryApp/public/books/{{$book->id}}">{{$book->title}}</a>
              </p>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>



  </main>
  <footer
    class="fixed bottom-0 left-0 w-full flex items-center justify-start font-bold bg-laravel text-background h-20 mt-24 opacity-90 md:justify-center">
    <p class="ml-2">Copyright &copy; 2022, All Rights reserved</p>
  </footer>

  <x-flash-message />
</body>

</html>