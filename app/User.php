<?php

namespace App;

use App\Mail\Register;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;

/**
 * App\User
 *
 * @property int $id
 * @property string $email
 * @property string $uuid
 * @property string $uuid_2
 * @property bool $verified
 * @property bool $verified_2
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|User newModelQuery()
 * @method static Builder|User newQuery()
 * @method static Builder|User query()
 * @method static Builder|User whereCreatedAt($value)
 * @method static Builder|User whereEmail($value)
 * @method static Builder|User whereId($value)
 * @method static Builder|User whereUpdatedAt($value)
 * @method static Builder|User whereUuid($value)
 * @method static Builder|User whereVerified($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereUuid2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereVerified2($value)
 * @mixin \Eloquent
 */
class User extends Model
{

    protected $fillable = [
        'email',
        'uuid',
    ];

    public function sendRegisterMail(string $email, string $name, bool $first) {
        Mail::to($email)->send(new Register($first ? $this->uuid: $this->uuid_2, $name));
    }

}
