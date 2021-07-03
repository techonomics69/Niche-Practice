<?php

namespace Modules\Admin\Services\Validations\Task;

use Modules\Task\Models\Task;
use App\Services\Validations\LaravelValidator;

class NewTaskValidator extends LaravelValidator
{
    protected $id = '';
    protected $messages = [
        // 'sys_type.unique' => 'Widget type already taken by an other alert please try any other.',
        // 'sys_type.required' => 'Widget type is required please select that is not already taken'
        ];
    protected $rules = [
        'title' => 'required|string|max:255',
        'sys_status' => 'required',
        'category' => 'nullable',
        // 'sys_type' => 'required|unique:alert_controller'
    ];

    public function passes()
    {
        $sys_typeRule = '';
        if(!empty($this->data['sys_type']))
        {
            if(!empty($this->data['id'])) {
                $this->id = $this->data['id'];
                $sys_typeRule = 'required|unique:alert_controller,sys_type,'.$this->id.',id';
//            $webRule = 'unique:business_master,website,'.$this->businessId.',business_id';
            }
            else
            {
                $sys_typeRule = 'required|unique:alert_controller';
            }
        }

        $this->messages = [
        'sys_type.unique' => 'This Widget type already taken. Please try another or save empty.',
        'sys_type.required' => 'Widget type is required please select widget that is not already taken.'
         ];

        $this->rules = [
        'sys_type' => $sys_typeRule,
    ];


        return parent::passes();
    }
}
