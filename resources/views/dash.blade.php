<!doctype html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Jekyll v3.8.6">
    <title>Blog Template · Bootstrap</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <!-- Favicons -->
    <link rel="apple-touch-icon" href="/docs/4.4/assets/img/favicons/apple-touch-icon.png" sizes="180x180">
    <link rel="icon" href="/docs/4.4/assets/img/favicons/favicon-32x32.png" sizes="32x32" type="image/png">
    <link rel="icon" href="/docs/4.4/assets/img/favicons/favicon-16x16.png" sizes="16x16" type="image/png">
    <link rel="manifest" href="/docs/4.4/assets/img/favicons/manifest.json">
    <link rel="mask-icon" href="/docs/4.4/assets/img/favicons/safari-pinned-tab.svg" color="#563d7c">
    <link rel="icon" href="/docs/4.4/assets/img/favicons/favicon.ico">
    <meta name="msapplication-config" content="/docs/4.4/assets/img/favicons/browserconfig.xml">
    <meta name="theme-color" content="#563d7c">


    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
      /* stylelint-disable selector-list-comma-newline-after */

    .blog-header {
    line-height: 1;
    border-bottom: 1px solid #e5e5e5;
    }

    .blog-header-logo {
    font-family: "Playfair Display", Georgia, "Times New Roman", serif;
    font-size: 2.25rem;
    }

    .blog-header-logo:hover {
    text-decoration: none;
    }

    .display-4 {
    font-size: 2.5rem;
    }
    @media (min-width: 768px) {
    .display-4 {
        font-size: 3rem;
    }
    }

    .nav-scroller {
    position: relative;
    z-index: 2;
    height: 2.75rem;
    overflow-y: hidden;
    }

    .nav-scroller .nav {
    display: -ms-flexbox;
    display: flex;
    -ms-flex-wrap: nowrap;
    flex-wrap: nowrap;
    padding-bottom: 1rem;
    margin-top: -1px;
    overflow-x: auto;
    text-align: center;
    white-space: nowrap;
    -webkit-overflow-scrolling: touch;
    }

    .nav-scroller .nav-link {
    padding-top: .75rem;
    padding-bottom: .75rem;
    font-size: .875rem;
    }

    .card-img-right {
    height: 100%;
    border-radius: 0 3px 3px 0;
    }

    .flex-auto {
    -ms-flex: 0 0 auto;
    flex: 0 0 auto;
    }

    .h-250 { height: 250px; }
    @media (min-width: 768px) {
    .h-md-250 { height: 250px; }
    }

    /* Pagination */
    .blog-pagination {
    margin-bottom: 4rem;
    }
    .blog-pagination > .btn {
    border-radius: 2rem;
    }

    /*
    * Blog posts
    */
    .blog-post {
    margin-bottom: 4rem;
    }
    .blog-post-title {
    margin-bottom: .25rem;
    font-size: 2.5rem;
    }
    .blog-post-meta {
    margin-bottom: 1.25rem;
    color: #999;
    }

    /*
    * Footer
    */
    .blog-footer {
    padding: 2.5rem 0;
    color: #999;
    text-align: center;
    background-color: #f9f9f9;
    border-top: .05rem solid #e5e5e5;
    }
    .blog-footer p:last-child {
    margin-bottom: 0;
}
    </style>
    <!-- Custom styles for this template -->
    <link href="https://fonts.googleapis.com/css?family=Playfair+Display:700,900" rel="stylesheet">
  </head>
  <body>
    <div class="container">
  <header class="blog-header py-3">
    <div class="row flex-nowrap justify-content-between align-items-center">
      <div class="col-4 text-center">
        <a class="blog-header-logo text-dark" href="#">🛍️ E-Commerce</a>
      </div>
      <div class="col-4 d-flex justify-content-end align-items-center">

      <div class="hidden sm:flex sm:items-center sm:ml-6">
                <a href="{{ url('/log_out') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-sign-in-alt"></i> Logout
            </a>
            </div>
        <a class="text-muted" href="#" aria-label="Search">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="mx-3" role="img" viewBox="0 0 24 24" focusable="false"><title>Search</title><circle cx="10.5" cy="10.5" r="7.5"/><path d="M21 21l-5.2-5.2"/></svg>
        </a>
      </div>
    </div>
  </header>

  <div class="jumbotron p-4 p-md-5 text-white rounded bg-dark">
    <div class="col-md-6 px-0">
      <h1 class="display-4 font-italic">Vente de t-shirts et chemises Homme et Femme</h1>
    </div>
  </div>

  <h3 class="pb-4 mb-4 font-italic border-bottom">
        Notre Catalogue
      </h3>
  <div class="row mb-2">
    @foreach ($products as $product)
      <div class="col-md-6">
        <a href="{{ route('products.show', ['id' => $product->id]) }}" style="text-decoration: none;">
        <div class="row no-gutters border rounded overflow-hidden flex-md-row mb-4 shadow-sm position-relative">
                <div class="card w-100">
                    <div class="text-center">
                        <img src="{{ asset($product->image) }}" style="max-height: 200px;" alt="Product Image">
                    </div>
                    <div class="card-body">
                        <p class="card-text text-muted">{{ $product->name }} (${{ $product->price }})</p>
                        <a href="{{route('add-to-cart',$product->id)}}"  style="margin-top: 40px;" class="stretched-link btn btn-info">Ajouter au panier</a>
                    </div>
                </div>
        </div>
        </a>
      </div>
    @endforeach
  </div>

</body>
</html>