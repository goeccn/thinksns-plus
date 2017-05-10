<?php

namespace Zhiyi\Plus\Unit\Middleware\Auth;

use Illuminate\Http\Request;
use Zhiyi\Plus\Tests\TestCase;
use Zhiyi\Plus\Models\User;
use Illuminate\Foundation\Testing\TestResponse;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Zhiyi\Plus\Http\Middleware\CheckUserByNameNotExisted;

class CheckUserByNameNotExistedTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * test check user with phone exited.
     *
     * @author bs<414606094@qq.com>
     */
    public function testHandle()
    {
        $user = factory(User::class)->create();
        $name = $user->name;

        $request = $this->getMockBuilder(Request::class)
            ->setMethods(['input'])
            ->getMock();

        $request->expects($this->any())
            ->method('input')
            ->with('name')
            ->willReturn($name);
        $response = TestResponse::fromBaseResponse(
            with(new CheckUserByNameNotExisted())->handle($request, function () {
            })
        );
        $response->assertStatus(403);
    }
}