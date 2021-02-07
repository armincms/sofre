<?php

namespace Armincms\Sofre\Models\Markables;   

use Zareismail\Markable\{Markable, HasPending};
use Armincms\Orderable\Models\{HasCompletion, HasOnHold};

trait OrderSituation 
{ 
    use Markable, HasPending, HasCompletion, HasOnHold,  HasPreparing, HasShipping;
}
