<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Menu;
use App\Models\Order;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard with the list of menu items.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $menu = Menu::with('category')->orderBy('created_at', 'desc')->paginate(10);
        $category = Category::all();
        $orders = Order::all();


        return view('home', compact('menu', 'category', 'orders'));
    }

    /**
     * Store a new dish in the menu.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeMenu(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,uuid',
        ]);

        Menu::create($validated);

        return redirect()->route('admin.index')->with('success', 'Новое блюдо добавлено в меню!');
    }

    /**
     * Update existing menu dishes.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateMenu(Request $request)
    {
        $request->validate([
            'dishes.*.name' => 'required|string|max:255',
            'dishes.*.description' => 'nullable|string',
            'dishes.*.price' => 'required|numeric|min:0',
            'dishes.*.category_id' => 'required|exists:categories,uuid',
        ]);

        foreach ($request->input('dishes') as $id => $dishData) {
            $menu = Menu::findOrFail($id);
            $menu->update($dishData);
        }

        return redirect()->route('admin.index')->with('success', 'Меню успешно обновлено!');
    }

    /**
     * Delete a dish from the menu.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroyMenu($id)
    {
        $menu = Menu::findOrFail($id);
        $menu->delete();

        return redirect()->route('admin.index')->with('success', 'Блюдо успешно удалено из меню!');
    }
}
