# SocialPostman
A PHP library to share posts (text, image, video) to multiple social platforms, asynchronously or via background workers.

## Laravel Usage Example

`App\Http\Controllers\PostController.php`
```php
use Nishadil\SocialPostman\Laravel\Facades\SocialPostman;
use Nishadil\SocialPostman\Providers\TwitterProvider;
use Nishadil\SocialPostman\Providers\FacebookProvider;
use Nishadil\SocialPostman\Laravel\Jobs\PublishSocialPost;

// Register providers (AppServiceProvider recommended)
SocialPostman::registerProvider(
    'twitter',
    new TwitterProvider(config('socialpostman.providers.twitter'))
);

SocialPostman::registerProvider(
    'facebook',
    new FacebookProvider(config('socialpostman.providers.facebook'))
);

// Dispatch job
PublishSocialPost::dispatch('twitter', [
    'message' => 'Posted from Laravel using SocialPostman'
]);

```

.env example

```text
FACEBOOK_ACCESS_TOKEN=
FACEBOOK_PAGE_ID=

INSTAGRAM_ACCESS_TOKEN=
INSTAGRAM_USER_ID=

LINKEDIN_ACCESS_TOKEN=
LINKEDIN_AUTHOR_URN=

TWITTER_BEARER_TOKEN=

```