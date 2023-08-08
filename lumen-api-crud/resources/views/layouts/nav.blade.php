<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="/">Navbar</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <div class="navbar-nav">
            <a class="nav-item nav-link" href="{{ route('master-disease.index')}}">Master Disease</a>
            <a class="nav-item nav-link" href="{{ route('scrap.index')}}">Scraper ODGJ</a>
            <a class="nav-item nav-link" href="{{ route('scrap-tb.index')}}">Scraper TBC</a>

        </div>
    </div>
</nav>