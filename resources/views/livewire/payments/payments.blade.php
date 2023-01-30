<section>
    <div class="p-8 bg-green-200 text-green-800 grid grid-cols-4 gap-2">
        @for($i=1; $i<=12; $i++) <div class="bg-green-100 rounded p-5">{{date('M Y', mktime(0,0,0,$i, 1, date('Y')))}}</div>
    @endfor
    </div>
    <div class="p-8 bg-green-200 text-blue-800 grid grid-cols-4 gap-2">
        @for($i=1; $i<=12; $i++) <div class="bg-blue-100 rounded p-5">{{date('M Y', mktime(0,0,0,$i, 1, date('Y')))}}</div>
    @endfor
    </div>
</section>