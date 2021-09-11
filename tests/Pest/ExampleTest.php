<?php

test('example', function () {
    expect(true)->toBeTrue();
});

test('view return string', function () {
    $view = $this->blade(
        '<x-markup :make="$markup">rav</x-markup>',
        ['markup' => 'div.card>div#testid-test.card-body']
    );
    
    $view->assertSee('rav');
});
