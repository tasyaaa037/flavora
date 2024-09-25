<section class="search-bar py-4">
    <div class="container">
        <form action="{{ route('search') }}" method="GET">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Search for restaurant..." name="query">
                <button class="btn btn-primary" type="submit">Search</button>
            </div>
        </form>
    </div>
</section>
