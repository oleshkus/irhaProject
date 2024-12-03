@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100 py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Profile Header -->
        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
            <div class="relative h-48 bg-gradient-to-r from-blue-500 to-indigo-600">
                <!-- Edit Button -->
                @if(auth()->id() === $user->id)
                    <div class="absolute top-4 right-4">
                        <a href="{{ route('profile.edit') }}" 
                           class="inline-flex items-center px-4 py-2 bg-white bg-opacity-90 hover:bg-opacity-100 border border-transparent rounded-md font-semibold text-xs text-blue-600 uppercase tracking-widest hover:bg-white focus:bg-white active:bg-white focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 transition ease-in-out duration-150">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                            </svg>
                            Редактировать
                        </a>
                    </div>
                @endif
                
                <!-- Profile Image -->
                <div class="absolute -bottom-16 left-8">
                    @if($user->avatar)
                        <img src="{{ asset('storage/' . $user->avatar) }}" 
                             alt="Avatar" 
                             class="w-32 h-32 rounded-full border-4 border-white shadow-lg object-cover">
                    @else
                        <div class="w-32 h-32 rounded-full border-4 border-white shadow-lg bg-gray-200 flex items-center justify-center">
                            <svg class="w-16 h-16 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Profile Info -->
            <div class="pt-20 pb-8 px-8">
                <h1 class="text-3xl font-bold text-gray-900">
                    {{ $user->name }}
                </h1>
                <p class="mt-2 text-gray-600">{{ $user->email }}</p>
            </div>
        </div>

        <!-- Profile Details -->
        <div class="mt-8 bg-white shadow-lg rounded-lg overflow-hidden">
            <div class="px-8 py-6">
                <h2 class="text-2xl font-semibold text-gray-900 mb-6">Информация о пользователе</h2>
                
                <div class="space-y-6">
                    <!-- Name -->
                    <div class="flex items-center">
                        <div class="w-1/4">
                            <span class="text-gray-600 font-medium">Имя</span>
                        </div>
                        <div class="w-3/4">
                            <span class="text-gray-900">{{ $user->name }}</span>
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="flex items-center">
                        <div class="w-1/4">
                            <span class="text-gray-600 font-medium">Email</span>
                        </div>
                        <div class="w-3/4">
                            <span class="text-gray-900">{{ $user->email }}</span>
                        </div>
                    </div>

                    <!-- Member Since -->
                    <div class="flex items-center">
                        <div class="w-1/4">
                            <span class="text-gray-600 font-medium">Дата регистрации</span>
                        </div>
                        <div class="w-3/4">
                            <span class="text-gray-900">{{ $user->created_at->format('d.m.Y') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
