<x-guest-layout>
    <div class="pagetitle">
        <h1>My Orders</h1>
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
                        <h5 class="card-title">My Orders</h5>
                        <!-- Table with stripped rows -->
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Order #</th>
                                    <th scope="col">Items</th>
                                    <th scope="col">Amount</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $count = 0;
                                @endphp
                                @foreach ($orders as $item)
                                    <tr>
                                        <th scope="row">
                                            @php
                                                $count++;
                                                echo $count;
                                            @endphp
                                        </th>
                                        <td>{{ $item->code }}</td>
                                        <td>
                                            @php
                                                $itemcount = \App\Models\OrderItem::where('order_id',$item->id)->count();
                                                echo $itemcount;
                                            @endphp
                                        </td>
                                        <td>{{$item->total}}</td>
                                        <td>
                                            @if ($item->status == 'pending')
                                                <span class="badge bg-secondary">{{$item->status}}</span>
                                            @elseif($item->status == 'shipping')
                                                <span class="badge bg-primary">{{$item->status}}</span>
                                            @else
                                                <span class="badge bg-success">{{$item->status}}</span>
                                            @endif
                                        </td>
                                        <td>{{$item->created_at}}</td>
                                        <td>
                                            <a class="btn btn-success" href="{{ route('user-track',$item->id) }}"><i class="bi bi-map"></i></a>
                                            <a class="btn btn-primary" href=""><i class="bi bi-download"></i></a>
                                        </td>
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
</x-guest-layout>

