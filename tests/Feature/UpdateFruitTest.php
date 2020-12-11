<?php

namespace Tests\Feature;
use App\Models\Fruit;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class UpdateFruitTest extends TestCase
{
    use DatabaseTransactions;


    public function testFruitIsUpdatedCorrectly (){
        $fruit = Fruit::create([
            'name' => 'Bananas',
            'size' => 'medium',
            'color'=> 'yellow'
        ]);

        $payload = [
            'name' => 'Pinapple',
            'size' => 'large'
        ];

        $response = $this->json('PUT', '/api/fruits/' . $fruit->id, $payload)
            ->assertStatus(200)
            ->assertJson(['id'   => $fruit->id,
                          'name' => 'Pinapple',
                          'size' => 'large',
                          'color'=> 'yellow'
        ]);
        $payload = [
            'name'  => 'pinapple',
            'size'  => 'large',
            'color' => 'brown'
        ];

        $response = $this->json('PUT', '/api/fruits/' . $fruit->id, $payload)
            ->assertStatus(200)
            ->assertJson(['id'   => $fruit->id,
                          'name' => 'pinapple',
                          'size' => 'large',
                          'color'=> 'brown'
        ]);
    }

    public function testFruitIsNotUpdatedIfMandatoryFieldsAreMissing(){
        $fruit = Fruit::create([
            'name' => 'Bananas',
            'size' => 'medium',
            'color'=> 'yellow'
        ]);

        $payload = [
            'name' => 'pinapple',
        ];

        $response = $this->json('PUT', '/api/fruits/' . $fruit->id, $payload)
            ->assertStatus(400);

        $payload = [
            'size' => 'large'
        ];

        $response = $this->json('PUT', '/api/fruits/' . $fruit->id, $payload)
            ->assertStatus(400);
    }

    public function testFruitIsNotUpdatedIfSizeValueIsInvalid(){
         $fruit = Fruit::create([
            'name' => 'Bananas',
            'size' => 'medium',
            'color'=> 'yellow'
        ]);

        $payload = [
            'name' => 'pinapple',
            'size' => 'big'
        ];

        $response = $this->json('PUT', '/api/fruits/' . $fruit->id, $payload)
            ->assertStatus(400);
    }

    public function testFruitIsNotUpdatedIfAlreadyExistAFruitWithTheSameAttributes(){
        $fruit = Fruit::create([
            'name' => 'bananas',
            'size' => 'medium',
            'color'=> 'yellow'
        ]);

        $fruit = Fruit::create([
            'name' => 'apples',
            'size' => 'medium',
            'color'=> 'red'
        ]);

        $payload = [
            'name' => 'bananas',
            'size' => 'medium',
            'color'=> 'yellow'
            
        ];
        $response = $this->json('PUT', '/api/fruits/' . $fruit->id, $payload)
            ->assertStatus(409);

    }
}
