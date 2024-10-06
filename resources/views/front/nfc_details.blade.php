@extends(homePageLayout())
@section('title')
    NFC details
@endsection
@section('content')
    <section class="top-margin" >
        <div class="container p-t-100 nfc-wrapper">
            <h1 class="nfc-header">NFC card details</h1>
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
            <form action="{{route('nfc.details')}}" method="post" class="nfc-form">
                @csrf
                <input type="text" name="card_id" placeholder="Enter card id" required>
                <input type="text" name="business_name" placeholder="Enter business name" required>
                <input type="datetime-local" name="issued_at" placeholder="Issued at">
                <button type="submit" class="nfc-btn">Submit</button>
            </form>
        </div>
    </section>
@endsection
