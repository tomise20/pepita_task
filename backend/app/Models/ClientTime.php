<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ClientTime
 *
 * @property int $id
 * @property string $day
 * @property string $start_time
 * @property string $end_time
 * @method static \Illuminate\Database\Eloquent\Builder|ClientTime newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ClientTime newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ClientTime query()
 * @method static \Illuminate\Database\Eloquent\Builder|ClientTime whereDay($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClientTime whereEndTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClientTime whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClientTime whereStartTime($value)
 * @mixin \Eloquent
 */
class ClientTime extends Model
{
    use HasFactory;

    protected $tabel = 'client_times';

    public $timestamps = false;
}
