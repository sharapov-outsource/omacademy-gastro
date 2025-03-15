@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Управление заказами</h1>

        {{-- Menu with checkboxes for creating a new order --}}
        @if($menu->isEmpty())
            <p>Меню пока пусто.</p>
        @else
            <form method="POST" action="{{ route('orders.store') }}">
                @csrf
                <table class="table">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Название</th>
                        <th>Категория</th>
                        <th>Цена</th>
                        <th>Выбрать</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($menu as $dish)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $dish->name }}</td>
                            <td>{{ $dish->category->name }}</td>
                            <td>{{ $dish->price }}</td>
                            <td>
                                <input type="checkbox" name="dishes[{{ $dish->uuid }}]" value="1">
                                <input type="number" name="quantities[{{ $dish->uuid }}]" class="form-control" value="1" placeholder="Кол-во" style="width: 80px">
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <button type="submit" class="btn btn-primary">Добавить в заказ</button>
            </form>

            <div class="mt-4">
                {{ $menu->links() }}
            </div>
        @endif

        {{-- List orders --}}
        <h2 class="mt-5">Заказы</h2>
        @if($orders->isEmpty())
            <p>Пока нет заказов.</p>
        @else
            <table class="table">
                <thead>
                <tr>
                    <th>#</th>
                    <th>ID заказа</th>
                    <th>Блюда</th>
                    <th>Дата создания</th>
                </tr>
                </thead>
                <tbody>
                @foreach($orders as $order)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $order->uuid }}</td>
                        <td>
                            <ul>
                                @foreach($order->items as $item)
                                    <li>{{ $item->menu->name }} ({{ $item->quantity }})</li>
                                @endforeach
                            </ul>
                        </td>
                        <td>{{ $order->created_at->format('d.m.Y H:i') }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
