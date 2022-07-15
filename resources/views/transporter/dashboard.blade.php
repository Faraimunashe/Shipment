<x-app-layout>
    <div class="pagetitle">
        <h1>Dashboard</h1>
        <nav>
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.html">Home</a></li>
            <li class="breadcrumb-item">Courrier</li>
            <li class="breadcrumb-item active">Dashboard</li>
          </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section profile">
        <div class="row">
          <div class="col-xl-4">
            <div class="card">
              <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
                <h2>{{$transporter->name}}</h2>
                <h3>
                    @if (is_null($shipment))
                        <span class="badge bg-warning">off duty</span>
                    @else
                        <span class="badge bg-success">on duty</span>
                    @endif
                </h3>
                <h3>{{$transporter->regnum}}</h3>
              </div>
            </div>

          </div>

          <div class="col-xl-8">

            <div class="card">
              <div class="card-body pt-3">
                <!-- Bordered Tabs -->
                <ul class="nav nav-tabs nav-tabs-bordered">
                  <li class="nav-item">
                    <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Shipment</button>
                  </li>

                  <li class="nav-item">
                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Items</button>
                  </li>

                  <li class="nav-item">
                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-settings">Update Location</button>
                  </li>
                </ul>
                <div class="tab-content pt-2">

                    <div class="tab-pane fade show active profile-overview" id="profile-overview">
                        <h5 class="card-title">Shipment Details</h5>

                        <div class="row">
                        <div class="col-lg-3 col-md-4 label ">Reference</div>
                        <div class="col-lg-9 col-md-8">{{$shipment->reference}}</div>
                        </div>

                        <div class="row">
                        <div class="col-lg-3 col-md-4 label">Order #</div>
                        <div class="col-lg-9 col-md-8">
                            @if (!is_null($order))
                                {{$order->code}}
                            @endif
                        </div>
                        </div>

                        <div class="row">
                        <div class="col-lg-3 col-md-4 label">Status</div>
                        <div class="col-lg-9 col-md-8">
                            @if ($shipment->status == 0)
                                Loading
                            @elseif ($shipment->status == 1)
                                Transit
                            @elseif ($shipment->status == 2)
                                Check Point
                            @elseif ($shipment->status == 3)
                                Missing
                            @elseif ($shipment->status == 4)
                                Delivered
                            @elseif ($shipment->status == 5)
                                Breakdown
                            @else
                                Unknown
                            @endif
                        </div>
                        </div>

                        <div class="row">
                        <div class="col-lg-3 col-md-4 label">Origin</div>
                            <div class="col-lg-9 col-md-8">
                                @if (!is_null($origin))
                                    {{$origin->name}}
                                @endif
                            </div>
                        </div>

                        <div class="row">
                        <div class="col-lg-3 col-md-4 label">Next Stop</div>
                        <div class="col-lg-9 col-md-8">
                            @if (!is_null($checkpoint))
                                {{$checkpoint->name}}
                            @endif
                        </div>
                        </div>

                        <div class="row">
                        <div class="col-lg-3 col-md-4 label">Destination</div>
                        <div class="col-lg-9 col-md-8">{{$shipment->destination}}</div>
                        </div>

                        <div class="row">
                        <div class="col-lg-3 col-md-4 label">Current Location</div>
                        <div class="col-lg-9 col-md-8">{{$shipment->current_position}}</div>
                        </div>

                    </div>

                    <div class="tab-pane fade profile-edit pt-3" id="profile-edit">
                        <h5 class="card-title">Shipment Items</h5>
                        <!-- Table with stripped rows -->
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Product</th>
                                    <th scope="col">Quantity</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $count = 0;
                                @endphp
                                @foreach ($shipitems as $item)
                                    <tr>
                                        <td>
                                            @php
                                                $count++;
                                                echo $count;
                                            @endphp
                                        </td>
                                        <td>{{$item->product_name}}</td>
                                        <td>{{$item->qty}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="tab-pane fade pt-3" id="profile-settings">
                        <h5 class="card-title">Set Current Location</h5>
                        <!-- Change Password Form -->
                        <a href="{{route('transporter-location', $shipment->id)}}" class="btn btn-primary">Click Here</a>

                    </div>
                </div><!-- End Bordered Tabs -->

              </div>
            </div>

          </div>
        </div>
        <div id="address-map-container" style="width:100%;height:400px; ">
            <div style="width: 100%; height: 100%" id="address-map"></div>
        </div>
    </section>

</x-app-layout>
