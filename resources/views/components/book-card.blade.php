@props(['book', 'role_id'])

<x-card>
  <div class="flex">
    <img class="hidden w-48 mr-6 md:block"
      src="{{$book->picture ? asset('storage/' . $book->picture) : asset('/images/no-image.png')}}" alt="" />
    <div>
      <h3 class="text-2xl">
        <a href="http://localhost/LibraryApp/public/books/{{$book->id}}">{{$book->title}}</a>
      </h3>
      <div class="text-xl font-bold mb-4"><a
          href="http://localhost/LibraryApp/public/authors/{{$book->author->id}}">{{$book->author->name}}</a></div>
      <div class="mb-4">{{substr($book->description, 0, 400)}}...</div>
      @if($book->borrowed)
      <div class="text-laravel mb-4">Not Avaliable</div>
      @else
      <div class="text-color3 mb-4">Avaliable</div>
      @endif
    </div>
  </div>
</x-card>