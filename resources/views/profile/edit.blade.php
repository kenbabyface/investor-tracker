<x-app-layout title="Edit Profile">
    <x-slot name="header">
        <div class="space-y-3">
            <nav class="text-sm">
                <ol class="list-none p-0 inline-flex flex-wrap items-center">
                    <li class="flex items-center">
                        <a href="{{ route('dashboard') }}" class="text-blue-600 hover:text-blue-800 transition-colors duration-200">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            </svg>
                        </a>
                        <svg class="w-3 h-3 mx-2 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"></path>
                        </svg>
                    </li>
                    <li class="flex items-center">
                        <a href="{{ route('profile.show') }}" class="text-blue-600 hover:text-blue-800 transition-colors duration-200 font-medium">Profile</a>
                        <svg class="w-3 h-3 mx-2 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"></path>
                        </svg>
                    </li>
                    <li class="flex items-center text-gray-500 font-medium">Edit</li>
                </ol>
            </nav>

            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div>
                    <h2 class="font-bold text-2xl text-gray-800 leading-tight tracking-tight">
                        {{ __('Edit Profile') }}
                    </h2>
                    <p class="text-sm text-gray-500 mt-1">Update your account information and settings</p>
                </div>
                <a href="{{ route('profile.show') }}"
                   class="inline-flex items-center px-4 py-2 bg-white border border-gray-200 hover:border-blue-300 hover:bg-blue-50 text-gray-700 hover:text-blue-700 font-medium rounded-xl transition-all duration-200 shadow-sm hover:shadow-md">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Profile
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="w-full mx-auto px-4 sm:px-6 lg:px-8 max-w-6xl">

            @if(session('status') === 'profile-updated')
                <div class="mb-6 bg-gradient-to-r from-green-50 to-emerald-50 border-l-4 border-green-500 rounded-xl shadow-sm animate-fadeIn">
                    <div class="flex items-center p-4">
                        <svg class="w-6 h-6 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        <p class="ml-3 text-sm font-semibold text-green-800">Profile updated successfully!</p>
                        <button onclick="this.parentElement.parentElement.remove()" class="ml-auto text-green-500 hover:text-green-700 p-1 hover:bg-green-100 rounded-lg transition-colors">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            @endif

            <div class="space-y-6">

                <!-- Row 1: Profile Info + Password side by side -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 items-start">

                    <!-- Profile Information Card -->
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden hover:shadow-xl transition-all duration-300">
                        <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-5">
                            <div class="flex items-center">
                                <div class="bg-white/20 backdrop-blur-sm p-2.5 rounded-xl shadow-inner">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <h3 class="text-lg font-bold text-white tracking-tight">Profile Information</h3>
                                    <p class="text-sm text-blue-100">Update your name and email address</p>
                                </div>
                            </div>
                        </div>
                        <div class="p-6 bg-gray-50/50">
                            @include('profile.partials.update-profile-information-form')
                        </div>
                    </div>

                    <!-- Update Password Card -->
                    <div id="password" class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden hover:shadow-xl transition-all duration-300">
                        <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-5">
                            <div class="flex items-center">
                                <div class="bg-white/20 backdrop-blur-sm p-2.5 rounded-xl shadow-inner">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <h3 class="text-lg font-bold text-white tracking-tight">Update Password</h3>
                                    <p class="text-sm text-blue-100">Ensure your account is using a secure password</p>
                                </div>
                            </div>
                        </div>
                        <div class="p-6 bg-gray-50/50">
                            @include('profile.partials.update-password-form')
                        </div>
                    </div>

                </div>

                <!-- Row 2: Delete Account — half width -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <div class="bg-white rounded-2xl shadow-lg border-2 border-red-200 overflow-hidden hover:shadow-xl transition-all duration-300">
                        <div class="bg-gradient-to-r from-red-500 to-red-600 px-6 py-5">
                            <div class="flex items-center">
                                <div class="bg-white/20 backdrop-blur-sm p-2.5 rounded-xl shadow-inner">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <h3 class="text-lg font-bold text-white tracking-tight">Delete Account</h3>
                                    <p class="text-sm text-red-100">Permanently delete your account and all data</p>
                                </div>
                            </div>
                        </div>
                        <div class="p-6 bg-red-50/50">
                            @include('profile.partials.delete-user-form')
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>

<style>
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(-10px); }
    to   { opacity: 1; transform: translateY(0); }
}
.animate-fadeIn { animation: fadeIn 0.5s ease-out; }
</style>