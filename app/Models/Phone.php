<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Phone
 *
 * @property int $id
 * @property int $company_id ID компании
 * @property int $number Номер телефона
 * @property string $desc Краткое описание номера телефон
 * @property string $type Тип телефона: мобильный, рабочий, факс
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \App\Models\Company $company
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Phone whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Phone whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Phone whereDesc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Phone whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Phone whereNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Phone whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Phone whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Phone extends Model
{
    //
    public function company()
    {
        return $this->belongsTo('App\Models\Company');

    }

    protected $fillable = [
        'company_id',
        'number',
        'type'
    ];


}
