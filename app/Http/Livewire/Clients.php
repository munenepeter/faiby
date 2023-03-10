<?php

namespace App\Http\Livewire;

use Carbon\Carbon;
use App\Models\Plan;
use App\Models\Client;
use App\Models\Payment;
use Livewire\Component;
use Livewire\WithPagination;

class Clients extends Component {
    use WithPagination;
    public  $plans, $name, $email, $phone, $notes, $plan_start_at, $plan, $clientId, $updateClient = false, $addClient = false, $viewClient = false;
    /**
     * delete action listener
     */
    protected $listeners = [
        'deleteClientListner' => 'deleteClient'
    ];

    /**
     * List of add/edit form rules
     */
    protected $rules = [
        'name' => 'required',
        'email' => 'required',
        'plan_start_at' => 'required',
        'plan' => 'required',
        'phone' => 'required|min:9|numeric',
        'notes' => 'required'
    ];

    /**
     * Reseting all inputted fields
     * @return void
     */
    public function resetFields() {
        $this->name = '';
        $this->email = '';
        $this->phone = '';
        $this->plan_start_at = '';
        $this->plan = '';
        $this->notes = '';
    }

    /**
     * render the client data
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render() {
        //  $this->clients = Client::all();;
        $this->plans = Plan::all();
        return view('livewire.clients.clients', [
            'clients' => Client::latest()->paginate(5),
        ]);
    }

    /**
     * Open Add Client form
     * @return void
     */
    public function addClient() {
        $this->resetFields();
        $this->addClient = true;
        $this->updateClient = false;
    }
    /**
     * store the user inputted client data in the clients table
     * @return void
     */
    public function storeClient() {
        $this->validate();
        try {
            Client::create([
                'full_names' => $this->name,
                'email' => $this->email,
                'phone' => $this->phone,
                'plan_start_at' => $this->plan_start_at,
                'plan_end_at' => date("Y-m-d", strtotime('+1 month', strtotime($this->plan_start_at))),
                'plan_id' => $this->plan,
                'notes' => $this->notes
            ]);
            session()->flash('success', 'Client Created Successfully!!');
            $this->resetFields();
            $this->addClient = false;
        } catch (\Exception $ex) {
            session()->flash('error', 'Something goes wrong!!');
            throw new \Exception($ex);
        }
    }

    /**
     * show existing client data in edit client form
     * @param mixed $id
     * @return void
     */
    public function editClient($id) { 
        try {
            $client = Client::findOrFail($id);    
            if (!$client) {
                session()->flash('error', 'Client not found');
            } else {             
                $this->name = $client->full_names;
                $this->email = $client->email;
                $this->phone = $client->phone;
                $this->notes = $client->notes;
                $this->clientId = $client->id;
                $this->updateClient = true;
                $this->addClient = false;
            }
        } catch (\Exception $ex) {
            session()->flash('error', 'Something goes wrong!!');
        }
    }

    /**
     * update the client data
     * @return void
     */
    public function updateClient() {
        $this->validate();
        try {
            Client::whereId($this->clientId)->update([
                'full_names' => $this->name,
                'email' => $this->email,
                'phone' => $this->phone,
                'plan_start_at' => $this->plan_start_at,
                'plan_end_at' => date("Y-m-d", strtotime('+1 month', strtotime($this->plan_start_at))),
                'plan_id' => $this->plan,
                'notes' => $this->notes
            ]);
            session()->flash('success', 'Client Updated Successfully!!');
            $this->resetFields();
            $this->updateClient = false;
        } catch (\Exception $ex) {
            session()->flash('success', 'Something goes wrong!!');
        }
    }

    /**
     * Cancel Add/Edit form and redirect to client listing page
     * @return void
     */
    public function cancelClient() {
        $this->addClient = false;
        $this->updateClient = false;
        $this->resetFields();
    }

      /**
     * show existing client data in edit client form
     * @param mixed $id
     * @return void
     */
    public function viewClient($id) {
        try {
            $client = Client::findOrFail($id);
            if (!$client) {
                session()->flash('error', 'Client not found');
            } else {
                $this->name = $client->full_names;
                $this->email = $client->email;
                $this->phone = $client->phone;
                $this->notes = $client->notes;
                $this->clientId = $client->id;
                $this->updateClient = false;
                $this->addClient = false;
                $this->viewClient = true;
            }
        } catch (\Exception $ex) {
            session()->flash('error', 'Something goes wrong!!');
        }
    }

    /**
     * delete specific client data from the clients table
     * @param mixed $id
     * @return void
     */
    public function deleteClient($id) {

        try {
            Client::find($id)->delete();
            session()->flash('success', "Client Deleted Successfully!!");
        } catch (\Exception $e) {
            session()->flash('error', "Something goes wrong!!");
        }
    }

    public function markPaid($id) {
        $client = Client::findOrFail($id);
        $last_start_at = new Carbon($client->plan_end_at);
        $last_start_at1 = new Carbon($client->plan_end_at);
        try {
            Client::whereId($id)->update([
                'plan_end_at' => $last_start_at->addMonth(),
                'status' => 'paid',
            ]);
            Payment::create([
                'period' => $last_start_at1->subMonth()->format('jS M Y') . ' - ' . date('jS M Y', strtotime($client->plan_end_at)),
                'amount' => $client->plan->amount,
                'client_id' => $client->id,
            ]);
            session()->flash('success', "Client Updated Successfully!!");
        } catch (\Exception $e) {
            throw new \Exception($e);
            session()->flash('error', "Something goes wrong!!");
        }
    }
}
