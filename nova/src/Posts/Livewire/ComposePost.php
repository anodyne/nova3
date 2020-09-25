<?php

namespace Nova\Posts\Livewire;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Nova\Foundation\Toast;
use Nova\Posts\Actions\SavePostManager;
use Nova\Posts\DataTransferObjects\PostData;
use Nova\Posts\DataTransferObjects\PostPositionData;
use Nova\Posts\DataTransferObjects\PostStatusData;
use Nova\Posts\Models\Post;

class ComposePost extends Component
{
    use AuthorizesRequests;
    use Concerns\HandlesPostSuggestion;
    use Concerns\HasPostType;
    use Concerns\HasStories;
    use Concerns\SetsPostPosition;
    use Concerns\WritesPost;

    public $saving = false;

    protected $listeners = ['postTypeSelected' => 'setPostType'];

    public function publish(SavePostManager $action)
    {
        $post = $this->post ?? new Post;

        $this->authorize('write', [$post, $this->postType]);

        $post = $action->execute(
            $this->getPostData(),
            $this->getPostStatusData('published'),
            $this->getPostPositionData()
        );

        app(Toast::class)->withTitle("{$post->title} was published")->success();

        return redirect()->route('stories.show', $this->story);
    }

    public function save(SavePostManager $action)
    {
        if ($this->postType && $this->title) {
            $post = $this->post ?? new Post;

            $this->authorize('write', [$post, $this->postType]);

            $this->saving = true;

            $this->post = $action->execute(
                $this->getPostData(),
                $this->getPostStatusData('draft'),
                $this->getPostPositionData()
            );

            $this->postId = $this->post->id;

            $this->saving = false;
        }
    }

    public function mount()
    {
        $this->setInitialStory();

        $this->setPostTypeIfOnlyOneIsAvailable();

        $this->getSuggestedPost();
    }

    public function render()
    {
        return view('livewire.posts.compose');
    }

    protected function getPostData(): PostData
    {
        return PostData::fromArray([
            'title' => $this->title,
            'content' => $this->content,
            'day' => $this->day,
            'time' => $this->time,
            'location' => $this->location,
            'id' => $this->postId,
            'postTypeId' => $this->postType->id,
            'storyId' => $this->story->id,
        ]);
    }

    protected function getPostStatusData(string $status): PostStatusData
    {
        return new PostStatusData([
            'status' => $status,
        ]);
    }

    protected function getPostPositionData(): PostPositionData
    {
        return PostPositionData::fromArray([
            'hasPositionChange' => false,
            'displayDirection' => $this->direction,
            'displayNeighbor' => $this->neighbor,
        ]);
    }
}
