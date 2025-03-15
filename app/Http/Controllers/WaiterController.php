<?php
/**
 * @copyright Alexander S. <alexander@sharapov.biz>
 * @link http://www.sharapov.biz/
 * @link https://golance.com/freelancer/alexander.sharapov
 * @link https://www.upwork.com/freelancers/sharapov
 * Date: 15.03.2025
 * Time: 15:52
 */

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class WaiterController extends Controller
{
    /**
     * Display a listing of waiters.
     */
    public function index()
    {
        // Fetch only users with role 'waiter'
        $waiters = User::where('role', 'waiter')->paginate(10);
        return view('admin.index', compact('waiters'));
    }

    /**
     * Store a new waiter in the database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:users,name',
            'password' => 'required|string|min:3',
        ]);

        User::create([
            'name' => $request->name,
            'password' => Hash::make($request->password),
            'role' => 'waiter',
        ]);

        return redirect()->route('admin.index')->with('success', 'Официант успешно добавлен.');
    }

    /**
     * Update the specified waiter in the database.
     */
    public function update(Request $request)
    {
        $waiters = $request->input('waiters');

        foreach ($waiters as $id => $data) {
            $waiter = User::where('id', $id)->where('role', 'waiter')->first();

            if ($waiter) {
                $waiter->update([
                    'name' => $data['name'] ?? $waiter->name,
                    'is_blocked' => $data['is_blocked'],
                ]);
            }
        }

        return redirect()->route('admin.index')->with('success', 'Данные успешно обновлены.');
    }

    /**
     * Remove the specified waiter from the database.
     */
    public function destroy(string $id)
    {
        $waiter = User::where('id', $id)->where('role', 'waiter')->first();

        if ($waiter) {
            $waiter->delete();
        }

        return redirect()->route('admin.index')->with('success', 'Официант успешно удалён.');
    }
}
