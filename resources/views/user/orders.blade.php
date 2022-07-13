<x-guest-layout>
    <!-- Cart Start -->
    <div class="container-fluid pt-5">
        <div class="row px-xl-5">
            <div class="col-lg-12 table-responsive mb-5">
                <table class="table table-bordered text-center mb-0">
                    <thead class="bg-secondary text-dark">
                        <tr>
                            <th>#</th>
                            <th>Order #</th>
                            <th>Items</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody class="align-middle">
                        @php
                            $count = 0;
                        @endphp
                        @foreach ($orders as $order)
                            <tr>
                                <td class="align-middle">
                                    @php
                                        $count++;
                                        echo $count;
                                    @endphp
                                </td>
                                <td class="align-middle">{{$order->code}}</td>
                                <td class="align-middle">
                                    @php
                                        $itemcount = \App\Models\OrderItem::where('order_id',$order->id)->count();
                                        echo $itemcount;
                                    @endphp
                                </td>
                                <td class="align-middle">{{$order->total}}</td>
                                <td class="align-middle">
                                    @if ($order->status == 'pending')
                                        <span class="badge bg-secondary">{{$order->status}}</span>
                                    @elseif($order->status == 'shipping')
                                        <span class="badge bg-primary">{{$order->status}}</span>
                                    @else
                                        <span class="badge bg-success">{{$order->status}}</span>
                                    @endif
                                </td>
                                <td class="align-middle">{{$order->created_at}}</td>
                                <td class="align-middle">
                                    @if ($order->status == 'shipping')
                                        <a href="{{route('user-track', $order->id)}}">track</a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Cart End -->
</x-guest-layout>
