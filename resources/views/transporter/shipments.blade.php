<x-app-layout>
    <div class="pagetitle">
        <h1>Shipments</h1>
          <nav>
              <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                  <li class="breadcrumb-item active">Shipments</li>
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
                        <h5 class="card-title">Shipments</h5>
                        <!-- Table with stripped rows -->
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">reference</th>
                                    <th scope="col">Order #</th>
                                    <th scope="col">Origin</th>
                                    <th scope="col">Destination</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $count = 0;
                                @endphp
                                @foreach ($shipments as $item)
                                    <tr>
                                        <th scope="row">
                                            @php
                                                $count++;
                                                echo $count;
                                            @endphp
                                        </th>
                                        <td>{{ $item->reference }}</td>
                                        <td>
                                            @php
                                                $order = \App\Models\Order::find($item->order_id);
                                                echo $order->code;
                                            @endphp
                                        </td>
                                        <td>
                                            @php
                                                $origin = \App\Models\CheckPoint::find($item->origin);
                                                echo $origin->name;
                                            @endphp
                                        </td>
                                        <td>{{$item->destination}}</td>
                                        <td>
                                            @if ($item->status == 0)
                                                Loading
                                            @elseif ($item->status == 1)
                                                Transit
                                            @elseif ($item->status == 2)
                                                Check Point
                                            @elseif ($item->status == 3)
                                                Missing
                                            @elseif ($item->status == 4)
                                                Delivered
                                            @elseif ($item->status == 5)
                                                Breakdown
                                            @else
                                                Unknown
                                            @endif
                                        </td>
                                        <td>{{ $item->created_at }}</td>
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
