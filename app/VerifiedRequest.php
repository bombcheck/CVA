<?php

namespace App;

use App\Tenant\ForTenant;
use Illuminate\Database\Eloquent\Model;

class VerifiedRequest extends Model
{
    use ForTenant;

    protected $table = 'verified_requests';

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function campaign()
    {
        return $this->belongsTo(Campaign::class, 'campaign_id');
    }
}
