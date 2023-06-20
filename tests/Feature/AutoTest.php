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

    public function test_EliminarUnoQueExista() {
        $response = $this -> delete('/api/autos/502');
        $response -> assertStatus(200);
        $response -> assertJsonFragment([
             "msj" => "Auto código 502 eliminada."
        ]);

        $this -> assertDatabaseMissing('auto', [
            'id' => '502',
            'deleted_at' => null
        ]);

        Auto::withTrashed() -> where("id",502) -> restore();
    }

    public function test_EliminarUnoQueNoExista() {
        $response = $this -> delete('/api/autos/503');
        $response -> assertStatus(404);
    }

    public function test_ModificarUnoQueNoExista() {
        $response = $this -> put('/api/autos/503');
        $response -> assertStatus(404);
    }

    public function test_ModificarUnoQueExista() {
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

        $response = $this -> put('/api/autos/500',[
            "marca" => "Toyota",
            "modelo" => "V-15",
            "color" => "Azul",
            "puertas" => 2,
            "cilindrado" => 0,
            "automatico" => 1,
            "electrico" => 0
        ]);

        $response -> assertStatus(200);
        $response -> assertJsonStructure($estructura);
        $response -> assertJsonFragment([
            "marca" => "Toyota",
            "modelo" => "V-15",
            "color" => "Azul",
            "puertas" => 2,
            "cilindrado" => 0,
            "automatico" => 1,
            "electrico" => 0
        ]);
    }

    public function test_Insertar() {
        $response = $this -> post('/api/autos/',
        [ 
            "marca" => "Toyota",
            "modelo" => "V-15",
            "color" => "Azul",
            "puertas" => 2,
            "cilindrado" => 0,
            "automatico" => 1,
            "electrico" => 0
        ]);

        $response -> assertStatus(201);
        $response -> assertJsonCount(7);
        $this -> assertDatabaseHas('auto', [
            "marca" => "Toyota",
            "modelo" => "V-15",
            "color" => "Azul",
            "puertas" => 2,
            "cilindrado" => 0,
            "automatico" => 1,
            "electrico" => 0
        ]);

    }
}
