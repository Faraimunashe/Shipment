<x-app-layout>
    <div class="pagetitle">
        <h1>Orders</h1>
          <nav>
              <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                  <li class="breadcrumb-item active">Orders</li>
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
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Orders</h5>
                        <!-- Table with stripped rows -->
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Order #</th>
                                    <th scope="col">Customer</th>
                                    <th scope="col">Amount</th>
                                    <th scope="col">Items</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $count = 0;
                                @endphp
                                @foreach ($orders as $order)
                                    <tr>
                                        <th scope="row">
                                            @php
                                                $count++;
                                                echo $count;
                                            @endphp
                                        </th>
                                        <td>{{ $order->code }}</td>
                                        <td>
                                            @php
                                                $customer = \App\Models\User::find($order->user_id);
                                                echo $customer->name;
                                            @endphp
                                        </td>
                                        <td>${{ $order->total }}</td>
                                        <td>
                                            @php
                                                $itemcount = \App\Models\OrderItem::where('order_id',$order->id)->count();
                                                echo $itemcount;
                                            @endphp
                                        </td>
                                        <td>
                                            @if ($order->status == 'pending')
                                                <span class="badge bg-secondary">{{$order->status}}</span>
                                            @elseif($order->status == 'shipping')
                                                <span class="badge bg-primary">{{$order->status}}</span>
                                            @else
                                                <span class="badge bg-success">{{$order->status}}</span>
                                            @endif
                                        </td>
                                        <td>{{ $order->created_at }}</td>
                                        <td>
                                            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addShipment{{ $order->id }}"><i class="bi bi-truck"></i></button>
                                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteCategory{{ $order->id }}"><i class="bi bi-trash"></i></button>
                                        </td>
                                        <!-- Add Shipment Modal -->
                                        <div class="modal fade" id="addShipment{{ $order->id }}" tabindex="-1">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <form action="{{ route('admin-add-shipments') }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="order_id" value="{{ $order->id }}" required>
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Add Shipment</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row mb-3">
                                                                <label for="inputText" class="col-sm-2 col-form-label">Transporter:</label>
                                                                <div class="col-sm-10">
                                                                    <select name="transporter_id" class="form-control" value="" required>
                                                                        <option selected disabled></option>
                                                                        @foreach ($transporters as $transporter)
                                                                            <option value="{{$transporter->id}}">{{$transporter->name}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="row mb-3">
                                                                <label for="inputText" class="col-sm-2 col-form-label">Next Stop:</label>
                                                                <div class="col-sm-10">
                                                                    <select name="next_point_id" class="form-control" value="" required>
                                                                        <option selected disabled></option>
                                                                        @foreach ($points as $point)
                                                                            <option value="{{$point->id}}">{{$point->name}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="row mb-3">
                                                                <label for="inputText" class="col-sm-2 col-form-label">Origin:</label>
                                                                <div class="col-sm-10">
                                                                    <select name="origin" class="form-control" value="" required>
                                                                        <option selected disabled></option>
                                                                        @foreach ($points as $point)
                                                                            <option value="{{$point->id}}">{{$point->name}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="row mb-3">
                                                                <label for="inputText" class="col-sm-2 col-form-label">Destination:</label>
                                                                <div class="col-sm-10">
                                                                    <input type="text" name="destination" class="form-control" placeholder="-18.987654, 26.098765" required>
                                                                </div>
                                                            </div>
                                                            <div class="row mb-3">
                                                                <label for="inputText" class="col-sm-2 col-form-label">Current Position:</label>
                                                                <div class="col-sm-10">
                                                                    <input type="text" name="current_position" class="form-control" placeholder="-18.987654, 26.098765" required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-primary">Save changes</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End Add Shipment Modal-->
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <!-- End Table with stripped rows -->
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>
