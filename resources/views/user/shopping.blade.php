<x-guest-layout>
    <div class="pagetitle">
        <h1>Shopping</h1>
        <nav>
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.html">Home</a></li>
            <li class="breadcrumb-item">User</li>
            <li class="breadcrumb-item active">Shopping</li>
          </ol>
        </nav>
    </div>
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <x-auth-validation-errors class="alert alert-danger" :errors="$errors" />
                @if (Session::has('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-octagon me-1"></i>
                        {{ Session::get('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if (Session::has('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle me-1"></i>
                        {{ Session::get('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
            </div>
            @foreach ($products as $product)
                <div class="col-md-8 col-lg-4 col-xl-4">
                    <div class="card text-black">
                        <i class="fab fa-apple fa-lg pt-3 pb-1 px-3"></i>
                        <img src="{{ asset('images') }}/{{ $product->img }}" height="250"
                        class="card-img-top" alt="Apple Computer" />
                        <div class="card-body">
                            <div class="text-center">
                                <h5 class="card-title">{{ $product->name }}</h5>
                                <p class="text-muted mb-4">
                                    @php
                                        $category = \App\Models\Category::find($product->category_id);
                                        echo $category->name;
                                    @endphp
                                </p>
                            </div>
                            <div>
                                <div class="d-flex justify-content-between">
                                    <span>Price: </span><span>${{ $product->price }}</span>
                                </div>
                            </div>
                            <div class="d-grid gap-2 mt-3">
                                <a class="btn btn-primary" href="{{ route('add-cart', $product->id) }}">
                                    <i class="bi bi-cart"></i>
                                    Add Cart
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
 </x-guest-layout>
