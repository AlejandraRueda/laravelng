<div class="p-6">
    {{-- Header con título y botón de agregar --}}
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-semibold">Listado de Tiendas</h2>
        <button wire:click="$dispatch('showCreateModal')" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded flex items-center">
            <i class="fas fa-plus mr-2"></i> Agregar
        </button>
    </div>

    {{-- Mensaje de éxito --}}
    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
            {{ session('message') }}
        </div>
    @endif

    {{-- Tabla de tiendas --}}
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ubicación</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @if(count($stores) > 0)
                    @foreach($stores as $store)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">{{ $store->id }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $store->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $store->location }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $store->status === 'Activo' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $store->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <button wire:click="$dispatch('editStore', { id: {{ $store->id }} })" 
                                        class="text-blue-600 hover:text-blue-900 mr-3">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button wire:click="confirmToggleStatus({{ $store->id }})"
                                        class="text-gray-600 hover:text-gray-900">
                                    <i class="fas fa-power-off"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                            No hay tiendas registradas
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>

    {{-- Modal de confirmación para cambiar estado --}}
    @if($showDeleteModal)
        <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full flex items-center justify-center">
            <div class="relative bg-white rounded-lg shadow-xl max-w-md mx-auto p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">
                    ¿Desea cambiar el estado de la tienda?
                </h3>
                <div class="mt-5 sm:mt-6 flex justify-end space-x-3">
                    <button wire:click="toggleStatus"
                            class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                        Aceptar
                    </button>
                    <button wire:click="$set('showDeleteModal', false)"
                            class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded">
                        Cancelar
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>