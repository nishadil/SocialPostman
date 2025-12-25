# SocialPostman
SocialPostman is a PHP library to publish posts to social media platforms.
(Facebook, Instagram, LinkedIn, Twitter/X) with background processing and retry support.




## Laravel Application Guide

### Step 1: Install via Composer

```bash
composer require nishadil/socialpostman
```
Laravel will auto-discover the service provider.

### Step 2: Publish Config File
```bash
php artisan vendor:publish --tag=socialpostman-config
```
This creates:
```text
config/socialpostman.php
```

### Step 3: Configure .env
```env
# Facebook
FACEBOOK_ACCESS_TOKEN=
FACEBOOK_PAGE_ID=

# Instagram
INSTAGRAM_ACCESS_TOKEN=
INSTAGRAM_USER_ID=

# LinkedIn
LINKEDIN_ACCESS_TOKEN=
LINKEDIN_AUTHOR_URN=

# Twitter / X
TWITTER_BEARER_TOKEN=
```

### Step 4: Register Providers (One Time)
Recommended place: `App\Providers\AppServiceProvider.php`

```php
use Nishadil\SocialPostman\SocialPostman;
use Nishadil\SocialPostman\Providers\FacebookProvider;
use Nishadil\SocialPostman\Providers\InstagramProvider;
use Nishadil\SocialPostman\Providers\LinkedInProvider;
use Nishadil\SocialPostman\Providers\TwitterProvider;

public function boot(SocialPostman $postman): void
{
    $postman->registerProvider(
        'facebook',
        new FacebookProvider(config('socialpostman.providers.facebook'))
    );

    $postman->registerProvider(
        'instagram',
        new InstagramProvider(config('socialpostman.providers.instagram'))
    );

    $postman->registerProvider(
        'linkedin',
        new LinkedInProvider(config('socialpostman.providers.linkedin'))
    );

    $postman->registerProvider(
        'twitter',
        new TwitterProvider(config('socialpostman.providers.twitter'))
    );
}
```

### Step 5: Post from Controller / Service
**Immediate Post**
```php
use Nishadil\SocialPostman\Laravel\Facades\SocialPostman;

SocialPostman::post('twitter', [
    'message' => 'Hello X 👋 from Laravel'
]);
```

**Background (Laravel Queue – Recommended)**

```php
use Nishadil\SocialPostman\Laravel\Jobs\PublishSocialPost;

PublishSocialPost::dispatch('facebook', [
    'message' => '🚀 Background post from Laravel'
]);
```

Make sure queue worker is running:

```bash
php artisan queue:work
```

### Step 6: Retry Failed Jobs
If any background post fails:
```bash
php artisan socialpostman:retry
```



## Non-Laravel (Plain PHP) Guide

### Step 1: Install via Composer

```bash
composer require nishadil/socialpostman
```

### Step 2: Create Bootstrap File
`bootstrap.php`

```php
<?php

require __DIR__ . '/vendor/autoload.php';

use Nishadil\SocialPostman\SocialPostman;
use Nishadil\SocialPostman\Providers\FacebookProvider;
use Nishadil\SocialPostman\Providers\InstagramProvider;
use Nishadil\SocialPostman\Providers\LinkedInProvider;
use Nishadil\SocialPostman\Providers\TwitterProvider;

$postman = new SocialPostman();

$postman->registerProvider('facebook', new FacebookProvider([
    'access_token' => 'FACEBOOK_ACCESS_TOKEN',
    'page_id' => 'FACEBOOK_PAGE_ID'
]));

$postman->registerProvider('instagram', new InstagramProvider([
    'access_token' => 'INSTAGRAM_ACCESS_TOKEN',
    'instagram_user_id' => 'INSTAGRAM_USER_ID'
]));

$postman->registerProvider('linkedin', new LinkedInProvider([
    'access_token' => 'LINKEDIN_ACCESS_TOKEN',
    'author' => 'urn:li:person:XXXX'
]));

$postman->registerProvider('twitter', new TwitterProvider([
    'bearer_token' => 'TWITTER_BEARER_TOKEN'
]));

return $postman;
```

### Step 3: Post Content

**Immediate Post**
```php
$postman = require 'bootstrap.php';

$postman->post('twitter', [
    'message' => 'Hello X 👋 from plain PHP'
]);
```

**Background Post (CLI Required)**
```php
$postman->post('facebook', [
    'message' => 'Background Facebook post'
], true);
```

**Requirements**
PHP CLI enabled
`exec()` allowed
Linux / macOS recommended

### Step 4: Run Retry Worker (Plain PHP)
Create a file: `retry.php`
```php
<?php

require __DIR__ . '/vendor/autoload.php';

use Nishadil\SocialPostman\Queue\RetryWorker;

(new RetryWorker())->run();
```

Run manually or via cron:
```bash
php retry.php
```

### Step 5: Setup Cron (Recommended)
```bash
* * * * * php /path/to/project/retry.php
```