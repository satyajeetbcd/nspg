<?php

namespace App\Models;

use App\Notifications\CustomResetPassword;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        // Basic Info
        'name',
        'email',
        'vat_number',
        'password',
        'avatar',

    ];
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    protected $casts = [
        'plan_expire_date' => 'datetime',
    ];
    protected $append = [
        'status',
    ];



    /**
     * Accessor for full billing address. 🏠
     */
    public function getFullBillingAddressAttribute(): string
    {
        return "{$this->billing_address}, {$this->billing_city}, {$this->billing_state}, {$this->billing_country}, ZIP: {$this->billing_zip}";
    }

    public function getIsActiveAttribute()
    {
        return $this->plan_expire_date && $this->plan_expire_date->isFuture();
    }
    public function getStatusAttribute()
    {
        if ($this->getIsActiveAttribute()) {
            return "Active";
        }
        return "Expired";
    }

    public function authId()
    {
        return $this->id;
    }



    // Current Plan
    public function currentPlan()
    {
        return $this->hasOne('App\Models\Plan', 'id', 'plan');
    }
    public function show_dashboard()
    {
        $user_type = Auth::user()->type;

        if ($user_type == 'company' || $user_type == 'super admin') {
            $user = Auth::user();
        } else {
            $user = User::where('id', Auth::user()->created_by)->first();
        }

        return $user?->plan;
        // return !empty($user->plan)?Plan::find($user->plan)->crm:'';
    }

    public function getPlan()
    {
        return $this->hasOne(Plan::class, 'id', 'plan');
    }


    public function invoice()
    {
        return $this->hasOne(Invoice::class, 'subscription_id');
    }
    public function invoices()
    {
        return $this->hasMany(Invoice::class, 'subscription_id');
    }

    public function assignPlan($planID, $company_id = 0)
    {
        $plan = Plan::find($planID);
        if ($plan) {
            $this->plan = $plan->id;
            if ($this->trial_expire_date != null) {
                $this->trial_expire_date = null;
            }
            if ($plan->duration == 'month') {
                $this->plan_expire_date = Carbon::now()->addMonths(1)->isoFormat('YYYY-MM-DD');
            } elseif ($plan->duration == 'year') {
                $this->plan_expire_date = Carbon::now()->addYears(1)->isoFormat('YYYY-MM-DD');
            } else {
                $this->plan_expire_date = null;
            }
            $this->save();

            if ($company_id != 0) {
                $user_id = $company_id;
            } else {
                $user_id = Auth::user()->creatorId();
            }

            $users = User::where('created_by', '=', $user_id)->where('type', '!=', 'super admin')->where('type', '!=', 'company')->where('type', '!=', 'client')->get();
            $clients = User::where('created_by', '=', $user_id)->where('type', 'client')->get();
            $customers = Customer::where('created_by', '=', $user_id)->get();
            $vendors = Vendor::where('created_by', '=', $user_id)->get();

            if ($plan->max_users == -1) {
                foreach ($users as $user) {
                    $user->is_active = 1;
                    $user->save();
                }
            } else {
                $userCount = 0;
                foreach ($users as $user) {
                    $userCount++;
                    if ($userCount <= $plan->max_users) {
                        $user->is_active = 1;
                        $user->save();
                    } else {
                        $user->is_active = 0;
                        $user->save();
                    }
                }
            }

            if ($plan->max_clients == -1) {
                foreach ($clients as $client) {
                    $client->is_active = 1;
                    $client->save();
                }
            } else {
                $clientCount = 0;
                foreach ($clients as $client) {
                    $clientCount++;
                    if ($clientCount <= $plan->max_clients) {
                        $client->is_active = 1;
                        $client->save();
                    } else {
                        $client->is_active = 0;
                        $client->save();
                    }
                }
            }

            if ($plan->max_customers == -1) {
                foreach ($customers as $customer) {
                    $customer->is_active = 1;
                    $customer->save();
                }
            } else {
                $customerCount = 0;
                foreach ($customers as $customer) {
                    $customerCount++;
                    if ($customerCount <= $plan->max_customers) {
                        $customer->is_active = 1;
                        $customer->save();
                    } else {
                        $customer->is_active = 0;
                        $customer->save();
                    }
                }
            }

            if ($plan->max_vendors == -1) {
                foreach ($vendors as $vendor) {
                    $vendor->is_active = 1;
                    $vendor->save();
                }
            } else {
                $vendorCount = 0;
                foreach ($vendors as $vendor) {
                    $vendorCount++;
                    if ($vendorCount <= $plan->max_vendors) {
                        $vendor->is_active = 1;
                        $vendor->save();
                    } else {
                        $vendor->is_active = 0;
                        $vendor->save();
                    }
                }
            }

            return ['is_success' => true];
        } else {
            return [
                'is_success' => false,
                'error' => 'Plan is deleted.',
            ];
        }
    }

    // UnAssign plan 🌟
    public function unAssignPlan($company_id = 0)
    {
        // Remove plan details
        $this->plan = null;
        $this->plan_expire_date = null;
        $this->trial_expire_date = null;
        $this->save();

        // Determine the owner ID
        $user_id = $company_id != 0 ? $company_id : \Auth::user()->creatorId();

        // Fetch related records
        $users = User::where('created_by', $user_id)
            ->where('type', '!=', 'super admin')
            ->where('type', '!=', 'company')
            ->where('type', '!=', 'client')
            ->get();

        $clients = User::where('created_by', $user_id)
            ->where('type', 'client')
            ->get();

        $customers = Customer::where('created_by', $user_id)->get();
        $vendors   = Vendor::where('created_by', $user_id)->get();

        // Deactivate all related users
        foreach ($users as $user) {
            $user->is_active = 0;
            $user->save();
        }

        // Deactivate all related clients
        foreach ($clients as $client) {
            $client->is_active = 0;
            $client->save();
        }

        // Deactivate all related customers
        foreach ($customers as $customer) {
            $customer->is_active = 0;
            $customer->save();
        }

        // Deactivate all related vendors
        foreach ($vendors as $vendor) {
            $vendor->is_active = 0;
            $vendor->save();
        }

        return ['is_success' => true];
    }

    public function planPrice()
    {
        $user = Auth::user();
        if ($user->type == 'super admin') {
            $userId = $user->id;
        } else {
            $userId = $user->created_by;
        }

        return DB::table('settings')->where('created_by', '=', $userId)->get()->pluck('value', 'name');
    }
    public function creatorId()
    {
        if ($this->type == 'company' || $this->type == 'super admin') {
            return $this->id;
        } else {
            return $this->created_by;
        }
    }
    // This Send Notification Forget Password
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new CustomResetPassword($token));
    }

    public function generalManager()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
