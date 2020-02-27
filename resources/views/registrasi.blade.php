<!doctype html>
<html lang="{{ app()->getLocale() }}">
 
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
 
    <title></title>
 
    <!-- Styles -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
        crossorigin="anonymous">
    <style>
        html, body {
        background-color: #fff;
        color: #636b6f;
        font-weight: 200;
        height: 100vh;
        margin: 0;
    }
    </style>
</head>
 
<body>
 
    <div class="container">
 
        <form class="form-horizontal" id="donation" onsubmit="return submitForm();">
 
            <!-- Form Name -->
            <legend>Registrasi Paket</legend>
 
            <div class="row">
                <div class="col-md-4">
 
                    <!-- Text input-->
                    <div class="form-group">
                        <label class="control-label" for="name">Name</label>
                        <div>
                            <input id="name" name="name" type="text" placeholder="Enter your name.." class="form-control input-md"
                                required="">
 
                        </div>
                    </div>
 
                </div>
 
                <div class="col-md-4">
 
                    <!-- Text input-->
                    <div class="form-group">
                        <label class="control-label" for="email">Email</label>
                        <div>
                            <input id="email" name="email" type="text" placeholder="Enter your email.." class="form-control input-md"
                                required="">
    
                        </div>
                    </div>
    
                </div>
 
                <div class="col-md-4">
 
                    <!-- Select Basic -->
                    <div class="form-group">
                        <label class="control-label" for="paket_id">Paket</label>
                        <div>
                            <select id="paket_id" name="paket_id" class="form-control">
                                <option value="1">Paket 1</option>
                                <option value="2">Paket 2</option>
                                <option value="3">Paket 3</option>
                            </select>
                        </div>
                    </div>
 
                </div>
            </div>
 
            <div class="row">
                <div class="col-md-4">
 
                    <!-- Prepended text-->
                    <label for="">Amount</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">Rp</span>
                        </div>
                        <input id="amount" name="amount" class="form-control" placeholder="" type="number" min="10000" max="999999999" required="">
                    </div>
 
                </div>

                <div class="col-md-4">
 
                    <!-- Prepended text-->
                    <label for="jumlah_responden">Jumlah responden</label>
                    <div class="input-group">
                        <input id="jumlah_responden" name="jumlah_responden" class="form-control" placeholder="" type="number">
                    </div>
 
                </div>

                <div class="col-md-4">
 
                    <div class="form-group">
                        <label class="control-label" for="user_id">User id</label>
                        <div>
                            <input type="number" class="form-control" id="user_id" name="user_id"></input>
                        </div>
                    </div>

                </div>
            </div>
 
            <button id="submit" class="btn btn-success">Submit</button>
 
        </form>
 
        <br>
 
        {{-- <table class="table table-striped" id="list">
            <tr>
                <th>ID</th>
                <th>Donor Name</th>
                <th>Amount</th>
                <th>Donation Type</th>
                <th>Status</th>
                <th style="text-align: center;">Pay</th>
            </tr>
            @foreach ($regist as $donation)
            <tr>
                <td><code>{{ $donation->id }}</code></td>
                <td>{{ $donation->name }}</td>
                <td>Rp. {{ number_format($donation->amount) }},-</td>
                <td>{{ $donation->jumlah_responden }}</td>
                <td>{{ ucfirst($donation->status) }}</td>
                <td style="text-align: center;">
                    @if ($donation->status == 'pending')
                    <button class="btn btn-success btn-sm" onclick="snap.pay('{{ $donation->snap_token }}')">Complete Payment</button>
                    @endif
                </td>
            </tr>
            @endforeach
            <tr>
                <td colspan="6">{{ $donations->links() }}</td>
            </tr>
        </table> --}}

    </div>
    <script
        src="https://code.jquery.com/jquery-3.3.1.min.js"
        integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
        crossorigin="anonymous"></script>
    <script src="{{ !config('services.midtrans.isProduction') ? 'https://app.sandbox.midtrans.com/snap/snap.js' : 'https://app.midtrans.com/snap/snap.js' }}" data-client-key="{{ config('services.midtrans.clientKey') }}"></script>
    <script>
    function submitForm() {
        // Kirim request ajax
        $.post("{{ route('registrasi.store') }}",
        {
            _method: 'POST',
            _token: '{{ csrf_token() }}',
            amount: $('input#amount').val(),
            jumlah_responden: $('input#jumlah_responden').val(),
            paket_id: $('select#paket_id').val(),
            name: $('input#name').val(),
            email: $('input#email').val(),
            user_id: $('input#user_id').val(),
        },
        function (data, status) {
            snap.pay(data.snap_token, {
                // Optional
                onSuccess: function (result) {
                    location.reload();
                },
                // Optional
                onPending: function (result) {
                    location.reload();
                },
                // Optional
                onError: function (result) {
                    location.reload();
                }
            });
        });
        return false;
    }
    </script>
</body>
</html>