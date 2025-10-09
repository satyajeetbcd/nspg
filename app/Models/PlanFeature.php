<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlanFeature extends Model
{
    //
    private $features;

    public function __construct()
    {
        $this->features =   [
            'feature1' => [['name' => __('Featrue 1 title')], ['type' => 'boolean'], ['default_value' => true]],
            'feature2' => [['name' => __('Featrue 2 title')], ['type' => 'int'], ['default_value' => 0]],
        ];
    }
    protected $table = "plan_features";
    protected $fillable = [
        "plan_id",
        "max_user",
        "module_account",
        "module_crm",
        "module_pos",
        "module_hrm",
        "module_project",
        "module_manfucture",
        "more_featrues",
    ];

    protected $casts = [
        'more_featrues' => 'array', // JSON will auto convert to array (typo in DB)
    ];






    public function modules(): array
    {
        $features = [
            'module_account'    => __('Accounts'),
            'module_crm'        => __('CRM'),
            'module_pos'        => __('POS'),
            'module_hrm'        => __('HRM'),
            'module_project'    => __('Project'),
            'module_manfucture' => __('Manufacture'),
        ];

        $active = [];

        foreach ($features as $column => $label) {
                $active[$column] = $label;
        }



        return $active;
    }
    public function planModules(): array
    {
        $features = [
            'module_account'    => __('Accounts'),
            'module_crm'        => __('CRM'),
            'module_pos'        => __('POS'),
            'module_hrm'        => __('HRM'),
            'module_project'    => __('Project'),
            'module_manfucture' => __('Manufacture'),
        ];

        $active = [];

        foreach ($features as $column => $label) {
            if ($this->$column == 1) {
                $active[] = $label;
            }
        }



        return $active;
    }

    public function activeFeatures(): array
    {
        $features = [
            'module_account'    => __('Accounts'),
            'module_crm'        => __('CRM'),
            'module_pos'        => __('POS'),
            'module_hrm'        => __('HRM'),
            'module_project'    => __('Project'),
            'module_manfucture' => __('Manufacture'),
        ];

        $active = [];

        foreach ($features as $column => $label) {
            if ($this->$column == 1) {
                $active[] = $label;
            }
        }

        // merge JSON features if exist (note: typo in DB field name)
        if (!empty($this->more_featrues) && is_array($this->more_featrues)) {
            $active = array_merge($active, $this->more_featrues);
        }

        return $active;
    }

    public function inactiveFeatures(): array
    {
        $features = [
            'module_account'    => __('Accounts'),
            'module_crm'        => __('CRM'),
            'module_pos'        => __('POS'),
            'module_hrm'        => __('HRM'),
            'module_project'    => __('Project'),
            'module_manfucture' => __('Manufacture'),
        ];

        $inactive = [];

        foreach ($features as $column => $label) {
            if (empty($this->$column)) {
                $inactive[] = $label;
            }
        }

        return $inactive;
    }
}
