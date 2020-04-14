<?php

namespace App\Eloquents;

use Illuminate\Database\Eloquent\Model;
use Altek\Accountant\Contracts\Recordable;

class AbstractModel extends Model implements Recordable
{
    use \Altek\Accountant\Recordable;
    use \Altek\Eventually\Eventually;
}
