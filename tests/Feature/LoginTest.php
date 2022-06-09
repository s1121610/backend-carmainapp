<?php

namespace Tests\Feature;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Hash;
use Illuminate\Support\Str;


class LoginTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    /** @test */
    public function login_exisiting_user(){
        $deviceName = Str::random(9);
        $user = User::create([
            'name' => Str::random(5),
            'license_plate' => Str::random(2).'-'.Str::random(2).'-'.Str::random(2),
            'email' => Str::random(8).'@gmail.com',
            'password' => Hash::make("#Test2022")
        ]);

        $response = $this->post('/api/login', [
            'email' => $user->email,
            'password' => '#Test2022',
            'device_name' => $deviceName,
        ]);
        $response->assertSuccessful();
        $this->assertNotEmpty($response->getContent());
        $this->assertDatabaseHas('personal_access_tokens', [
            'name' => $deviceName,
            'tokenable_type' => User::class,
            'tokenable_id' => $user->id,
        ]);
    }

    /** @test */
    public function get_user_from_token(){
        $user = User::create([
            'name' => Str::random(5),
            'license_plate' => Str::random(2).'-'.Str::random(2).'-'.Str::random(2),
            'email' => Str::random(8).'@gmail.com',
            'password' => Hash::make("#Test2022")
        ]);
        $token = $user->createToken('galaxy_a71')->plainTextToken;
        $response = $this->get('/api/user', [
            'Authorization' => 'Bearer ' . $token
        ]);

        $response->assertSuccessful();
        $response->assertJson(function ($json) {
            $json->where('email', 'maxosewoudt01@gmail.com')
                ->missing('password')
                ->etc();
        });

    }
}
