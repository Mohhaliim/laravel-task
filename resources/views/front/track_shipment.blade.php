@extends(homePageLayout())
@section('title')
    Track Shipment
@endsection
@section('content')
    <section class="top-margin" >
        <div class="container p-t-100 tracking-wrapper">
            <h1 class="tracking-header">Track Your shipment</h1>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            <form action="{{route('track.shipment')}}" method="post" class="tracking-form">
                @csrf
                <input type="text" name="tracking_number" placeholder="Enter waybill" required>
                <button type="submit" class="tracking-btn">Track</button>
            </form>
            @if (session('trackingResult'))
                <div class="tracking-result mt-4">
                    <h2>Tracking Details:</h2>
                    <ul>
                        @foreach (session('trackingResult') as $key => $value)
                            <li><strong>{{ ucfirst($key) }}:</strong> {{ is_array($value) ? json_encode($value) : $value }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    </section>
@endsection
