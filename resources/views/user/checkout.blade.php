<x-guest-layout>
    <!-- Checkout Start -->
    <div class="container-fluid pt-5">
        <div class="row px-xl-5">
            <form action="{{ route('user-checkout-post') }}" method="POST">
                @csrf
                <div class="col-lg-8">
                    <div class="mb-4">
                        <h4 class="font-weight-semi-bold mb-4">Billing Address</h4>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label>First Name</label>
                                <input class="form-control" name="firstname" type="text" required>
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Last Name</label>
                                <input class="form-control" name="lastname" type="text" required>
                            </div>
                            <div class="col-md-6 form-group">
                                <label>E-mail</label>
                                <input class="form-control" name="email" type="email" required>
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Mobile No</label>
                                <input class="form-control" name="phone" type="tel" required>
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Address Line 1</label>
                                <input class="form-control" name="addr1" type="text" required>
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Address Line 2</label>
                                <input class="form-control" name="addr2" type="text" required>
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Country</label>
                                <select name="country" class="custom-select" required>
                                    <option selected disabled>Select Country</option>
                                    <option value="Zimbabwe">Zimbabwe</option>
                                </select>
                            </div>
                            <div class="col-md-6 form-group">
                                <label>City</label>
                                <input class="form-control" name="city" type="text" required>
                            </div>
                            <div class="col-md-6 form-group">
                                <label>State</label>
                                <input class="form-control" name="state" type="text" required>
                            </div>
                            <div class="col-md-6 form-group">
                                <label>ZIP Code</label>
                                <input class="form-control" name="zip" type="text" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card border-secondary mb-5">
                        <div class="card-header bg-secondary border-0">
                            <h4 class="font-weight-semi-bold m-0">Order Total</h4>
                        </div>
                        <div class="card-body">
                            <h5 class="font-weight-medium mb-3">Products</h5>
                            @php
                                $gtotal = 0;
                            @endphp
                            @foreach ($cart as $item)
                                @php
                                    $product = \App\Models\Product::join('product_images', 'product_images.product_id', '=', 'products.id')
                                        ->where('products.id', $item->product_id)
                                        ->select('products.id', 'products.name', 'products.slug', 'products.price', 'product_images.img', 'products.created_at')
                                        ->first();
                                @endphp
                                <div class="d-flex justify-content-between">
                                    <p>{{ $product->name }} {{ $item->qty }}</p>
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
                                <h6 class="font-weight-medium">${{ $gtotal }}</h6>
                            </div>
                            <div class="d-flex justify-content-between">
                                <h6 class="font-weight-medium">Shipping</h6>
                                <h6 class="font-weight-medium">
                                    @php
                                        $sfee = \App\Models\ShipFee::first();
                                        echo "$".$sfee->amount;
                                    @endphp
                                </h6>
                            </div>
                        </div>
                        <div class="card-footer border-secondary bg-transparent">
                            <div class="d-flex justify-content-between mt-2">
                                <h5 class="font-weight-bold">Total</h5>
                                <h5 class="font-weight-bold">${{ $sfee->amount + $gtotal }}</h5>
                            </div>
                        </div>
                    </div>
                    <div class="card border-secondary mb-5">
                        <div class="card-header bg-secondary border-0">
                            <h4 class="font-weight-semi-bold m-0">Payment</h4>
                        </div>
                        <div class="card-body">
                            <input type="hidden" name="gtotal" value="{{ $gtotal }}" required>
                            <input type="hidden" name="sfee" value="{{ $sfee->amount }}" required>
                            <input type="hidden" name="total" value="{{ $sfee->amount + $gtotal }}" required>
                        </div>
                        <div class="card-footer border-secondary bg-transparent">
                            <button type="submit" class="btn btn-lg btn-block btn-primary font-weight-bold my-3 py-3">Place Order</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- Checkout End -->
</x-guest-layout>
