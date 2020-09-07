<?php

namespace BeetleCore\Validators;

use App\Admin\Admin;

class Basic
{
    protected $field;
    protected $params;
    /**
     * @var Admin
     */
    protected $record;
    public function __construct($field, $params, $record)
    {
        $this->field = $field;
        $this->params = $params;
        $this->record = $record;
    }

    public function valid($value)
    {
        return true;
    }

}

