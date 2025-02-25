<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Queue;

use App\Models\User;
use App\Models\UserMessage;
use App\Jobs\ProcessMessage;
use Tests\TestCase;

class UserMessageTest extends TestCase
{
    use DatabaseMigrations;

    public function test_admin_page(): void
    {
        $response = $this->get('user-message');
        $response->assertStatus(200);
    }

    public function test_user_first_create(): void
    {
        $userEmail = 'testing@example.com';
        $response = $this->get('api/user-messages/show?email='.$userEmail);
        $response->assertStatus(200);

        $user = User::where('email', $userEmail)->first();
        $this->assertEquals($user->email, $userEmail);
    }

    public function test_user_message_get_api(): void
    {
        $user = new User;
        $user->name = '';
        $user->email = 'testing@example.com';
        $user->password = '';
        $user->save();

        $userMessage = new UserMessage;
        $userMessage->user_id = 1;
        $userMessage->message = 'test message';
        $userMessage->status = 'pending';
        $userMessage->save();

        $response = $this->get('api/user-messages/show?email='.$user->email);
        $response->assertStatus(200);
        $response->assertJson([[
            'id' => 1,
            'user_id' => $userMessage->user_id,
            'message' => $userMessage->message,
            'result' => null,
            'status' => $userMessage->status
        ]]);
    }

    public function test_admin_process_message(): void
    {
        $userMessage = new UserMessage;
        $userMessage->user_id = 1;
        $userMessage->message = 'test message';
        $userMessage->status = 'pending';
        $userMessage->save();

        $response = $this->post('user-message/1');
        $response->assertStatus(302); //it should redirect back to the admin page

        $userMessage = UserMessage::find(1);
        $this->assertEquals('done', $userMessage->status);
    }

    public function test_user_message_store_api(): void
    {
        Queue::fake();

        $response = $this->post('api/user-messages/store', [
            'email' => 'testing@example.com',
            'message' => 'test message',
        ]);
        Queue::assertPushed(ProcessMessage::class);

        $response->assertStatus(200);
    }
}
