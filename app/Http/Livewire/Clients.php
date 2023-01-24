<?php

namespace App\Http\Livewire;

use App\Models\Client;
use Livewire\Component;

class Clients extends Component {

    public $clients, $name, $email, $phone, $location, $notes,$start_at, $amount, $clientId, $updateClient = false, $addClient = false;

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
        'location' => 'required',
        'start_at' => 'required',
        'amount' => 'required',
        'phone' => 'required',
        'notes' => 'required'
    ];

    /**
     * Reseting all inputted fields
     * @return void
     */
    public function resetFields() {
        $this->name = '';
        $this->email = '';
        $this->location = '';
        $this->phone = '';
        $this->start_at = '';
        $this->amount = '';
        $this->notes = '';
    }

    /**
     * render the client data
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render() {
        $this->clients = Client::all();
        return view('livewire.clients.clients');
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
                'name' => $this->name,
                'email' => $this->email,
                'phone' => $this->phone,
                'location' => $this->location,
                'start_at' => $this->start_at,
                'amount' => $this->amount,
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
                $this->name = $client->name;
                $this->email = $client->email;
                $this->location = $client->location;
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
                'name' => $this->name,
                'email' => $this->email,
                'location' => $this->location,
                'phone' => $this->phone,
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
}
