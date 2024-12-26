@use('Nova\Discussions\Enums\MessageType')
@use('Nova\Foundation\Helpers\DateHelper')

<div class="space-y-8 lg:col-span-2">
    @if (filled($discussionId))
        <div class="flex items-start space-x-4">
            <div class="min-w-0 flex-1">
                <form
                    class="relative"
                    x-data="{
                        shift: false,
                    }"
                    x-on:keydown.shift="shift = true"
                    x-on:keyup.shift="shift = false"
                    x-on:keydown.enter="
                        if (! shift && ! $event.target.value) {
                            $event.preventDefault()
                        }

                        if (! shift && $event.target.value) {
                            $event.preventDefault()
                            $wire.sendMessage()
                        }
                    "
                >
                    <x-fieldset.field name="content" id="contentMobile">
                        <x-input.textarea
                            rows="3"
                            class="max-h-40 min-h-20 [field-sizing:content]"
                            placeholder="Message {{ $discussion->is_direct_message ? $participant?->name : $discussion->name ?? 'group' }}"
                            wire:model.live="content"
                        ></x-input.textarea>

                        <div class="text-base/6 text-gray-500 sm:text-sm/6 dark:text-gray-400" data-slot="help">
                            Enter to send a message, Shift + Enter for a new line
                        </div>
                    </x-fieldset.field>
                </form>
            </div>
        </div>

        <x-panel class="overflow-hidden">
            <x-spacing size="md">
                <div class="prose max-w-none space-y-6 dark:prose-invert">
                    {!! str($this->latestMessage->content)->markdown() !!}
                </div>
            </x-spacing>

            <x-spacing
                height="sm"
                width="md"
                class="flex items-center justify-between border-t border-primary-200 bg-primary-50 text-sm/6 text-primary-600"
            >
                <div class="flex items-center gap-x-2">
                    <x-avatar :src="$this->latestMessage->user->avatar_url" size="xs"></x-avatar>
                    <span class="font-semibold">
                        {{ $this->latestMessage->user->name }}
                    </span>
                </div>

                <div class="item-center flex shrink-0 text-xs/5">
                    {{ DateHelper::formatShortDateWithTime($this->latestMessage->created_at) }}
                </div>
            </x-spacing>
        </x-panel>

        <div class="relative">
            <div class="absolute inset-0 flex items-center" aria-hidden="true">
                <div class="w-full border-t border-gray-950/10 dark:border-white/10"></div>
            </div>
            <div class="relative flex justify-center">
                <button
                    type="button"
                    class="relative inline-flex items-center gap-x-1.5 rounded-full bg-white px-2 py-1.5 text-sm font-medium text-gray-900 shadow-sm ring-1 ring-inset ring-gray-950/10 hover:bg-gray-50 dark:ring-white/10"
                    wire:click="$toggle('remainingMessagesLoaded')"
                >
                    <div
                        class="flex size-5 shrink-0 flex-col items-center justify-center rounded-full bg-gray-900 text-xs/5 tabular-nums text-white"
                    >
                        <div>
                            {{ $this->remainingMessages->count() }}
                        </div>
                    </div>
                    <div class="flex items-center gap-x-1">
                        <span>Older messages</span>

                        @if ($remainingMessagesLoaded)
                            <x-icon.chevron-down class="size-4 text-gray-500 dark:text-gray-600"></x-icon.chevron-down>
                        @else
                            <x-icon.chevron-right
                                class="size-4 text-gray-500 dark:text-gray-600"
                            ></x-icon.chevron-right>
                        @endif
                    </div>
                </button>
            </div>
        </div>

        @if ($remainingMessagesLoaded)
            <div class="space-y-8">
                @foreach ($this->remainingMessages as $message)
                    <x-panel class="overflow-hidden">
                        <x-spacing size="md">
                            <div class="prose max-w-none space-y-6 dark:prose-invert">
                                {!! str($message->content)->markdown() !!}
                            </div>
                        </x-spacing>

                        <x-spacing
                            height="sm"
                            width="md"
                            @class([
                                'flex items-center justify-between border-t text-sm/6',
                                'border-primary-200 bg-primary-50 text-primary-600' => $message->user?->is(auth()->user()),
                                'border-gray-200 bg-gray-50 text-gray-600' => ! $message->user?->is(auth()->user()),
                            ])
                        >
                            <div class="flex items-center gap-x-2">
                                <x-avatar :src="$message->user->avatar_url" size="xs"></x-avatar>
                                <span class="font-semibold">
                                    {{ $message->user->name }}
                                </span>
                            </div>

                            <div class="item-center flex shrink-0 text-xs/5">
                                {{ DateHelper::formatShortDateWithTime($message->created_at) }}
                            </div>
                        </x-spacing>
                    </x-panel>
                @endforeach
            </div>
        @endif
    @endif
</div>
