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
                    class="bg-background text-center text-black py-4 rounded-xl hover:opacity-50"><i
                        class="fa-solid fa-book"></i>
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
        @include('partials._search')
        <table class="table-auto rounded-sm mt-5 ml-4">
            <tbody>
                <tr class="border-gray-300 bg-laravel">
                    <td class="px-4 border-gray-300 text-lg text-white font-bold text-center bg-purple-400">
                        <p>
                            <a href="?entity=AUTHOR">AUTHOR</a>
                        </p>
                    </td>
                    <td class="px-4 border-gray-300 text-lg text-white font-bold text-center bg-blue-400">
                        <p>
                            <a href="?entity=COPY">COPY</a>
                        </p>
                    </td>
                    <td class="px-4 border-gray-300 text-lg text-white font-bold text-center bg-yellow-400">
                        <p>
                            <a href="?entity=BOOK">BOOK</a>
                        </p>
                    </td>
                </tr>
            </tbody>
        </table>
        <h1 class="text-2xl uppercase text-black mb-10 mt-10 ml-4 font-bold">
            <span class="text-black"> LOGS:</span>
        </h1>
        @if(count($logs)!=0)
        <x-card>
            <table class="w-full table-auto rounded-sm">
                <tbody>
                    <tr class="border-gray-300 bg-laravel">
                        <td
                            class="px-4 py-8 border-t border-b border-r border-l border-gray-300 text-lg text-white font-bold text-center">
                            <p>
                                User:
                            </p>
                        </td>
                        <td
                            class="px-4 py-8 border-t border-b border-r border-gray-300 text-lg text-white font-bold text-center">
                            <p>
                                Description:
                            </p>
                        </td>
                        <td
                            class="px-4 py-8 border-t border-b border-r border-gray-300 text-lg text-white font-bold text-center">
                            <p>
                                Entity:
                            </p>
                        </td>
                        <td
                            class="px-4 py-8 border-t border-b border-r border-gray-300 text-lg text-white font-bold text-center">
                            <p>
                                Time:
                            </p>
                        </td>
                    </tr>
                    @foreach($logs as $log)
                    <tr class="border-gray-300 bg-white">
                        <td
                            class="px-4 py-8 border-t border-b border-r border-l border-gray-300 text-lg text-black text-center">
                            <p>
                                {{$log->user->name}}
                            </p>
                        </td>
                        <td class="px-4 py-8 border-t border-b border-r border-gray-300 text-lg text-black text-center">
                            <p>
                                {{$log->description}}
                            </p>
                        </td>
                        @if($log->entity=='BOOK')
                        <td
                            class="font-bold px-4 py-8 border-t border-b border-r border-gray-300 text-lg text-white text-center bg-yellow-400">
                            <p>
                                <a href="?entity={{$log->entity}}">{{$log->entity}}</a>
                            </p>
                        </td>
                        @elseif($log->entity=='AUTHOR')
                        <td
                            class="font-bold px-4 py-8 border-t border-b border-r border-gray-300 text-lg text-white text-center bg-purple-400">
                            <p>
                                <a href="?entity={{$log->entity}}">{{$log->entity}}</a>
                            </p>
                        </td>
                        @elseif($log->entity=='COPY')
                        <td
                            class="font-bold px-4 py-8 border-t border-b border-r border-gray-300 text-lg text-white text-center bg-blue-400">
                            <p>
                                <a href="?entity={{$log->entity}}">{{$log->entity}}</a>
                            </p>
                        </td>
                        @endif

                        <td class="px-4 py-8 border-t border-b border-r border-gray-300 text-lg text-black text-center">
                            <p>
                                {{$log->created_at}}
                            </p>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

        </x-card>
        @else
        <table class="w-full table-auto rounded-sm mt-6">
            <tbody>
                <tr class="border-gray-300 bg-white">
                    <td class="px-4 py-8 border-t border-b border-gray-300 text-lg text-black font-bold text-center">
                        <p>
                            No logs!
                        </p>
                    </td>
                </tr>
            </tbody>
        </table>
        @endif
    </main>
    <footer
        class="fixed bottom-0 left-0 w-full flex items-center justify-start font-bold bg-laravel text-background h-20 mt-24 opacity-90 md:justify-center">
        <p class="ml-2">Copyright &copy; 2022, All Rights reserved</p>
    </footer>

    <x-flash-message />
</body>

</html>