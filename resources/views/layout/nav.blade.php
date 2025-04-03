<nav>
    <div class="site-title">
        <a href="/first"><h1>Blog Daro</h1></a>
        <p>Daro</p>
    </div>
    @if (auth()->check())
    <ul>
        <li><a href="/first">Blog</a></li>
        <li><a href="/aboutblog">About</a></li>
        <li><a href="/blogs/create">New Blog</a></li>
    </ul>
    @endif
   
</nav>