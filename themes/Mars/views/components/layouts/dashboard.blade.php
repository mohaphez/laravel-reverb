<!-- Top Header -->
<header class="bg-blue-500 p-4 text-white">
    <div class="container mx-auto">
        <h1 class="text-2xl font-semibold">Welcome - {{auth()->user()->name }}</h1>
    </div>
</header>

<!-- Main Content -->
<div class="flex">
    <!-- Sidebar -->
    <aside class="w-64 bg-gray-800 text-white min-h-screen">
        <div class="flex items-center justify-center h-16 bg-gray-700">
            <span class="text-xl font-semibold">Logo</span>
        </div>
        <nav class="mt-4">
            <a href="/" class="block py-2 px-4 text-gray-300 hover:bg-gray-700 hover:text-white">Dashboard</a>
        </nav>
        <nav class="mt-4">
            <a href="/travel" class="block py-2 px-4 text-gray-300 hover:bg-gray-700 hover:text-white">Travel</a>
        </nav>
        <nav class="mt-4">
            <a href="/currency" class="block py-2 px-4 text-gray-300 hover:bg-gray-700 hover:text-white">Currency</a>
        </nav>

         <nav class="mt-4">
            <a href="/document" class="block py-2 px-4 text-gray-300 hover:bg-gray-700 hover:text-white">Document</a>
        </nav>
    </aside>


    <!-- Main Content Area -->
    <main class="flex-1 p-4">
           {{$slot}}
    </main>
</div>
