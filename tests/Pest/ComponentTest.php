<?php

test('package provides the `x-emerald-markup` blade component', function () {
    $view = (string) $this->blade('<x-emerald-markup make="span" />');
    
    expect($view)->toContain('<span></span>');
});

test('`x-markup` can be used as an alias of `x-emerald-markup` component', function () {
    $view = (string) $this->blade('<x-markup make="span" />');
    
    expect($view)->toContain('<span></span>');
});

test('`make` prop is required for x-markup & x-emerald-markup component', function () {
    if(isLaravel(8))
    expect(function() { return $this->blade('<x-markup />'); })->toThrow(Illuminate\View\ViewException::class, 'Unresolvable dependency');

    else
    expect(function() { return $this->blade('<x-markup />'); })->toThrow('Unresolvable dependency');
});

test('markup component accept slot', function () {
    $bladeStr = <<<BLADE
<x-markup make="">
<p>slotted content</p>
</x-markup>
BLADE;

    $view = (string) $this->blade($bladeStr);

    expect($view)->toContain('<p>slotted content</p>');
});

it('wraps slotted content with generated markup', function () {
    $view = (string) $this->blade(
        '<x-markup :make="$abbreviation"><p>slotted content</p></x-markup>',
        ['abbreviation' => 'div.aqua > span#emerald']
    );
    
    expect($view)->toContain('<div class="aqua"><span id="emerald"><p>slotted content</p></span></div>');
});

test('markup component can be used only for generating html without need of wrapping slotted content', function () {
    $view = (string) $this->blade('<x-markup make="div > span" />');

    expect($view)->toContain('<div><span></span></div>');
});
