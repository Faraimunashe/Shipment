<x-app-layout>
    <!-- Cart Start -->
    <div class="container-fluid pt-5">
        <div class="row px-xl-5">
            <div class="col-lg-8 table-responsive mb-5">
                <table class="table table-bordered text-center mb-0">
                    <thead class="bg-secondary text-dark">
                        <tr>
                            <th>Products</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                            <th>Remove</th>
                        </tr>
                    </thead>
                    <tbody class="align-middle">
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
                                <td class="align-middle"><img src="{{ asset('images') }}/{{ $product->img }}" alt="" style="width: 50px;"> {{ $product->name }}</td>
                                <td class="align-middle">${{ $product->price }}</td>
                                <td class="align-middle">
                                    <div class="input-group quantity mx-auto" style="width: 100px;">
                                        <div class="input-group-btn">
                                            <a href="{{ route('decrease-cart', $item->id) }}" class="btn btn-sm btn-primary btn-minus" >
                                            <i class="fa fa-minus"></i>
                                            </a>
                                        </div>
                                        <input type="text" class="form-control form-control-sm bg-secondary text-center" value="{{ $item->qty }}">
                                        <div class="input-group-btn">
                                            <a href="{{ route('increase-cart', $item->id) }}" class="btn btn-sm btn-primary btn-plus">
                                                <i class="fa fa-plus"></i>
                                            </a>
                                        </div>
                                    </div>
                                </td>
                                <td class="align-middle">
                                    @php
                                        $ptotal = 0;
                                        $ptotal = $product->price * $item->qty;
                                        $gtotal = $gtotal + $ptotal;
                                        echo "$".$ptotal;
                                    @endphp
                                </td>
                                <td class="align-middle"><a href="{{ route('delete-cart', $item->id) }}" class="btn btn-sm btn-primary"><i class="fa fa-times"></i></a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="col-lg-4">
                <div class="card border-secondary mb-5">
                    <div class="card-header bg-secondary border-0">
                        <h4 class="font-weight-semi-bold m-0">Cart Summary</h4>
                    </div>
                    <div class="card-body">
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
                        <a href="{{ route('user-checkout') }}" class="btn btn-block btn-primary my-3 py-3">Proceed To Checkout</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Cart End -->
</x-app-layout>
