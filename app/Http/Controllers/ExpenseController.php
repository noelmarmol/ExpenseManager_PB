<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ExpenseRequest;
use Illuminate\Support\Facades\DB;
use App\Expense;
use App\Category;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct() 
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        $expenses_post = DB::table('expenses')
        ->select(
            'categories.name AS category_id',
            'expenses.amount',
            'expenses.entry_date',
            'expenses.created_at AS created_at'
        )
        ->join('categories', 'categories.id', '=', 'expenses.category_id')
        ->get();

        $categories = Category::all();

        return view('expenses', compact('expenses_post', 'categories'));
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
    public function store(ExpenseRequest $expenserequest)
    {
        $expense_post = Expense::create($expenserequest->all());

        return response()->json([
            'message' => 'Expense has been succesfully posted!',
            'data' => $expense_post
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ExpenseRequest $expenserequest, Expense $expense)
    {
        $expense_post = $expense->update($expenserequest->all());
        
        return response()->json([
            'message' => 'Expense has been succesfully updated!',
            'data' => $expense_post
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Expense $expense)
    {
        $expense->delete();

        return response()->json([
            'message' => 'Expense has been succesfully deleted!'
        ]);
    }
}
