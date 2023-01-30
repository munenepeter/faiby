<section>
    <div class="p-8 bg-green-200 text-blue-800 grid grid-cols-4 gap-2">
        @foreach($payments as $payment)
        <div class="bg-blue-100 rounded p-5">
           <span> {{$payment->period}}</span>
        </div>
        @endforeach
    </div>
</section>