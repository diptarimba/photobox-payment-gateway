@extends('layouts.master')

@section('tab-title', 'Home')

@section('header')
    <style>
        body {
            --var-color: rgb(0, 238, 255);
        }

        .header-bg {
            background-image: linear-gradient(45deg, red, yellow);
            animation: hue-rotate 2s linear infinite alternate;
            height: 100%;
        }

        @keyframes hue-rotate {
            to {
                filter: hue-rotate(90deg);
            }
        }

        .footer-bag {
            height: 100%;
        }
    </style>
    <script type="text/javascript"
    src="https://app.sandbox.midtrans.com/snap/snap.js"
    data-client-key="{{config('midtrans.client_key')}}"></script>
@endsection

@section('body')
    <div class="container-fluid min-vh-100 d-flex flex-column">
        <div class="row flex-grow-1">
            <div class="col-12 align-self-start header-bg">
                {{-- <div class="text-center mt-4">
                    <p class="h1 text-white">PHOTATA</p>
                </div> --}}
                <div class="mt-4 text-center">
                    <img style="max-width: 400px" src="{{asset('LOGO.png')}}" alt="PHOTATA">
                </div>
                <figure class="text-center mt-4 col-6 mx-auto">
                    <blockquote class="blockquote">
                        <p>{{$quote->text}}</p>
                    </blockquote>
                    <figcaption class="blockquote-footer text-white ">
                        <cite title="Source Title">{{$quote->author}}</cite>
                    </figcaption>
                </figure>
            </div>
            <div class="col-12 align-self-center">
                <p class="status-payment h3 text-danger text-center"></p>
            </div>
            <div class="col-12 align-self-center">
                <div class="col-lg-3 col-md-6 col-6 mx-auto">
                    <div class="card">
                        <div class="card-body">
                            <div class="text-center h2 text-white text-wrap header-bg">
                                WANNA TAKE A PHOTO?
                            </div>
                            <select id="select-price" class="form-select" aria-label="Default select example">
                                <option selected>Select Package</option>
                                @foreach ($priceData as $each)
                                    <option value="{{ $each->price }}">{{ $each->name }} ( Rp.{{ number_format($each->price, 0, ',', '.') }} )</option>
                                @endforeach
                            </select>
                        </div>
                        <button class="btn btn-primary btnSubmit">Let's
                            Go!</button>
                    </div>
                    <!-- Modal -->
                    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false"
                        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="staticBackdropLabel">Confirm Page</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3 row">
                                        <label for="packageName" class="col-sm-2 col-form-label">Package</label>
                                        <div class="col-sm-10">
                                            <input id="packageName"type="text" readonly class="form-control-plaintext"
                                                id="packageName" value="" disabled>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="packagePrice" class="col-sm-2 col-form-label">Price</label>
                                        <div class="col-sm-10">
                                            <input id="packagePrice" type="text" readonly class="form-control-plaintext"
                                                id="packagePrice" value="" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button id="pay-button" type="button" class="btn btn-primary">Understood</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 bg-dark align-self-end bg-opacity-10 footer-bag">
                <div class="container">
                    Photata @ 2022
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    <script>
        function sleep(ms) {
            return new Promise(resolve => setTimeout(resolve, ms));
        }
        $(document).ready(() => {
            $('#select-price').on('change', function() {
                $('#select-price option').each(function() {
                    if ($(this).is(':selected')) {
                        // $(this).val()
                        $('#packageName').val($(this).text())
                        $('#packagePrice').val($(this).val())
                    }
                })
            })

            $('.btnSubmit').on('click', function(){
                var name = $('#packageName').val();
                var price = $('#packagePrice').val();
                if(name !== '' && price !== ''){
                    $('#staticBackdrop').modal('toggle');
                }else{
                    alert('Silahkan Pilih Paket Terlebih Dahulu!');
                }
            })


            // For example trigger on button clicked, or any time you need
            var payButton = document.getElementById('pay-button');
            payButton.addEventListener('click', function() {
                // Update Web Check
                var cost = $('#packagePrice').val();
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
                        // console.log(tokenBayar)
                        window.snap.pay(tokenBayar, {
                            onSuccess: function(result) {
                                /* You may add your own implementation here */
                                $('.status-payment').text('Payment Berhasil, Happy Snap!');
                                sleep(3000);
                                window.close();
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
                                    'you closed the popup without finishing the payment');
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
