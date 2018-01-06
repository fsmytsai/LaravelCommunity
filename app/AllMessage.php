<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\AllMessage
 *
 * @property int $all_mess_id
 * @property string $account
 * @property string $content
 * @property \Carbon\Carbon $created_at
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AllMessage whereAccount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AllMessage whereAllMessId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AllMessage whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AllMessage whereCreatedAt($value)
 * @mixin \Eloquent
 */
class AllMessage extends Model
{
    protected $table = 'all_messages';
    protected $primaryKey = 'all_mess_id';
    const UPDATED_AT = null;

    protected $fillable = [
        'account', 'content'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'account');
    }
}
