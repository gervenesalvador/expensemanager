<?php

namespace App\Http\Controllers;

use App\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('expense.index');
    }

    public function get()
    {
        $expenses = Expense::where(['user_id' => Auth::id()])->get();
        $data = [];
        foreach ($expenses as $expense) {
            $data[] = [
                'expense_id' => $expense->id,
                'category_id' => $expense->category_id,
                'category_name' => $expense->expense_category->name,
                'amount' => $expense->amount,
                'entry_date' => $expense->entry_date->format('Y-m-d'),
                'created_at' => $expense->created_at->format('Y-m-d h:i a')
            ];
        }
        return response()->json([
            'status' => 'success',
            'expenses' => $data
        ]);
    }

    public function getAll()
    {
        $expenses = Expense::all();
        $data = [];
        foreach ($expenses as $expense) {
            $data[] = [
                'expense_id' => $expense->id,
                'category' => [
                    'id' => $expense->category_id,
                    'name' => $expense->expense_category->name
                ],
                'user' => [
                    'id' => $expense->user->id,
                    'name' => $expense->user->name,
                ],
                'amount' => $expense->amount,
                'entry_date' => $expense->entry_date->format('Y-m-d'),
                'created_at' => $expense->created_at->format('Y-m-d h:i a')
            ];
        }
        return response()->json([
            'status' => 'success',
            'expenses' => $data
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category_id' => 'required',
            'amount' => 'required',
            'entry_date' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'failed',
                'error' => ['message' => 'Invalid data']
            ]);
        }
        
        if (!strtotime($request->entry_date)) {
            return response()->json([
                'status' => 'failed',
                'error' => ['message' => 'Invalid entry date format']
            ]);
        }

        $expense = new Expense;
        $expense->user_id = Auth::id();
        $expense->category_id = $request->category_id;
        $expense->amount = $request->amount;
        $expense->entry_date = Carbon::createFromFormat('Y-m-d', $request->entry_date);

        if ($expense->save()) {
            return response()->json([
                'status' => 'success',
                'expense' => $expense
            ]);
        }

        return response()->json([
            'status' => 'failed',
            'error' => ['message' => 'failed to create expense']
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function show(Expense $expense)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function edit(Expense $expense)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Expense $expense)
    {
        $validator = Validator::make($request->all(), [
            'expense_id' => 'required',
            'category_id' => 'required',
            'amount' => 'required',
            'entry_date' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'failed',
                'error' => ['message' => 'Invalid data']
            ]);
        }

        if (!strtotime($request->entry_date)) {
            return response()->json([
                'status' => 'failed',
                'error' => ['message' => 'Invalid entry date format']
            ]);
        }

        $expense = Expense::find($request->expense_id);
        $expense->user_id = Auth::id();
        $expense->category_id = $request->category_id;
        $expense->amount = $request->amount;
        $expense->entry_date = Carbon::createFromFormat('Y-m-d', $request->entry_date);

        if ($expense->save()) {
            return response()->json([
                'status' => 'success',
                'expense' => $expense
            ]);
        }

        return response()->json([
            'status' => 'failed',
            'error' => ['message' => 'failed to update the expense']
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function destroy(Expense $expense)
    {
        //
    }

    
}
