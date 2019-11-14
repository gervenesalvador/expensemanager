<?php

namespace App\Http\Controllers;

use App\ExpenseCategory;
use Illuminate\Http\Request;
use App\Http\Requests\StoreExpenseCategoryPost;
use Illuminate\Support\Facades\Validator;

class ExpenseCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('expense_category.index');
    }

    public function get()
    {
        $expense_category = ExpenseCategory::all();
        
        return response()->json([
            'status' => 'success',
            'expense_category' => $expense_category
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
    public function store(StoreExpenseCategoryPost $request)
    {
        $expense_category = new ExpenseCategory;
        $expense_category->name = $request->name;
        $expense_category->description = $request->description;

        if ($expense_category->save()) {
            return response()->json([
                'status' => 'success',
                'expense_category' => $expense_category
            ]);
        }

        return response()->json([
            'status' => 'failed',
            'error' => ['message' => 'failed to create expense category']
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ExpenseCategory  $expenseCategory
     * @return \Illuminate\Http\Response
     */
    public function show(ExpenseCategory $expenseCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ExpenseCategory  $expenseCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(ExpenseCategory $expenseCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ExpenseCategory  $expenseCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'category_id' => 'required',
            'name' => 'required',
            'description' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'failed',
                'error' => ['message' => 'Invalid data']
            ]);
        }

        $expense_category = ExpenseCategory::find($request->category_id);
        $expense_category->name = $request->name;
        $expense_category->description = $request->description;

        if ($expense_category->save()) {
            return response()->json([
                'status' => 'success',
                'expense_category' => $expense_category
            ]);
        }

        return response()->json([
            'status' => 'failed',
            'error' => ['message' => 'failed to update the expense category']
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ExpenseCategory  $expenseCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(ExpenseCategory $expenseCategory)
    {
        $expense_category = ExpenseCategory::find($id);

        if (empty($expense_category)) {
            return response()->json([
                'status' => 'failed',
                'error' => ['message' => 'expense category not existing']
            ]);
        }

        if ($expense_category->delete()) {
            return response()->json([
                'status' => 'success',
            ]);
        }

        return response()->json([
            'status' => 'failed',
            'error' => ['message' => 'failed to delete the expense category']
        ]);
    }
}
