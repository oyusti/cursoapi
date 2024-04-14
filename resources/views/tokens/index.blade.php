<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Api Tokens') }}
        </h2>
    </x-slot>

    <div id="app">
        <x-container class=" py-8">
            
            {{-- Crear Tokens --}}
            <x-form-section class=" mb-12">

                <x-slot name="title">
                    Access Tokens
                </x-slot>

                <x-slot name="description">
                    Aqui se mostraran los Access Tokens que se han creado.
                </x-slot>

                <div class=" space-y-4">

                    <div v-if="form.errors.length > 0">
                        class=" px-4 py-4 rounded bg-red-200 text-red-700 border border-red-700 mb-4">
                        <strong class=" font-bold">Whops! </strong>
                        <span>Algo salio mal!</span>

                        <ul>
                            <li v-for="error in form.errors">
                                @{{ error }}
                            </li>
                        </ul>
                    </div>

                    <x-input-label :value="__('Nombre')" />
                    <x-text-input class="block mt-1 w-full" type="text" v-model="form.name"/>

                    <div v-if="scopes.length > 0">

                        <x-input-label :value="__('Scopes')" />

                        <div v-for="scope in scopes">
                            <label>
                                <input type="checkbox" name="scopes" :value="scope.id" v-model="form.scopes">
                                @{{ scope.id }}
                            </label>
                        </div>
                        
                    </div>

                </div>

                <x-slot name="actions">
                    <x-primary-button v-on:click="store" v-bind:disabled="form.disabled">
                        {{ __('Crear') }}
                    </x-primary-button>
                </x-slot>

            </x-form-section>

            {{-- Mostrar Tokens --}}
            {{-- v-if="tokens.length > 0" --}}
            <x-form-section v-if="tokens.length > 0" >

                <x-slot name="title">
                    Lista de Tokens
                </x-slot>

                <x-slot name="description">
                    Lista de Tokens registrados en la aplicación
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
                            <tr v-for="token in tokens">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">
                                        @{{ token.name }}
                                    </div>
                                </td>
                                <td class="flex divide-x divide-gray-200 px-6 py-4 whitespace-nowrap">
                                    <a v-on:click="show(token)" href="#" class=" px-2 text-indigo-600 hover:text-green-900">
                                        Ver
                                    </a>
                                    <a v-on:click="revoke(token)" href="#" class="pl-2 text-indigo-600 hover:text-red-600">
                                        Eliminar
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </x-form-section>

        </x-container>

        {{-- Modal de Show --}}
        <x-dialog-modal modal="showToken.open">
            <x-slot name="title">
                Mostrar Tokens
            </x-slot>
    
            <x-slot name="content">
                <div class=" space-y-4">
                    <div class=" px-4 py-4 rounded mb-4 overflow-auto" >
                        <div class="mt-2">
                            <p>
                                <span class=" font-semibold">
                                    NOMBRE:
                                </span>
                                <span>
                                    @{{ showToken.name }}
                                </span>
                            </p>
                            <p>
                                <span class=" font-semibold">
                                    CLIENT ID:
                                </span>
                                <span>
                                    @{{ showToken.id }}
                                </span>
                            </p>
                        </div>
                    </div>
                </div>
            </x-slot>

            <x-slot name="footer">
                <button v-on:click="showToken.open = false" type="button" class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto">
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
                        tokens: [],
                        scopes: [],
                        form: {
                            name: null,
                            errors: [],
                            tokens: [],
                            scopes: [],
                            disabled: false
                        },
                        showToken: {
                            open: false,
                            id: '',
                        }
                    }
                },
                mounted() {
                    this.getTokens()
                    this.getScopes()
                },
                methods: {
                    getTokens(){
                        axios.get('/oauth/personal-access-tokens')
                            .then(response => {
                                this.tokens = response.data;
                            })
                    },
                    getScopes() {
                        axios.get('/oauth/scopes')
                            .then(response => {
                                this.scopes = response.data;
                            })
                    },
                    store() {
                        this.form.disabled = true;

                        axios.post('/oauth/personal-access-tokens', this.form)
                            .then(response => {
                                this.form.name = '';
                                this.form.errors = [];
                                this.form.scopes = [];
                                this.form.disabled = false;
                                this.getTokens()
                            })
                            .catch(error => {
                                this.form.errors = Object.values(error.response.data.errors).flat();
                                this.form.disabled = false;
                            });
                    },
                    revoke(token) {
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
                                axios.delete('/oauth/personal-access-tokens/' + token.id)
                                    .then(response => {
                                        this.getTokens()
                                    })
                                Swal.fire(
                                    'Eliminado!',
                                    'El cliente ha sido eliminado.',
                                    'success'
                                )
                            }
                        })
                    },
                    show(token) {
                        this.showToken.open = true;
                        this.showToken.id = token.id;
                        this.showToken.name = token.name;
                    }
                        
                }
            }).mount('#app');

        </script>

    @endpush

</x-app-layout>