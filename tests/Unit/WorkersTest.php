<?php

namespace Tests\Unit;

use Mockery\Exception;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Test RESTful interface
 *
 * Class WorkersTest
 * @package Tests\Unit
 */
class WorkersTest extends TestCase
{
    /**
     * Test list of workers (GET /workers)
     */
    public function testIndex()
    {
        $response = $this->json('GET', '/workers');
        $response->assertStatus(200);

        $data = $response->json();

        $this->assertTrue($data['success']);
        $this->assertArrayHasKey('workers', $data);
    }

    /**
     * Test create new worker (POST /workers)
     */
    public function testStore()
    {
        $response = $this->json('POST', '/workers', [
                'first_name' => 'Ihor',
                'last_name' => 'Kordiak',
                'email' => 'generak013@gmail.com',
                'description' => 'PHP programmer',
                'resume' => 'Secret!',
                'birthday' => '1992-08-13'
            ]);
        $response->assertStatus(201 );

        $data = $response->json();

        $this->assertTrue($data['success']);
        $this->assertArrayHasKey('worker', $data);
    }

    /**
     * Test get worker info (GET /workers/{id})
     */
    public function testShow()
    {
        $workers = $this->getWorkers();

        if($workers) {
            $response = $this->json('GET', '/workers/' . $workers[0]['id']);
            $response->assertStatus(200);

            $data = $response->json();

            $this->assertTrue($data['success']);
            $this->assertArrayHasKey('worker', $data);
        } else {
            throw new Exception('Workers not found');
        }
    }

    /**
     * Test update worker info (PATCH /workers/{id})
     */
    public function testUpdate()
    {
        $workers = $this->getWorkers();

        if($workers) {
            $response = $this->json('PATCH', '/workers/' . $workers[0]['id'], [
                'first_name' => 'Ihor',
                'last_name' => 'Kordiak',
                'email' => 'generak013@gmail.com',
                'description' => 'PHP programmer',
                'resume' => 'Unknown',
                'birthday' => '1992-08-13'
            ]);
            $response->assertStatus(200);

            $data = $response->json();

            $this->assertTrue($data['success']);
            $this->assertArrayHasKey('worker', $data);
        } else {
            throw new Exception('Workers not found');
        }
    }

    /**
     * TEST removing worker (DELETE /workers/{id})
     */
    public function testDestroy()
    {
        $workers = $this->getWorkers();

        if($workers) {
            $response = $this->json('DELETE', '/workers/' . $workers[0]['id']);
            $response->assertStatus(204);
        } else {
            throw new Exception('Workers not found');
        }
    }

    /**
     * @return array|null List of workers
     */
    private function getWorkers()
    {
        $data = $this->json('GET', '/workers')->json();
        return $data['workers']['data'] ?? null;
    }
}
