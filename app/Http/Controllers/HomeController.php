<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Expense;
use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $expenses = Expense::where('user_id', Auth::id())->get();
        $data = [];
        $total = 0;
        foreach ($expenses as $expense) {
            if (empty($data[$expense->expense_category->id])) {
                $data[$expense->expense_category->id] = [
                    'name' => $expense->expense_category->name,
                    'sum' => $expense->amount
                ];
            } else {
                $data[$expense->expense_category->id]['sum'] += $expense->amount;
            }
            $total +=  $expense->amount;
        }

        return view('home', [
            'expenses' => $data,
            'total' => $total
        ]);
    }
}
