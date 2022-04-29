<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class MatchStatusEnum extends Enum
{
    const UPCOMING = 'upcoming';
    const FINISHED =   'finished';
    const LIVE = 'live';
}
