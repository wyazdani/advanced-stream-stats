<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    @php $braintree = new \App\Services\Braintree(); @endphp
    <div class="section-plans">
        <section class="bg-white dark:bg-gray-900">
            <div class="py-8 px-4 mx-auto max-w-screen-xl lg:py-16 lg:px-6">
                <div class="mx-auto max-w-screen-md text-center mb-8 lg:mb-12">
                    <h2 class="mb-4 text-4xl tracking-tight font-extrabold text-gray-900 dark:text-white">Select Plan</h2>
                </div>
                <div class="space-y-8 lg:grid lg:grid-cols-2 sm:gap-6 xl:gap-10 lg:space-y-0">
                    @foreach($braintree->getPlans() as $plan)
                        <div class="flex flex-col p-6 mx-auto max-w-lg text-center text-gray-900 bg-white rounded-lg border border-gray-100 shadow dark:border-gray-600 xl:p-8 dark:bg-gray-800 dark:text-white">
                            <h3 class="mb-4 text-2xl font-semibold">{{$plan->name}}</h3>
                            <div class="flex justify-center items-baseline my-8">
                                <span class="mr-2 text-5xl font-extrabold">{{$plan->price}} {{$plan->currencyIsoCode}}</span>
                            </div>
                            <!-- List -->
                            <ul role="list" class="mb-8 space-y-4 text-left">
                                <li class="flex items-center space-x-3">
                                    <!-- Icon -->
                                    <svg class="flex-shrink-0 w-5 h-5 text-green-500 dark:text-green-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                                    <span>Testing Plan</span>
                                </li>
                            </ul>
                            <button data-plan_id="{{$plan->id}}" data-amount="{{$plan->price}}" class="get-package text-white bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:ring-primary-200 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:text-white  dark:focus:ring-primary-900">Get started</button>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    </div>
    <div class="checkout-form" style="display: none">
        <form method="post" id="payment-form">
            <section>
                <div class="bt-drop-in-wrapper">
                    <div id="bt-dropin"></div>
                </div>
            </section>

            <input id="nonce" name="payment_method_nonce" type="hidden" />
            <button class="text-white bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:ring-primary-200 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:text-white  dark:focus:ring-primary-900" type="submit"><span>Submit</span></button>
        </form>
    </div>
    <div class="bg-gray-100 h-screen success-page" style="display: none">
        <div class="bg-white p-6  md:mx-auto">
            <svg viewBox="0 0 24 24" class="text-green-600 w-16 h-16 mx-auto my-6">
                <path fill="currentColor"
                      d="M12,0A12,12,0,1,0,24,12,12.014,12.014,0,0,0,12,0Zm6.927,8.2-6.845,9.289a1.011,1.011,0,0,1-1.43.188L5.764,13.769a1,1,0,1,1,1.25-1.562l4.076,3.261,6.227-8.451A1,1,0,1,1,18.927,8.2Z">
                </path>
            </svg>
            <div class="text-center">
                <h3 class="md:text-2xl text-base text-gray-900 font-semibold text-center">Payment Done!</h3>
                <p class="text-gray-600 my-2">Thank you for completing your secure online payment.</p>
                <p> Have a great day!  </p>
            </div>
        </div>
    </div>
@section('scripts')
        <script src="https://js.braintreegateway.com/web/dropin/1.33.5/js/dropin.min.js"></script>
        <script>
            $(document).ready(function (){
                $('body').on('click','.get-package', function (){
                    $('.section-plans').hide();
                    $('.checkout-form').show();
                    let amount = $(this).attr('data-amount');
                    let planId = $(this).attr('data-plan_id');
                    let client_token = '{{$braintree->generateClientToken()}}';
                    braintree.dropin.create({
                        authorization: client_token,
                        selector: '#bt-dropin',
                        paypal: {
                            flow: 'vault'
                        }
                    }, function (createErr, instance) {
                        if (createErr) {
                            console.log('Create Error', createErr);
                            return;
                        }
                        $('body').on('submit','#payment-form', function (e){
                            e.preventDefault();
                            instance.requestPaymentMethod(function (err, payload) {
                                if (err) {
                                    console.log('Request Payment Method Error', err);
                                    return;
                                }
                                $.ajax({
                                    type:'post',
                                    url:"{{route('checkout.store')}}",
                                    data        :   {
                                        amount: amount,
                                        planId: planId,
                                        paymentMethodNonce: payload.nonce,
                                        _token: $('meta[name=csrf-token]').attr("content")
                                    },
                                    success:function(data) {
                                        $('.checkout-form').hide();
                                        $('.success-page').show();

                                    },
                                });
                            });

                        })

                    });
                })
            });


        </script>
    @endsection
</x-app-layout>

