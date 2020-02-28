<?php

class UserTest extends TestCase
{
    /**
     * /users [GET]
     */
    public function testShouldReturnAllUsers()
    {
        $this->get("/api/v1/users", []);
        $this->seeStatusCode(200);
        $this->seeJsonStructure([
            'success',
            'data' => ['*' =>
                [
                    'id',
                    'name',
                    'email',
                    'phone',
                    'country',
                    'created_at',
                    'updated_at',
                ]
            ]
        ]);
    }

    /**
     * /user/id [GET]
     */
    public function testShouldReturnUser()
    {
        $this->get("/api/v1/user/1", []);
        $this->seeStatusCode(200);
        $this->seeJsonStructure([
                'success',
                'data' =>
                    [
                        'id',
                        'name',
                        'email',
                        'phone',
                        'country',
                        'created_at',
                        'updated_at',
                        'updated_at',
                        'rewards',
                    ]
            ]
        );
    }

    /**
     * /user [POST]
     */
    public function testShouldCreateUser()
    {
        $params = [
            'name' => 'Test User',
            'email' => uniqid() . '@email.com',
            'phone' => rand(),
            'country' => "UAE",
        ];

        $this->post("/api/v1/user", $params, []);
        $this->seeStatusCode(200);
        $this->seeJsonStructure(
            [
                'success',
                'data' =>
                    [
                        'id',
                        'name',
                        'email',
                        'phone',
                        'country',
                        'created_at',
                        'updated_at',
                        'updated_at',
                    ]
            ]
        );
    }

    /**
     * /user/id [PUT]
     */
    public function testShouldUpdateUser()
    {
        $params = [
            'name' => 'Test User',
            'email' => uniqid() . '@email.com',
            'phone' => rand(),
            'country' => "UAE",
        ];

        $this->put("/api/v1/user/5", $params, []);
        $this->seeStatusCode(200);
        $this->seeJsonStructure([
                'success',
                'data' =>
                    [
                        'id',
                        'name',
                        'name',
                        'phone',
                        'country',
                        'created_at',
                        'updated_at',
                        'updated_at',
                    ]
            ]
        );
    }

    /**
     * /user/id [DELETE]
     */
    public function testShouldDeleteUser()
    {
        $this->delete("/api/v1/user/10", [], []);
        $this->seeStatusCode(200);
        $this->seeJsonStructure([
            'success',
            'message'
        ]);
    }
}
