{{-- resources/views/layouts/sidebar.blade.php --}}

<aside id="sidebar" class="w-64 bg-white shadow-xl border-r border-gray-200 flex flex-col min-h-screen">
    {{-- Header --}}
    <div class="p-6 border-b border-gray-100">
        <h2 class="text-2xl font-bold text-blue-600 mb-4">HydroSync</h2>

        {{-- User Profile --}}
        <div class="flex items-center space-x-3 p-3 bg-blue-50 rounded-lg">
            <div class="w-8 h-8 bg-blue-500 rounded-full overflow-hidden ring-2 ring-blue-200 flex-shrink-0">
                @if(Auth::user()->profile_photo)
                    <img src="{{ asset('storage/avatars/' . Auth::user()->profile_photo) }}"
                         class="object-cover w-full h-full" />
                @else
                    <div class="flex items-center justify-center h-full text-white font-bold text-xs">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                @endif
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-medium text-gray-900 truncate">{{ Auth::user()->name }}</p>
                <p class="text-xs text-gray-500 truncate">{{ Auth::user()->email }}</p>
            </div>
        </div>
    </div>

    {{-- Navigation --}}
    <nav class="flex-1 px-4 py-6 space-y-1">

        {{-- Common to all roles --}}
        <a href="{{ route('dashboard') }}" class="group flex items-center px-3 py-2 text-sm font-medium text-gray-700 rounded-md hover:bg-blue-50 hover:text-blue-600 transition {{ request()->routeIs('dashboard') ? 'bg-blue-50 text-blue-600 border-r-2 border-blue-600' : '' }}">
            <span class="text-lg mr-3">📊</span> Dashboard
        </a>

        <a href="{{ route('transactions.index') }}" class="group flex items-center px-3 py-2 text-sm font-medium text-gray-700 rounded-md hover:bg-blue-50 hover:text-blue-600 transition {{ request()->routeIs('transactions.*') ? 'bg-blue-50 text-blue-600 border-r-2 border-blue-600' : '' }}">
            <span class="text-lg mr-3">💵</span> Transactions
        </a>

        {{-- Admin-only links --}}
        @if(auth()->user()->role === 'admin')
            <a href="{{ route('expenses.index') }}" class="group flex items-center px-3 py-2 text-sm font-medium text-gray-700 rounded-md hover:bg-blue-50 hover:text-blue-600 transition {{ request()->routeIs('expenses.*') ? 'bg-blue-50 text-blue-600 border-r-2 border-blue-600' : '' }}">
                <span class="text-lg mr-3">🧾</span> Expenses
            </a>

            <a href="{{ route('sales.history') }}" class="group flex items-center px-3 py-2 text-sm font-medium text-gray-700 rounded-md hover:bg-blue-50 hover:text-blue-600 transition {{ request()->routeIs('sales.*') ? 'bg-blue-50 text-blue-600 border-r-2 border-blue-600' : '' }}">
                <span class="text-lg mr-3">📈</span> Sales History
            </a>

            <a href="{{ route('calendar.index') }}" class="group flex items-center px-3 py-2 text-sm font-medium text-gray-700 rounded-md hover:bg-blue-50 hover:text-blue-600 {{ request()->routeIs('calendar.index') ? 'bg-blue-50 text-blue-600 border-r-2 border-blue-600' : '' }}">
                <span class="text-lg mr-3">🗓️</span> Calendar
            </a>

              <a href="{{ route('chat.index') }}" class="group flex items-center px-3 py-2 text-sm font-medium text-gray-700 rounded-md hover:bg-blue-50 hover:text-blue-600 {{ request()->routeIs('profile.*') ? 'bg-blue-50 text-blue-600 border-r-2 border-blue-600' : '' }}">
            <span class="text-lg mr-3">🤖</span> AI Assistant
        </a>


            <div class="pt-4 mt-4 border-t border-gray-200">
                <p class="px-3 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Admin</p>
                <a href="{{ route('staff.index') }}" class="group flex items-center px-3 py-2 text-sm font-medium text-gray-700 rounded-md hover:bg-blue-50 hover:text-blue-600 transition {{ request()->routeIs('staff.*') ? 'bg-blue-50 text-blue-600 border-r-2 border-blue-600' : '' }}">
                    <span class="text-lg mr-3">👥</span> Staff Management
                </a>
            </div>
        @endif

        {{-- Always visible --}}
        <a href="{{ route('profile.show') }}" class="group flex items-center px-3 py-2 text-sm font-medium text-gray-700 rounded-md hover:bg-blue-50 hover:text-blue-600 transition {{ request()->routeIs('profile.*') ? 'bg-blue-50 text-blue-600 border-r-2 border-blue-600' : '' }}">
            <span class="text-lg mr-3">🙍</span> Profile
        </a>
    </nav>

    {{-- Footer Logout --}}
    <div class="p-4 border-t border-gray-200">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full flex items-center px-3 py-2 text-sm font-medium text-red-600 rounded-md hover:bg-red-50 hover:text-red-700 transition">
                <span class="text-lg mr-3">🔓</span> Log Out
            </button>
        </form>
    </div>
</aside>
