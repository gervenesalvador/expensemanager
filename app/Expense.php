<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'entry_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function expense_category()
    {
        return $this->belongsTo('App\ExpenseCategory', 'category_id');
    }
}
