@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Управление меню</h1>

        {{-- Check if the menu is currently empty --}}
        @if($menu->isEmpty())
            <p>Меню пока пусто.</p>
        @else
            {{-- Form for updating dish details --}}
            <form method="POST" action="{{ route('menu.update') }}">
                @csrf
                @method('PATCH')

                <table class="table">
                    <thead>
                    <tr>
                        <th>Название</th>
                        <th>Описание</th>
                        <th>Цена</th>
                        <th>Категория</th>
                        <th>Действие</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($menu as $dish)
                        <tr>
                            <td><input type="text" name="dishes[{{ $dish->uuid }}][name]" value="{{ $dish->name }}" class="form-control"></td>
                            <td><textarea name="dishes[{{ $dish->uuid }}][description]" class="form-control">{{ $dish->description }}</textarea></td>
                            <td><input type="number" name="dishes[{{ $dish->uuid }}][price]" value="{{ $dish->price }}" class="form-control" step="0.01" min="0"></td>
                            <td>
                                <select name="dishes[{{ $dish->uuid }}][category_id]" class="form-control">
                                    @foreach($category as $item)
                                        <option value="{{ $item->uuid }}" {{ $dish->category_id == $item->uuid ? 'selected' : '' }}>
                                            {{ $item->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                {{-- Button to delete a dish --}}
                                <button type="button" class="btn btn-danger" onclick="deleteDish('{{ route('menu.destroy', $dish->uuid) }}')">Удалить</button>
                            </td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>

                {{-- Submit button to save changes --}}
                <button type="submit" class="btn btn-primary">Сохранить изменения</button>
            </form>

            {{-- Add pagination controls --}}
            <div class="mt-4">
                {{ $menu->links() }}
            </div>
        @endif

        {{-- Form for adding a new dish --}}
        <h2 class="mt-5">Добавить новое блюдо</h2>
        <form method="POST" action="{{ route('menu.store') }}">
            @csrf
            <div class="form-group">
                <label for="name">Название:</label>
                <input type="text" name="name" id="name" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="description">Описание:</label>
                <textarea name="description" id="description" class="form-control"></textarea>
            </div>
            <div class="form-group">
                <label for="price">Цена:</label>
                <input type="number" name="price" id="price" class="form-control" step="0.01" min="0" required>
            </div>
            <div class="form-group">
                <label for="category_id">Категория:</label>
                <select name="category_id" id="category_id" class="form-control" required>
                    @foreach($category as $item)
                        <option value="{{ $item->uuid }}">{{ $item->name }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-success mt-3">Добавить блюдо</button>
        </form>
    </div>

    {{-- JavaScript for handling the delete action --}}
    <script>
        function deleteDish(url) {
            if (confirm('Вы уверены, что хотите удалить это блюдо?')) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = url;

                const methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                methodInput.value = 'DELETE';
                form.appendChild(methodInput);

                const csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = '_token';
                csrfInput.value = '{{ csrf_token() }}';
                form.appendChild(csrfInput);

                document.body.appendChild(form);
                form.submit();
            }
        }
    </script>
<div class="h-25">&nbsp;</div>
    <div class="container">
        <h1>Управление официантами</h1>

        {{-- Check if there are any waiters --}}
        @if($waiters->isEmpty())
            <p>Список официантов пуст.</p>
        @else
            {{-- Form for updating waiter details --}}
            <form method="POST" action="{{ route('waiters.update') }}">
                @csrf
                @method('PATCH')

                <table class="table">
                    <thead>
                    <tr>
                        <th>Имя</th>
                        <th>Статус</th>
                        <th>Действие</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($waiters as $waiter)
                        <tr>
                            <td><input type="text" name="waiters[{{ $waiter->id }}][name]" value="{{ $waiter->name }}" class="form-control"></td>
                            <td>
                                <select name="waiters[{{ $waiter->id }}][is_blocked]" class="form-control">
                                    <option value="0" {{ !$waiter->is_blocked ? 'selected' : '' }}>Активен</option>
                                    <option value="1" {{ $waiter->is_blocked ? 'selected' : '' }}>Заблокирован</option>
                                </select>
                            </td>
                            <td>
                                {{-- Button to delete a waiter --}}
                                <button type="button" class="btn btn-danger" onclick="deleteWaiter('{{ route('waiters.destroy', $waiter->id) }}')">Удалить</button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                {{-- Submit button to save changes --}}
                <button type="submit" class="btn btn-primary">Сохранить изменения</button>
            </form>
        @endif

        {{-- Form for adding a new waiter --}}
        <h2 class="mt-5">Добавить нового официанта</h2>
        <form method="POST" action="{{ route('waiters.store') }}">
            @csrf
            <div class="form-group">
                <label for="name">Имя:</label>
                <input type="text" name="name" id="name" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="password">Пароль:</label>
                <input type="password" name="password" id="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-success mt-3">Добавить официанта</button>
        </form>
    </div>

    {{-- JavaScript for handling the delete action --}}
    <script>
        function deleteWaiter(url) {
            if (confirm('Вы уверены, что хотите удалить этого официанта?')) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = url;

                const methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                methodInput.value = 'DELETE';
                form.appendChild(methodInput);

                const csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = '_token';
                csrfInput.value = '{{ csrf_token() }}';
                form.appendChild(csrfInput);

                document.body.appendChild(form);
                form.submit();
            }
        }
    </script>
@endsection
