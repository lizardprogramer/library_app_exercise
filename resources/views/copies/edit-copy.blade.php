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
                <span class="">Welcome: {{auth()->user()->name}}</span>
            </li>
            @if($role_id)
            <li>
                <i class="fa-solid fa-user"></i> Administrator
            </li>
            @else
            <li>
                <a href="http://localhost/LibraryApp/public/books/mybooks"
                    class="bg-background text-center text-black py-4 rounded-xl hover:opacity-50">
                    <i class="fa-solid fa-book"></i>My books
                </a>
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
        {{-- EDIT copy form --}}
        @include('partials._hero')
        <a href="{{ URL::previous() }}" class="inline-block text-black ml-4 mb-4"><i class="fa-solid fa-arrow-left"></i>
            Back</a>
        <div class="bg-gray-50 border border-gray-200 p-10 rounded max-w-lg mx-auto mt-24">
            <header class="text-center">
                <h2 class="text-2xl font-bold uppercase mb-10">
                    EDIT the copy
                </h2>
            </header>

            <form method="POST" action="http://localhost/LibraryApp/public/admin/copies/edit/{{$copy->id}}"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="mb-6">
                    <label for="title" class="inline-block text-lg mb-2">Publisher</label>
                    <input type="publisher" class="border border-gray-200 rounded p-2 w-full" name="publisher"
                        value="{{$copy->publisher}}" />

                    @error('publisher')
                    <p class="text-red-500 text xs mt-1">{{$message}}</p>
                    @enderror
                </div>
                <div class="mb-6">
                    <label for="ISBN" class="inline-block text-lg mb-2">ISBN(13 digits)</label>
                    <input type="text" class="border border-gray-200 rounded p-2 w-full" name="ISBN"
                        value="{{$copy->ISBN}}" />

                    @error('ISBN')
                    <p class="text-red-500 text xs mt-1">{{$message}}</p>
                    @enderror
                </div>
                <div class="mb-6">
                    <label for="language" class="inline-block text-lg mb-2">Language</label>
                    <input type="text" class="border border-gray-200 rounded p-2 w-full" name="language"
                        value="{{$copy->language}}" />

                    @error('language')
                    <p class="text-red-500 text xs mt-1">{{$message}}</p>
                    @enderror
                </div>
                <div class="mb-6">
                    <button class="bg-laravel text-white rounded py-2 px-4 hover:bg-black">
                        Edit copy
                    </button>
                </div>
            </form>
        </div>
    </main>
    <footer
        class="fixed bottom-0 left-0 w-full flex items-center justify-start font-bold bg-laravel text-background h-20 mt-24 opacity-90 md:justify-center">
        <p class="ml-2">Copyright &copy; 2022, All Rights reserved</p>
    </footer>

    <x-flash-message />
</body>

</html>