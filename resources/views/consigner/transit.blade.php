<x-app-layout>
    <div class="pagetitle">
        <h1>Shipments</h1>
          <nav>
              <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                  <li class="breadcrumb-item active">Transit</li>
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
                        <h5 class="card-title">Shipments In Transit</h5>
                        <!-- Table with stripped rows -->
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">ref</th>
                                    <th scope="col">Current Position</th>
                                    <th scope="col">Destination</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Action</th>
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
                                            @if ($item->status == 1)
                                                Transit
                                            @else
                                                {{ $item->status }}
                                            @endif
                                        </td>
                                        <td>
                                            @if (is_null($item->courier_id))
                                                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addShipment{{ $item->id }}"><i class="bi bi-truck"></i></button>
                                                <a class="btn btn-primary" href="{{ route('consigner-maps',$item->id) }}"><i class="bi bi-map"></i></a>
                                            @endif
                                        </td>
                                        <!-- Add Shipment Modal -->
                                        <div class="modal fade" id="addShipment{{ $item->id }}" tabindex="-1">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <form action="{{ route('consigner-update-transit') }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="shipment_id" value="{{ $item->id }}" required>
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Update Status</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row mb-3">
                                                                <label for="inputText" class="col-sm-2 col-form-label">Status:</label>
                                                                <div class="col-sm-10">
                                                                    <select name="status" class="form-control" required>
                                                                        <option selected disabled>Select Shipment Status</option>
                                                                        <option value="2">Warehouse</option>
                                                                        <option value="3">Missing</option>
                                                                        <option value="5">Breakdown</option>
                                                                    </select>
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
