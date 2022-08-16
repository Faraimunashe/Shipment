<x-guest-layout>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" referrerpolicy="no-referrer"></script>
    <div class="pagetitle">
        <h1>Order Checkout</h1>
        <nav>
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item">Order</li>
            <li class="breadcrumb-item active">Checkout</li>
          </ol>
        </nav>
    </div><!-- End Page Title -->
    @php
        $gtotal = 0;
    @endphp
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
          <div class="col-lg-12">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title">Billing Details</h5>
                <!-- Horizontal Form -->
                <form action="{{ route('user-checkout-post') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="row mb-3">
                                <label for="inputEmail3" class="col-sm-2 col-form-label">Firstname</label>
                                <div class="col-sm-10">
                                    <input type="text" name="firstname" class="form-control" id="inputText" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="inputEmail3" class="col-sm-2 col-form-label">Lastname</label>
                                <div class="col-sm-10">
                                    <input type="text" name="lastname" class="form-control" id="inputText" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="inputEmail3" class="col-sm-2 col-form-label">Email</label>
                                <div class="col-sm-10">
                                    <input type="text" name="email" class="form-control" id="inputText" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="inputEmail3" class="col-sm-2 col-form-label">Phone</label>
                                <div class="col-sm-10">
                                    <input type="text" name="phone" class="form-control" id="inputText" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="inputEmail3" class="col-sm-2 col-form-label">Zip Code</label>
                                <div class="col-sm-10">
                                    <input type="text" name="zip" class="form-control" id="inputText" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="inputEmail3" class="col-sm-2 col-form-label">Address Line1</label>
                                <div class="col-sm-10">
                                    <input type="text" name="addr1" class="form-control" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="inputEmail3" class="col-sm-2 col-form-label">Address Line2</label>
                                <div class="col-sm-10">
                                    <input type="text" name="addr2" class="form-control" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="inputEmail3" class="col-sm-2 col-form-label">City</label>
                                <div class="col-sm-10">
                                    <input type="text" name="city" class="form-control" id="inputText" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="inputEmail3" class="col-sm-2 col-form-label">State</label>
                                <div class="col-sm-10">
                                    <input type="text" name="state" class="form-control" id="inputText" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="inputEmail3" class="col-sm-2 col-form-label">Country</label>
                                <div class="col-sm-10">
                                    <select name="country" class="form-control" id="inputText" required>
                                        <option selected disabled>Select Country</option>
                                        <option value="Botswana">Botswana</option>
                                        <option value="South Africa">South Africa</option>
                                        <option value="United Kingdom">United Kingdom</option>
                                        <option value="Spain">Spain</option>
                                        <option value="Zambia">Zambia</option>
                                        <option value="Zimbabwe">Zimbabwe</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="card border-primary">
                                <div class="card-header">
                                    <h5>Choose Consigner</h5>
                                </div>
                                <div class="card-body">
                                    <hr class="mt-0">
                                    <fieldset class="row mb-3">
                                        @foreach ($consigners as $consigner)
                                            <div class="d-flex justify-content-between">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="consigner_id" id="consignerfee{{ $consigner->id }}" value="{{ $consigner->id }}" required>
                                                    <label class="form-check-label" for="consignerfee">
                                                        <div> {{ $consigner->name }} $
                                                            <div id="theAmount{{ $consigner->id }}">{{ $consigner->pricing }}</div>
                                                        </div>
                                                    </label>
                                                </div>
                                                <script>
                                                    var the_amount{{ $consigner->id }} = document.getElementById("theAmount{{ $consigner->id }}");

                                                    $('#consignerfee{{ $consigner->id }}').change(function(){

                                                        if($(this).is(':checked')){
                                                            // Checkbox is checked.
                                                            var subtotal = document.getElementById('subbb');
                                                            var gt = parseFloat(the_amount{{ $consigner->id }}.textContent) + parseFloat(subtotal.textContent);


                                                            $("#sfee").html(the_amount{{ $consigner->id }}.innerText);
                                                            $("#ssfee").html(the_amount{{ $consigner->id }}.innerText);
                                                            $("#gto").html(gt);
                                                        }else{
                                                            // Checkbox is not checked.
                                                        }

                                                    });
                                                </script>
                                            </div>
                                            <hr class="mt-0">
                                        @endforeach
                                    </fieldset>
                                </div>
                                <div class="card-footer border-secondary bg-transparent">
                                    <div class="d-flex justify-content-between mt-2">
                                        <h5 class="font-weight-bold">Shipping Fee</h5>
                                        <h5 class="font-weight-bold" id="sfee"></h5>
                                    </div>
                                </div>
                            </div>
                            <div class="card border-primary">
                                <div class="card-header">
                                    <h5>Products</h5>
                                </div>
                                <div class="card-body">

                                    @foreach ($cart as $item)
                                        @php
                                            $product = \App\Models\Product::join('product_images', 'product_images.product_id', '=', 'products.id')
                                                ->where('products.id', $item->product_id)
                                                ->select('products.id', 'products.name', 'products.slug', 'products.price', 'product_images.img', 'products.created_at')
                                                ->first();
                                        @endphp
                                        <div class="d-flex justify-content-between">
                                            <p>{{ $product->name }}  x{{ $item->qty }}</p>
                                            <p>
                                                @php
                                                $ptotal = 0;
                                                $ptotal = $product->price * $item->qty;
                                                $gtotal = $gtotal + $ptotal;
                                                echo "$".$ptotal;
                                            @endphp
                                            </p>
                                        </div>
                                    @endforeach
                                    <hr class="mt-0">
                                    <div class="d-flex justify-content-between mb-3 pt-1">
                                        <h6 class="font-weight-medium">Subtotal</h6>
                                        <h6 class="font-weight-medium" id="subbb">{{ $gtotal }}</h6>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <h6 class="font-weight-medium">Shipping</h6>
                                        <h6 class="font-weight-medium" id="ssfee"></h6>
                                    </div>
                                </div>
                                <div class="card-footer border-secondary bg-transparent">
                                    <div class="d-flex justify-content-between mt-2">
                                        <h5 class="font-weight-bold">Total</h5>
                                        <script>

                                        </script>
                                        <h5 class="font-weight-bold" id="gto">{{ $gtotal }}</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="card border-primary">
                                <div class="card-body">
                                    <input type="hidden" name="gtotal" value="{{ $gtotal }}" required>
                                    <input type="hidden" name="sfee" value="0" required>
                                    <input type="hidden" name="total" value="{{ $gtotal }}" required>
                                </div>
                                <div class="d-grid gap-2">
                                    <button class="btn btn-primary" type="submit">
                                        <i class="bi bi-cash"></i>
                                        Place Order
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form><!-- End Horizontal Form -->
              </div>
            </div>
          </div>
        </div>
    </section>

</x-guest-layout>
