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
                                    <th scope="col">ref</th>
                                    <th scope="col">Current Position</th>
                                    <th scope="col">Destination</th>
                                    <th scope="col">Status</th>
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
                                        <td>{{$item->current_position}}</td>
                                        <td>{{$item->destination_name}}</td>
                                        <td>
                                            @if ($item->status == 0)
                                                <span class="badge bg-secondary text-dark">
                                                    <i class="bi bi-info-circle me-1"></i>
                                                    Loading
                                                </span>
                                            @elseif ($item->status == 1)
                                                <span class="badge bg-info text-dark">
                                                    <i class="bi bi-info-circle me-1"></i>
                                                    Transit
                                                </span>
                                            @elseif ($item->status == 2)
                                                <span class="badge bg-warning text-dark">
                                                    <i class="bi bi-info-circle me-1"></i>
                                                    Warehouse
                                                </span>
                                            @elseif ($item->status == 3)
                                                <span class="badge bg-danger text-dark">
                                                    <i class="bi bi-info-circle me-1"></i>
                                                    Missing
                                                </span>
                                            @elseif ($item->status == 4)
                                                <span class="badge bg-success text-dark">
                                                    <i class="bi bi-info-circle me-1"></i>
                                                    Delivered
                                                </span>
                                            @elseif ($item->status == 5)
                                                <span class="badge bg-dark text-dark">
                                                    <i class="bi bi-info-circle me-1"></i>
                                                    Breakdown
                                                </span>
                                            @else
                                                Unknown
                                            @endif
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
</x-app-layout>
