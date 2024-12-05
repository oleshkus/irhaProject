@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <x-custom.breadcrumbs 
            title="Редактирование пользователя"
            :backRoute="route('admin.users.index')" 
            backText="К списку пользователей"
        />

        <div class="mt-8 bg-white overflow-hidden shadow rounded-lg">
            <form action="{{ route('admin.users.update', $user) }}" method="POST" class="divide-y divide-gray-200">
                @csrf
                @method('PUT')

                <div class="px-4 py-5 sm:p-6">
                    <div class="grid grid-cols-1 gap-6">
                        <!-- Имя -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">Имя</label>
                            <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                            @error('name')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                            <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                            @error('email')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Пароль -->
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700">
                                Новый пароль
                                <span class="text-sm text-gray-500">(оставьте пустым, если не хотите менять)</span>
                            </label>
                            <input type="password" name="password" id="password"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                            @error('password')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Подтверждение пароля -->
                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Подтверждение нового пароля</label>
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                        </div>

                        <!-- Роль -->
                        <div>
                            <label for="role" class="block text-sm font-medium text-gray-700">Роль</label>
                            <select name="role" id="role" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                <option value="user" {{ old('role', $user->role) === 'user' ? 'selected' : '' }}>Пользователь</option>
                                <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Администратор</option>
                            </select>
                            @error('role')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                    <button type="submit"
                            class="inline-flex justify-center rounded-md border border-transparent bg-blue-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        Сохранить изменения
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
