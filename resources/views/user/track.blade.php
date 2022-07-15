<x-guest-layout>
    <!-- Cart Start -->
    <div class="container-fluid pt-5">
        <div class="row px-xl-5">
            <div class="col-lg-4">
                <!-- Card with header and footer -->
                <div class="card">
                    <div class="card-header">Tracking Details</div>
                    <div class="card-body">
                        <!-- List group with custom content -->
                        <ol class="list-group list-group-numbered">
                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                <div class="ms-2 me-auto">
                                    <div class="fw-bold"><b>Shipment Ref: </b></div>
                                    {{$shipment->reference}}
                                </div>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                <div class="ms-2 me-auto">
                                    <div class="fw-bold"><b>Transport Mode: </b></div>
                                    @php
                                        $trans = \App\Models\Transporter::find($shipment->transporter_id);
                                        echo $trans->type;
                                    @endphp
                                </div>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                <div class="ms-2 me-auto">
                                    <div class="fw-bold"><b>Transporter: </b></div>
                                    {{$trans->name}}
                                </div>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                <div class="ms-2 me-auto">
                                    <div class="fw-bold"><b>Order #: </b></div>
                                    {{$shipment->order_id}}
                                    @php
                                        $ordery = \App\Models\Order::find($shipment->order_id);
                                        echo $ordery->code;
                                    @endphp
                                </div>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                <div class="ms-2 me-auto">
                                    <div class="fw-bold"><b>Status: </b></div>
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
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                <div class="ms-2 me-auto">
                                    <div class="fw-bold"><b>Origin: </b></div>
                                    @php
                                        $origin = \App\Models\CheckPoint::find($shipment->origin);
                                        echo $origin->name;
                                    @endphp
                                </div>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                <div class="ms-2 me-auto">
                                    <div class="fw-bold"><b>Current Location: </b></div>
                                    {{$shipment->current_position}}
                                </div>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                <div class="ms-2 me-auto">
                                    <div class="fw-bold"><b>Next Stop: </b></div>
                                    @php
                                        $checkpoint = \App\Models\CheckPoint::find($shipment->next_point_id);
                                        echo $checkpoint->name;
                                    @endphp
                                </div>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                <div class="ms-2 me-auto">
                                    <div class="fw-bold"><b>Destination: </b></div>
                                    {{$shipment->destination}}
                                </div>
                            </li>
                        </ol>
                        <!-- End with custom content -->
                    </div>
                    <div class="card-footer">
                    Live Tracking
                    </div>
                </div>
                <!-- End Card with header and footer -->
            </div>
            <div class="col-lg-8">
                <div class="row">
                    <div class="col-lg-12">
                        @php
                            $cpOrigin = \App\Models\CheckPoint::find($shipment->origin);
                        @endphp
                        @if ($shipment->current_position == "-19.51847555,29.83736827")
                            <iframe
                                width="750"
                                height="350"
                                frameborder="2" style="border:2"
                                referrerpolicy="no-referrer-when-downgrade"
                                src="https://www.google.com/maps/embed/v1/directions?key={{env('GOOGLE_MAP_KEY')}}&origin={{$cpOrigin->cordinates}}&destination={{$cpOrigin->cordinates}}&avoid=tolls|highways"
                                allowfullscreen>
                            </iframe>
                        @else
                            @php
                                $ways = \App\Models\WayPoint::where('shipment_id', $shipment->id)->get();
                                //dd($ways);
                            @endphp
                            @if ($ways->isEmpty())
                                <iframe
                                    width="750"
                                    height="350"
                                    frameborder="2" style="border:2"
                                    referrerpolicy="no-referrer-when-downgrade"
                                    src="https://www.google.com/maps/embed/v1/directions?key={{env('GOOGLE_MAP_KEY')}}&origin={{$cpOrigin->cordinates}}&destination={{$shipment->current_position}}&avoid=tolls|highways"
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
                                    width="750"
                                    height="350"
                                    frameborder="2" style="border:2"
                                    referrerpolicy="no-referrer-when-downgrade"
                                    src="https://www.google.com/maps/embed/v1/directions?key={{env('GOOGLE_MAP_KEY')}}&origin={{$cpOrigin->cordinates}}&destination={{$shipment->current_position}}&avoid=tolls|highways&waypoints={{$waypoints}}"
                                    allowfullscreen>
                                </iframe>
                            @endif

                        @endif
                    </div>
                    <div class="col-lg-12 table-responsive mb-5">
                        <table class="table table-bordered text-center mb-0">
                            <thead class="bg-secondary text-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Product</th>
                                    <th>Qty</th>
                                    <th>Unit Price</th>
                                    <th>Total Price</th>
                                </tr>
                            </thead>
                            <tbody class="align-middle">
                                @php
                                    $count = 0;
                                @endphp
                                @foreach ($orderitems as $item)
                                    <tr>
                                        <td class="align-middle">
                                            @php
                                                $count++;
                                                echo $count;
                                            @endphp
                                        </td>
                                        <td class="align-middle">{{$item->product_name}}</td>
                                        <td class="align-middle">{{$item->qty}}</td>
                                        <td class="align-middle">{{$item->price}}</td>
                                        <td class="align-middle">{{$item->total}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- Cart End -->
</x-guest-layout>
