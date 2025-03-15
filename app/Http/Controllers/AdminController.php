<?php
/**
 * @copyright Alexander S. <alexander@sharapov.biz>
 * @link http://www.sharapov.biz/
 * @link https://golance.com/freelancer/alexander.sharapov
 * @link https://www.upwork.com/freelancers/sharapov
 * Date: 26.10.2024
 * Time: 18:23
 */

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Menu;
use App\Models\User;

class AdminController extends Controller
{
    public function index()
    {
        $menu = Menu::with('category')->paginate(10);
        $category = Category::all();
        $waiters = User::where('role', 'waiter')->get();

        return view('admin.index', compact('menu', 'category', 'waiters'));
    }
}
