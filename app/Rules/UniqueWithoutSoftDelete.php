<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class UniqueWithoutSoftDelete implements Rule
{
    protected $table;
    protected $column;
    protected $ignoreId;

    public function __construct($table, $column, $ignoreId = null)
    {
        $this->table = $table;
        $this->column = $column;
        $this->ignoreId = $ignoreId;
    }

    public function passes($attribute, $value)
    {
        $query = DB::table($this->table)
            ->where($this->column, $value)
            ->whereNull('deleted_at');

        if ($this->ignoreId !== null) {
            $query->where('id', '!=', $this->ignoreId);
        }

        $result = $query->count();

        return $result === 0;
    }

    public function message()
    {
        return 'The :attribute has already been taken.';
    }
}
