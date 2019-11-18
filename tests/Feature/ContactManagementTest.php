<?php

namespace Tests\Unit;

use App\Contact;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class ContactManagementTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_contact()
    {
        $this->withoutExceptionHandling();

        $token = $this->authenticate();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $token,
        ])->json('POST', route('contact.create'), $this->data());

        $response->assertStatus(200);
        $count = Contact::where('first_name','Sunnyboy')->first()->count();
        $this->assertEquals(1,$count);
    }

    /** @test */
    public function it_can_get_all_contacts()
    {
        $this->withoutExceptionHandling();

        $token = $this->authenticate();
        $contact = Contact::create($this->data());

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $token,
        ])->json('GET',route('contact.all'));

        $response->assertStatus(200);

        $this->assertEquals(1,count($response->json()));
        $this->assertEquals('Sunnyboy',$response->json()['contacts'][0]['first_name']);
    }

    /** @test */
    public function it_can_update_contact()
    {
        $this->withoutExceptionHandling();

        $token = $this->authenticate();
        $contact = Contact::create($this->data());

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $token,
        ])->json('PUT',route('contact.update',['contact' => $contact->id]),
        ['first_name' => 'Tumi']);

        $response->assertStatus(200);

        $this->assertEquals('Tumi', Contact::first()->first_name);
    }

    /** @test */
    public function it_can_show_contact()
    {
        $this->withoutExceptionHandling();

        $token = $this->authenticate();

        $contact = Contact::create($this->data());

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $token,
        ])->json('GET',route('contact.show',['contact' => $contact->id]));

        $response->assertStatus(200);

        $this->assertEquals('Mathole',$response->json()['contact']['last_name']);
    }

    /** @test */
    public function it_can_delete_contact()
    {
        $token = $this->authenticate();

        $contact = Contact::create($this->data());

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $token,
        ])->json('POST',route('contact.delete',['contact' => $contact->id]));

        $response->assertStatus(200);
        $this->assertEquals(0, Contact::count());
    }

    private function data()
    {
        return [
            'first_name'    => 'Sunnyboy',
            'last_name'     => 'Mathole',
        ];
    }
}