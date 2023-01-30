<?php

namespace App\Http\Livewire;

use App\Models\Payment;
use Livewire\Component;

class Payments extends Component {
    public $payments;
    public function render() {
        $this->payments = Payment::all();
        return view('livewire.payments.payments');
    }
}
