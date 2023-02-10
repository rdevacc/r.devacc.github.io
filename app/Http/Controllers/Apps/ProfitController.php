<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use App\Models\Profit;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProfitController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index()
    {

        return Inertia::render('Apps/Profits/Index');
    }

    /**
     * filter
     *
     * @param  mixed $request
     * @return void
     */
    public function filter(Request $request)
    {

        $this->validate($request, [
            'start_date' => 'required',
            'end_date' => 'required',
        ]);

        // Get data profits by range date
        $profits = Profit::with('transaction')
            ->whereDate('created_at', '>=', $request->start_date)
            ->whereDate('created_at', '<=', $request->end_date)
            ->get();

        // Get total profit by range date
        $total = Profit::whereDate('created_at', '>=', $request->start_date)
            ->whereDate('created_at', '<=', $request->end_date)
            ->sum('total');

        // Return Inertia
        return Inertia::render('Apps/Profits/Index', [
            'profits' => $profits,
            'total' => (int) $total,
        ]);
    }
}
