# Laravel Blade Emerald
> [Emmet](http://emmet.io/) like Abbreviation to generate and wrap [Laravel](https://laravel.com/) [Blade Component](https://laravel.com/docs/master/blade#components) with markup

## 🌈 Features

- Generate HTML in a Blade file via package provided component: `<x-markup make="div.col>span#alert">`
- Emmet style syntax to produce nested markup
- Wrap around any content / other component with markup
- Make any Blade Component accept abbreviation to wrap itself with markup ( *doesn't work for Anonymous Components* )


## 🛸 Compatibility

| Package Version | Laravel version | PHP version | Compatible |
|-----------------|-----------------|-------------|------------|
|    ^1.0         |       8.*       |   7.3 - 8.0 |      🟢  |
|                 |       7.*       |   7.3 - 7.4 |      🟢  |

## 📥 Installation

```shell
composer require aqua/blade-emerald
```

## 📖 Usage

💡 The package provides a Blade Component `<x-emerald-markup />`, This component can be used like `<x-markup ...>` as an alias.
The component support one prop named `make` which accept the abbreviation

#### 🏷️ Generate static nested markup

```html
<x-markup make="div.card[style='color:green;'] > div.card-body#box" />
```
> produced html
```html
<div class="card" style="color:green;">
    <div class="card-body" id="box"></div>
</div>
```

#### 🏷️ Wrap some content
```html
<x-markup make="div.col>div.alert.alert-success[role=alert]">
    <strong>Success !</strong> give it a click if you like.
</x-markup>
```
<details>
<summary>produced html</summary>

```html
<div class="col">
    <div class="alert alert-success" role="alert">
        <strong>Success !</strong> give it a click if you like.
    </div>
</div>
```
</details>

#### 🏷️ Accept abbreviation in your Blade Component

> this feature doesn't support *Anonymous Components*

1.  use `Aqua\Emerald\Traits\Markup` trait in your Component Class
```php
class YourComponent extends Component {
    use Markup;
    ...
```
2.  the `Markup` trait assumes the prop name to be `wrap`, so lets add this as a class property & instantiate
```php
public function __construct(public $wrap) {...} // using php 8.0 constructor property promotion
```
[read more](https://php.watch/versions/8.0/constructor-property-promotion) about constructor property promotion

3.  accept abbreviation
```html
<x-your-component wrap=".card.bg-dark.pt-2 > .card-body.text-danger" />
```
<details>
<summary>produced html</summary>

```html
<div class="card bg-dark pt-2">
    <div class="card-body text-danger">
        <!-- actual content of your-component -->
        <p>Laravel... The PHP Framework for Web Artisans</p>
        <!-- actual content of your-component -->
    </div>
</div>
```
</details>

4.  accept abbreviation using prop of your choise
to customize the prop name that receives the abbreviation create a static property `$wrapby` and set its value to your prop name

```php
class YourComponent extends Component {
    use Markup;

    protected static $wrapby = 'markup'; 👈

    public function __construct(public $markup, ...) {
                                        👆
    }
    ...
```

```html
<x-your-component markup=".card.bg-dark.pt-2 > .card-body.text-danger" />
                   👆
```

## 🧰 Useful Examples
<details>
<summary>Bootstrap grid</summary>

```html
<x-markup make="div.container > div.row > div.col-md-6">
    <p>Hello world!</p>
</x-markup>
```
</details>

<details>
<summary>Breadcrumb</summary>

```html
<x-markup make="nav[aria-label=breadcrumb]>ol.breadcrumb">
    <li class="breadcrumb-item"><a href="#">Home</a></li>
    <li class="breadcrumb-item active" aria-current="page">Library</li>
</x-markup>
```
</details>

<details>
<summary>Bootstrap card with links</summary>

```html
<x-markup make="div.card.text-center">
    <x-markup make="div.card-header>ul.nav.nav-pills.card-header-pills">
        <x-markup make="li.nav-item>a.nav-link.active[href=#]">Active</x-markup>
        <x-markup make="li.nav-item>a.nav-link[href=#]">Link</x-markup>
        <x-markup make="li.nav-item>a.nav-link.disabled[href=# tabindex=-1 aria-disabled=true]">Disabled</x-markup>
    </x-markup>
    <div class="card-body">
        <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
    </div>
</x-markup>
```
</details>

<details>
<summary>Bootstrap form-group</summary>

```html
<x-markup make="div.form-group>div.mb-3">
    <label for="email" class="form-label">Email address</label>
    <input type="email" class="form-control" id="email" aria-describedby="emailHelp" />

    <x-markup make="div>div.#emailHelp.form-text>span.text-danger.validation-msg" />
</x-markup>
```
</details>

<details>
<summary>Self closing tag</summary>

```html
<x-markup make="img#profile[src=/avatar.jpg width=80]" />
```

</details>

<details>
<summary>Alpine x-for</summary>

```html
<ul x-data="{ colors: [{ id: 1, label: 'Green' }, ...] }">
    <x-markup make="template[x-for=color in colors] [:key=color.id] > li[x-text=color.label]" />
</ul>
```
> equivalent to
```html
<ul x-data="{ colors: ...}">
    <template x-for="color in colors" :key="color.id">
        <li x-text="color.label"></li>
    </template>
</ul>
```
</details>


## 📚 Abbreviation Guide
checkout [spatie/html-element](https://github.com/spatie/html-element#examples) to get more idea.

| Syntax | Example | Description |
|-----------------|-----------------|-----------------|
| `#id` | `p#foo` | ID attribute |
| `.class` | `p.foo` | Class attribute |
| `>` | `div.row>div.col` | Nesting with child |
| `[style='color:green;']` | `div[style='color:green;']` | Single attribute |
| `[title=Hello world][data-foo=bar]` |  | Multiple attributes |

## 📅 Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## 🏆 Credits
This package is actually a wrapper around [spatie/html-element](https://github.com/spatie/html-element), all the hard work has been done by Team Spatie so they deserve all the credits. All I did is make it work with Laravel Blade Componets.

## 🎫 License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.