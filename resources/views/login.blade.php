<!DOCTYPE html>
<html lang="en">
    @include('layout.head') 
<body>

     @include('layout.nav')
      <div class="create-blog content">
    

        @if (session('error'))
        <p style="text-align: center; display: flex; justify-content: center; align-items: center; color:red;">
            {{ session('error') }} 
        </p>
        @endif

     
        <form action="{{ route('login') }}"  method="POST">
            @csrf
          <label for="body">Email:</label>
          <input type="text" id="email" name="email" >
          <label for="body">password:</label>
          <input type="text" id="password" name="password" >
          <button>Submit</button>
        </form>
      </div>
     @include('layout.footer')
</body>
</html>