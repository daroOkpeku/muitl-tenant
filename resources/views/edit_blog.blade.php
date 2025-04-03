<!DOCTYPE html>
<html lang="en">
    @include('layout.head') 
<body>
   <!-- include('./partial/nav.ejs') this connect different html component just like react  -->
   @include('layout.nav')

   @if (session('error'))
   <p style="text-align: center; display: flex; justify-content: center; align-items: center; color:red;">
       {{ session('error') }} 
   </p>
   @endif
      <div class="create-blog content">
        <form action="{{ route('create_blog_edit',['id' =>$id]) }}"  method="POST">
            @csrf
            @method('PUT')
          <label for="title">Blog title:</label>
          <input type="text" id="title" value="{{ $blog->title }}" name="title" required>
          <label for="snippet">Blog heading:</label>
          <input type="text" id="snippet" value="{{ $blog->heading }}" name="snippet" required>
          <label for="body">Blog body:</label>
          <textarea id="body" name="body" required>{{ old('body', $blog->body) }}</textarea>
          <button>Submit</button>
        </form>
      </div>
      @include('layout.footer')
</body>
</html>