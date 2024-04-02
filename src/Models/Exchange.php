<?php

namespace Coinhoppa\Models;

use Cache;
use Carbon\Carbon;
use Vinkla\Hashids\Facades\Hashids;
use Illuminate\Database\Eloquent\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Collection;

class Exchange extends Model
{
    use HasFactory;

    /**
     * @var table name
     */
    protected $table = 'exchange';

    /**
     * @var mass fillable attributes
     */
    protected $fillable = [
        'name',
        'module',
        'display_name',
        'meta_keywords',
        'meta_description',
        'desc',
        'short_desc',
        'score',
        'coins',
        'site_url',
        'blog_url',
        'twitter_url',
        'facebook_url',
        'linkedin_url',
        'instagram_url',
        'tiktok_url',
        'youtube_url',
        'country_id',
        'active',
        'deleted',
        'banned',
        'banned_until',
        'year_established',
        'updated_by'
    ];
}