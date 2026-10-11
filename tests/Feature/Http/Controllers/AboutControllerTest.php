<?php

it('explains what Neigh is', function () {
    $response = $this->get(route('about'));

    $response->assertOk()->assertSee('Neigh is Tinder for horses.');
});
