@extends($meta->template)

@section('content')
    <x-panel>
        <x-panel.header title="Email settings">
            <x-slot:controls>
                <div x-data="{}">
                    <x-button color="primary-outline" @click="$dispatch('toggle-spotlight')" leading="search">
                        Find a setting
                    </x-button>
                </div>
            </x-slot:controls>
        </x-panel.header>

        {{-- <div class="absolute inset-0 w-full h-full rounded-lg overflow-hidden  transition-all duration-300"> --}}
            <x-content-box class="relative">
                <div class="absolute inset-0 w-full h-full text-center p-16 z-50">
                    <div class="flex items-center justify-center space-x-4">
                        @icon('warning', 'h-8 w-8 text-danger-500')
                        <h1 class="block text-4xl leading-loose font-extrabold text-danger-600 tracking-tight">Warning</h1>
                        @icon('warning', 'h-8 w-8 text-danger-500')
                    </div>

                    <p class="text-lg font-medium text-gray-900 mb-4">
                        This post contains mature content that may not be suitable for all audiences.
                    </p>

                    <p class="text-sm font-medium text-gray-600 mb-8">
                        By continuing, you agree that you are of suitable age for this content.
                    </p>

                    <x-button color="error-outline">
                        Continue
                    </x-button>
                </div>

                <div class="prose max-w-none filter blur opacity-75">
                    <h1>My Title</h1>

                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Alias fugiat sapiente nobis autem ducimus necessitatibus, fuga dolorem. Esse veniam nisi nesciunt rerum dolores porro aperiam repellendus, quia similique deserunt! Tempore? Lorem ipsum dolor sit, amet consectetur adipisicing elit. Doloribus, quasi illo. Reiciendis quaerat necessitatibus dolor autem, consectetur tempore blanditiis quod exercitationem deleniti aperiam dicta? Reprehenderit omnis culpa officia totam dolorem? Lorem ipsum dolor, sit amet consectetur adipisicing elit. Eligendi, enim expedita qui illo, nesciunt consequuntur est saepe nobis rerum dolorum, neque ab mollitia earum aut perferendis quo unde dolores dolorem!</p>

                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Alias fugiat sapiente nobis autem ducimus necessitatibus, fuga dolorem. Esse veniam nisi nesciunt rerum dolores porro aperiam repellendus, quia similique deserunt! Tempore? Lorem ipsum dolor sit, amet consectetur adipisicing elit. Doloribus, quasi illo. Reiciendis quaerat necessitatibus dolor autem, consectetur tempore blanditiis quod exercitationem deleniti aperiam dicta? Reprehenderit omnis culpa officia totam dolorem? Lorem ipsum dolor, sit amet consectetur adipisicing elit. Eligendi, enim expedita qui illo, nesciunt consequuntur est saepe nobis rerum dolorum, neque ab mollitia earum aut perferendis quo unde dolores dolorem!</p>

                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Alias fugiat sapiente nobis autem ducimus necessitatibus, fuga dolorem. Esse veniam nisi nesciunt rerum dolores porro aperiam repellendus, quia similique deserunt! Tempore? Lorem ipsum dolor sit, amet consectetur adipisicing elit. Doloribus, quasi illo. Reiciendis quaerat necessitatibus dolor autem, consectetur tempore blanditiis quod exercitationem deleniti aperiam dicta? Reprehenderit omnis culpa officia totam dolorem? Lorem ipsum dolor, sit amet consectetur adipisicing elit. Eligendi, enim expedita qui illo, nesciunt consequuntur est saepe nobis rerum dolorum, neque ab mollitia earum aut perferendis quo unde dolores dolorem!</p>
                </div>
            </x-content-box>
        {{-- </div> --}}
        {{-- <x-form :action="route('settings.update')" method="PUT" id="email">
            <x-form.footer>
                <x-button type="submit" form="email" color="primary">Update</x-button>
            </x-form.footer>
        </x-form> --}}
    </x-panel>
@endsection
