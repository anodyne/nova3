@props([
    'field',
    'name',
    'suggestion',
    'value'
])

@if ($field->enabled)
    <div class="flex flex-col space-y-1 w-full">
        <div
            x-data="{
                content: 'Lorem ipsum dolor sit amet'
            }"
            class="group flex items-center w-full space-x-2"
            wire:ignore
        >
            <div class="group flex flex-col items-start relative w-full rounded-md py-2 px-3 border border-gray-200 shadow-sm bg-white transition ease-in-out duration-200 focus-within:border-blue-300 focus-within:shadow-outline-blue space-y-6">
                <alpine-editor x-model="content" data-h1-classes="text-xl" class="w-full">
                    <div class="flex items-center space-x-2" data-type="menu">
                        <button
                            type="button"
                            data-command="strong"
                            data-active-class="text-blue-500"
                            class="text-gray-400 hover:text-gray-600 transition ease-in-out duration-150"
                        >
                            <svg viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"><path d="M5.5 4.25C5.5 3.56 6.06 3 6.75 3h3.501c2.403 0 3.999 1.988 3.999 4 0 .872-.3 1.738-.834 2.44.904.703 1.581 1.802 1.581 3.31 0 2.863-2.437 4.245-4.244 4.245H6.75c-.69 0-1.25-.56-1.25-1.25V4.25zM8 11v3.495h2.753c.811 0 1.744-.618 1.744-1.745 0-1.129-.937-1.75-1.744-1.75H8zm0-2.5h2.248A1.5 1.5 0 0011.75 7c0-.78-.62-1.5-1.499-1.5H8v3z" fill="currentColor" fill-rule="nonzero" /></svg>
                        </button>
                        <button
                            type="button"
                            data-command="em"
                            data-active-class="text-blue-500"
                            class="text-gray-400 hover:text-gray-600 transition ease-in-out duration-150"
                        >
                            <svg viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"><path d="M16 3a.5.5 0 010 1h-3.157L8.227 16H11.5a.5.5 0 010 1H4a.5.5 0 010-1h3.156l4.615-12H8.5a.5.5 0 010-1H16z" fill="currentColor" fill-rule="nonzero" /></svg>
                        </button>
                        <button
                            type="button"
                            data-command="code"
                            data-active-class="bg-blue-400"
                            class="bg-gray-500"
                        >
                            Code
                        </button>
                        <button
                            type="button"
                            data-command="heading"
                            data-level="1"
                            data-active-class="bg-blue-400"
                            class="bg-gray-500"
                        >
                            H1
                        </button>
                    </div>

                    <div data-type="editor" class="pt-4 whitespace-pre-wrap focus:outline-none"></div>
                </alpine-editor>
            </div>
        </div>

        @if ($field->suggest && $suggestion && ! $value)
            <div class="text-xs">
                <span class="font-medium text-gray-600">Suggested:</span>
                <x-button
                    wire:click="$set('{{ $name }}', '{{ $suggestion->{$name} }}')"
                    color="blue-text"
                    size="none-xs"
                >{{ $suggestion->{$name} }}</x-button>
            </div>
        @endif
    </div>
@endif