<?php

test('the `Markup` trait can be used in blade component to wrap its content by generated markup using abbreviation', function () {
    $view = (string) $this->blade('<x-emeraldtest-test-component wrap=".card > .card-body" />');
    
    expect($view)->toContain('<div class="card"><div class="card-body"><p>Lorem ipsum</p></div></div>');
});

test('when using the `Markup` trait emerald assumes the abbreviation receiver prop name to be `wrap`', function () {
    expect(
        (string) $this->blade('<x-emeraldtest-test-component wrap=".col" />')
    )
    ->toContain('class="col"');
});

test('when using the `Markup` trait the abbreviation receiver prop name can be customized', function () {
    expect(
        (string) $this->blade('<x-emeraldtest-test-component-custom-wrap-prop markup=".col" />')
    )
    ->toContain('class="col"');
});