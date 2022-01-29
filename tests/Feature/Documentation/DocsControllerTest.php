<?php

namespace Tests\Feature\Documentation;

use App\Http\Controllers\DocsController;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DocsControllerTest extends TestCase
{
    /**
     * @var DocsController
     */
    private $docsController;

    protected function setUp()
    {
        parent::setUp();
        $this->docsController = $this->app->make(DocsController::class);
    }


    public function testShow()
    {
        $file = 'installation.md';
        $result = $this->docsController->show($file);

        $this->assertNotNull($result, 'Result must not nullable');
        $this->assertArrayHasKey('index', $result);
        $this->assertArrayHasKey('content', $result);
        $this->assertNotNull($result['index']);
        $this->assertNotNull($result['content']);
    }
}
