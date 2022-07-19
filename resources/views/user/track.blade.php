<x-guest-layout>
    <div class="pagetitle">
        <h1>Tracking</h1>
          <nav>
              <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="{{ route('user-orders') }}">Order</a></li>
                  <li class="breadcrumb-item active">Tracking</li>
              </ol>
          </nav>
    </div>
      <!-- End Page Title -->
    <section class="section">
        <div class="row">
            <div class="col-lg-9">
                <div class="card">
                    <div class="card-header">Map Rendered</div>
                    <div class="card-body profile-card pt-4 d-flex flex-column">
                        <div class="row">
                            <div class="col-lg-12">
                                @php
                                    $cpOrigin = \App\Models\CheckPoint::find($shipment->origin);
                                @endphp
                                @if ($shipment->current_position == "-19.51847555,29.83736827")
                                    <iframe
                                        width="700"
                                        height="450"
                                        frameborder="2" style="border:2"
                                        referrerpolicy="no-referrer-when-downgrade"
                                        src="https://www.google.com/maps/embed/v1/directions?key={{env('GOOGLE_MAP_KEY')}}&origin={{$shipment->origin}}&destination={{$cpOrigin->cordinates}}&avoid=tolls|highways"
                                        allowfullscreen>
                                    </iframe>
                                @else
                                    @php
                                        $ways = \App\Models\WayPoint::where('shipment_id', $shipment->id)->get();
                                        //dd($ways);
                                    @endphp
                                    @if ($ways->isEmpty())
                                        <iframe
                                            width="700"
                                            height="450"
                                            frameborder="2" style="border:2"
                                            referrerpolicy="no-referrer-when-downgrade"
                                            src="https://www.google.com/maps/embed/v1/directions?key={{env('GOOGLE_MAP_KEY')}}&origin={{$shipment->origin}}&destination={{$shipment->current_position}}&avoid=tolls|highways"
                                            allowfullscreen>
                                        </iframe>
                                    @else
                                        @php
                                            $waypoints = "";
                                            $counter = $ways->count();
                                            $i = 0;
                                            foreach($ways as $way)
                                            {
                                                $i++;
                                                $waypoints = $waypoints.$way->cords;
                                                if($i<$counter)
                                                {
                                                    $waypoints = $waypoints."|";
                                                }
                                            }
                                            //echo $waypoints;
                                        @endphp
                                        <iframe
                                            width="700"
                                            height="450"
                                            frameborder="2" style="border:2"
                                            referrerpolicy="no-referrer-when-downgrade"
                                            src="https://www.google.com/maps/embed/v1/directions?key={{env('GOOGLE_MAP_KEY')}}&origin={{$shipment->origin}}&destination={{$shipment->current_position}}&avoid=tolls|highways&waypoints={{$waypoints}}"
                                            allowfullscreen>
                                        </iframe>
                                    @endif

                                @endif
                            </div>
                            <div class="col-lg-12 table-responsive mb-5">
                                <hr class="mt-0">
                                <h4> <strong>Order Items</strong></h4>
                                <hr class="mt-0">
                                <!-- Table with stripped rows -->
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Product</th>
                                        <th scope="col">Qty</th>
                                        <th scope="col">Unit Price</th>
                                        <th scope="col">Total Price</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $count = 0;
                                        @endphp
                                        @foreach ($orderitems as $item)
                                            <tr>
                                                <th scope="row">
                                                    @php
                                                        $count++;
                                                        echo $count;
                                                    @endphp
                                                </th>
                                                <td>{{$item->product_name}}</td>
                                                <td>{{$item->qty}}</td>
                                                <td>{{$item->price}}</td>
                                                <td>{{$item->total}}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                        <!-- End Table with stripped rows -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="card">
                    <div class="card-header">Overview</div>
                    <div class="card-body profile-card pt-4 d-flex flex-column">
                        <div><b>Time: </b>14 Days</div>
                        <hr class="mt-0">
                        <div><b>Delay: </b>3 Days</div>
                        <hr class="mt-0">
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">Tracking Details</div>
                    <div class="card-body profile-card pt-4 d-flex flex-column">
                        <div class="row">
                            <div><b>Reference: </b>{{ $shipment->reference }}</div>
                        </div><hr class="mt-0">
                        <div><b>Consigner: </b>{{ $consigner->name }}</div>
                        <hr class="mt-0">
                        <div><b>Courier: </b>
                            @if (is_null($shipment->courier_id))
                                Unsigned Yet
                            @else
                                @php
                                    $cor = \App\Models\Courier::find($shipment->courier_id);
                                    echo $cor->name;
                                @endphp
                            @endif
                        </div>
                        <hr class="mt-0">
                        <div><b>Order #: </b>{{ $order->code }}</div>
                        <hr class="mt-0">
                        <div><b>Status: </b>
                            @if ($shipment->status == 0)
                                <span class="badge bg-secondary text-dark">
                                    <i class="bi bi-info-circle me-1"></i>
                                    Loading
                                </span>
                            @elseif ($shipment->status == 1)
                                <span class="badge bg-info text-dark">
                                    <i class="bi bi-info-circle me-1"></i>
                                    Transit
                                </span>
                            @elseif ($shipment->status == 2)
                                <span class="badge bg-warning text-dark">
                                    <i class="bi bi-info-circle me-1"></i>
                                    Warehouse
                                </span>
                            @elseif ($shipment->status == 3)
                                <span class="badge bg-danger text-dark">
                                    <i class="bi bi-info-circle me-1"></i>
                                    Missing
                                </span>
                            @elseif ($shipment->status == 4)
                                <span class="badge bg-success text-dark">
                                    <i class="bi bi-info-circle me-1"></i>
                                    Delivered
                                </span>
                            @elseif ($shipment->status == 5)
                                <span class="badge bg-dark text-dark">
                                    <i class="bi bi-info-circle me-1"></i>
                                    Breakdown
                                </span>
                            @else
                                Unknown
                            @endif
                        </div>
                        <hr class="mt-0">
                        <div><b>Origin: </b>{{ $shipment->origin }}</div>
                        <hr class="mt-0">
                        <div><b>Current: </b>{{ $shipment->current_position }}</div>
                        <hr class="mt-0">
                        <div><b>Next Stop: </b></div>
                            @php
                                $nextstop = \App\Models\CheckPoint::find($shipment->next_point_id);
                                if(is_null($nextstop)){
                                    echo $order->destination_name;
                                }else{
                                    echo $nextstop->name;
                                }
                            @endphp
                        <hr class="mt-0">
                        <div><b>Destination: </b></div><p>{{ $order->destination_name }}</p>
                        <hr class="mt-0">
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-guest-layout>
