<?php

namespace App\Http\Controllers\Admin;

use App\CentralLogics\Helpers;
use App\Http\Controllers\Controller;
use App\Models\EMoney;
use App\Models\Transaction;
use App\Models\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function __construct(
        private User        $user,
        private EMoney      $eMoney,
        private Transaction $transaction
    )
    {
    }

    /**
     * @param Request $request
     * @return Application|Factory|View
     */
    public function dashboard(Request $request): View|Factory|Application
    {
        $data = [];

        $topAgents = $this->transaction->with('user')
            ->agent()
            ->select(['user_id', DB::raw("(SUM(debit) + SUM(credit)) as total_transaction")])
            ->orderBy("total_transaction", 'desc')
            ->groupBy('user_id')
            ->take(6)
            ->get();

        $topCustomers = $this->transaction->with('user')
            ->customer()
            ->select(['user_id', DB::raw("(SUM(debit) + SUM(credit)) as total_transaction")])
            ->orderBy("total_transaction", 'desc')
            ->groupBy('user_id')
            ->take(4)
            ->get();

        $topTransactions = $this->transaction->with('user')
            ->notAdmin()
            ->where('ref_trans_id', null)
            ->select(['user_id', DB::raw("(SUM(debit) + SUM(credit)) as total_transaction")])
            ->orderBy("total_transaction", 'desc')
            ->groupBy('user_id')
            ->take(20)
            ->get();

        $data['top_agents'] = $topAgents;
        $data['top_customers'] = $topCustomers;
        $data['top_transactions'] = $topTransactions;

        $balance = self::getBalanceStat();


        $transaction = [];
        for ($i = 1; $i <= 12; $i++) {
            $from = date('Y-' . $i . '-01');
            $to = date('Y-' . $i . '-30');
            $transaction[$i] = $this->transaction->where(['ref_trans_id' => 0])
                ->whereBetween('created_at', [$from, $to])
                ->select([DB::raw("SUM(debit) as total_credit")])
                ->orderBy("total_credit", 'desc')
                ->groupBy('user_id')
                ->first()->total_credit ?? 0;
        }

        return view('admin-views.dashboard', compact('balance', 'transaction', 'data'));
    }

    /**
     * @return array
     */
    public function getBalanceStat(): array
    {
        $usedBalance = $this->eMoney->with('user')
            ->where('user_id', '!=', Helpers::get_admin_id())
            ->sum('current_balance');

        $unusedBalance = $this->eMoney->with('user')
            ->where('user_id', Helpers::get_admin_id())
            ->sum('current_balance');

        $totalBalance = $this->transaction->where('user_id', Helpers::get_admin_id())->where('transaction_type', CASH_IN)->sum('credit');
        $chargeEarned = $this->eMoney->with('user')->where('user_id', Auth::id())->first()->charge_earned ?? 0;
        $pendingBalance = $this->eMoney->with('user')->sum('pending_balance');

        $balance = [];
        $balance['total_balance'] = $totalBalance;
        $balance['used_balance'] = $usedBalance + $pendingBalance;
        $balance['unused_balance'] = $unusedBalance;
        $balance['total_earned'] = $chargeEarned;

        return $balance;
    }

    /**
     * @return Application|Factory|View
     */
    public function settings(): View|Factory|Application
    {
        return view('admin-views.settings');
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function settingsUpdate(Request $request): RedirectResponse
    {
        $request->validate([
            'f_name' => 'required',
            'l_name' => 'required',
            'phone' => 'required',
        ]);

        $admin = $this->user->find(auth('user')->id());
        $admin->f_name = $request->f_name;
        $admin->l_name = $request->l_name;
        $admin->email = $request->email;
        $admin->phone = $request->phone;
        $admin->image = $request->has('image') ? Helpers::update('admin/', $admin->image, 'png', $request->file('image')) : $admin->image;
        $admin->save();
        Toastr::success(translate('Admin updated successfully!'));
        return back();
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function settingsPasswordUpdate(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => 'required|same:confirm_password|min:8',
            'confirm_password' => 'required',
        ]);
        $admin = $this->user->find(auth('user')->id());
        $admin->password = bcrypt($request['password']);
        $admin->save();
        Toastr::success('Admin password updated successfully!');
        return back();
    }
}
