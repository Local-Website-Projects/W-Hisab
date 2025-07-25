<?php

namespace App\Http\Controllers;

use App\Models\DebitCredits;
use App\Models\Profile;
use App\Models\Project;
use App\Models\Supplier;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    function formatBDT($amount)
    {
        $amount = number_format($amount, 2, '.', '');
        $parts = explode('.', $amount);
        $int = $parts[0];
        $decimal = isset($parts[1]) ? '.' . $parts[1] : '';

        $len = strlen($int);
        if ($len <= 3) {
            return '৳' . $int . $decimal;
        }

        $last3 = substr($int, -3);
        $rest = substr($int, 0, -3);
        $rest = preg_replace("/\B(?=(\d{2})+(?!\d))/", ",", $rest);

        return '৳' . $rest . ',' . $last3 . $decimal;
    }


    public function index(){
        $todayExpense = DebitCredits::whereDate('date', Carbon::today())->sum('debit');
        $todayExpense = $this->formatBDT($todayExpense);
        $todayDeposit = DebitCredits::whereDate('date', Carbon::today())->sum('credit');
        $todayDeposit = $this->formatBDT($todayDeposit);
        $projects = Project::where('status', 1)->count();
        $suppliers = Supplier::count();
        $cashbooks = DebitCredits::whereDate('date', Carbon::today())->with('project','supplier','product')->latest()->paginate(20)->onEachSide(2);
        $totalCredit = DebitCredits::sum('credit');
        $totalDebit = DebitCredits::sum('debit');
        $cashOnHand = $totalCredit - $totalDebit;
        $cashOnHand = $this->formatBDT($cashOnHand);
        $rawResults = DB::table('projects')
            ->join('debit_credits', 'projects.project_id', '=', 'debit_credits.project_id')
            ->select(
                'projects.project_id',
                'projects.project_name',
                DB::raw('SUM(debit_credits.debit) as total_debit'),
                DB::raw('SUM(debit_credits.credit) as total_credit')
            )
            ->where('projects.status', 1)
            ->groupBy('projects.project_id', 'projects.project_name') // Group by both columns
            ->get();
        $results = $rawResults->map(function ($item) {
            return [
                'project_id'    => $item->project_id,
                'project_name'  => $item->project_name,
                'total_debit'   => $this->formatBDT($item->total_debit),
                'total_credit'  => $this->formatBDT($item->total_credit),
            ];
        });
        return view('dashboard',compact('todayExpense','todayDeposit','projects','suppliers','cashbooks','results','cashOnHand'));
    }
}
