<?php

namespace Azzarip\Teavel\Actions\Contact;

use Azzarip\Teavel\Models\Contact;

class MutateData {

    public static function mutate(array $data)
    {
        unset($data['privacy_policy']);
        $data['privacy_at'] = now();
        $data['opt_in'] = true;

        if (array_key_exists('marketing', $data)) {
            $data['marketing_at'] = now();
            unset($data['marketing']);
        }

        if (array_key_exists('password', $data)) {
            $data['password'] = bcrypt($data['password']);
        }

        if (array_key_exists('first_name', $data)) {
            $data['first_name'] = ucwords($data['first_name']);
        }

        if (array_key_exists('last_name', $data)) {
            $data['last_name'] = ucwords($data['last_name']);
        }

        return $data;
    }
}