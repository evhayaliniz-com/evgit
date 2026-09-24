<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Idea extends Model
{
    protected $fillable = ['content', 'category_id', 'sub_category_id', 'path', 'user_id', 'status', 'is_confirmed', 'title', 'slug', 'cover_photo'];

    public function scopeActive(Builder $query): void
    {
        $query->where('status', 1);
    }

    public function scopeConfirmed(Builder $query): void
    {
        $query->where('is_confirmed', 1);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function category()
    {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }

    public function subCategory()
    {
        return $this->hasOne(Category::class, 'id', 'sub_category_id');
    }

    public function replies()
    {
        return $this->hasMany(IdeaReply::class, 'idea_id');
    }

    public function views()
    {
        return $this->hasMany(View::class, 'to_id')->where('type', 'idea');
    }

    public function likes()
    {
        return $this->hasMany(IdeaLike::class, 'idea_id');
    }

    public function ideaViewCount($id)
    {
        return \App\Models\View::where('to_id', $id)->where('type', 'idea')->count();
    }

    public function ideaReplyLikeCount($id)
    {
        $replies = IdeaReply::active()->where('idea_id', $id)->get();
        return IdeaReplyLike::whereIn('reply_id', $replies->pluck('id')->toArray())->count();
    }

    public function ideaLikeCount($id)
    {
        return IdeaLike::where('idea_id', $id)->count();
    }

    public function ideaLikeExists($id)
    {
        return auth()->check() ? IdeaLike::where('user_id', auth()->user()->id)->where('idea_id', $id)->first() : 0;
    }
}
