<?php

it('can create html element with class', function () {
    $view = (string) $this->blade('<x-markup make="div.emerald" />');
    
    expect($view)->toBe('<div class="emerald"></div>');
});

it('can create html element with id', function () {
    $view = (string) $this->blade('<x-markup make="div#emerald" />');
    
    expect($view)->toBe('<div id="emerald"></div>');
});

it('can create html element with multiple classes and id', function () {
    $view = (string) $this->blade(
        '<x-markup :make="$abbreviation" />',
        ['abbreviation' => "div.first-class.second-class#emerald"]
    );
    
    expect($view)
    ->toContain('div')
    ->toContain('class="first-class second-class"')
    ->toContain('id="emerald"');
});

it('can create html element with attribute', function () {
    $view = (string) $this->blade(
        '<x-markup :make="$abbreviation" />',
        ['abbreviation' => "div[data-title=aqua]"]
    );
    
    expect($view)->toBe('<div data-title="aqua"></div>');
});

it('can create html element with id, classes and attributes', function () {
    $view = (string) $this->blade(
        '<x-markup :make="$abbreviation" />',
        ['abbreviation' => "div.f-class.sec-class#some-id[x-bind:width=10][x-text=sourav]"]
    );
    
    expect($view)
    ->toContain('div')
    ->toContain('class="f-class sec-class"')
    ->toContain('id="some-id"')
    ->toContain('x-bind:width="10"')
    ->toContain('x-text="sourav"');
});

it('can create html element with attribute value wrapped in single quote', function () {
    $view = (string) $this->blade(
        '<x-markup :make="$abbreviation" />',
        ['abbreviation' => "div.[x-text='sourav']"]
    );
    
    expect($view)
    ->toContain('x-text="sourav"');
});

it('can create html element with attribute value wrapped in double quote', function () {
    $view = (string) $this->blade(
        '<x-markup :make="$abbreviation" />',
        ['abbreviation' => 'div.[x-text="sourav"]']
    );
    
    expect($view)
    ->toContain('x-text="sourav"');
});

it('can create html element with attribute without values', function () {
    $view = (string) $this->blade(
        '<x-markup :make="$abbreviation" />',
        ['abbreviation' => 'input[type=text][required]']
    );
    
    expect($view)
    ->toBe('<input type="text" required>');
});

it('can create self closing html element', function () {
    $view = (string) $this->blade(
        '<x-markup :make="$abbreviation" />',
        ['abbreviation' => 'img[src=/aqua.jpg]']
    );
    
    expect($view)
    ->toBe('<img src="/aqua.jpg">');
});

it('support emmet style abbreviation to generate nested html elements', function () {
    $content = (string) $this->blade(
        '<x-markup :make="$abbreviation"><span>A simple success alert</span></x-markup>',
        ['abbreviation' => 'div.col>div.alert.alert-success[role=alert]']
    );
    
    expect($content)
    ->toContain('<div class="col">')
    ->toContain('class="alert alert-success"')
    ->toContain('role="alert"')
    ->toContain('<span>A simple success alert</span>');
});

it('creates `div` if elelement is not explicitly provided', function () {
    $content = (string) $this->blade(
        '<x-markup :make="$abbreviation" />',
        ['abbreviation' => '.container>.row>.card#card-id']
    );
    
    expect($content)
    ->toBe('<div class="container"><div class="row"><div id="card-id" class="card"></div></div></div>');
});