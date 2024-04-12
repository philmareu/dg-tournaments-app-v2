<?php

namespace Tests;

use App\Models\User\User;

trait ValidationHelperTrait
{
    public function postValidationTest($endpoint, $attribute, $data = [])
    {
        $this->validationTest('POST', $endpoint, $attribute, $data);
    }

    public function putValidationTest($endpoint, $attribute, $data = [])
    {
        $this->validationTest('PUT', $endpoint, $attribute, $data);
    }

    public function validationTest($method, $endpoint, $attribute, $data = [])
    {
        $response = $this->actingAs(User::factory()->create())
            ->call($method, $endpoint, $data)
            ->assertSessionHasErrors($attribute);
    }
}
