<?php

namespace Tests\Feature;

use App\View\Components\GuestLayout;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\View\View;
use Tests\TestCase;

class GuestLayoutTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_renders_the_guest_layout_view()
    {
        $component = new GuestLayout();

        $renderedView = $component->render();

        $this->assertInstanceOf(View::class, $renderedView);
        $this->assertEquals('layouts.guest', $renderedView->getName());
    }
}
