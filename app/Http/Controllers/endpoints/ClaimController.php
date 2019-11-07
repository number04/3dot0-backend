<?php

namespace App\Http\Controllers\endpoints;

use App\Http\Controllers\Controller;
use App\Models\Claim;
use App\Http\Resources\ClaimResource;

class ClaimController extends Controller
{
    public function claim()
    {
        return ClaimResource::collection(Claim::get());
    }
}
