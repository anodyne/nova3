<div>
    @if ($currentStepName === 'posts-wizard-step-setup')
        <livewire:posts-wizard-step-setup
            :post-id="$postId"
            :post-type="$postType"
            :story="$story"
            :all-steps-names="$this->stepNames->toArray()"
        />
    @endif

    @if ($currentStepName === 'posts-wizard-step-compose')
        <livewire:posts-wizard-step-compose
            :post-id="$postId"
            :post-type="$postType"
            :story="$story"
            :all-steps-names="$this->stepNames->toArray()"
        />
    @endif

    @if ($currentStepName === 'posts-wizard-step-publish')
        <livewire:posts-wizard-step-publish
            :post-id="$postId"
            :post-type="$postType"
            :story="$story"
            :all-steps-names="$this->stepNames->toArray()"
        />
    @endif
</div>
