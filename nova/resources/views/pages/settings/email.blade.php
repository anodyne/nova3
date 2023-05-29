@extends($meta->template)

@section('content')
    <x-panel>
        <x-panel.header title="Email settings">
            <x-slot:actions>
                <div x-data="{}">
                    <x-button.outline color="primary" leading="search" @click="$dispatch('toggle-spotlight')">
                        Find a setting
                    </x-button.outline>
                </div>
            </x-slot:actions>
        </x-panel.header>

        {{-- <div class="absolute inset-0 w-full h-full rounded-lg overflow-hidden  transition-all duration-300"> --}}
            <x-content-box class="relative">
                <div class="absolute inset-0 w-full h-full text-center p-16 z-50">
                    <div class="flex items-center justify-center space-x-4">
                        <x-icon name="warning" size="xl" class="text-danger-500"></x-icon>
                        <h1 class="block text-4xl leading-loose font-extrabold text-danger-600 tracking-tight">Warning</h1>
                        <x-icon name="warning" size="xl" class="text-danger-500"></x-icon>
                    </div>

                    <p class="text-lg font-medium text-gray-900 mb-4">
                        This post contains mature content that may not be suitable for all audiences.
                    </p>

                    <p class="text-sm font-medium text-gray-600 mb-8">
                        By continuing, you agree that you are of suitable age for this content.
                    </p>

                    <x-button.outline color="danger">
                        Continue
                    </x-button.outline>
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
                <x-button.filled type="submit" form="email" color="primary">Update</x-button.filled>
            </x-form.footer>
        </x-form> --}}
    </x-panel>
@endsection
