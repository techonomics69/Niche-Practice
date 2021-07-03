<?php

namespace Modules\ThirdParty\Services\Validations;

use Modules\Business\Models\Business;
use App\Services\Validations\LaravelValidator;

class AddSocialMediaValidator extends LaravelValidator
{

    protected $rules;

    protected $messages;

    public function passes()
    {
        $fileRule = 'max:200';
        if(!empty($this->data['file'])) {
            foreach ($this->data['file'] as $row){
               // dd($row);
                $type =  substr($row->getMimeType(),0,strrpos($row->getMimeType(),'/'));
                if($type == 'image'){
                    $fileRule = 'max:10000|mimes:jpeg,png';
                }else if($type == 'video'){
                    //$fileRule = 'max:512000|mimes:mp4';
                    $fileRule = 'max:10000|mimes:mp4';
                }
                else{
                    $fileRule = 'max:10000|mimes:jpeg,png,mp4';
                }
            }
        }

        $this->messages = [
            'file.*.max'  => 'File not greater 10MB',
            'schedule_date.required_if'  => 'schedule date is required',
        ];

        $this->rules = [
            'file' => 'array',
            'file.*' => $fileRule,
            'schedule_date' => 'required_if:status,schedule'

        ];

        return parent::passes();
    }
}