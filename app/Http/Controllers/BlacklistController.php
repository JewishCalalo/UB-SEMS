<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BlacklistedEmail;

class BlacklistController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','verified','can:manager,admin']);
    }

    public function index(Request $request)
    {
        $query = BlacklistedEmail::query();

        if ($request->filled('search')) {
            $query->where('email', 'like', '%' . $request->search . '%');
        }

        $perPage = max(5, min((int) $request->get('per_page', 15), 100));
        $items = $query->latest('created_at')->paginate($perPage)->appends($request->query());

        $view = auth()->user()->isAdmin()
            ? 'admin.missing-equipment.blacklist'
            : 'manager.missing-equipment.blacklist';

        return view($view, compact('items'));
    }

    public function release(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        BlacklistedEmail::where('email', strtolower(trim($request->email)))->delete();
        return back()->with('success', 'Email released from blacklist.');
    }
}


