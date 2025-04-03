<nav>
    <div class="site-title">
        <a href="/first"><h1>Blog Daro</h1></a>
        <p>Daro</p>
    </div>
    @if (auth()->check())
    <ul>
        <li><a href="{{ route('dashboard') }}">dashboard</a></li>
        <li><a href="{{ route('list') }}">All Blogs</a></li>
        <li><a href="{{ route('create_blog') }}">New Blog</a></li>
    </ul>
    @endif
   
</nav>