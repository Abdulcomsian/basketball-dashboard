<?php

namespace App\Traits;

use App\Models\Log;

trait Loggable
{
    public static function bootLoggable()
    {
        foreach (['created', 'updated', 'deleted'] as $event) {
            static::$event(function ($model) use ($event) {
                $model->logActivity($event);
            });
        }
    }

    protected function logActivity($action)
    {
        $logData = [
            'action' => $action,
            'model' => class_basename(static::class),
            'model_id' => $this->id,
            'user_id' => auth()->id(),
            'related_id' => $this->related_id ?? null,
            'related_model' => $this->related_model ?? null,
            'description' => auth()->user()->name . ' ' . $action . ' ' . class_basename(static::class) . ' successfully.',
        ];

        if ($action === 'updated') {
            $logData['data'] = json_encode([
                'old' => $this->getOriginal(),
                'new' => json_decode($this->toJson(), true),
            ]);
        } else {
            $logData['data'] = $this->toJson();
        }

        Log::create($logData);
    }


    protected function logCustomActivity($action, $description, $model = null)
    {
        $user = auth()->user();

        Log::create([
            'action' => $action,
            'model' => $model,
            'user_id' => $user ? $user->id : null,
            'description' => $description,
        ]);
    }
}
