<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Auto;
use Tests\TestCase;

class AutoTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_ListarUnoQueExista() {
        $estructura = [
            "id",
            "marca",
            "modelo",
            "color",
            "puertas",
            "cilindrado",
            "automatico",
            "electrico",
            "deleted_at"
        ];

        $response = $this -> get('/api/autos/500');

        $response -> assertStatus(200);
        $response -> assertJsonCount(9);
        $response -> assertJsonStructure($estructura);
    }

    public function test_ListarUnoQueNoExista() {
        $response = $this -> get('/api/autos/501');
        $response -> assertStatus(404);
    }
}
