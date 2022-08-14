@extends('layouts.master')

@section('tab-title', 'Home')

@section('header')
    <style>
        @font-face {
            font-family: '1up';
            src: url('{{ asset('1up.ttf') }}') format('truetype');
            /* Chrome 4+, Firefox 3.5, Opera 10+, Safari 3—5 */
        }

        body {
            --var-color: rgb(0, 238, 255);
        }

        .header-bg-rotate {
            background-image: linear-gradient(45deg, red, yellow);
            animation: hue-rotate 2s linear infinite alternate;
            height: 100%;
        }

        .header-bg-static {
            position: relative;
            height: 30vh;
            width: 100vw;
            background-image: linear-gradient(#e71a21 33.33%, #dfc75d 33.33%, #dfc75d 66.66%, #84acdb 66.66%);
            background-size: 100% 100%;
            background-repeat: no-repeat;
            margin: 0px;
        }

        .body-bg {
            height: 70vh;
            background-color: #19181b;
            border: 4px solid #84acdb;
        }

        .logo-fix {
            display: block;
            width: auto;
            height: auto;
            max-width: 100%;
            max-height: 80%;
            margin: 1% auto;
            filter: drop-shadow(0 0.3rem 0.1rem black);
        }
        .buttn {
            border: 2px solid #e8c570;
            background-color: #19181b;
            color: white;
            padding: 5px 20px;
            font-size: 16px;
            cursor: pointer;
            width: 30%;
        }
        .buttn-price {
            border-radius: 30px;
            border-color: #e8c570;
            color: white
        }

        .buttn-submit {
            background-color: #84acdb;
            color: black;
        }

        @keyframes hue-rotate {
            to {
                filter: hue-rotate(90deg);
            }
        }

        .font-1-up {
            font-family: '1up', 'Sans-Serif';
        }

        .big-font {
            font-size: 50px;
        }

        .color-red {
            color: #e73924;
        }

        .footer-bag {
            height: 100%;
        }

        .contact {
            position: absolute;
            bottom: 10px;
            left: 10px;
        }
    </style>
    @if (config('midtrans.is_production') == true)
        <script type="text/javascript" src="https://app.midtrans.com/snap/snap.js"
            data-client-key="{{ config('midtrans.client_key') }}"></script>
    @else
        <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js"
            data-client-key="{{ config('midtrans.client_key') }}"></script>
    @endif
@endsection

@section('body')
    <div class="container-fluid min-vh-100 d-flex flex-column">
        <div class="row">
            <div class="col-12 header-bg-static">
                <img class="logo-fix" src="{{ asset('LOGO.png') }}" alt="PHOTATA">
            </div>

            <div class="col-12 body-bg">
                <div class="mx-auto">
                    <div class="status-payment font-1-up text-white text-center">
                    </div>
                    <div class="text-center text-wrap mt-5 font-1-up color-red big-font ">
                        START PHOTO ?
                    </div>
                    <div class="text-center">
                        <button class="buttn mt-5 buttn-price font-1-up" disabled type="text" name="price" id="price"
                            value="{{ $priceData->price }}">Rp. {{ number_format($priceData->price, 0, ",", ".") }}</button>
                    </div>
                    <div class="text-center">
                        <button class="btn btn-primary buttn-submit font-1-up btnSubmit mt-3">LET'S GO!</button>
                    </div>
                    <!-- Modal -->
                    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false"
                        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="staticBackdropLabel">Konfirmasi Pembayaran</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
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
                                                id="packagePrice"
                                                value="Rp. {{ number_format($priceData->price, 0, ',', '.') }}" disabled>
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
                <table class="text-white contact" style="letter-spacing: 3px;">
                    <tbody>
                        <tr>
                            <td>INSTAGRAM</td>
                            <td>: LA.PHOTATA</td>
                        </tr>
                        <tr>
                            <td>WHATSAPP 1</td>
                            <td>: +6281367370540</td>
                        </tr>
                        <tr>
                            <td>WHATSAPP 2</td>
                            <td>: +6282119802417</td>
                        </tr>
                        <tr>
                            <td>E-MAIL</td>
                            <td>: PHOTATABOX@GMAIL.com</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            {{-- <div class="col-12 bg-dark align-self-end bg-opacity-10 footer-bag">
                <div class="container">
                    Photata @ 2022
                </div>
            </div> --}}
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
