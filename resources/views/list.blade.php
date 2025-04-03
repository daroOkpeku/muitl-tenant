<!DOCTYPE html>
<html lang="en">
    @include('layout.head') 
<body>

    @include('layout.nav')

    <div class="blogs content">
        <h2>All Blogs</h2>

        
            @foreach ($blogs as $blog)
            <a >
                <h3 class="title">{{$blog->title}}</h3>
                <p class="snippet">{{$blog->heading}}</p>
                <span class="icons_del">
                    <button onclick="window.location.href='{{ route('del_list', ['id' => $blog->id]) }}'" class="btn_del">
                        <i class="ri-delete-bin-line"></i>
                    </button>
                  <button  onclick="window.location.href='{{ route('edit_blog', ['id' => $blog->id]) }}'" class="btn_edit">
                    <i class="ri-edit-2-line"></i>
                  </button>
                </span>
            </a>  
            @endforeach
            
               
          
      

        {{-- <h3 class="title">no data availiable</h3>  --}}
   
    </div>

    @include('layout.footer')

</body>
</html>