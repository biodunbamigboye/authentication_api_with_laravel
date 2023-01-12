<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class SalesRequest extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    const STATUS_PENDING = 'pending';

    const STATUS_COMPLETED = 'completed';

    const STATUS_PAID = 'paid';

    const STATUS_CANCELLED = 'cancelled';

    public static function statuses(): array
    {
        return [
            self::STATUS_PENDING,
            self::STATUS_COMPLETED,
            self::STATUS_PAID,
            self::STATUS_CANCELLED,
        ];
    }

    protected static function booted()
    {
        static::creating(function (SalesRequest $model) {
            $model->user_id = auth()->id();
        });

        static::updating(function (SalesRequest $model) {
            if (
                $model->isDirty(['price', 'description']) &&
                $model->status !== self::STATUS_PENDING &&
                !auth()->user()->is_admin
            ) {

                throw new UnprocessableEntityHttpException(__('You can only update the status of a sales request that is pending.'));
            }
        });
    }
}
