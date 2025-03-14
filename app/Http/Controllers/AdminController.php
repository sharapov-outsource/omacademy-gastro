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
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $menu = Menu::with('category')->paginate(10);
        $category = Category::all();

        return view('admin.menus', compact('menu', 'category'));
    }

    public function updateStatus(Request $request)
    {
        $validated = $request->validate([
            'statuses' => 'required|array',
            'statuses.*' => 'in:Новое,Подтверждено,Отменено',
        ]);

        foreach ($validated['statuses'] as $menuId => $status) {
            $booking = Menu::findOrFail($menuId);
            $booking->status = $status;
            $booking->save();
        }

        return redirect()->route('menu.index')->with('status', 'Статусы успешно обновлены.');
    }
}
