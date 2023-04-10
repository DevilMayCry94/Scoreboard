<?php

namespace App\Models;

use App\Services\Storages\GameStorage;

use Illuminate\Support\Facades\Log;

abstract class BaseModel
{
    private string $uuid = '';

    public function setUuid(string $uuid): void
    {
        $this->uuid = $uuid;
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function fill(array $data): void
    {
        foreach ($data as $key => $value) {
            $this->{$this->dashesToCamelCase($key)} = $value;
        }
    }

    public function save(): ?self
    {
        try {
            GameStorage::setGame($this->uuid, $this);
            return $this;
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return null;
        }
    }

    private function dashesToCamelCase(string $string): string
    {
        //TODO move to utils
        return lcfirst(str_replace(' ', '', ucwords(str_replace('_', ' ', $string))));
    }
}
