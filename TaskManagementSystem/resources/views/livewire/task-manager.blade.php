<div class="container mx-auto p-6">
    <!-- Exibir Mensagens Flash -->
    @if (session()->has('message'))
    <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-200 dark:text-green-800" role="alert">
        {{ session('message') }}
    </div>
    @endif

    @if (session()->has('error'))
    <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg dark:bg-red-200 dark:text-red-800" role="alert">
        {{ session('error') }}
    </div>
    @endif

    <!-- Título -->
    <h1 class="text-4xl font-bold mb-8 text-center text-gray-800">Sistema de Gerenciamento de Tarefas</h1>

    <!-- Formulário para criar/atualizar tarefas -->
    <div class="bg-white p-6 rounded-lg shadow-lg mb-8">
        <h2 class="text-2xl font-semibold mb-4">{{ $taskId ? 'Atualizar Tarefa' : 'Criar Nova Tarefa' }}</h2>
        <form wire:submit.prevent="storeTask">
            <div class="mb-6">
                <label for="name" class="block text-lg font-medium text-gray-800">Nome da Tarefa</label>
                <input type="text" wire:model="name" id="name" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition ease-in-out duration-150" placeholder="Digite o nome da tarefa">
                @error('name')
                <span class="text-red-600 text-sm">Nome da tarefa é um campo obrigatório.</span>
                @enderror
            </div>

            <div class="mb-6">
                <label for="description" class="block text-lg font-medium text-gray-800">Descrição</label>
                <textarea wire:model="description" id="description" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition ease-in-out duration-150" placeholder="Digite a descrição da tarefa"></textarea>
                @error('description')
                <span class="text-red-600 text-sm">Descrição é um campo obrigatória.</span>
                @enderror
            </div>

            <div class="mb-6">
                <label for="category_id" class="block text-lg font-medium text-gray-800">Categoria</label>
                <select wire:model="category_id" id="category_id" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition ease-in-out duration-150">
                    <option value="">Selecione uma Categoria</option>
                    @forelse($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @empty
                    <option value="">Nenhuma categoria registrada</option>
                    @endforelse
                </select>
                @error('category_id')
                <span class="text-red-600 text-sm">Categoria é um campo obrigatória.</span>
                @enderror
            </div>

            <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-300 transition ease-in-out duration-150">
                {{ $taskId ? 'Atualizar' : 'Criar' }} Tarefa
            </button>
        </form>
    </div>

    <!-- Filtros de busca -->
    <div class="bg-white p-6 rounded-lg shadow-lg mb-8">
        <h2 class="text-2xl font-semibold mb-4">Filtrar Tarefas</h2>
        <form wire:submit.prevent="applyFilters" class="space-y-6">
            <!-- Busca por Nome -->
            <div class="mb-6">
                <label for="search_name" class="block text-lg font-medium text-gray-800">Buscar por Nome</label>
                <input type="text" wire:model="searchName" id="search_name" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition ease-in-out duration-150" placeholder="Digite o nome da tarefa">
            </div>

            <!-- Busca por Categoria -->
            <div class="mb-6">
                <label for="search_category" class="block text-lg font-medium text-gray-800">Buscar por Categoria</label>
                <select wire:model="searchCategory" id="search_category" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition ease-in-out duration-150">
                    <option value="">Todas as Categorias</option>
                    @forelse($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @empty
                    <option value="">Nenhuma categoria registrada</option>
                    @endforelse
                </select>
            </div>

            <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-300 transition ease-in-out duration-150">
                Aplicar Filtros
            </button>
        </form>
    </div>

    <!-- Tabela de tarefas -->
    @if($tasks->isEmpty())
    <p class="text-center text-gray-600">Nenhuma tarefa registrada.</p>
    @else
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-300 rounded-lg shadow-lg">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-6 py-3 text-left font-semibold text-gray-700">
                        <button wire:click="sortBy('name')" class="flex items-center font-semibold text-gray-700">
                            Nome
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" fill="currentColor" viewBox="0 0 20 20">
                                @if($sortField === 'name' && $sortDirection === 'asc')
                                <path d="M5 12l5-5 5 5H5z" />
                                @elseif($sortField === 'name' && $sortDirection === 'desc')
                                <path d="M5 8l5 5 5-5H5z" />
                                @endif
                            </svg>
                        </button>
                    </th>
                    <th class="px-6 py-3 text-left font-semibold text-gray-700">Descrição</th>
                    <th class="px-6 py-3 text-left font-semibold text-gray-700">Categoria</th>
                    <th class="px-6 py-3 text-center font-semibold text-gray-700">Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($tasks as $task)
                <tr class="border-t hover:bg-gray-50 transition ease-in-out duration-150">
                    <td class="px-6 py-4 text-gray-900">{{ $task->name }}</td>
                    <td class="px-6 py-4 text-gray-700">{{ $task->description }}</td>
                    <td class="px-6 py-4 text-gray-700">{{ $task->category->name }}</td>
                    <td class="px-6 py-4 text-center">
                        <div class="flex justify-center space-x-2">
                            <button wire:click="editTask({{ $task->id }})" class="bg-yellow-500 text-white px-4 py-2 rounded-lg hover:bg-yellow-600 focus:outline-none focus:ring-4 focus:ring-yellow-300 transition ease-in-out duration-150 flex items-center">
                                Editar
                            </button>
                            <button wire:click="deleteTask({{ $task->id }})" class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 focus:outline-none focus:ring-4 focus:ring-red-300 transition ease-in-out duration-150 flex items-center">
                                Excluir
                            </button>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <!-- Paginação -->
        <div class="mt-6">
            {{ $tasks->links() }} <!-- Exibe os links de paginação -->
        </div>
    </div>
    @endif
</div>