<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class IdeaReply extends Model
{
    protected $fillable = ['content', 'idea_id', 'user_id', 'parent_reply_id', 'quoted_reply_id', 'status'];


    public function scopeActive(Builder $query): void
    {
        $query->where('status', 1);
    }

    public function idea()
    {
        return $this->belongsTo(Idea::class, 'idea_id');
    }

    // Ana yoruma bağlı alt yorumlar (Bir yoruma birden fazla cevap gelebilir)
    public function answers()
    {
        return $this->hasMany(IdeaReply::class, 'parent_reply_id');
    }

    // Alıntılanan yorum (Bir cevap, başka bir yorumu alıntılayabilir)
    public function quotedReply()
    {
        return $this->hasOne(IdeaReply::class, 'id', 'quoted_reply_id');
    }

    public function likes()
    {
        return $this->hasMany(IdeaReplyLike::class, 'reply_id');
    }

    public function like($id)
    {
        return auth()->check() ? IdeaReplyLike::where('reply_id', $id)->where('user_id', auth()->user()->id)->first() : null;
    }
}
