<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Clientes') }}
        </h2>
    </x-slot>
    <div id="app">
        <x-container class=" py-8">
            {{-- Crear Clientes --}}
            <x-form-section class=" mb-12">

                <x-slot name="title">
                    Crea un nuevo Cliente
                </x-slot>

                <x-slot name="description">
                    Ingrese los datos solicitados para crear un nuevo cliente
                </x-slot>

                <div class=" space-y-4">

                    <div v-if="createForm.errors.length > 0"
                        class=" px-4 py-4 rounded bg-red-200 text-red-700 border border-red-700 mb-4">
                        <strong class=" font-bold">Whops! </strong>
                        <span>Algo salio mal!</span>

                        <ul>
                            <li v-for="error in createForm.errors">
                                @{{ error }}
                            </li>
                        </ul>
                    </div>

                    <x-input-label :value="__('Nombre')" />
                    <x-text-input class="block mt-1 w-full" type="text" v-model="createForm.name" :value="old('name')"
                        required autofocus />

                    <x-input-label :value="__('Url de redireccion')" />
                    <x-text-input class="block mt-1 w-full" type="text" v-model="createForm.redirect" :value="old('url')"
                        required autofocus />
                </div>

                <x-slot name="actions">
                    <x-primary-button v-on:click="store" v-bind:disabled="createForm.disabled">
                        {{ __('Crear') }}
                    </x-primary-button>
                </x-slot>

            </x-form-section>

            {{-- Lista de Clientes --}}
            <x-form-section v-if="clients.length > 0">

                <x-slot name="title">
                    Lista de Clientes
                </x-slot>

                <x-slot name="description">
                    Lista de clientes registrados en la aplicación
                </x-slot>

                <div>
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-full">
                                    Nombre
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Acciones
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr v-for="client in clients">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">
                                        @{{ client.name }}
                                    </div>
                                </td>
                                <td class="flex divide-x divide-gray-200 px-6 py-4 whitespace-nowrap">
                                    <a v-on:click="show(client)" href="#" class=" px-2 text-indigo-600 hover:text-green-900">
                                        Ver
                                    </a>
                                    <a v-on:click="edit(client)" href="#" class=" px-2 text-indigo-600 hover:text-indigo-900">
                                        Editar
                                    </a>
                                    <a href="#" class="pl-2 text-indigo-600 hover:text-red-600"
                                        v-on:click="destroy(client)">
                                        Eliminar
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>



            </x-form-section>
        </x-container>
        
        {{-- Modal de Edit --}}
        <x-dialog-modal modal="editForm.open">
            <x-slot name="title">
                Editar Cliente
            </x-slot>
    
            <x-slot name="content">
                <div class=" space-y-4">
                    <div v-if="editForm.errors.length > 0"
                        class=" px-4 py-4 rounded bg-red-200 text-red-700 border border-red-700 mb-4">
                        <strong class=" font-bold">Whops! </strong>
                        <span>Algo salio mal!</span>
    
                        <ul>
                            <li v-for="error in editForm.errors">
                                @{{ error }}
                            </li>
                        </ul>
                    </div>
    
                    <x-input-label :value="__('Nombre')" />
                    <x-text-input class="block mt-1 w-full" type="text" v-model="editForm.name" :value="old('name')"
                        required autofocus />
    
                    <x-input-label :value="__('Url de redireccion')" />
                    <x-text-input class="block mt-1 w-full" type="text" v-model="editForm.redirect" :value="old('url')"
                        required autofocus />
                </div>
            </x-slot>

            <x-slot name="footer">
                <button v-on:click="update()" type="button" class="inline-flex w-full justify-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 sm:ml-3 sm:w-auto">
                    Actualizar
                </button>
                <button v-on:click="editForm.open = false" type="button" class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto">
                    Cancelar
                </button>
            </x-slot>
    
        </x-dialog-modal>

        {{-- Modal de Show --}}
        <x-dialog-modal modal="showClient.open">
            <x-slot name="title">
                Mostrar Credenciales
            </x-slot>
    
            <x-slot name="content">
                <div class=" space-y-4">
                    <div class=" px-4 py-4 rounded bg-green-200 text-green-700 border border-green-700 mb-4" >
                        <div class="mt-2">
                            <p>
                                <span class=" font-semibold">
                                    CLIENTE:
                                </span>
                                <span>
                                    @{{ showClient.name }}
                                </span>
                            </p>
                            <p>
                                <span class=" font-semibold">
                                    CLIENT ID:
                                </span>
                                <span>
                                    @{{ showClient.id }}
                                </span>
                            </p>
                            <p>
                                <span class=" font-semibold">
                                    SECRET ID:
                                </span>
                                <span>
                                    @{{ showClient.secret }}
                                </span>
                            </p>
                        </div>
                    </div>
                </div>
            </x-slot>

            <x-slot name="footer">
                <button v-on:click="showClient.open = false" type="button" class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto">
                    Cancelar
                </button>
            </x-slot>
    
        </x-dialog-modal>

    </div>

    @push('js')
        <script>
            const {
                createApp
            } = Vue
            createApp({
                data() {
                    return {
                        clients: [],
                        showClient: {
                            open: false,
                            id: null,
                            secret: null,
                            name: null
                        },
                        createForm: {
                            disabled: false,
                            errors: [],
                            name: null,
                            redirect: null
                        },
                        editForm: {
                            open: false,
                            disabled: false,
                            id: null,
                            errors: [],
                            name: null,
                            redirect: null
                        }
                    }
                },
                mounted() {
                    this.getClients()
                },
                methods: {
                    getClients() {
                        axios.get('/oauth/clients')
                            .then(response => {
                                this.clients = response.data
                            })
                            .catch(error => {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'Ha ocurrido un error al obtener los clientes'
                                })
                            })
                    },
                    show(client){
                        this.showClient.open = true
                        this.showClient.id = client.id
                        this.showClient.secret = client.secret
                        this.showClient.name = client.name
                    },
                    store() {
                        this.createForm.disabled = true
                        axios.post('/oauth/clients', this.createForm)
                            .then(response => {
                                this.createForm = {
                                    name: null,
                                    redirect: null,
                                    errors: []
                                }
                                this.getClients()
                                this.createForm.disabled = false
                                this.show(response.data)
                                /* Swal.fire({
                                    icon: 'success',
                                    title: 'Cliente creado',
                                    text: 'El cliente ha sido creado exitosamente'
                                }) */
                            })

                            .catch(error => {
                                this.createForm.disabled = false

                                this.createForm.errors = Object.values(error.response.data.errors).flat()
                            })
                    },
                    destroy(client) {
                        Swal.fire({
                            title: '¿Estas seguro?',
                            text: "¡No podrás revertir esto!",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Si, eliminar!',
                            cancelButtonText: 'Cancelar'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                axios.delete('/oauth/clients/' + client.id)
                                    .then(response => {
                                        this.getClients()
                                    })
                                Swal.fire(
                                    'Eliminado!',
                                    'El cliente ha sido eliminado.',
                                    'success'
                                )
                            }
                        })
                    },
                    edit(client){
                        this.editForm.open = true
                        this.editForm.name = client.name
                        this.editForm.redirect = client.redirect
                        this.editForm.id = client.id
                        this.editForm.errors = []
                    },
                    update(){
                        this.editForm.disabled = true
                        axios.put('/oauth/clients/' + this.editForm.id, this.editForm)
                            .then(response => {
                                this.editForm = {
                                    open: false,
                                    disabled: false,
                                    id: null,
                                    errors: [],
                                    name: null,
                                    redirect: null
                                }
                                this.getClients()
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Cliente actualizado',
                                    text: 'El cliente ha sido actualizado exitosamente'
                                })
                            })
                            .catch(error => {
                                this.editForm.disabled = false

                                this.editForm.errors = Object.values(error.response.data.errors).flat()
                            })
                    }
                    
                }
            }).mount('#app');
        </script>
    @endpush
</x-app-layout>
