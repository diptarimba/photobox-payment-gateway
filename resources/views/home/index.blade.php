@extends('layouts.master')

@section('tab-title', 'Home')

@section('header')
    @if (config('midtrans.is_production') == true)
        <script type="text/javascript" src="//app.midtrans.com/snap/snap.js"
            data-client-key="{{ config('midtrans.client_key') }}"></script>
    @else
        <script type="text/javascript" src="//app.sandbox.midtrans.com/snap/snap.js"
            data-client-key="{{ config('midtrans.client_key') }}"></script>
    @endif
@endsection

@section('body')
    <div class="box_content">
        <div class="d-flex justify-content-between align-items-center py-lg-4 pb-2 py-xxl-0">
            <img src="{{ asset('img/logo-photo.png') }}" class="logo" width="60%" alt="" />
            <button class="button_launch" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                <img src="{{ asset('img/LAUNCH.svg') }}" alt="" />
            </button>
            {{-- <div class="status-payment text-white text-center"> --}}
        </div>
        <!-- Modal -->
        <input type="hidden" name="price" id="price" value="{{ $priceData->price }}">
        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Konfirmasi Pembayaran</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3 row">
                            <label for="packageName" class="col-sm-2 col-form-label">Paket</label>
                            <div class="col-sm-10">
                                <input id="packageName"type="text" readonly class="form-control-plaintext"
                                    id="packageName" value="{{ $priceData->name }}" disabled>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="packagePrice" class="col-sm-2 col-form-label">Harga</label>
                            <div class="col-sm-10">
                                <input id="packagePrice" type="text" readonly class="form-control-plaintext"
                                    id="packagePrice" value="Rp. {{ number_format($priceData->price, 0, ',', '.') }}"
                                    disabled>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button id="pay-button" type="button" class="btn btn-primary">Bayar!</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
    <div class="box_text">
        <h1>
            HALLO! <br />
            WELCOME TO OUR SHIP <br />
            IN THIS SHIP WE CAN SHARE OUR MOMENT <br />
            FEEL FREE WITH YOUR POSE <br />
            IF YOU READY TO TAKE OFF, PRESS THE "LAUNCH" BUTTON <br />
            AND IF YOU HAVE A PROBLEM YOU CAN CONTACT US
        </h1>
        <ul style="list-style-type: square" class="d-flex flex-column flex-lg-row gap-lg-5 py-0 align-items-lg-center mt-4">
            <li class="ps-2">INSTAGRAM : LA.PHOTO</li>
            <li class="ps-2">WHATSAPP : +6281367370540 / +6282119802417</li>
        </ul>
    </div>
    </div>
@endsection

@section('footer')
    <script>
        function sleep(ms) {
            return new Promise(resolve => setTimeout(resolve, ms));
        }
        $(document).ready(() => {
            $('.btnSubmit').on('click', function() {
                var name = '{{ $priceData->name }}';
                var price = '{{ $priceData->price }}';
                if (name !== '' && price !== '') {
                    $('#staticBackdrop').modal('toggle');
                } else {
                    alert('Silahkan Pilih Paket Terlebih Dahulu!');
                }
            })


            // For example trigger on button clicked, or any time you need
            var payButton = document.getElementById('pay-button');
            payButton.addEventListener('click', function() {
                // Update Web Check
                var cost = $('#price').val();
                console.log(cost)
                $.ajax({
                    url: '{{ route('home.index') }}',
                    dataType: 'json',
                    data: {
                        cost: cost
                    },
                    type: 'get',
                    success: function(data) { // check if available
                        // status.text('Waiting for Scanning!');
                        var tokenBayar = data.token
                        $('#staticBackdrop').modal('toggle');
                        // console.log(tokenBayar)
                        window.snap.pay(tokenBayar, {
                            onSuccess: function(result) {
                                /* You may add your own implementation here */
                                $('.status-payment').text(
                                    'Payment Berhasil, Happy Snap!');
                                sleep(3000);
                                window.location.href = '{!! config('dslr.url') !== '' ? config('dslr.url') : '' !!}'
                                // console.log(result);
                            },
                            onPending: function(result) {
                                /* You may add your own implementation here */
                                alert("wating your payment!");
                                console.log(result);
                            },
                            onError: function(result) {
                                /* You may add your own implementation here */
                                alert("payment failed!");
                                console.log(result);
                            },
                            onClose: function() {
                                /* You may add your own implementation here */
                                alert(
                                    'you closed the popup without finishing the payment'
                                );
                            }
                        })
                    },
                    error: function() { // error logging
                        console.log('Error!');
                    }
                });
                // Trigger snap popup. @TODO: Replace TRANSACTION_TOKEN_HERE with your transaction token
            });
        })
    </script>
@endsection
