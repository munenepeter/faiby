<?php

namespace App\Http\Livewire;

use App\Models\Plan;
use Livewire\Component;

class Plans extends Component {

    public $plans, $name, $amount, $renewal_period, $planId, $updatePlan = false, $addPlan = false;

    /**
     * delete action listener
     */
    protected $listeners = [
        'deletePlanListner' => 'deletePlan'
    ];

    /**
     * List of add/edit form rules
     */
    protected $rules = [
        'name' => 'required',
        'renewal_period' => 'required',
        'amount' => 'required|min:9|numeric'
    ];

    /**
     * Reseting all inputted fields
     * @return void
     */
    public function resetFields() {
        $this->name = '';
        $this->amount = '';
        $this->renewal_period = '';
    }

    /**
     * render the plan data
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render() {
        $this->plans = Plan::all();
        return view('livewire.plans.plans');
    }

    /**
     * Open Add Plan form
     * @return void
     */
    public function addPlan() {
        $this->resetFields();
        $this->addPlan = true;
        $this->updatePlan = false;
    }
    /**
     * store the user inputted plan data in the plans table
     * @return void
     */
    public function storePlan() {
        $this->validate();
        try {
            Plan::create([
                'name' => $this->name,
                'amount' => $this->amount,
                'renew_period' => $this->renewal_period
            ]);
            session()->flash('success', 'Plan Created Successfully!!');
            $this->resetFields();
            $this->addPlan = false;
        } catch (\Exception $ex) {
            session()->flash('error', 'Something goes wrong!!');
            throw new \Exception($ex);
        }
    }

    /**
     * show existing plan data in edit plan form
     * @param mixed $id
     * @return void
     */
    public function editPlan($id) {
        try {
            $plan = Plan::findOrFail($id);
            if (!$plan) {
                session()->flash('error', 'Plan not found');
            } else {
                $this->name = $plan->name;
                $this->amount = $plan->amount;
                $this->renewal_period = $plan->renewal_period;
                $this->planId = $plan->id;
                $this->updatePlan = true;
                $this->addPlan = false;
            }
        } catch (\Exception $ex) {
            session()->flash('error', 'Something goes wrong!!');
        }
    }

    /**
     * update the plan data
     * @return void
     */
    public function updatePlan() {
        $this->validate();
        try {
            Plan::whereId($this->planId)->update([
                'name' => $this->name,
                'amount' => $this->amount,
                'renew_period' => $this->renewal_period
            ]);
            session()->flash('success', 'Plan Updated Successfully!!');
            $this->resetFields();
            $this->updatePlan = false;
        } catch (\Exception $ex) {
            session()->flash('success', 'Something goes wrong!!');
        }
    }

    /**
     * Cancel Add/Edit form and redirect to plan listing page
     * @return void
     */
    public function cancelPlan() {
        $this->addPlan = false;
        $this->updatePlan = false;
        $this->resetFields();
    }

    /**
     * delete specific plan data from the plans table
     * @param mixed $id
     * @return void
     */
    public function deletePlan($id) {

        try {
            Plan::find($id)->delete();
            session()->flash('success', "Plan Deleted Successfully!!");
        } catch (\Exception $e) {
            session()->flash('error', "Something goes wrong!!");
        }
    }
}
