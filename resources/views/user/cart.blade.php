<x-guest-layout>
    <div class="pagetitle">
        <h1>My Cart</h1>
          <nav>
              <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                  <li class="breadcrumb-item active">Cart</li>
              </ol>
          </nav>
    </div>
      <!-- End Page Title -->
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <!-- Validation Errors -->
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
            <div class="col-lg-9">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">My Cart</h5>
                        <!-- Table with stripped rows -->
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">Products</th>
                                    <th scope="col">Price</th>
                                    <th scope="col">Quantity</th>
                                    <th scope="col">Total</th>
                                    <th scope="col">Remove</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $gtotal = 0;
                                @endphp
                                @foreach ($cart as $item)
                                    <tr>
                                        @php
                                            $product = \App\Models\Product::join('product_images', 'product_images.product_id', '=', 'products.id')
                                                ->where('products.id', $item->product_id)
                                                ->select('products.id', 'products.name', 'products.slug', 'products.price', 'product_images.img', 'products.created_at')
                                                ->first();
                                        @endphp
                                        <td><img src="{{ asset('images') }}/{{ $product->img }}" alt="" style="width: 50px;"> {{ $product->name }}</td>
                                        <td>${{ $product->price }}</td>
                                        <td>
                                            <div class="input-group quantity mx-auto" style="width: 100px;">
                                                <div class="input-group-btn">
                                                    <a href="{{ route('decrease-cart', $item->id) }}" class="btn btn-sm btn-primary btn-minus" >
                                                    <i class="bi bi-cart-dash"></i>
                                                    </a>
                                                </div>
                                                <input type="text" class="form-control form-control-sm bg-secondary text-center" value="{{ $item->qty }}">
                                                <div class="input-group-btn">
                                                    <a href="{{ route('increase-cart', $item->id) }}" class="btn btn-sm btn-primary btn-plus">
                                                        <i class="bi bi-cart-plus"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            @php
                                                $ptotal = 0;
                                                $ptotal = $product->price * $item->qty;
                                                $gtotal = $gtotal + $ptotal;
                                                echo "$".$ptotal;
                                            @endphp
                                        </td>
                                        <td>
                                            <a href="{{ route('delete-cart', $item->id) }}" class="btn btn-sm btn-primary">
                                                <i class="bi bi-cart-x"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <!-- End Table with stripped rows -->
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="card border-primary mb-5">
                    <div class="card-header border-0">
                        <h4>Cart Summary</h4>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-3 pt-1">
                            <h6 class="font-weight-medium">Subtotal</h6>
                            <h6 class="font-weight-medium">${{ $gtotal }}</h6>
                        </div>
                    </div>
                    <div class="card-footer border-secondary bg-transparent">
                        <div class="d-flex justify-content-between mt-2">
                            <h5 class="font-weight-bold">Total</h5>
                            <h5 class="font-weight-bold">${{ $gtotal }}</h5>
                        </div>
                        <a href="{{ route('user-checkout') }}" class="btn btn-block btn-primary my-3 py-3">Proceed To Checkout</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-guest-layout>
