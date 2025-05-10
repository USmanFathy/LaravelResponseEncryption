<?php

namespace UsmanAhmed\LaravelResponseEncryption\Services;
use Illuminate\Contracts\Encryption\Encrypter;

class EncryptionService
{
    private $disabled = false;

    public function __construct(protected Encrypter $encrypter) {}

    public function encrypt($data): string
    {
        if ($this->disabled) {
            return $data;
        }

        if (is_array($data) || is_object($data)) {
            $data = json_encode($data);
        }

        return $this->encrypter->encrypt($data, false);
    }

    public function disable(): void
    {
        $this->disabled = true;
    }

    public function enable(): void
    {
        $this->disabled = false;
    }

    public function isDisabled(): bool
    {
        return $this->disabled;
    }
}